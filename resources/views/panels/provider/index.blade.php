@extends('layouts.provider-layout')

@section('provider-title', 'Dashboard - Cleaner Portal')
@section('content')
<div class="page-wrapper">
    <!-- Start Content -->
    <div class="content">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Welcome back, {{ $stats['name'] ?? $stats['business_name'] }}!</h4>
                <p class="mb-0">Here's what's happening with your account today.</p>
            </div>
            {{-- <div class="subscription-status">
                @if(isset($stats['subscription_status']['status']) && $stats['subscription_status']['status'] === 'active')
                    <span class="badge bg-success">
                        <i class="ti ti-crown me-1"></i>
                        {{ $stats['subscription_status']['plan_name'] }} Plan
                        @if($stats['subscription_status']['days_remaining'] > 0)
                            - {{ $stats['subscription_status']['days_remaining'] }} days remaining
                        @endif
                    </span>
                @else
                    <span class="badge bg-warning">
                        <i class="ti ti-alert-circle me-1"></i>
                        No Active Subscription
                    </span>
                @endif
            </div> --}}
        </div>
        <!-- End Page Header -->

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Profile Views -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-icon bg-primary bg-opacity-10 rounded-circle flex-shrink-0">
                                <i class="ti ti-eye fs-20 text-primary"></i>
                            </div>
                            <div class="ms-3">
                                <p class="mb-1 text-truncate">Profile Views</p>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['profile_views']['total']) }}</h4>
                                <small class="text-{{ $stats['profile_views']['trend'] === 'up' ? 'success' : 'danger' }}">
                                    <i class="ti ti-arrow-{{ $stats['profile_views']['trend'] }} fs-12"></i>
                                    {{ number_format(abs($stats['profile_views']['change']), 1) }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inquiries -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-icon bg-info bg-opacity-10 rounded-circle flex-shrink-0">
                                <i class="ti ti-message-circle fs-20 text-info"></i>
                            </div>
                            <div class="ms-3">
                                <p class="mb-1 text-truncate">Inquiries</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['inquiries']['total'] }}</h4>
                                <small class="text-{{ $stats['inquiries']['trend'] === 'up' ? 'success' : 'danger' }}">
                                    <i class="ti ti-arrow-{{ $stats['inquiries']['trend'] }} fs-12"></i>
                                    {{ number_format(abs($stats['inquiries']['change']), 1) }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-icon bg-success bg-opacity-10 rounded-circle flex-shrink-0">
                                <i class="ti ti-calendar-event fs-20 text-success"></i>
                            </div>
                            <div class="ms-3">
                                <p class="mb-1 text-truncate">Events</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['events']['total'] }}</h4>
                                <small class="text-muted">{{ $stats['events']['active'] }} active</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Rating -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-icon bg-warning bg-opacity-10 rounded-circle flex-shrink-0">
                                <i class="ti ti-star fs-20 text-warning"></i>
                            </div>
                            <div class="ms-3">
                                <p class="mb-1 text-truncate">Rating</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['ratings']['average'] }}/5</h4>
                                <small class="text-muted">{{ $stats['ratings']['total'] }} reviews</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saves -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-icon bg-danger bg-opacity-10 rounded-circle flex-shrink-0">
                                <i class="ti ti-heart fs-20 text-danger"></i>
                            </div>
                            <div class="ms-3">
                                <p class="mb-1 text-truncate">Saves</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['engagement']['saves'] }}</h4>
                                <small class="text-muted">{{ $stats['engagement']['followers'] }} followers</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Rate -->
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-icon bg-purple bg-opacity-10 rounded-circle flex-shrink-0">
                                <i class="ti ti-clock fs-20 text-purple"></i>
                            </div>
                            <div class="ms-3">
                                <p class="mb-1 text-truncate">Response Rate</p>
                                <h4 class="mb-0 fw-bold">{{ $stats['engagement']['response_rate'] }}%</h4>
                                <small class="text-muted">
                                    @if($inquiryStats['response_time'])
                                        {{ $inquiryStats['response_time'] }}h avg
                                    @else
                                        No responses
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Quick Actions Row -->
        <div class="row mb-4 align-items-stretch">
            <!-- Activity Chart -->
            <div class="col-xl-8 col-lg-7 d-flex">
                <div class="card w-100 h-100 d-flex flex-column">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Performance Overview</h5>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary active" data-period="week">7D</button>
                                <button type="button" class="btn btn-outline-secondary" data-period="month">30D</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body flex-grow-1">
                        <canvas id="performanceChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Stats -->
            <div class="col-xl-4 col-lg-5 d-flex">
                <div class="card w-100 h-100 d-flex flex-column">
                    <div class="card-header border-0 pb-0">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        {{-- <div class="quick-actions-grid mb-4">
                            <a href="{{ route('admin.events.create') }}" class="quick-action-btn">
                                <div class="action-icon bg-primary">
                                    <i class="ti ti-calendar-plus"></i>
                                </div>
                                <span>Create Event</span>
                            </a>
                            
                            @if(!$stats['subscription_status']['is_premium'])
                                <a href="{{ route('provider-subscription') }}" class="quick-action-btn">
                                    <div class="action-icon bg-warning">
                                        <i class="ti ti-crown"></i>
                                    </div>
                                    <span>Upgrade Plan</span>
                                </a>
                            @else
                                <a href="{{ route('provider-subscription') }}" class="quick-action-btn">
                                    <div class="action-icon bg-success">
                                        <i class="ti ti-crown"></i>
                                    </div>
                                    <span>Manage Plan</span>
                                </a>
                            @endif
                            
                            <a href="{{ url('provider.inquiries.index') }}" class="quick-action-btn">
                                <div class="action-icon bg-info">
                                    <i class="ti ti-message-circle"></i>
                                </div>
                                <span>View Inquiries</span>
                            </a>
                            
                            <a href="{{ url('provider.profile.edit') }}" class="quick-action-btn">
                                <div class="action-icon bg-secondary">
                                    <i class="ti ti-edit"></i>
                                </div>
                                <span>Edit Profile</span>
                            </a>
                        </div> --}}

                        <!-- Mini Stats -->
                        <div class="mini-stats">
                            <div class="mini-stat-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Pending Inquiries</span>
                                    <span class="fw-bold text-primary">{{ $stats['quick_stats']['pending_inquiries'] }}</span>
                                </div>
                            </div>
                            <div class="mini-stat-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Upcoming Events</span>
                                    <span class="fw-bold text-success">{{ $stats['quick_stats']['upcoming_events'] }}</span>
                                </div>
                            </div>
                            <div class="mini-stat-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">New Reviews</span>
                                    <span class="fw-bold text-warning">{{ $stats['quick_stats']['new_reviews'] }}</span>
                                </div>
                            </div>
                            <div class="mini-stat-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Conversion Rate</span>
                                    <span class="fw-bold text-info">{{ number_format($inquiryStats['conversion_rate'], 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row - Charts -->
        <div class="row mb-4">
            <!-- Inquiry Status Chart -->
            <div class="col-xl-4 col-md-6 d-flex">
                <div class="card w-100 h-100 d-flex flex-column">
                    <div class="card-header border-0 pb-0">
                        <h5 class="card-title mb-0">Inquiry Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="inquiryChart" style="height: 250px;"></canvas>
                        <div class="inquiry-legend mt-3">
                            @php
                                $statusColors = [
                                    'pending' => 'primary',
                                    'contacted' => 'info', 
                                    'approved' => 'success',
                                    'rejected' => 'danger'
                                ];
                            @endphp
                            @foreach($inquiryStats['by_status'] as $status => $count)
                                @if($count > 0)
                                    <div class="legend-item">
                                        <span class="legend-color bg-{{ $statusColors[$status] }}"></span>
                                        <span class="legend-label text-capitalize">{{ $status }}</span>
                                        <span class="legend-count">{{ $count }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating Distribution -->
            <div class="col-xl-4 col-md-6 d-flex">
                <div class="card w-100 h-100 d-flex flex-column">
                    <div class="card-header border-0 pb-0">
                        <h5 class="card-title mb-0">Rating Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="rating-distribution">
                            @foreach([5, 4, 3, 2, 1] as $rating)
                                @php
                                    $count = $stats['ratings']['distribution'][$rating] ?? 0;
                                    $percentage = $stats['ratings']['total'] > 0 ? ($count / $stats['ratings']['total']) * 100 : 0;
                                @endphp
                                <div class="rating-bar mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="ti ti-star{{ $i <= $rating ? ' filled' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="rating-stats">
                                            <span class="count">{{ $count }}</span>
                                            <span class="percentage">({{ number_format($percentage, 1) }}%)</span>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="col-xl-4 d-flex">
                <div class="card w-100 h-100 d-flex flex-column">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Notifications</h5>
                            <span class="badge bg-primary">{{ $notifications->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body notifications-container">
                        @forelse($notifications as $notification)
                            <div class="notification-item 
                                @if($notification->type === 'warning') notification-warning
                                @elseif($notification->type === 'error') notification-error
                                @elseif($notification->type === 'success') notification-success
                                @else notification-info @endif">
                                <div class="notification-content">
                                    <h6 class="mb-1">{{ $notification->title }}</h6>
                                    <p class="mb-2 text-muted small">{{ $notification->message }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="ti ti-bell-off fs-32 text-muted mb-2"></i>
                                <p class="text-muted mb-0">No notifications</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Performance Chart
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(performanceCtx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [
                    {
                        label: 'Profile Views',
                        data: @json($chartData['views']),
                        borderColor: '#5f7f7a',
                        backgroundColor: 'rgba(95, 127, 122, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    },
                    {
                        label: 'Inquiries',
                        data: @json($chartData['inquiries']),
                        borderColor: '#f5c16c',
                        backgroundColor: 'rgba(245, 193, 108, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    },
                    {
                        label: 'Saves',
                        data: @json($chartData['saves']),
                        borderColor: '#e74c3c',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Inquiry Status Chart
        const inquiryCtx = document.getElementById('inquiryChart').getContext('2d');
        const inquiryChart = new Chart(inquiryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Contacted', 'Approved', 'Rejected'],
                datasets: [{
                    data: [
                        @json($inquiryStats['by_status']['pending']),
                        @json($inquiryStats['by_status']['contacted']),
                        @json($inquiryStats['by_status']['approved']),
                        @json($inquiryStats['by_status']['rejected'])
                    ],
                    backgroundColor: [
                        '#4e73df', '#36b9cc', '#1cc88a', '#e74a3b'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Period switcher
        document.querySelectorAll('[data-period]').forEach(button => {
            button.addEventListener('click', function() {
                const period = this.dataset.period;
                
                // Update active button
                document.querySelectorAll('[data-period]').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                // Fetch new data
                fetch(`/cleaner/dashboard/data?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        performanceChart.data.labels = data.labels;
                        performanceChart.data.datasets[0].data = data.views;
                        performanceChart.data.datasets[1].data = data.inquiries;
                        performanceChart.data.datasets[2].data = data.saves;
                        performanceChart.update();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endpush

<style>
.stat-card {
    border: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem 1rem;
    border: 1px solid #e9ecef;
    border-radius: 0.75rem;
    background: white;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
    text-align: center;
}

.quick-action-btn:hover {
    background: #f8f9fa;
    border-color: #5f7f7a;
    color: #5f7f7a;
    text-decoration: none;
    transform: translateY(-2px);
}

.action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
}

.action-icon i {
    font-size: 1.5rem;
    color: white;
}

.mini-stats {
    border-top: 1px solid #e9ecef;
    padding-top: 1.5rem;
}

.mini-stat-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.mini-stat-item:last-child {
    border-bottom: none;
}

.inquiry-legend {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.legend-label {
    flex: 1;
    text-transform: capitalize;
    font-size: 0.875rem;
}

.legend-count {
    font-weight: 600;
    color: #495057;
}

.rating-distribution {
    padding: 0.5rem 0;
}

.rating-bar .stars {
    display: flex;
    gap: 2px;
}

.rating-bar .stars i {
    font-size: 0.875rem;
    color: #dee2e6;
}

.rating-bar .stars i.filled {
    color: #ffc107;
}

.rating-stats {
    display: flex;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.rating-stats .count {
    font-weight: 600;
    color: #495057;
}

.rating-stats .percentage {
    color: #6c757d;
}

.notifications-container {
    max-height: 400px;
    overflow-y: auto;
}

.notification-item {
    padding: 1rem;
    border-left: 4px solid #6c757d;
    background: #f8f9fa;
    margin-bottom: 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.notification-item:hover {
    transform: translateX(4px);
}

.notification-warning {
    border-left-color: #ffc107;
    background: #fffbf0;
}

.notification-error {
    border-left-color: #dc3545;
    background: #fdf2f2;
}

.notification-success {
    border-left-color: #198754;
    background: #f0f9f0;
}

.notification-info {
    border-left-color: #0dcaf0;
    background: #f0fdff;
}

.bg-purple {
    background-color: #6f42c1 !important;
}

.text-purple {
    color: #6f42c1 !important;
}

.subscription-status .badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}
</style>