<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Cleaner as Provider;

class PricingController extends Controller
{

    // PlanController.php
private $allFeatures = [
    'Listing in Parent Searches',
    'Business Name, Address, Contact Info',
    'Update Basic Profile Info',
    'Showcase Photos & Videos',
    'Expanded Profile Details (programs, specialties, credentials)',
    'Analytics (views, clicks, leads)',
    'Appear in Comparison Tool',
    'Save & Share Parent Leads',
    'Verified Provider Badge',
    'Featured Placement (top of search, homepage)',
    'Highlighted in Comparisons',
    '“Trusted Choice” Badge',
    'Early Access to Events & Partnerships',
];

private $planDefaults = [
    'Basic' => [
        'Listing in Parent Searches' => true,
        'Business Name, Address, Contact Info' => true,
        'Update Basic Profile Info' => true,
        'Showcase Photos & Videos' => false,
        'Expanded Profile Details (programs, specialties, credentials)' => false,
        'Analytics (views, clicks, leads)' => false,
        'Appear in Comparison Tool' => false,
        'Save & Share Parent Leads' => false,
        'Verified Provider Badge' => false,
        'Featured Placement (top of search, homepage)' => false,
        'Highlighted in Comparisons' => false,
        '“Trusted Choice” Badge' => false,
        'Early Access to Events & Partnerships' => false,
    ],
    'Premium' => [
        'Listing in Parent Searches' => true,
        'Business Name, Address, Contact Info' => true,
        'Update Basic Profile Info' => true,
        'Showcase Photos & Videos' => true,
        'Expanded Profile Details (programs, specialties, credentials)' => true,
        'Analytics (views, clicks, leads)' => true,
        'Appear in Comparison Tool' => true,
        'Save & Share Parent Leads' => true,
        'Verified Provider Badge' => false,
        'Featured Placement (top of search, homepage)' => false,
        'Highlighted in Comparisons' => false,
        '“Trusted Choice” Badge' => false,
        'Early Access to Events & Partnerships' => true,
    ],
    'Featured' => [
        'Listing in Parent Searches' => true,
        'Business Name, Address, Contact Info' => true,
        'Update Basic Profile Info' => true,
        'Showcase Photos & Videos' => true,
        'Expanded Profile Details (programs, specialties, credentials)' => true,
        'Analytics (views, clicks, leads)' => true,
        'Appear in Comparison Tool' => true,
        'Save & Share Parent Leads' => true,
        'Verified Provider Badge' => true,
        'Featured Placement (top of search, homepage)' => true,
        'Highlighted in Comparisons' => true,
        '“Trusted Choice” Badge' => true,
        'Early Access to Events & Partnerships' => true,
    ],
];


    public function index(Request $request)
    {
        $plans = Plan::orderBy('name')->get();

        // Simple analytics: MRR, ARR, active subscribers (cached on plans)
        
        $plans = Plan::withCount(['subscriptions as subscribers_count' => function($query) {
            $query->where('status', 'active');
        }])->get();

        $revenueStats = $this->getRevenueStats();
        $chartData = $this->getChartData();

        return view('admin.plan.index', compact('plans','chartData','revenueStats'));
    }

    public function create(){
       
       $allFeatures=$this->allFeatures;
       return view('admin.plan.create',compact('allFeatures'));
    }


    public function edit($id){

        $plan=Plan::where('id',$id)->first();
        $allFeatures=$this->allFeatures;
       
       return view('admin.plan.edit',compact('plan','allFeatures'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Basic,Standard,Premium',
            'monthly_fee' => 'required|numeric|min:0',
            'annual_fee' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'is_active' => 'boolean',
        ]);

        
        $plan = Plan::create([
             'name' => $request->name,
            'type' => $request->type,
            'monthly_fee' => $request->monthly_fee,
            'annual_fee' => $request->annual_fee,
            'description' => $request->description,
            'features' => $request->features ? array_filter($request->features) : [],
            'is_active' => $request->has('is_active'),
        ]);

        return handleResponse($request, 'Plan added successfully!', 'admin.pricing.index');
    }

    public function update(Request $request, Plan $plan)
    {
         $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Basic,Standard,Premium',
            'monthly_fee' => 'required|numeric|min:0',
            'annual_fee' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'is_active' => 'boolean',
        ]);
       
        $plan->update([
              'name' => $request->name,
            'type' => $request->type,
            'monthly_fee' => $request->monthly_fee,
            'annual_fee' => $request->annual_fee,
            'description' => $request->description,
            'features' => $request->features ? array_filter($request->features) : [],
            'is_active' => $request->has('is_active'),
        ]);

         return handleResponse($request, 'Plan updated successfully!', 'admin.pricing.index');
    }

    public function destroy($id)
    {
        $plan=Plan::where('id',$id)->first();
        return redirect()->route('admin.pricing.index')->with('success','Plan deleted');
    }

    private function getRevenueStats()
    {
        $currentMonth = now()->format('Y-m');
        $currentYear = now()->year;

        // Monthly Recurring Revenue
        $mrr = Subscription::where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->where(function($query) use ($currentMonth) {
                $query->where('subscriptions.started_at', 'like', "{$currentMonth}%")
                    ->orWhere('subscriptions.renews_at', 'like', "{$currentMonth}%");
            })
            ->sum('plans.monthly_fee');

        // Annual Recurring Revenue
        $arr = Subscription::where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->whereYear('subscriptions.started_at', $currentYear)
            ->sum(DB::raw('plans.monthly_fee * 12'));

        // Active Subscribers
        $activeSubscribers = Subscription::where('status', 'active')->count();

        // Average Revenue Per User
        $arpu = $activeSubscribers > 0 ? $mrr / $activeSubscribers : 0;

        return [
            'monthly_revenue' => $mrr,
            'annual_revenue' => $arr,
            'active_subscribers' => $activeSubscribers,
            'average_revenue_per_user' => $arpu
        ];
    }

    private function getChartData()
    {
        // Revenue Trends - Last 6 months
        $revenueTrends = Payment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $monthlyRevenue = [];
        $labels = [];

        foreach ($revenueTrends as $revenue) {
            $monthName = date('M', mktime(0, 0, 0, $revenue->month, 1));
            $labels[] = $monthName . ' ' . $revenue->year;
            $monthlyRevenue[] = $revenue->total;
        }

        // Subscription Distribution
        $subscriptionDistribution = Subscription::select(
                'plans.name',
                'plans.type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(plans.monthly_fee) as monthly_revenue')
            )
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->where('subscriptions.status', 'active')
            ->groupBy('plans.id', 'plans.name', 'plans.type')
            ->get();

        $planData = [];
        $planLabels = [];
        $planColors = ['#555a64', '#5f7f7a', '#f5c16c']; // Basic colors for charts

        foreach ($subscriptionDistribution as $index => $plan) {
            $planLabels[] = $plan->name;
            $planData[] = [
                'count' => $plan->count,
                'revenue' => $plan->monthly_revenue,
                'color' => $planColors[$index] ?? '#cccccc'
            ];
        }

        return [
            'revenue_trends' => [
                'labels' => $labels,
                'data' => $monthlyRevenue
            ],
            'subscription_distribution' => [
                'labels' => $planLabels,
                'data' => $planData
            ]
        ];
    }
}
