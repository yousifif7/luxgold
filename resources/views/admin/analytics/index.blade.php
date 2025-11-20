@extends('layouts.main')

@section('title', 'Analytics & Reporting')

@section('content')
<div class="page-wrapper">
  <div class="content">
    
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
      <div class="breadcrumb-arrow">
        <h4 class="mb-1">Analytics & Reporting</h4>
        <div class="text-end">
          <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Home</a></li>
            <li class="breadcrumb-item active">Analytics & Reporting</li>
          </ol>
        </div>
      </div>
      <div class="d-flex gap-2 align-items-center">
        <div class="forecast-widget bg-primary text-white px-3 py-2 rounded">
          <small>Projected Next Month</small>
          <div class="fw-bold">${{ number_format($forecast['projected_next_month']) }}</div>
          <small>+{{ $forecast['projected_growth_rate'] }}% growth</small>
        </div>
      </div>
    </div>

    <!-- Primary KPI Row -->
    <div class="row g-2 mb-3">
      <div class="col-md-3">
        <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
          <p class="mb-2">Monthly Revenue</p>
          <h4 class="text-primary">${{ number_format($overview['current_revenue'] ?? 0) }}</h4>
          <small class="{{ $overview['revenue_growth_rate'] >= 0 ? 'text-success' : 'text-danger' }}">
            <i class="ti ti-arrow-{{ $overview['revenue_growth_rate'] >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($overview['revenue_growth_rate']) }}% vs last month
          </small>
        </div>
      </div>
      <div class="col-md-3">
        <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
          <p class="mb-2">Active Subscriptions</p>
          <h4 class="text-info">{{ number_format($overview['total_active_subscriptions'] ?? 0) }}</h4>
          <small class="text-muted">{{ $overview['new_subscriptions'] ?? 0 }} new this month</small>
        </div>
      </div>
      <div class="col-md-3">
        <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
          <p class="mb-2">Conversion Rate</p>
          <h4 class="text-success">{{ ($overview['conversion_rate'] ?? 0) }}%</h4>
          <small class="text-muted">{{ $overview['total_inquiries'] ?? 0 }} total inquiries</small>
        </div>
      </div>
      <div class="col-md-3">
        <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
          <p class="mb-2">Active Users</p>
          <h4 class="text-warning">{{ number_format($overview['active_users'] ?? 0) }}</h4>
          <small class="text-muted">Last 30 days</small>
        </div>
      </div>
    </div>

    <!-- Secondary KPI Row -->
    <div class="row g-2 mb-4">
      <div class="col-md-2">
        <div class="bg-white border border-1 p-2 h-100 text-center">
          <p class="mb-1 small text-muted">MoM Growth</p>
          <h6 class="{{ $overview['revenue_growth_rate'] >= 0 ? 'text-success' : 'text-danger' }} mb-0">
            {{ $overview['revenue_growth_rate'] }}%
          </h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="bg-white border border-1 p-2 h-100 text-center">
          <p class="mb-1 small text-muted">Churn Rate</p>
          <h6 class="{{ ($overview['churn_rate'] ?? 0) <= 5 ? 'text-success' : 'text-danger' }} mb-0">
            {{ $overview['churn_rate'] ?? 0 }}%
          </h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="bg-white border border-1 p-2 h-100 text-center">
          <p class="mb-1 small text-muted">New Subs</p>
          <h6 class="text-info mb-0">{{ $overview['new_subscriptions'] ?? 0 }}</h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="bg-white border border-1 p-2 h-100 text-center">
          <p class="mb-1 small text-muted">Renewal Rate</p>
          <h6 class="text-success mb-0">{{ $overview['renewal_rate'] ?? 0 }}%</h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="bg-white border border-1 p-2 h-100 text-center">
          <p class="mb-1 small text-muted">Failed Payments</p>
          <h6 class="text-warning mb-0">{{ $overview['failed_payments'] ?? 0 }}</h6>
        </div>
      </div>
      <div class="col-md-2">
        <div class="bg-white border border-1 p-2 h-100 text-center">
          <p class="mb-1 small text-muted">Refunds</p>
          <h6 class="text-danger mb-0">${{ number_format($overview['refunds_amount'] ?? 0) }}</h6>
        </div>
      </div>
    </div>

    <!-- Revenue Trends & Subscription Distribution -->
    <div class="row g-2 mb-3">
      <div class="col-md-8">
        <div class="card card-h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
              <div class="card-title">Revenue Trends</div>
              <p class="mb-0 text-muted">MRR, New vs Returning Subscribers</p>
            </div>
            <div class="btn-group btn-group-sm">
              <a href="?period=1_month" class="btn btn-outline-secondary {{ $period === '1_month' ? 'active' : '' }}">1M</a>
              <a href="?period=3_months" class="btn btn-outline-secondary {{ $period === '3_months' ? 'active' : '' }}">3M</a>
              <a href="?period=6_months" class="btn btn-outline-secondary {{ $period === '6_months' ? 'active' : '' }}">6M</a>
              <a href="?period=1_year" class="btn btn-outline-secondary {{ $period === '1_year' ? 'active' : '' }}">1Y</a>
            </div>
          </div>
          <div class="card-body" style="height:400px;">
            <canvas id="revenueTrendsChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-h-100">
          <div class="card-header">
            <div class="card-title">Subscription Distribution</div>
            <p class="mb-0 text-muted">Revenue share by plan type</p>
          </div>
          <div class="card-body text-center" style="height:400px;">
            <canvas id="subscriptionDistributionChart"></canvas>
            <div class="distribution-legend mt-3">
              @foreach($subscriptionDistribution as $plan)
                <div class="legend-item d-flex align-items-center justify-content-between mb-1">
                  <div class="d-flex align-items-center">
                    <span class="legend-color me-2" style="background-color: {{ $plan['color'] }}; width:12px;height:12px;border-radius:50%;"></span>
                    <span class="small">{{ $plan['plan_type'] }}</span>
                  </div>
                  <span class="small fw-bold">${{ number_format($plan['revenue']) }}</span>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Cohort Analysis & ARPU -->
    <div class="row g-2 mb-3">
      <div class="col-md-6">
        <div class="card card-h-100">
          <div class="card-header">
            <div class="card-title">Cohort Retention Analysis</div>
            <p class="mb-0 text-muted">Customer retention by signup month (%)</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th>Signup Month</th>
                    @for($i = 0; $i <= 6; $i++)
                      <th class="text-center">Month {{ $i }}</th>
                    @endfor
                  </tr>
                </thead>
                <tbody>
                  @foreach($cohortAnalysis as $cohort)
                    <tr>
                      <td class="fw-semibold">{{ $cohort['signup_month'] }}</td>
                      @for($i = 0; $i <= 6; $i++)
                        @php
                          $rate = $cohort["month_{$i}"] ?? 0;
                          $colorClass = $rate >= 80 ? 'table-success' : ($rate >= 60 ? 'table-warning' : 'table-danger');
                        @endphp
                        <td class="text-center {{ $colorClass }} fw-bold">
                          {{ $rate }}%
                        </td>
                      @endfor
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-h-100">
          <div class="card-header">
            <div class="card-title">Average Revenue Per User (ARPU)</div>
            <p class="mb-0 text-muted">Monthly ARPU trend</p>
          </div>
          <div class="card-body" style="height:300px;">
            <canvas id="arpuChart"></canvas>
          </div>
        </div>

        <!-- Forecast Summary -->
        <div class="card mt-3">
          <div class="card-body">
            <h6 class="card-title">Growth Forecast</h6>
            <div class="row text-center">
              <div class="col-6 border-end">
                <div class="text-success fw-bold fs-5">+{{ $forecast['estimated_annual_growth'] }}%</div>
                <small class="text-muted">Est. Annual Growth</small>
              </div>
              <div class="col-6">
                <div class="text-primary fw-bold fs-5">${{ number_format($forecast['estimated_annual_revenue']) }}</div>
                <small class="text-muted">Est. Annual Revenue</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pricing Plan Summary -->
    <div class="card mt-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Pricing Plan Performance</h5>
          <p class="mb-0 text-muted">Active plans with subscriber counts and revenue</p>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th>Plan Name</th>
                <th>Type</th>
                <th>Monthly Price</th>
                <th>Annual Price</th>
                <th>Subscribers</th>
                <th>Monthly Revenue</th>
                <th>Conversion Rate</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pricingPlanSummary as $plan)
                <tr>
                  <td>
                    <div class="fw-semibold">{{ $plan['name'] }}</div>
                    <small class="text-muted">{{ Str::limit($plan['description'], 50) }}</small>
                  </td>
                  <td><span class="badge bg-secondary">{{ $plan['type'] }}</span></td>
                  <td>${{ number_format($plan['monthly_fee'], 2) }}</td>
                  <td>${{ number_format($plan['annual_fee'], 2) }}</td>
                  <td>{{ $plan['subscriber_count'] }}</td>
                  <td class="fw-bold text-success">${{ number_format($plan['revenue']) }}</td>
                  <td>
                    <span class="badge bg-{{ $plan['conversion_rate'] >= 15 ? 'success' : ($plan['conversion_rate'] >= 10 ? 'warning' : 'danger') }}">
                      {{ $plan['conversion_rate'] }}%
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-{{ $plan['status'] === 'Active' ? 'success' : 'secondary' }}">
                      {{ $plan['status'] }}
                    </span>
                  </td>
                  
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Top Providers Table -->
    <div class="card mt-3">
      <div class="card-header">
        <h5 class="mb-1">Top Performing Providers</h5>
        <p class="mb-0 text-muted">Views, clicks, inquiries, and conversion rates</p>
      </div>
      <div class="card-body">
        <table class="table mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th>Provider</th>
              <th>Views</th>
              <th>Inquiries</th>
              <th>Rating</th>
              <th>Conversion Rate</th>
              <th>Performance</th>
            </tr>
          </thead>
          <tbody>
            @foreach($topProviders as $p)
              <tr>
                <td>
                  <div class="fw-semibold">{{ $p['name'] }}</div>
                </td>
                <td>{{ number_format($p['views']) }}</td>
                <td>{{ $p['inquiries'] }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <i class="ti ti-star text-warning me-1"></i>
                    <span>{{ $p['rating'] }}</span>
                  </div>
                </td>
                <td>
                  <span class="badge bg-{{ $p['conversion'] >= 2 ? 'success' : ($p['conversion'] >= 1 ? 'warning' : 'danger') }}">
                    {{ $p['conversion'] }}%
                  </span>
                </td>
                <td>
                  <span class="badge bg-{{ $p['performance'] === 'High' ? 'success' : ($p['performance'] === 'Medium' ? 'warning' : 'danger') }}">
                    {{ $p['performance'] }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Revenue Trends Chart
  const revenueCtx = document.getElementById('revenueTrendsChart').getContext('2d');
  const revenueChart = new Chart(revenueCtx, {
    type: 'bar',
    data: {
      labels: @json($revenueTrends['labels']),
      datasets: [
        {
          label: 'Monthly Revenue',
          data: @json($revenueTrends['revenue']),
          backgroundColor: 'rgba(78, 140, 160, 0.7)',
          borderColor: '#4e8ca0',
          borderWidth: 2,
          type: 'bar',
          yAxisID: 'y'
        },
        {
          label: 'New Subscribers',
          data: @json($revenueTrends['new_subscribers']),
          borderColor: '#27ae60',
          backgroundColor: 'transparent',
          borderWidth: 2,
          type: 'line',
          yAxisID: 'y1'
        },
        {
          label: 'Returning Subscribers',
          data: @json($revenueTrends['returning_subscribers']),
          borderColor: '#f39c12',
          backgroundColor: 'transparent',
          borderWidth: 2,
          type: 'line',
          yAxisID: 'y1'
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      scales: {
        y: {
          type: 'linear',
          display: true,
          position: 'left',
          title: { display: true, text: 'Revenue ($)' }
        },
        y1: {
          type: 'linear',
          display: true,
          position: 'right',
          title: { display: true, text: 'Subscribers' },
          grid: { drawOnChartArea: false }
        }
      }
    }
  });

  // Subscription Distribution Chart
  const distributionCtx = document.getElementById('subscriptionDistributionChart').getContext('2d');
  const distributionChart = new Chart(distributionCtx, {
    type: 'doughnut',
    data: {
      labels: @json(array_column($subscriptionDistribution, 'plan_type')),
      datasets: [{
        data: @json(array_column($subscriptionDistribution, 'revenue')),
        backgroundColor: @json(array_column($subscriptionDistribution, 'color')),
        borderWidth: 2,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              const plan = @json($subscriptionDistribution)[context.dataIndex];
              return [
                `${plan.plan_type}: $${plan.revenue.toLocaleString()}`,
                `Revenue Share: ${plan.revenue_share.toFixed(1)}%`,
                `Subscribers: ${plan.subscriber_count}`
              ];
            }
          }
        }
      },
      cutout: '60%'
    }
  });

  // ARPU Chart
  const arpuData = @json($arpu);
  new Chart(document.getElementById('arpuChart'), {
    type: 'line',
    data: {
      labels: arpuData.labels,
      datasets: [{
        label: 'ARPU',
        data: arpuData.data,
        borderColor: '#27ae60',
        backgroundColor: 'rgba(39, 174, 96, 0.1)',
        tension: 0.3,
        borderWidth: 3,
        pointRadius: 4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Average Revenue Per User' }
        }
      }
    }
  });
</script>
@endpush

<style>
.forecast-widget {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.distribution-legend {
  max-height: 200px;
  overflow-y: auto;
}

.legend-item {
  padding: 0.25rem 0;
  border-bottom: 1px solid #f8f9fa;
}

.legend-item:last-child {
  border-bottom: none;
}

.table-success { background-color: #d1f2eb !important; }
.table-warning { background-color: #fef9e7 !important; }
.table-danger { background-color: #fadbd8 !important; }
</style>
@endsection