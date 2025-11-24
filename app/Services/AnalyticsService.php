<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Review;
use App\Models\Cleaner;
use App\Models\Inquiry;
use App\Models\Cleaner as Provider ;
use App\Models\RecentlyViewed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AnalyticsService
{
    public function getOverview(): array
    {
        // Total page views - using RecentlyViewed model
        $pageViews = 0;
        if (Schema::hasTable('recently_viewed')) {
            try {
                $pageViews = RecentlyViewed::count();
            } catch (\Throwable $e) {
                $pageViews = 0;
            }
        }

        // Total inquiries - using Inquiry model
        $inquiries = 0;
        if (Schema::hasTable('inquiries')) {
            $inquiries = Inquiry::count();
        }

        // Active users (last 30 days)
        $activeUsers = 0;
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'last_login_at')) {
                $activeUsers = DB::table('users')->where('last_login_at', '>=', Carbon::now()->subDays(30))->count();
            } else {
                $activeUsers = DB::table('users')->where('created_at', '>=', Carbon::now()->subDays(30))->count();
            }
        }

        // Conversion rate = inquiries / pageViews
        $conversionRate = 0.0;
        if ($pageViews > 0) {
            $conversionRate = round(($inquiries / $pageViews) * 100, 2);
        }

        // Revenue metrics
        $revenueMetrics = $this->getRevenueMetrics();
        $growthMetrics = $this->getGrowthMetrics();
        $subscriptionMetrics = $this->getSubscriptionMetrics();
        $reviewMetrics = $this->getReviewMetrics();

        return array_merge([
            'total_page_views' => $pageViews,
            'total_inquiries' => $inquiries,
            'conversion_rate' => $conversionRate,
            'active_users' => $activeUsers,
        ], $revenueMetrics, $growthMetrics, $subscriptionMetrics, $reviewMetrics);
    }

    private function getRevenueMetrics(): array
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();
        
        // Current month revenue
        $currentRevenue = DB::table('payments')
            ->where('status', 'completed')
            ->where('created_at', '>=', $currentMonth)
            ->sum('amount') ?? 0;

        // Previous month revenue
        $previousRevenue = DB::table('payments')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$previousMonth, $currentMonth])
            ->sum('amount') ?? 0;

        // MoM growth rate
        $growthRate = $previousRevenue > 0 ? 
            (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;

        // Failed payments
        $failedPayments = DB::table('payments')
            ->where('status', 'failed')
            ->where('created_at', '>=', $currentMonth)
            ->count();

        // Refunds
        $refunds = DB::table('payments')
            ->where('status', 'refunded')
            ->where('created_at', '>=', $currentMonth)
            ->sum('amount') ?? 0;

        return [
            'current_revenue' => $currentRevenue,
            'previous_revenue' => $previousRevenue,
            'revenue_growth_rate' => round($growthRate, 2),
            'failed_payments' => $failedPayments,
            'refunds_amount' => $refunds,
        ];
    }

    private function getGrowthMetrics(): array
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();

        // New subscriptions this month
        $newSubscriptions = DB::table('subscriptions')
            ->where('created_at', '>=', $currentMonth)
            ->count();

        // Renewals this month
        $renewals = DB::table('subscriptions')
            ->where('renews_at', '>=', $currentMonth)
            ->where('renews_at', '<', Carbon::now()->addMonth()->startOfMonth())
            ->count();

        // Churn calculation (cancelled subscriptions this month)
        $churned = DB::table('subscriptions')
            ->where('status', 'cancelled')
            ->where('cancelled_at', '>=', $currentMonth)
            ->count();

        $totalActiveSubs = DB::table('subscriptions')
            ->where('status', 'active')
            ->where('is_active', true)
            ->count();

        $churnRate = $totalActiveSubs > 0 ? ($churned / $totalActiveSubs) * 100 : 0;

        return [
            'new_subscriptions' => $newSubscriptions,
            'renewals_count' => $renewals,
            'churn_rate' => round($churnRate, 2),
            'total_active_subscriptions' => $totalActiveSubs,
        ];
    }

    private function getSubscriptionMetrics(): array
    {
        // Renewal rate calculation
        $renewals = DB::table('subscriptions')
            ->where('status', 'active')
            ->whereNotNull('renews_at')
            ->count();

        $totalEligible = DB::table('subscriptions')
            ->whereIn('status', ['active', 'pending_renewal'])
            ->count();

        $renewalRate = $totalEligible > 0 ? ($renewals / $totalEligible) * 100 : 0;

        return [
            'renewal_rate' => round($renewalRate, 2),
        ];
    }

    private function getReviewMetrics(): array
    {
        $totalReviews = Review::count();
        $approvedReviews = Review::where('status', 'approved')->count();
        $pendingReviews = Review::where('status', 'pending')->count();
        
        // Average rating
        $averageRating = Review::where('status', 'approved')->avg('rating') ?? 0;

        // Recent reviews (last 30 days)
        $recentReviews = Review::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        return [
            'total_reviews' => $totalReviews,
            'approved_reviews' => $approvedReviews,
            'pending_reviews' => $pendingReviews,
            'average_rating' => round($averageRating, 1),
            'recent_reviews' => $recentReviews,
        ];
    }

    public function getRevenueTrends(string $period = '6_months'): array
    {
        $months = $this->getPeriodMonths($period);
        $labels = [];
        $revenue = [];
        $newSubscribers = [];
        $returningSubscribers = [];

        foreach ($months as $month) {
            $labels[] = $month->format('M Y');
            
            // Revenue for the month
            $monthRevenue = DB::table('payments')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->sum('amount') ?? 0;
            $revenue[] = $monthRevenue;

            // New vs Returning subscribers
            $newSubs = DB::table('subscriptions')
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
            $newSubscribers[] = $newSubs;

            // Returning subscribers (renewals)
            $returningSubs = DB::table('subscriptions')
                ->whereBetween('renews_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->where('status', 'active')
                ->count();
            $returningSubscribers[] = $returningSubs;
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'new_subscribers' => $newSubscribers,
            'returning_subscribers' => $returningSubscribers,
            'active_subscribers' => $this->getActiveSubscribersByMonth($months),
        ];
    }

    private function getPeriodMonths(string $period): array
    {
        $months = [];
        $start = Carbon::now()->startOfMonth();
        
        switch ($period) {
            case '1_year':
                $count = 12;
                break;
            case '3_months':
                $count = 3;
                break;
            case '1_month':
                $count = 1;
                break;
            default: // 6_months
                $count = 6;
        }

        for ($i = $count - 1; $i >= 0; $i--) {
            $months[] = $start->copy()->subMonths($i);
        }

        return $months;
    }

    private function getActiveSubscribersByMonth(array $months): array
    {
        $activeSubs = [];
        
        foreach ($months as $month) {
            $count = DB::table('subscriptions')
                ->where('status', 'active')
                ->where('is_active', true)
                ->where('started_at', '<=', $month->copy()->endOfMonth())
                ->where(function($query) use ($month) {
                    $query->whereNull('renews_at')
                          ->orWhere('renews_at', '>=', $month->copy()->startOfMonth());
                })
                ->count();
            $activeSubs[] = $count;
        }

        return $activeSubs;
    }

    public function getSubscriptionDistribution(): array
    {
        $plans = DB::table('plans')
            ->where('is_active', true)
            ->get();

        $distribution = [];
        $revenueByPlan = [];
        $totalRevenue = 0;

        foreach ($plans as $plan) {
            $subscriberCount = DB::table('subscriptions')
                ->where('plan_id', $plan->id)
                ->where('status', 'active')
                ->where('is_active', true)
                ->count();

            $planRevenue = DB::table('payments')
                ->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
                ->where('subscriptions.plan_id', $plan->id)
                ->where('payments.status', 'completed')
                ->where('payments.created_at', '>=', Carbon::now()->subMonth())
                ->sum('payments.amount') ?? 0;

            $totalRevenue += $planRevenue;

            $distribution[] = [
                'plan_name' => $plan->name,
                'plan_type' => $plan->type,
                'monthly_fee' => $plan->monthly_fee,
                'subscriber_count' => $subscriberCount,
                'revenue' => $planRevenue,
                'color' => $this->getPlanColor($plan->type),
            ];
        }

        // Calculate revenue share
        foreach ($distribution as &$plan) {
            $plan['revenue_share'] = $totalRevenue > 0 ? ($plan['revenue'] / $totalRevenue) * 100 : 0;
        }

        return $distribution;
    }

    private function getPlanColor(string $type): string
    {
        $colors = [
            'Basic' => '#95a5a6',
            'Standard' => '#3498db', 
            'Premium' => '#9b59b6',
            'Featured' => '#f39c12'
        ];

        return $colors[$type] ?? '#bdc3c7';
    }

    public function getPricingPlanSummary(): array
    {
        $plans = DB::table('plans')
            ->where('is_active', true)
            ->get();

        $summary = [];

        foreach ($plans as $plan) {
            $subscriberCount = DB::table('subscriptions')
                ->where('plan_id', $plan->id)
                ->where('status', 'active')
                ->count();

            $totalRevenue = DB::table('payments')
                ->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
                ->where('subscriptions.plan_id', $plan->id)
                ->where('payments.status', 'completed')
                ->where('payments.created_at', '>=', Carbon::now()->subMonth())
                ->sum('payments.amount') ?? 0;

            // Calculate conversion rate using Inquiry model
            $totalInquiries = Inquiry::count();
            $planConversions = $subscriberCount;
            $conversionRate = $totalInquiries > 0 ? ($planConversions / $totalInquiries) * 100 : 0;

            $summary[] = [
                'id' => $plan->id,
                'name' => $plan->name,
                'type' => $plan->type,
                'monthly_fee' => $plan->monthly_fee,
                'annual_fee' => $plan->annual_fee,
                'subscriber_count' => $subscriberCount,
                'revenue' => $totalRevenue,
                'conversion_rate' => round($conversionRate, 2),
                'status' => $plan->is_active ? 'Active' : 'Inactive',
                'description' => $plan->description,
            ];
        }

        return $summary;
    }

    public function getCohortAnalysis(): array
    {
        $cohortData = [];
        $signupMonths = DB::table('subscriptions')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as signup_month'))
            ->groupBy('signup_month')
            ->orderBy('signup_month')
            ->limit(6)
            ->get()
            ->pluck('signup_month');

        foreach ($signupMonths as $month) {
            $cohortRow = ['signup_month' => $month];
            $signupDate = Carbon::createFromFormat('Y-m', $month);
            
            for ($i = 0; $i <= 6; $i++) {
                $periodEnd = $signupDate->copy()->addMonths($i)->endOfMonth();
                $retainedCount = DB::table('subscriptions')
                    ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $month)
                    ->where(function($query) use ($periodEnd) {
                        $query->whereNull('cancelled_at')
                              ->orWhere('cancelled_at', '>', $periodEnd);
                    })
                    ->where('status', 'active')
                    ->count();

                $totalSignups = DB::table('subscriptions')
                    ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $month)
                    ->count();

                $retentionRate = $totalSignups > 0 ? ($retainedCount / $totalSignups) * 100 : 0;
                $cohortRow["month_{$i}"] = round($retentionRate, 1);
            }

            $cohortData[] = $cohortRow;
        }

        return $cohortData;
    }

    public function getForecast(): array
    {
        // Simple forecasting based on recent growth
        $currentRevenue = DB::table('payments')
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('amount') ?? 0;

        $lastMonthRevenue = DB::table('payments')
            ->where('status', 'completed')
            ->whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->sum('amount') ?? 0;

        $growthRate = $lastMonthRevenue > 0 ? 
            (($currentRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 10;

        $projectedNextMonth = $currentRevenue * (1 + ($growthRate / 100));
        $estimatedAnnual = $currentRevenue * 12 * (1 + (min($growthRate, 35) / 100));

        return [
            'projected_next_month' => round($projectedNextMonth, 2),
            'projected_growth_rate' => round($growthRate, 2),
            'estimated_annual_growth' => 35, // Conservative estimate
            'estimated_annual_revenue' => round($estimatedAnnual, 2),
        ];
    }

    public function getSubscriptionSeries(): array
    {
        $labels = [];
        $basic = [];
        $standard = [];
        $premium = [];

        $start = Carbon::now()->subMonths(5)->startOfMonth();
        for ($i = 0; $i < 6; $i++) {
            $m = $start->copy()->addMonths($i);
            $labels[] = $m->format('M');

            $basic[] = DB::table('subscriptions')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->where('plans.type', 'Basic')
                ->whereBetween('subscriptions.created_at', [$m->copy()->startOfMonth(), $m->copy()->endOfMonth()])
                ->count();

            $standard[] = DB::table('subscriptions')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->where('plans.type', 'Standard')
                ->whereBetween('subscriptions.created_at', [$m->copy()->startOfMonth(), $m->copy()->endOfMonth()])
                ->count();

            $premium[] = DB::table('subscriptions')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->where('plans.type', 'Premium')
                ->whereBetween('subscriptions.created_at', [$m->copy()->startOfMonth(), $m->copy()->endOfMonth()])
                ->count();
        }

        return [
            'labels' => $labels, 
            'basic' => $basic,
            'standard' => $standard,
            'premium' => $premium
        ];
    }

    public function getCleanerCategories(): array
    {
        if (Schema::hasTable('categories')) {
            $rows = DB::table('categories')
                ->select('name', DB::raw('cleaners_count as count'))
                ->where('status', 1)
                ->orderBy('cleaners_count', 'desc')
                ->get();

            $labels = $rows->pluck('name')->toArray();
            $data = $rows->pluck('count')->toArray();

            return ['labels' => $labels, 'data' => $data];
        }

        return ['labels' => ['Daycare','Preschool','Tutoring','Activity Centers','After School','Other'], 'data' => [156,89,67,45,34,23]];
    }

    public function getArpuSeries(): array
    {
        $labels = [];
        $arpu = [];
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        
        for ($i = 0; $i < 6; $i++) {
            $m = $start->copy()->addMonths($i);
            $labels[] = $m->format('M');
            
            $total = DB::table('payments')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$m->copy()->startOfMonth(), $m->copy()->endOfMonth()])
                ->sum('amount') ?? 0;
                
            $users = DB::table('users')->where('created_at', '<=', $m->copy()->endOfMonth())->count();
            $arpu[] = $users > 0 ? round($total / $users, 2) : 0;
        }

        return ['labels' => $labels, 'data' => $arpu];
    }

    public function getTopCleaners(int $limit = 6): array
{
    if (Schema::hasTable('cleaners')) {
        $rows = Cleaner::with('approvedReviews', 'inquiries', 'recentlyViewed') // load relationships
            ->select('business_name as name') // you can only select columns from table itself
            ->where('status', 'approved')
            ->get()
            ->map(function ($r) {
                $totalView = $r->totalView();
                $totalInquiries = $r->totalInquiries();
                $averageRating = $r->averageRating();

                $conversion = $totalView > 0 ? ($totalInquiries / $totalView) * 100 : 0;
                $performance = $conversion >= 2 ? 'High' : ($conversion >= 1 ? 'Medium' : 'Low');

                return [
                    'name' => $r->name,
                    'views' => $totalView,
                    'inquiries' => $totalInquiries,
                    'rating' => $averageRating,
                    'conversion' => round($conversion, 1),
                    'performance' => $performance
                ];
            })
            ->sortByDesc('views') // sort after mapping
            ->take($limit)
            ->values()
            ->toArray();

        return $rows;
    }

    return [];
}
    // New methods for review and click analytics
    public function getReviewAnalytics(): array
    {
        $totalReviews = Review::count();
        $approvedReviews = Review::where('is_approved', true)->count();
        $pendingReviews = Review::where('is_approved', false)->count();
        $averageRating = Review::where('is_approved', true)->avg('rating') ?? 0;

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = Review::where('rating', $i)->where('is_approved', true)->count();
        }

        // Recent reviews trend (last 6 months)
        $recentMonths = [];
        $reviewTrend = [];
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        
        for ($i = 0; $i < 6; $i++) {
            $month = $start->copy()->addMonths($i);
            $recentMonths[] = $month->format('M Y');
            $reviewTrend[] = Review::whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth()
            ])->count();
        }

        return [
            'total_reviews' => $totalReviews,
            'approved_reviews' => $approvedReviews,
            'pending_reviews' => $pendingReviews,
            'average_rating' => round($averageRating, 1),
            'rating_distribution' => $ratingDistribution,
            'review_trend' => [
                'labels' => $recentMonths,
                'data' => $reviewTrend
            ]
        ];
    }

    public function getClickAnalytics(): array
    {
        // Get recent views using RecentlyViewed model
        $recentViews = RecentlyViewed::where('viewed_at', '>=', Carbon::now()->subDays(30))->count();
        
        // Get unique viewers
        $uniqueViewers = RecentlyViewed::where('viewed_at', '>=', Carbon::now()->subDays(30))
            ->distinct('user_id')
            ->count('user_id');

        // Views by day (last 7 days)
        $dailyViews = [];
        $dailyLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyLabels[] = $date->format('D');
            $dailyViews[] = RecentlyViewed::whereDate('viewed_at', $date)->count();
        }

        // Most viewed providers
        $mostViewedProviders = DB::table('recently_viewed')
            ->join('cleaners', 'recently_viewed.cleaner_id', '=', 'cleaners.id')
            ->select('cleaners.business_name', DB::raw('COUNT(recently_viewed.id) as view_count'))
            ->where('recently_viewed.viewed_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('cleaners.id', 'cleaners.business_name')
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        return [
            'recent_views' => $recentViews,
            'unique_viewers' => $uniqueViewers,
            'daily_views' => [
                'labels' => $dailyLabels,
                'data' => $dailyViews
            ],
            'most_viewed_providers' => $mostViewedProviders
        ];
    }

    public function getInquiryAnalytics(): array
    {
        $totalInquiries = Inquiry::count();
        $recentInquiries = Inquiry::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        
        // Inquiry status breakdown
        $statusBreakdown = Inquiry::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Inquiries by day (last 7 days)
        $dailyInquiries = [];
        $dailyLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyLabels[] = $date->format('D');
            $dailyInquiries[] = Inquiry::whereDate('created_at', $date)->count();
        }

        return [
            'total_inquiries' => $totalInquiries,
            'recent_inquiries' => $recentInquiries,
            'status_breakdown' => $statusBreakdown,
            'daily_trend' => [
                'labels' => $dailyLabels,
                'data' => $dailyInquiries
            ]
        ];
    }
}