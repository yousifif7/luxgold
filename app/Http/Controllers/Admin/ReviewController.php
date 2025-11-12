<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['parent','provider'])->orderByDesc('created_at');
        
        if ($request->filled('q')) {
            $t = $request->get('q');
            $query->where('content', 'like', "%{$t}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->filled('rating')) {
            $query->where('rating', $request->get('rating'));
        }

        $reviews = $query->paginate(25)->appends($request->query());
        
        // Basic totals
        $totalReviews = Review::count();
        $pendingCount = Review::where('status', 'pending')->count();
        $flaggedCount = Review::where('status', 'flagged')->count();
        $approvedCount = Review::where('status', 'approved')->count();
        $hiddenCount = Review::where('status', 'hidden')->count();
        $rejectedCount = Review::where('status', 'rejected')->count();
        $avgRating = Review::avg('rating') ?: 0;

        // Rating distribution
        $ratingDistribution = DB::table('reviews')
            ->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        // Status distribution
        $statusRows = DB::table('reviews')
            ->select('status', DB::raw('count(*) as cnt'))
            ->groupBy('status')
            ->get();
        $statusLabels = $statusRows->pluck('status');
        $statusCounts = $statusRows->pluck('cnt');

        // Reviews by city: get approved and flagged counts per city (top by total)
        $cityTotals = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select('users.city', DB::raw('count(*) as cnt'))
            ->whereNotNull('users.city')
            ->groupBy('users.city')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get();

        $cities = $cityTotals->pluck('city')->toArray();

        // approved per city
        $approvedRows = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select('users.city', DB::raw('count(*) as cnt'))
            ->where('reviews.status','approved')
            ->whereIn('users.city', $cities)
            ->groupBy('users.city')
            ->get()->pluck('cnt','city');

        // flagged per city
        $flaggedRows = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select('users.city', DB::raw('count(*) as cnt'))
            ->where('reviews.status','flagged')
            ->whereIn('users.city', $cities)
            ->groupBy('users.city')
            ->get()->pluck('cnt','city');

        $cityLabels = $cities;
        $approvedCounts = [];
        $flaggedCounts = [];
        foreach($cities as $c){
            $approvedCounts[] = (int) ($approvedRows[$c] ?? 0);
            $flaggedCounts[] = (int) ($flaggedRows[$c] ?? 0);
        }

        // Recent activity (last 30 days)
        $recentActivity = DB::table('reviews')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Provider with most reviews
        $topProviders = DB::table('reviews')
            ->join('users', 'reviews.provider_id', '=', 'users.id')
            ->select('users.first_name', DB::raw('count(*) as review_count'), DB::raw('avg(rating) as avg_rating'))
            ->groupBy('users.id', 'users.first_name')
            ->orderByDesc('review_count')
            ->limit(5)
            ->get();

        return view('admin.reviews.index', compact('reviews'))
            ->with('totalReviews', $totalReviews)
            ->with('pendingCount', $pendingCount)
            ->with('flaggedCount', $flaggedCount)
            ->with('approvedCount', $approvedCount)
            ->with('hiddenCount', $hiddenCount)
            ->with('rejectedCount', $rejectedCount)
            ->with('avgRating', round($avgRating, 2))
            ->with('ratingDistribution', $ratingDistribution)
            ->with('cityLabels', $cityLabels)
            ->with('approvedCounts', $approvedCounts)
            ->with('flaggedCounts', $flaggedCounts)
            ->with('statusLabels', $statusLabels->toArray())
            ->with('statusCounts', $statusCounts->toArray())
            ->with('recentActivity', $recentActivity)
            ->with('topProviders', $topProviders);
    }

    public function show(Review $review)
    {
        $review->load(['parent', 'provider', 'user']);
        return view('admin.reviews.show', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,flagged,hidden,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $review=Review::where('id',$id)->first();
        
        $review->update($data);
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review status updated successfully');
    }


    public function moderateReview(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,flagged,hidden,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $review=Review::where('id',$id)->first();
        
        $review->update($data);
        
                   return handleAjaxResponse($request, 'Parent updated successfully!', 'admin-home');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
            'status' => 'required|in:pending,approved,flagged,hidden,rejected'
        ]);

        Review::whereIn('id', $request->review_ids)
            ->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', count($request->review_ids) . ' reviews updated successfully');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        Review::whereIn('id', $request->review_ids)->delete();

        return redirect()->back()
            ->with('success', count($request->review_ids) . ' reviews deleted successfully');
    }
}