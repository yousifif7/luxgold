<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Subscription;
use App\Services\AnalyticsService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Services\ReviewAnalysisService;
use Illuminate\Http\Request;


class AnalyticsController extends Controller
{
    protected AnalyticsService $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    public function index(Request $request)
    {
        $period = $request->get('period', '6_months');
        
        $overview = $this->analytics->getOverview();
        $revenueTrends = $this->analytics->getRevenueTrends($period);
        $subscriptionDistribution = $this->analytics->getSubscriptionDistribution();
        $pricingPlanSummary = $this->analytics->getPricingPlanSummary();
        $cohortAnalysis = $this->analytics->getCohortAnalysis();
        $forecast = $this->analytics->getForecast();

        // Existing data for backward compatibility
        $subscriptions = $this->analytics->getSubscriptionSeries();
        $providerCats = $this->analytics->getCleanerCategories();
        $arpu = $this->analytics->getArpuSeries();
        $topProviders = $this->analytics->getTopCleaners();

        // Additional metrics
        $totalParents = User::role('customer')->count();
        $totalProviders = User::role('cleaner')->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $monthlyRevenue = $overview['current_revenue'] ?? 0;
        $newSignups = $overview['new_subscriptions'] ?? 0;

        // Recent subscriptions
        $recentSubscriptions = [];
        $subscriptionRows = Subscription::with(['cleaner', 'plan'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $recentSubscriptions = $subscriptionRows->map(function($s){
            return [
                'provider' => $s->cleaner->business_name ?? '—',
                'plan' => $s->plan->name ?? '—',
                'amount' => $s->plan->monthly_fee ?? 0,
                'date' => $s->created_at ? $s->created_at->toDateString() : '',
                'status' => $s->status ?? 'active'
            ];
        })->toArray();

        // Business-impact KPI tiles (safe, best-effort calculations)
        $startPrev = Carbon::now()->subMonth()->startOfMonth();
        $endPrev = Carbon::now()->subMonth()->endOfMonth();

        // Growth (MoM) based on subscription revenue if available
        $momGrowth = null;
        if (Schema::hasColumn('subscriptions', 'amount')) {
            $currentRevenue = (float) Subscription::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
            $prevRevenue = (float) Subscription::whereBetween('created_at', [$startPrev, $endPrev])->sum('amount');
            if ($prevRevenue > 0) {
                $momGrowth = (($currentRevenue - $prevRevenue) / $prevRevenue) * 100;
            } elseif ($currentRevenue > 0) {
                $momGrowth = 100.0;
            }
        }

        // Churn rate (best-effort)
        $churn = null;
        if (Schema::hasColumn('subscriptions', 'status')) {
            $cancelled = Subscription::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'cancelled')->count();
            $prevTotal = Subscription::whereBetween('created_at', [$startPrev, $endPrev])->count();
            if ($prevTotal > 0) $churn = ($cancelled / $prevTotal) * 100;
        } elseif (Schema::hasColumn('subscriptions', 'cancelled_at')) {
            $cancelled = Subscription::whereBetween('cancelled_at', [$startOfMonth, $endOfMonth])->count();
            $prevTotal = Subscription::whereBetween('created_at', [$startPrev, $endPrev])->count();
            if ($prevTotal > 0) $churn = ($cancelled / $prevTotal) * 100;
        }

        // Acquisition
        $newSubscriptions = Subscription::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Engagement: renewals (if present)
        $renewals = null; $renewalRate = null;
        if (Schema::hasColumn('subscriptions', 'is_renewal')) {
            $renewals = Subscription::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('is_renewal', 1)->count();
            if ($newSubscriptions > 0) $renewalRate = ($renewals / $newSubscriptions) * 100;
        }

        // Operational: failed payments / refunds (best-effort)
        $failedPayments = null;
        if (Schema::hasTable('payments')) {
            $failedPayments = DB::table('payments')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->whereIn('status', ['failed','refunded','chargeback'])->count();
        } elseif (Schema::hasTable('transactions')) {
            $failedPayments = DB::table('transactions')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->whereIn('status', ['failed','refunded','chargeback'])->count();
        }

        $kpis = [
            'growth' => [
                'label' => 'MoM Growth Rate (%)',
                'value' => is_null($momGrowth) ? 'N/A' : number_format($momGrowth,2) . '%',
                'why' => 'Shows monthly growth trend in MRR.'
            ],
            'retention' => [
                'label' => 'Churn Rate (%)',
                'value' => is_null($churn) ? 'N/A' : number_format($churn,2) . '%',
                'why' => 'Key for subscription models.'
            ],
            'acquisition' => [
                'label' => 'New Subscriptions (This Month)',
                'value' => $newSubscriptions,
                'why' => 'Helps correlate marketing performance.'
            ],
            'engagement' => [
                'label' => 'Renewals Count / %',
                'value' => is_null($renewals) ? 'N/A' : ($renewals . (is_null($renewalRate) ? '' : ' (' . number_format($renewalRate,1) . '%)')),
                'why' => 'Indicates loyalty and value realization.'
            ],
            'operational' => [
                'label' => 'Failed Payments / Refunds',
                'value' => is_null($failedPayments) ? 'N/A' : $failedPayments,
                'why' => 'Crucial for cash flow oversight.'
            ],
        ];

        // Build 6-month series for sparklines (months labels and per-metric arrays)
        $months = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i);
            $months[] = $m->format('Y-m');
            $labels[] = $m->format('M Y');
        }

