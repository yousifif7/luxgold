<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Provider;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Category;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        $recentInquiries = $this->getRecentInquiries();
        $pendingProviders = $this->getPendingProviders();
        $reportedReviews = $this->getReportedReviews();
        $newInquiries = Inquiry::where('status', 'pending')->latest()->take(5)->get();
        $openSupportCount = SupportTicket::where('status', 'open')->count();
        $recentTickets = SupportTicket::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'stats', 'recentInquiries', 'pendingProviders', 'reportedReviews', 'newInquiries',
            'openSupportCount', 'recentTickets'
        ));
    }

    private function getPendingProviders($limit = 6)
    {
        return Provider::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->take($limit)
            ->get(['id','business_name','created_at']);
    }

    private function getReportedReviews($limit = 3)
    {
        return Review::where('status', 'flagged')
            ->with(['parent','provider'])
            ->latest()
            ->take($limit)
            ->get();
    }

    public function deleteInquiry($id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
        $inquiry->delete();
        return response()->json(['success' => true]);
    }

    public function resolveInquiry(Request $request, $id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
        $inquiry->status = 'closed';
        $inquiry->save();
        return response()->json(['success' => true]);
    }

    public function exportPaymentsCSV(Request $request)
    {
        $fileName = 'payments_export_' . now()->format('Y_m_d_H_i') . '.csv';
        $payments = Payment::where('status', 'completed')->with('provider')->orderByDesc('paid_at');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function() use ($payments) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id','provider_id','provider_name','amount','currency','status','paid_at','transaction_id']);
            $payments->chunk(200, function($rows) use ($out) {
                foreach ($rows as $p) {
                    fputcsv($out, [
                        $p->id,
                        $p->provider_id,
                        $p->provider->business_name ?? $p->provider_id,
                        $p->amount,
                        $p->currency ?? '',
                        $p->status,
                        $p->paid_at ? $p->paid_at->toDateTimeString() : '',
                        $p->transaction_id ?? ''
                    ]);
                }
            });
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Paginated transaction log view for admin
     */
    public function paymentsIndex(Request $request)
    {
        $query = Payment::with('provider')->orderByDesc('paid_at');

        // optional filters
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->get('provider_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->filled('from')) {
            $query->whereDate('paid_at', '>=', $request->get('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('paid_at', '<=', $request->get('to'));
        }

        $payments = $query->paginate(25)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Admin: show all inquiries with basic stats and controls.
     * Preserve existing parent/provider logic for non-admin routes — this is admin-only.
     */
    public function inquiriesIndex(Request $request)
    {
        $query = Inquiry::with(['provider', 'user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->get('provider_id'));
        }
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhere('message', 'like', "%{$q}%");
            });
        }

        $inquiries = $query->paginate(25)->withQueryString();

        // Basic stats for admin dashboard: total, by status, top providers, monthly trend
        $stats = $this->getInquiryStats();
        $trend = $this->getInquiriesMonthlyTrend();

        return view('admin.inquiries.index', compact('inquiries', 'stats', 'trend'));
    }

    private function getInquiryStats()
    {
        $total = Inquiry::count();
        $byStatus = Inquiry::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function($r){ return [$r->status => (int) $r->total]; })
            ->toArray();

        // Top providers by number of inquiries
        $topProviders = Inquiry::selectRaw('provider_id, COUNT(*) as total')
            ->whereNotNull('provider_id')
            ->groupBy('provider_id')
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(function($r){
                $provider = Provider::find($r->provider_id);
                return [
                    'provider_id' => $r->provider_id,
                    'provider_name' => $provider ? $provider->business_name : '(deleted)',
                    'total' => (int) $r->total
                ];
            })->toArray();

        return [
            'total' => $total,
            'by_status' => $byStatus,
            'top_providers' => $topProviders
        ];
    }

    private function getInquiriesMonthlyTrend($months = 12)
    {
        $start = now()->subMonths($months - 1)->startOfMonth();
        $rows = Inquiry::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->where('created_at', '>=', $start)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $labels = [];
        $data = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $m = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $data[] = $rows[$m] ?? 0;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getDashboardStats()
    {
        return [
            'total_providers' => Provider::count(),
            'total_parents' => User::whereHas('roles', function($query) {
                $query->where('name', 'parent');
            })->count(),
            'active_events' => Event::where('status', 'active')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'pending_approvals' => Provider::where('status', 'pending')->count(),
            'featured_providers' => Provider::where('is_featured', 1)
                ->whereHas('subscription', function($query) {
                    $query->where('plan_id', '!=', 1); // Assuming plan 1 is basic/free
                })
                ->count(),
            'new_inquiries' => Inquiry::where('status', 'pending')
                ->whereDate('created_at', today())
                ->count(),
            'reported_reviews' => Review::where('status', 'flagged')->count(),
        ];
    }

    private function getRecentInquiries()
    {
        return Inquiry::with(['provider', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($inquiry) {
                return [
                    'id' => $inquiry->id,
                    'inquiry_id' => '#INQ' . str_pad($inquiry->id, 3, '0', STR_PAD_LEFT),
                    'parent_name' => $inquiry->name,
                    'parent_email' => $inquiry->email,
                    'provider_name' => $inquiry->provider->business_name ?? 'N/A',
                    'provider_id' => $inquiry->provider->id,
                    'service_type' => $inquiry->provider->category ?? 'General',
                    'date_time' => $inquiry->created_at->format('d M Y, h:i A'),
                    'status' => $inquiry->status,
                    'message' => $inquiry->message,
                ];
            });
    }

    public function getChartData(Request $request)
    {
        $period = $request->get('period', 'monthly');
        
        switch ($period) {
            case 'weekly':
                $data = $this->getWeeklyData();
                break;
            case 'monthly':
            default:
                $data = $this->getMonthlyData();
                break;
        }

        // Add category breakdown, top earning categories and engagement heatmap
        $data['categories'] = $this->getProviderCategoryBreakdown();
        $data['top_categories'] = $this->getTopEarningCategories();
        $data['engagement_by_city'] = $this->getEngagementByCity();

        return response()->json($data);
    }

    /**
     * Return a small realtime feed payload (for polling) containing newest signups, inquiries and flagged reviews.
     */
    public function realtimeFeed(Request $request)
    {
        $latestUsers = User::orderByDesc('created_at')->take(8)->get(['id','name','created_at'])->map(function($u){
            return ['id'=>$u->id,'name'=>$u->name,'created_at'=>$u->created_at->diffForHumans()];
        });

        $latestInquiries = Inquiry::with('provider')->orderByDesc('created_at')->take(8)->get()->map(function($i){
            return ['id'=>$i->id,'name'=>$i->name,'provider'=> $i->provider->business_name ?? 'N/A','created_at'=>$i->created_at->diffForHumans()];
        });

        $flaggedReviews = Review::where('status','flagged')->with('provider')->latest()->take(6)->get()->map(function($r){
            return [
                'id' => $r->id,
                'provider' => $r->provider->business_name ?? 'N/A',
                'snippet' => \Illuminate\Support\Str::limit($r->comment ?? $r->content ?? '', 80),
                'created_at' => $r->created_at->diffForHumans()
            ];
        });

        return response()->json([
            'users' => $latestUsers,
            'inquiries' => $latestInquiries,
            'flagged_reviews' => $flaggedReviews
        ]);
    }

    private function getMonthlyData()
    {
        $currentYear = now()->year;
        
        $providers = Provider::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $inquiries = Inquiry::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $revenue = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', $currentYear)
            ->where('status', 'completed')
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Parents (users with role 'parent') per month
        $parents = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->whereHas('roles', function($q) { $q->where('name', 'parent'); })
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill in missing months with zero
        $months = range(1, 12);
        $data = [
            'labels' => [],
            'providers' => [],
            'inquiries' => [],
            'revenue' => []
        ];

        foreach ($months as $month) {
            $monthName = date('M', mktime(0, 0, 0, $month, 1));
            $data['labels'][] = $monthName;
            $data['providers'][] = $providers[$month] ?? 0;
            $data['inquiries'][] = $inquiries[$month] ?? 0;
            $data['revenue'][] = $revenue[$month] ?? 0;
            $data['parents'][] = $parents[$month] ?? 0;
        }

        return $data;
    }

    /**
     * Return breakdown of providers by category (for pie chart)
     */
    private function getProviderCategoryBreakdown()
    {
        $counts = Provider::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->category ?? 'Unspecified' => (int) $item->total];
            })->toArray();

        return $counts;
    }

    /**
     * Top earning categories by payments (sum)
     */
    private function getTopEarningCategories($limit = 8)
    {
        $rows = Payment::selectRaw('providers.category as category, SUM(payments.amount) as total')
            ->join('providers', 'payments.provider_id', '=', 'providers.id')
            ->where('payments.status', 'completed')
            ->groupBy('providers.category')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();

        return $rows->map(function($r) {
            return [
                'category' => $r->category ?? 'Unspecified',
                'total' => (float) $r->total
            ];
        })->toArray();
    }

    /**
     * Engagement by city: counts of inquiries, reviews and events grouped by city
     */
    private function getEngagementByCity($limit = 12)
    {
        // inquiries by provider city
        $inquiries = Inquiry::selectRaw('providers.city as city, COUNT(inquiries.id) as total')
            ->join('providers', 'inquiries.provider_id', '=', 'providers.id')
            ->groupBy('providers.city')
            ->get()
            ->keyBy('city')
            ->map(function($r){ return (int) $r->total; })->toArray();

        // reviews by provider city
        $reviews = Review::selectRaw('providers.city as city, COUNT(reviews.id) as total')
            ->join('providers', 'reviews.provider_id', '=', 'providers.id')
            ->groupBy('providers.city')
            ->get()
            ->keyBy('city')
            ->map(function($r){ return (int) $r->total; })->toArray();

        // events by city (events table has city column)
        $events = Event::selectRaw('city, COUNT(id) as total')
            ->groupBy('city')
            ->get()
            ->keyBy('city')
            ->map(function($r){ return (int) $r->total; })->toArray();

        // combine cities and build rows
        $cities = array_unique(array_merge(array_keys($inquiries), array_keys($reviews), array_keys($events)));
        $rows = [];
        foreach ($cities as $city) {
            $rows[] = [
                'city' => $city ?: 'Unspecified',
                'inquiries' => $inquiries[$city] ?? 0,
                'reviews' => $reviews[$city] ?? 0,
                'events' => $events[$city] ?? 0,
            ];
        }

        // sort by total engagement desc
        usort($rows, function($a, $b){
            $sa = $a['inquiries'] + $a['reviews'] + $a['events'];
            $sb = $b['inquiries'] + $b['reviews'] + $b['events'];
            return $sb <=> $sa;
        });

        return array_values(array_slice($rows, 0, $limit));
    }

    private function getWeeklyData()
    {
        $startDate = now()->subDays(30);
        
        $providers = Provider::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        $inquiries = Inquiry::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Group by week
        $data = [
            'labels' => [],
            'providers' => [],
            'inquiries' => []
        ];

        for ($i = 4; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekEnd = now()->subWeeks($i)->endOfWeek();
            $weekLabel = $weekStart->format('M d') . ' - ' . $weekEnd->format('M d');
            
            $data['labels'][] = $weekLabel;
            $data['providers'][] = $this->getCountForWeek($providers, $weekStart, $weekEnd);
            $data['inquiries'][] = $this->getCountForWeek($inquiries, $weekStart, $weekEnd);
        }

        return $data;
    }

    private function getCountForWeek($data, $start, $end)
    {
        $count = 0;
        foreach ($data as $date => $value) {
            $dateObj = \Carbon\Carbon::parse($date);
            if ($dateObj->between($start, $end)) {
                $count += $value;
            }
        }
        return $count;
    }
}