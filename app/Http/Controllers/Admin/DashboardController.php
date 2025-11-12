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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        $recentInquiries = $this->getRecentInquiries();
        $pendingProviders = $this->getPendingProviders();
        $reportedReviews = $this->getReportedReviews();
        $categoryDistribution = $this->getCategoryDistribution();
        $revenueData = $this->getRevenueData();
        $engagementData = $this->getEngagementData();
        
        return view('admin.dashboard', compact(
            'stats', 
            'recentInquiries', 
            'pendingProviders', 
            'reportedReviews',
            'categoryDistribution',
            'revenueData',
            'engagementData'
        ));
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
            'featured_providers' => Provider::where('status', 'approved')
                ->where('is_featured', 1)
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
                    'provider_id' => $inquiry->provider->id ?? null,
                    'service_type' => $inquiry->provider->category ?? 'General',
                    'date_time' => $inquiry->created_at->format('d M Y, h:i A'),
                    'status' => $inquiry->status,
                    'message' => $inquiry->message,
                ];
            });
    }

    private function getPendingProviders()
    {
        return Provider::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($provider) {
                return [
                    'id' => $provider->id,
                    'business_name' => $provider->business_name,
                    'contact_person' => $provider->contact_person,
                    'email' => $provider->email,
                    'category' => $provider->category,
                    'submitted_date' => $provider->created_at->format('d M Y'),
                    'days_pending' => $provider->created_at->diffInDays(now()),
                ];
            });
    }

    private function getReportedReviews()
    {
        return Review::with(['user', 'provider'])
            ->where('status', 'flagged')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($review) {
                return [
                    'id' => $review->id,
                    'user_name' => $review->user->first_name . ' ' . $review->user->last_name,
                    'provider_name' => $review->provider->business_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'reported_date' => $review->updated_at->format('d M Y'),
                ];
            });
    }

    private function getCategoryDistribution()
    {
        $distribution = Provider::where('status', 'approved')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->get();

        return [
            'labels' => $distribution->pluck('category')->toArray(),
            'data' => $distribution->pluck('count')->toArray(),
        ];
    }

    private function getRevenueData()
    {
        $months = collect(range(0, 11))->map(function($i) {
            return Carbon::now()->subMonths(11 - $i);
        });

        $revenueByMonth = Payment::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        $labels = [];
        $data = [];
        $cumulative = 0;
        $cumulativeData = [];

        foreach ($months as $month) {
            $key = $month->format('Y-m');
            $labels[] = $month->format('M Y');
            $monthRevenue = $revenueByMonth->get($key)->total ?? 0;
            $data[] = $monthRevenue;
            $cumulative += $monthRevenue;
            $cumulativeData[] = $cumulative;
        }

        return [
            'labels' => $labels,
            'monthly' => $data,
            'cumulative' => $cumulativeData,
        ];
    }

    private function getEngagementData()
    {
        $weeks = collect(range(0, 11))->map(function($i) {
            return Carbon::now()->subWeeks(11 - $i)->startOfWeek();
        });

        $labels = [];
        $inquiriesData = [];
        $reviewsData = [];
        $eventsData = [];

        foreach ($weeks as $week) {
            $weekEnd = $week->copy()->endOfWeek();
            $labels[] = $week->format('M d');

            $inquiriesData[] = Inquiry::whereBetween('created_at', [$week, $weekEnd])->count();
            $reviewsData[] = Review::whereBetween('created_at', [$week, $weekEnd])->count();
            $eventsData[] = Event::whereBetween('created_at', [$week, $weekEnd])->count();
        }

        return [
            'labels' => $labels,
            'inquiries' => $inquiriesData,
            'reviews' => $reviewsData,
            'events' => $eventsData,
        ];
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

        return response()->json($data);
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

        $parents = User::whereHas('roles', function($query) {
                $query->where('name', 'parent');
            })
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
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

        // Fill in missing months with zero
        $months = range(1, 12);
        $data = [
            'labels' => [],
            'providers' => [],
            'parents' => [],
            'inquiries' => [],
        ];

        foreach ($months as $month) {
            $monthName = date('M', mktime(0, 0, 0, $month, 1));
            $data['labels'][] = $monthName;
            $data['providers'][] = $providers[$month] ?? 0;
            $data['parents'][] = $parents[$month] ?? 0;
            $data['inquiries'][] = $inquiries[$month] ?? 0;
        }

        return $data;
    }

    private function getWeeklyData()
    {
        $weeks = collect(range(0, 11))->map(function($i) {
            return Carbon::now()->subWeeks(11 - $i)->startOfWeek();
        });

        $data = [
            'labels' => [],
            'providers' => [],
            'parents' => [],
            'inquiries' => []
        ];

        foreach ($weeks as $week) {
            $weekEnd = $week->copy()->endOfWeek();
            $weekLabel = $week->format('M d') . ' - ' . $weekEnd->format('M d');
            
            $data['labels'][] = $weekLabel;
            $data['providers'][] = Provider::whereBetween('created_at', [$week, $weekEnd])->count();
            $data['parents'][] = User::whereHas('roles', function($query) {
                    $query->where('name', 'parent');
                })
                ->whereBetween('created_at', [$week, $weekEnd])
                ->count();
            $data['inquiries'][] = Inquiry::whereBetween('created_at', [$week, $weekEnd])->count();
        }

        return $data;
    }

    public function approveProvider(Request $request, $id)
    {
        $provider = Provider::findOrFail($id);
        $provider->status = 'approved';
        $provider->save();

        return response()->json(['success' => true, 'message' => 'Provider approved successfully']);
    }

    public function rejectProvider(Request $request, $id)
    {
        $provider = Provider::findOrFail($id);
        $provider->status = 'rejected';
        $provider->save();

        return response()->json(['success' => true, 'message' => 'Provider rejected successfully']);
    }

    public function moderateReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $action = $request->input('action'); // 'approve', 'reject', 'hide'
        
        $statusMap = [
            'approve' => 'approved',
            'reject' => 'rejected',
            'hide' => 'hidden'
        ];

        $review->status = $statusMap[$action] ?? 'pending';
        $review->save();

        return response()->json(['success' => true, 'message' => 'Review moderated successfully']);
    }

    public function markInquiryResolved(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->status = 'contacted';
        $inquiry->responded_at = now();
        $inquiry->save();

        return response()->json(['success' => true, 'message' => 'Inquiry marked as resolved']);
    }

    public function exportRevenue(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $payments = Payment::with(['provider', 'subscription'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($format === 'csv') {
            $filename = 'revenue_export_' . now()->format('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($payments) {
                $file = fopen('php://output', 'w');
                
                // Header row
                fputcsv($file, ['Date', 'Transaction ID', 'Provider', 'Amount', 'Currency', 'Payment Method', 'Status']);
                
                // Data rows
                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->created_at->format('Y-m-d H:i:s'),
                        $payment->transaction_id,
                        $payment->provider->business_name ?? 'N/A',
                        $payment->amount,
                        $payment->currency,
                        $payment->payment_method ?? 'N/A',
                        $payment->status,
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return response()->json(['error' => 'Invalid format'], 400);
    }
}