        $rangeStart = Carbon::now()->subMonths(5)->startOfMonth();
        $rangeEnd = Carbon::now()->endOfMonth();

        // revenue series (sum amount per month)
        $revenueMap = [];
        if (Schema::hasColumn('subscriptions', 'amount')) {
            $rows = DB::table('subscriptions')
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(amount) as total")
                ->whereBetween('created_at', [$rangeStart, $rangeEnd])
                ->groupBy('ym')
                ->pluck('total', 'ym')
                ->toArray();
            $revenueMap = $rows;
        }

        // new subscriptions per month
        $newMap = DB::table('subscriptions')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
            ->whereBetween('created_at', [$rangeStart, $rangeEnd])
            ->groupBy('ym')
            ->pluck('cnt','ym')
            ->toArray();

        // cancelled per month (try cancelled_at then status)
        $cancelMap = [];
        if (Schema::hasColumn('subscriptions', 'cancelled_at')) {
            $cancelMap = DB::table('subscriptions')
                ->selectRaw("DATE_FORMAT(cancelled_at, '%Y-%m') as ym, COUNT(*) as cnt")
                ->whereBetween('cancelled_at', [$rangeStart, $rangeEnd])
                ->groupBy('ym')
                ->pluck('cnt','ym')
                ->toArray();
        } elseif (Schema::hasColumn('subscriptions', 'status')) {
            $cancelMap = DB::table('subscriptions')
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
                ->whereBetween('created_at', [$rangeStart, $rangeEnd])
                ->where('status','cancelled')
                ->groupBy('ym')
                ->pluck('cnt','ym')
                ->toArray();
        }

        // renewals per month
        $renewalMap = [];
        if (Schema::hasColumn('subscriptions', 'is_renewal')) {
            $renewalMap = DB::table('subscriptions')
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
                ->whereBetween('created_at', [$rangeStart, $rangeEnd])
                ->where('is_renewal', 1)
                ->groupBy('ym')
                ->pluck('cnt','ym')
                ->toArray();
        }

        // failed payments per month (payments/transactions)
        $failedMap = [];
        if (Schema::hasTable('payments')) {
            $failedMap = DB::table('payments')
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
                ->whereBetween('created_at', [$rangeStart, $rangeEnd])
                ->whereIn('status', ['failed','refunded','chargeback'])
                ->groupBy('ym')
                ->pluck('cnt','ym')
                ->toArray();
        } elseif (Schema::hasTable('transactions')) {
            $failedMap = DB::table('transactions')
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
                ->whereBetween('created_at', [$rangeStart, $rangeEnd])
                ->whereIn('status', ['failed','refunded','chargeback'])
                ->groupBy('ym')
                ->pluck('cnt','ym')
                ->toArray();
        }

        // assemble arrays in months order
        $revenueSeries = [];$newSeries=[];$cancelSeries=[];$renewalSeries=[];$failedSeries=[];
        foreach($months as $ym) {
            $revenueSeries[] = isset($revenueMap[$ym]) ? (float)$revenueMap[$ym] : 0;
            $newSeries[] = isset($newMap[$ym]) ? (int)$newMap[$ym] : 0;
            $cancelSeries[] = isset($cancelMap[$ym]) ? (int)$cancelMap[$ym] : 0;
            $renewalSeries[] = isset($renewalMap[$ym]) ? (int)$renewalMap[$ym] : 0;
            $failedSeries[] = isset($failedMap[$ym]) ? (int)$failedMap[$ym] : 0;
        }

        $kpiSeries = [
            'labels' => $labels,
            'revenue' => $revenueSeries,
            'new_subs' => $newSeries,
            'cancelled' => $cancelSeries,
            'renewals' => $renewalSeries,
            'failed_payments' => $failedSeries,
        ];

        return view('admin.analytics.index', compact(
            'overview', 'revenueTrends', 'subscriptionDistribution', 'pricingPlanSummary',
            'cohortAnalysis', 'forecast', 'period', 'subscriptions', 'providerCats', 
            'arpu', 'topProviders', 'totalParents', 'totalProviders', 'monthlyRevenue',
            'newSignups', 'recentSubscriptions', 'kpis'
        ));
    }

    public function getChartData(Request $request)
    {
        $period = $request->get('period', '6_months');
        $revenueTrends = $this->analytics->getRevenueTrends($period);
        
        return response()->json($revenueTrends);
    }

    public function updatePlan(Request $request, Plan $plan)
    {
        $request->validate([
            'monthly_fee' => 'required|numeric|min:0',
            'annual_fee' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $plan->update([
            'monthly_fee' => $request->monthly_fee,
            'annual_fee' => $request->annual_fee,
            'is_active' => $request->is_active ?? $plan->is_active,
        ]);

        return redirect()->back()->with('success', 'Plan updated successfully.');
    }

    public function togglePlanStatus(Plan $plan)
    {
        $plan->update([
            'is_active' => !$plan->is_active
        ]);

        $status = $plan->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Plan {$status} successfully.");
    }

    public function reviews(ReviewAnalysisService $service)
    {
        $summary = $service->analyze();
        return view('admin.analytics.reviews', compact('summary'));
    }
}
