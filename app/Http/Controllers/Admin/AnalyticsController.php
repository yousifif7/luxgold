<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\AnalyticsService;
use App\Http\Controllers\Controller;
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
        $providerCats = $this->analytics->getProviderCategories();
        $arpu = $this->analytics->getArpuSeries();
        $topProviders = $this->analytics->getTopProviders();

        // Additional metrics
        $totalParents = User::role('parent')->count();
        $totalProviders = User::role('provider')->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $monthlyRevenue = $overview['current_revenue'] ?? 0;
        $newSignups = $overview['new_subscriptions'] ?? 0;

        // Recent subscriptions
        $recentSubscriptions = [];
        $subscriptionRows = Subscription::with(['provider', 'plan'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $recentSubscriptions = $subscriptionRows->map(function($s){
            return [
                'provider' => $s->provider->business_name ?? '—',
                'plan' => $s->plan->name ?? '—',
                'amount' => $s->plan->monthly_fee ?? 0,
                'date' => $s->created_at ? $s->created_at->toDateString() : '',
                'status' => $s->status ?? 'active'
            ];
        })->toArray();

        return view('admin.analytics.index', compact(
            'overview', 'revenueTrends', 'subscriptionDistribution', 'pricingPlanSummary',
            'cohortAnalysis', 'forecast', 'period', 'subscriptions', 'providerCats', 
            'arpu', 'topProviders', 'totalParents', 'totalProviders', 'monthlyRevenue',
            'newSignups', 'recentSubscriptions'
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
}