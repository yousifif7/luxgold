<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\Inquiry;
use App\Models\Event;
use App\Models\Review;
use App\Models\SavedProvider;
use App\Models\FollowedProvider;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProviderPanelController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $provider = auth()->user()->provider;
        
        if (!$provider) {
            return redirect()->route('provider.profile.create')
                ->with('error', 'Please complete your provider profile first.');
        }

        $stats = $this->getDashboardStats($provider);
        $chartData = $this->getChartData($provider);
        $inquiryStats = $this->getInquiryStats($provider);
        $notifications = $this->getNotifications($provider);
        echo json_encode($this->getSubscriptionStatus($provider)); exit;

        return view('panels.provider.index', compact('stats', 'chartData', 'inquiryStats', 'notifications'));
    }

    private function getDashboardStats(Provider $provider)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Profile views (current month vs last month)
        $currentMonthViews = $provider->views;
        $lastMonthViews = $provider->views; // You might need to implement monthly view tracking

        // Inquiries
        $totalInquiries = Inquiry::where('provider_id', $provider->id)->count();
        $monthlyInquiries = Inquiry::where('provider_id', $provider->id)
            ->where('created_at', '>=', $startOfMonth)
            ->count();
        $lastMonthInquiries = Inquiry::where('provider_id', $provider->id)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        // Events
        $totalEvents = Event::where('provider_id', $provider->id)->count();
        $activeEvents = Event::where('provider_id', $provider->id)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->count();

        // Reviews and ratings
        $averageRating = Review::where('provider_id', $provider->id)
            ->where('status', 'approved')
            ->avg('rating') ?? 0;
        $totalReviews = Review::where('provider_id', $provider->id)
            ->where('status', 'approved')
            ->count();

        // Engagement metrics
        $savesCount = SavedProvider::where('provider_id', $provider->id)->count();
        $followersCount = FollowedProvider::where('provider_id', $provider->id)->count();

        // Response metrics
        $respondedInquiries = Inquiry::where('provider_id', $provider->id)
            ->whereNotNull('responded_at')
            ->count();
        $responseRate = $totalInquiries > 0 ? ($respondedInquiries / $totalInquiries) * 100 : 0;

        // Subscription info
        $subscription = $this->getSubscriptionStatus($provider);

        return [
            // Profile Views
            'profile_views' => [
                'total' => $currentMonthViews,
                'monthly' => $monthlyInquiries, // Using inquiries as proxy for monthly views
                'change' => $lastMonthInquiries > 0 ? 
                    (($monthlyInquiries - $lastMonthInquiries) / $lastMonthInquiries) * 100 : 0,
                'trend' => $monthlyInquiries >= $lastMonthInquiries ? 'up' : 'down'
            ],

            // Inquiries
            'inquiries' => [
                'total' => $totalInquiries,
                'monthly' => $monthlyInquiries,
                'change' => $lastMonthInquiries > 0 ? 
                    (($monthlyInquiries - $lastMonthInquiries) / $lastMonthInquiries) * 100 : 0,
                'trend' => $monthlyInquiries >= $lastMonthInquiries ? 'up' : 'down'
            ],

            // Events
            'events' => [
                'total' => $totalEvents,
                'active' => $activeEvents,
                'upcoming' => Event::where('provider_id', $provider->id)
                    ->where('start_date', '>', now())
                    ->where('status', 'active')
                    ->count()
            ],

            // Ratings
            'ratings' => [
                'average' => round($averageRating, 1),
                'total' => $totalReviews,
                'distribution' => $this->getRatingDistribution($provider)
            ],

            // Engagement
            'engagement' => [
                'saves' => $savesCount,
                'followers' => $followersCount,
                'response_rate' => round($responseRate, 1)
            ],

            // Business Info
            'business_name' => $provider->business_name ?? 'Provider',
            'profile_status' => $provider->status,
            'subscription_status' => $subscription,

            // Quick Stats
            'quick_stats' => [
                'pending_inquiries' => Inquiry::where('provider_id', $provider->id)
                    ->where('status', 'pending')
                    ->count(),
                'upcoming_events' => Event::where('provider_id', $provider->id)
                    ->where('start_date', '>', now())
                    ->where('status', 'active')
                    ->count(),
                'new_reviews' => Review::where('provider_id', $provider->id)
                    ->where('status', 'pending')
                    ->count(),
            ]
        ];
    }

    private function getRatingDistribution(Provider $provider)
    {
        return Review::where('provider_id', $provider->id)
            ->where('status', 'approved')
            ->select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->pluck('count', 'rating')
            ->toArray();
    }

    private function getInquiryStats(Provider $provider)
    {
        $inquiries = Inquiry::where('provider_id', $provider->id)->get();
        
        $statusCounts = $inquiries->groupBy('status')->map->count();
        $totalInquiries = $inquiries->count();

        return [
            'total' => $totalInquiries,
            'by_status' => [
                'pending' => $statusCounts['pending'] ?? 0,
                'contacted' => $statusCounts['contacted'] ?? 0,
                'approved' => $statusCounts['approved'] ?? 0,
                'rejected' => $statusCounts['rejected'] ?? 0,
            ],
            'conversion_rate' => $totalInquiries > 0 ? 
                (($statusCounts['approved'] ?? 0) / $totalInquiries) * 100 : 0,
            'response_time' => $this->calculateAverageResponseTime($provider)
        ];
    }

    private function calculateAverageResponseTime(Provider $provider)
    {
        $respondedInquiries = Inquiry::where('provider_id', $provider->id)
            ->whereNotNull('responded_at')
            ->get();

        if ($respondedInquiries->isEmpty()) {
            return null;
        }

        $totalHours = 0;
        foreach ($respondedInquiries as $inquiry) {
            $responseTime = $inquiry->created_at->diffInHours($inquiry->responded_at);
            $totalHours += $responseTime;
        }

        return round($totalHours / $respondedInquiries->count(), 1);
    }

    private function getChartData(Provider $provider)
    {
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Daily profile views (you'll need to implement this tracking)
        $viewsData = DB::table('recently_viewed') // You might need to create this table
            ->where('provider_id', $provider->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('created_at as date', DB::raw('COUNT(*) as views'))
            ->groupBy('created_at')
            ->get()
            ->pluck('views', 'date')
            ->toArray();

        // Daily inquiries
        $inquiriesData = Inquiry::where('provider_id', $provider->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as inquiries'))
            ->groupBy('date')
            ->get()
            ->pluck('inquiries', 'date')
            ->toArray();

        // Monthly saves/follows (example - you might need to adjust based on your tracking)
        $savesData = SavedProvider::where('provider_id', $provider->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as saves'))
            ->groupBy('date')
            ->get()
            ->pluck('saves', 'date')
            ->toArray();

        // Fill in missing days
        $labels = [];
        $views = [];
        $inquiries = [];
        $saves = [];

        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->format('M j');
            
            $labels[] = $dayName;
            $views[] = $viewsData[$date] ?? 0;
            $inquiries[] = $inquiriesData[$date] ?? 0;
            $saves[] = $savesData[$date] ?? 0;
        }

        return [
            'labels' => $labels,
            'views' => $views,
            'inquiries' => $inquiries,
            'saves' => $saves,
            'max_views' => max($views) ?: 1,
            'max_inquiries' => max($inquiries) ?: 1,
            'max_saves' => max($saves) ?: 1
        ];
    }

    private function getSubscriptionStatus(Provider $provider)
    {
        $subscription = Subscription::where('provider_id', $provider->id)
            ->where('status', 'active')
            ->first();

        if (!$subscription) {
            return [
                'status' => 'inactive',
                'plan_name' => 'Basic',
                'renews_at' => null,
                'is_premium' => false,
                'days_remaining' => 0
            ];
        }

        $plan = Plan::find($subscription->plan_id);
        $daysRemaining = $subscription->renews_at ? now()->diffInDays($subscription->renews_at, false) : 0;

        return [
            'status' => 'active',
            'plan_name' => $plan->name ?? 'Unknown',
            'renews_at' => $subscription->renews_at,
            'is_premium' => $plan && $plan->type !== 'Basic',
            'days_remaining' => max(0, $daysRemaining)
        ];
    }

    private function getNotifications(Provider $provider)
    {
        return $provider->user->notifications()
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }


    public function subscription()
    {
        $provider = auth()->user();
        $plans = Plan::where('is_active', true)->get();
        
        // Get current active subscription
        $currentSubscription = Subscription::where('provider_id', $provider->id)
            ->where('is_active', true)
            ->orderBy('id','DESC')
            ->where(function($query) {
                $query->where('renews_at', '>', now())
                      ->orWhereNull('renews_at');
            })
            ->with('plan')
            ->first();

        // Get billing history
        $billingHistory = Payment::where('provider_id', $provider->id)
            ->where('status', 'completed')
            ->with('subscription.plan')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('panels.provider.subscription', compact(
            'plans', 
            'currentSubscription', 
            'billingHistory',
            'provider'
        ));
    }

    /**
     * Process plan upgrade/downgrade
     */
    public function changePlan(Request $request, Plan $plan)
    {
        $provider = auth()->user();
        
        // Check if this is the current plan
        $currentSubscription = Subscription::where('provider_id', $provider->id)
            ->where('status', 'active')
            ->where('is_active', true)
            ->first();

        if ($currentSubscription && $currentSubscription->plan_id == $plan->id) {
            return redirect()->back()->with('info', 'You are already on this plan.');
        }

        // If plan is free, activate immediately
        if ($plan->monthly_fee <= 0) {
            // Deactivate current subscription
            if ($currentSubscription) {
                $currentSubscription->update(['is_active' => false]);
            }

            // Create new free subscription
            $subscription = Subscription::create([
                'provider_id' => $provider->id,
                'plan_id' => $plan->id,
                'plan' => $plan->name,
                'amount' => $plan->monthly_fee,
                'currency' => $plan->currency ?? 'USD',
                'status' => 'active',
                'is_active' => true,
                'started_at' => now(),
                'renews_at' => now()->addDays($plan->duration_days ?? 30),
                'meta' => [
                    'plan_features' => $plan->features,
                    'auto_renew' => true,
                    'is_free' => true,
                ],
            ]);

            // Update provider's plan
            $provider->update(['plan_id' => $plan->id]);

            return redirect()->route('provider-subscription')
                ->with('success', 'Plan changed successfully!');
        }

        // For paid plans, redirect to payment
        return redirect()->route('subscriptions.checkout', ['plan' => $plan->id]);
    }

    /**
     * Toggle auto-renewal
     */
    public function toggleAutoRenewal(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'auto_renew' => 'required|boolean',
        ]);

        $subscription = Subscription::where('id', $request->subscription_id)
            ->where('provider_id', auth()->id())
            ->firstOrFail();

        $subscription->update([
            'meta->auto_renew' => $request->auto_renew,
        ]);

        $message = $request->auto_renew 
            ? 'Auto-renewal enabled successfully.' 
            : 'Auto-renewal disabled successfully.';

        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * Download invoice
     */
    public function downloadInvoice(Payment $payment)
    {
        // Verify the payment belongs to the authenticated provider
        if ($payment->provider_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Generate PDF invoice (you'll need to implement this)
        return $this->generateInvoicePdf($payment);
    }
}