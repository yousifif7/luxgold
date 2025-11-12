@extends('layouts.admin')

@section('admin-title', 'Pricing - Admin Panel')
@section('content')
<div class="page-wrapper">
    <!-- Start Content -->
    <div class="content">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Monetization & Pricing</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Monetization & Pricing</li>
                    </ol>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip"
                    data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
                    <i class="ti ti-refresh"></i>
                </a>
                <a href="#" data-size="lg" data-url="{{ route('admin.pricing.create') }}" data-ajax-popup="true"  
                   data-title="{{__('New Plan')}}" class="btn btn-primary">New Plan</a>
            </div>
        </div>

        <!-- Revenue Stats -->
        <div class="row g-2 mb-3">
            <div class="col-md-3">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Monthly Recurring Revenue</p>
                    <h6>${{ number_format($revenueStats['monthly_revenue'], 2) }}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Annual Recurring Revenue</p>
                    <h6>${{ number_format($revenueStats['annual_revenue'], 2) }}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Active Subscribers</p>
                    <h6>{{ $revenueStats['active_subscribers'] }}</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Average Revenue Per User</p>
                    <h6>${{ number_format($revenueStats['average_revenue_per_user'], 2) }}</h6>
                </div>
            </div>
        </div>

        <!-- End Page Header -->
        <div class="container my-4">
            <ul class="nav nav-tabs custom-tabs w-100" id="pricingTab" role="tablist">
                <li class="nav-item flex-fill text-center" role="presentation">
                    <button class="nav-link active" id="plans-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button" role="tab">
                        Pricing Plans
                    </button>
                </li>
                <li class="nav-item flex-fill text-center" role="presentation">
                    <button class="nav-link" id="revenue-tab" data-bs-toggle="tab" data-bs-target="#revenue" type="button" role="tab">
                        Revenue Analytics
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="pricingTabContent">
                <!-- Pricing Plans Tab -->
                <div class="tab-pane fade show active" id="plans" role="tabpanel">
                    <div class="card mb-0">
                        <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="d-inline-flex align-items-center mb-0">
                                Subscription Plans 
                                <span class="badge bg-danger ms-2">{{ $plans->count() }}</span>
                            </h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive table-nowrap">
                                <table class="table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Plan</th>
                                            <th>Pricing</th>
                                            <th>Features</th>
                                            <th>Status</th>
                                            <th>Subscribers</th>
                                            <th class="no-sort">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plans as $plan)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $plan->name }}</span>
                                                        <span class="text-muted small">Type: {{ $plan->type }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">${{ number_format($plan->monthly_fee, 2) }}/month</span>
                                                        <span class="text-muted small">${{ number_format($plan->annual_fee, 2) }}/year</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        @forelse(array_slice($plan->features, 0, 3) as $key=>$feature)
                                                            <span class="text-muted small">{{ $key }}</span>
                                                        @empty
                                                            <span class="text-muted small">No features</span>
                                                        @endforelse
                                                        @if(count($plan->features) > 3)
                                                            <span class="text-primary small">+{{ count($plan->features) - 3 }} more</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $plan->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $plan->subscribers_count }}</span>
                                                        <span class="text-muted small">
                                                            ${{ number_format(($plan->monthly_fee * $plan->subscribers_count), 2) }}/mo
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu p-2">
                                                            <li>
                                                                <a href="#" class="dropdown-item" data-size="lg" 
                                                                   data-url="{{ route('admin.pricing.edit', $plan->id) }}" 
                                                                   data-ajax-popup="true"  
                                                                   data-title="{{ __('Edit Plan') }}">
                                                                    <i class="ti ti-edit me-1"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form method="POST" action="{{ route('admin.pricing.destroy', $plan->id) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item text-danger" type="submit" 
                                                                            onclick="return confirm('Are you sure you want to delete this plan?')">
                                                                        <i class="ti ti-trash me-1"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Analytics Tab -->
                <div class="tab-pane fade" id="revenue" role="tabpanel">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Revenue Trends -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-white border-0">
                                            <h6 class="mb-0">Revenue Trends</h6>
                                            <small class="text-muted">Monthly revenue for the last 6 months</small>
                                        </div>
                                        <div class="card-body">
                                            <div style="height:400px;">
                                                <canvas id="revenueTrends"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subscription Distribution -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-white border-0">
                                            <h6 class="mb-0">Subscription Distribution</h6>
                                            <small class="text-muted">Active subscribers by plan type</small>
                                        </div>
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <div style="height:300px; width:100%; max-width:400px;">
                                                <canvas id="subscriptionDist"></canvas>
                                            </div>
                                            <ul class="list-unstyled mt-3 text-center">
                                                @foreach($chartData['subscription_distribution']['data'] as $index => $plan)
                                                    <li>
                                                        <span class="legend-dot" style="background-color: {{ $plan['color'] }}; display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 8px;"></span>
                                                        {{ $plan['count'] }} subscribers 
                                                        <small>${{ number_format($plan['revenue'], 2) }}/mo</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Revenue Trends Chart
        const ctxBar = document.getElementById('revenueTrends').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($chartData['revenue_trends']['labels']),
                datasets: [{
                    label: 'Monthly Revenue',
                    backgroundColor: '#5f7f7a',
                    data: @json($chartData['revenue_trends']['data'])
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `$${ctx.parsed.y.toLocaleString()}`
                        }
                    }
                }
            }
        });

        // Subscription Distribution Chart
        const ctxDoughnut = document.getElementById('subscriptionDist').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: @json($chartData['subscription_distribution']['labels']),
                datasets: [{
                    data: @json(array_column($chartData['subscription_distribution']['data'], 'count')),
                    backgroundColor: @json(array_column($chartData['subscription_distribution']['data'], 'color')),
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '65%',
                plugins: { 
                    legend: { display: false } 
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush