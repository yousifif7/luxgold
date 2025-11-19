<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use App\Models\ReviewModerationLog;
use Illuminate\Support\Facades\Auth;

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

        // Additional filters
        if ($request->filled('city')) {
            $city = $request->get('city');
            $query->whereHas('parent', function($q) use ($city) { $q->where('city', $city); });
        }
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->get('date_to'));
        }
        if ($request->filled('provider_category')) {
            $cat = $request->get('provider_category');
            $query->whereHas('provider', function($q) use ($cat) { $q->where('category', $cat); });
        }
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', (int)$request->get('min_rating'));
        }
        if ($request->filled('only_flagged') && $request->get('only_flagged')) {
            $query->where('status', 'flagged');
        }

        $reviews = $query->paginate(25)->appends($request->query());
        // Totals
        $totalReviews = Review::count();
        $pendingCount = Review::where('status', 'pending')->count();
        $flaggedCount = Review::where('status', 'flagged')->count();
        $avgRating = Review::avg('rating') ?: 0;

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

        // Insights: trends and top flagged providers
        $recentCount = Review::where('created_at', '>=', now()->subDays(7))->count();
        $prevCount = Review::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $trendPercent = 0;
        $trendDir = 'neutral';
        if ($prevCount > 0) {
            $trendPercent = round((($recentCount - $prevCount) / max(1, $prevCount)) * 100, 1);
            $trendDir = $trendPercent > 0 ? 'up' : ($trendPercent < 0 ? 'down' : 'neutral');
        } else {
            if ($recentCount > 0) { $trendDir = 'up'; $trendPercent = 100.0; }
        }

        $topFlagged = DB::table('reviews')
            ->select('provider_id', DB::raw('count(*) as cnt'))
            ->where('status', 'flagged')
            ->groupBy('provider_id')
            ->orderByDesc('cnt')
            ->limit(5)
            ->get();

        $providerNames = [];
        if ($topFlagged->isNotEmpty()) {
            $providerIds = $topFlagged->pluck('provider_id')->toArray();
            $providerNames = \App\Models\Provider::whereIn('id', $providerIds)->pluck('name','id')->toArray();
        }

        $mostActiveCity = $cityTotals->first()->city ?? null;

        // Export CSV if requested (simple export of current filtered query)
        if ($request->filled('export') && $request->get('export') === 'csv') {
            $exportRows = $query->get();
            $filename = 'reviews_export_' . date('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];
            $columns = ['id','user_id','provider_id','rating','status','comment','created_at'];
            $callback = function() use ($exportRows, $columns) {
                $out = fopen('php://output', 'w');
                fputcsv($out, $columns);
                foreach ($exportRows as $row) {
                    $line = [];
                    foreach ($columns as $c) { $line[] = $row->{$c} ?? ''; }
                    fputcsv($out, $line);
                }
                fclose($out);
            };
            return response()->stream($callback, 200, $headers);
        }

        return view('admin.reviews.index', compact('reviews'))
            ->with('totalReviews', $totalReviews)
            ->with('pendingCount', $pendingCount)
            ->with('flaggedCount', $flaggedCount)
            ->with('avgRating', round($avgRating,2))
            ->with('cityLabels', $cityLabels)
            ->with('approvedCounts', $approvedCounts)
            ->with('flaggedCounts', $flaggedCounts)
            ->with('statusLabels', $statusLabels->toArray())
            ->with('statusCounts', $statusCounts->toArray());
    }

    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    public function action(Request $request, Review $review)
    {
        $data = $request->validate(['action' => 'required|string', 'note' => 'nullable|string']);
        $action = $data['action'];
        $mapping = [
            'approve' => 'approved',
            'reject' => 'rejected',
            'flag' => 'flagged',
            'hide' => 'hidden'
        ];
        if (! isset($mapping[$action])) {
            return response()->json(['error' => 'Invalid action'], 422);
        }
        $old = $review->status;
        $review->status = $mapping[$action];
        $review->save();

        ReviewModerationLog::create([
            'review_id' => $review->id,
            'admin_user_id' => Auth::id(),
            'action' => $action,
            'note' => $data['note'] ?? null,
        ]);

        return response()->json(['success' => true, 'status' => $review->status]);
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        if (! is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'No IDs provided'], 422);
        }
        $updated = 0;
        foreach ($ids as $id) {
            $r = Review::find($id);
            if ($r && $r->status !== 'approved') {
                $r->status = 'approved';
                $r->save();
                ReviewModerationLog::create(['review_id'=>$r->id,'admin_user_id'=>Auth::id(),'action'=>'approve','note'=>'bulk approved']);
                $updated++;
            }
        }
        return response()->json(['success'=>true,'updated'=>$updated]);
    }

    public function history(Review $review)
    {
        $logs = ReviewModerationLog::where('review_id',$review->id)->with('adminUser')->orderByDesc('created_at')->get();
        return view('admin.reviews._history', compact('logs'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,flagged,hidden,rejected',
        ]);
        $review->update($data);
        return redirect()->route('admin.reviews.index')->with('success','Review updated');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success','Review deleted');
    }
}
