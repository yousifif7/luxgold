@extends('layouts.admin')

@section('admin-title', 'Dashboard - Admin Panel')

@push('styles')
<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .action-card {
        border-left: 3px solid;
        transition: all 0.3s ease;
    }
    .action-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <!-- Start Content -->
    <div class="content">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Welcome, Admin</h4>
                <p class="mb-0">Today you have <strong>{{ $stats['new_inquiries'] }}</strong> new inquiries</p>
            </div>
            <div class="d-flex gap-2">
               
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Providers -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-building-store fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Total Providers</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['total_providers'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Parents -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-success rounded-circle flex-shrink-0">
                                <i class="ti ti-users fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Total Parents</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['total_parents'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Events -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-info rounded-circle flex-shrink-0">
                                <i class="ti ti-calendar-event fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Active Events</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['active_events'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-warning rounded-circle flex-shrink-0">
                                <i class="ti ti-currency-dollar fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Total Revenue</p>
                               <h6 class="mb-0 fw-semibold">${{ number_format($stats['total_revenue'], 2) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-warning rounded-circle flex-shrink-0">
                                <i class="ti ti-hourglass-high fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Pending Approvals</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['pending_approvals'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Providers -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-success rounded-circle flex-shrink-0">
                                <i class="ti ti-star fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Featured Providers</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['featured_providers'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Inquiries -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-info rounded-circle flex-shrink-0">
                                <i class="ti ti-mail fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">New Inquiries</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['new_inquiries'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reported Reviews -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-danger rounded-circle flex-shrink-0">
                                <i class="ti ti-flag fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Reported Reviews</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['reported_reviews'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Visualization Charts -->
        <div class="row mb-4">
            <!-- User Growth Chart -->
            <div class="col-xl-8 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">User Growth Trends</h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active" onclick="updateGrowthChart('weekly')">Weekly</button>
                            <button type="button" class="btn btn-outline-primary" onclick="updateGrowthChart('monthly')">Monthly</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="userGrowthChart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="col-xl-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Provider Categories</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue and Engagement Charts -->
        <div class="row mb-4">
            <!-- Revenue Trend -->
            <div class="col-xl-8 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Revenue Trends (Last 12 Months)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <!-- Engagement Heatmap -->
            <div class="col-xl-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Activity Overview</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="engagementChart" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="row mb-4">
            <!-- Pending Provider Approvals -->
            <div class="col-xl-4 mb-3">
                <div class="card action-card" style="border-left-color: #f59e0b;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-hourglass-high text-warning me-2"></i>
                            Pending Approvals
                        </h5>
                        <a href="{{ route('admin.providers.index') }}?status=pending" class="btn btn-sm btn-outline-warning">View All</a>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @forelse($pendingProviders as $provider)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $provider['business_name'] }}</h6>
                                    <p class="text-muted small mb-1">{{ $provider['contact_person'] }}</p>
                                    <p class="text-muted small mb-1">
                                        <i class="ti ti-category me-1"></i>{{ $provider['category'] }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        Submitted: {{ $provider['submitted_date'] }} 
                                        <span class="badge badge-soft-warning">{{ $provider['days_pending'] }} days pending</span>
                                    </p>
                                </div>
                                <div class="d-flex gap-1 flex-shrink-0 ms-2">
                                    <button class="btn btn-sm btn-success" onclick="approveProvider({{ $provider['id'] }})" title="Approve">
                                        <i class="ti ti-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="rejectProvider({{ $provider['id'] }})" title="Reject">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-muted">No pending approvals</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Reported Reviews -->
            <div class="col-xl-4 mb-3">
                <div class="card action-card" style="border-left-color: #ef4444;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-flag text-danger me-2"></i>
                            Reported Reviews
                        </h5>
                        <a href="{{ route('admin.reviews.index') }}?status=flagged" class="btn btn-sm btn-outline-danger">View All</a>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @forelse($reportedReviews as $review)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $review['user_name'] }}</h6>
                                    <p class="text-muted small mb-1">Provider: {{ $review['provider_name'] }}</p>
                                    <div class="mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ti ti-star{{ $i <= $review['rating'] ? '-filled text-warning' : ' text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="small mb-1">{{ Str::limit($review['comment'], 100) }}</p>
                                    <p class="text-muted small mb-0">Reported: {{ $review['reported_date'] }}</p>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-success" onclick="moderateReview({{ $review['id'] }}, 'approved')">Approve</button>
                                <button class="btn btn-sm btn-warning" onclick="moderateReview({{ $review['id'] }}, 'hidden')">Hide</button>
                                <button class="btn btn-sm btn-danger" onclick="moderateReview({{ $review['id'] }}, 'rejected')">Reject</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-muted">No reported reviews</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Inquiries Preview -->
            <div class="col-xl-4 mb-3">
                <div class="card action-card" style="border-left-color: #3b82f6;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-mail text-info me-2"></i>
                            Recent Inquiries
                        </h5>
                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-info">View All</a>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @forelse($recentInquiries->take(3) as $inquiry)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $inquiry['parent_name'] }}</h6>
                                    <p class="text-muted small mb-1">{{ $inquiry['parent_email'] }}</p>
                                    <p class="text-muted small mb-1">Provider: {{ $inquiry['provider_name'] }}</p>
                                    <p class="small mb-1">{{ Str::limit($inquiry['message'], 80) }}</p>
                                    <p class="text-muted small mb-0">{{ $inquiry['date_time'] }}</p>
                                </div>
                            </div>
                            @if($inquiry['status'] === 'pending')
                            @else
                            <span class="badge badge-soft-success">{{ ucfirst($inquiry['status']) }}</span>
                            @endif
                        </div>
                        @empty
                        <p class="text-center text-muted">No recent inquiries</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">Quick Actions</h5>
            </div>
            <!-- All Providers -->
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <a href="{{ route('admin.providers.index') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-building-store"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0">All Providers</p>
                    </div>
                </a>
            </div>

            <!-- All Parents -->
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <a href="{{ route('admin.parents.index') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-users"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0">All Parents</p>
                    </div>
                </a>
            </div>

            <!-- Events -->
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <a href="{{ route('admin.events.index') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-calendar-event"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0">Events</p>
                    </div>
                </a>
            </div>

            <!-- Reviews -->
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <a href="{{ route('admin.reviews.index') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-star"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0">Reviews</p>
                    </div>
                </a>
            </div>

            <!-- Content Management -->
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <a href="{{ route('admin.content-management') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-map"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0">Content</p>
                    </div>
                </a>
            </div>

            <!-- Monetization -->
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <a href="{{ route('admin.pricing.index') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-currency-dollar"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0 text-truncate">Monetization</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Full Inquiries Table -->
        <div class="card shadow flex-fill w-100 mb-0">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-truncate">All Provider Inquiries</h5> 
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-light flex-shrink-0">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive table-nowrap">
                    <table class="table border mb-0">
                        <thead>
                            <tr>
                                <th>Inquiry ID</th>
                                <th>Parent Name</th>
                                <th>Provider</th>
                                <th>Service Type</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInquiries as $inquiry)
                            <tr>
                                <td>
                                    <a href="javascript:void(0);" class="link-muted" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#viewInquiryModal"
                                       data-inquiry="{{ json_encode($inquiry) }}">
                                        {{ $inquiry['inquiry_id'] }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fs-14 mb-0 fw-medium">{{ $inquiry['parent_name'] }}</h6>
                                            <small class="text-muted">{{ $inquiry['parent_email'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fs-14 mb-0 fw-medium">
                                                @if($inquiry['provider_id'])
                                                <a href="{{ route('admin.providers.show', $inquiry['provider_id']) }}">
                                                    {{ $inquiry['provider_name'] }}
                                                </a>
                                                @else
                                                {{ $inquiry['provider_name'] }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $inquiry['service_type'] }}</td>
                                <td>{{ $inquiry['date_time'] }}</td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'pending' => ['class' => 'badge-soft-info', 'text' => 'New'],
                                            'contacted' => ['class' => 'badge-soft-warning', 'text' => 'Contacted'],
                                            'approved' => ['class' => 'badge-soft-success', 'text' => 'Approved'],
                                            'closed' => ['class' => 'badge-soft-danger', 'text' => 'Closed']
                                        ];
                                        $config = $statusConfig[$inquiry['status']] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="badge {{ $config['class'] }} border py-1 ps-1">
                                        {{ $config['text'] }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu p-2">
                                            <li>
                                                <a href="#" class="dropdown-item d-flex align-items-center view-inquiry" 
                                                   data-inquiry="{{ json_encode($inquiry) }}">
                                                    <i class="ti ti-eye me-1"></i>View Details
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center text-danger delete-inquiry" 
                                                   data-inquiry-id="{{ $inquiry['id'] }}">
                                                    <i class="ti ti-trash me-1"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">No inquiries found</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
</div>

<!-- View Inquiry Modal -->
<div class="modal fade" id="viewInquiryModal" tabindex="-1" aria-labelledby="viewInquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewInquiryModalLabel">Inquiry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inquiryDetails">
                    <!-- Content will be loaded via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Data from Backend
const categoryData = @json($categoryDistribution);
const revenueData = @json($revenueData);
const engagementData = @json($engagementData);

// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    initializeEventListeners();
});

function initializeCharts() {
    // User Growth Chart
    const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
    window.userGrowthChart = new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Providers',
                    data: [],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Parents',
                    data: [],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Load initial monthly data
    updateGrowthChart('monthly');

    // Category Distribution Pie Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.labels,
            datasets: [{
                data: categoryData.data,
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                    'rgb(139, 92, 246)',
                    'rgb(236, 72, 153)',
                    'rgb(20, 184, 166)',
                    'rgb(251, 146, 60)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10
                    }
                }
            }
        }
    });

    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: revenueData.labels,
            datasets: [
                {
                    label: 'Monthly Revenue',
                    data: revenueData.monthly,
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderColor: 'rgb(245, 158, 11)',
                    borderWidth: 1
                },
                {
                    label: 'Cumulative Revenue',
                    data: revenueData.cumulative,
                    type: 'line',
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        callback: function(value) {
                            return + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Engagement Chart (Activity Radar)
    const engagementCtx = document.getElementById('engagementChart').getContext('2d');
    new Chart(engagementCtx, {
        type: 'line',
        data: {
            labels: engagementData.labels,
            datasets: [
                {
                    label: 'Inquiries',
                    data: engagementData.inquiries,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Reviews',
                    data: engagementData.reviews,
                    borderColor: 'rgb(245, 158, 11)',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Events',
                    data: engagementData.events,
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 8
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function updateGrowthChart(period) {
    // Update button states
    const buttons = document.querySelectorAll('.btn-group button');
    buttons.forEach(btn => btn.classList.remove('active'));
     // Fetch data
    fetch(`/admin/dashboard/chart-data?period=${period}`)
        .then(response => response.json())
        .then(data => {
            window.userGrowthChart.data.labels = data.labels;
            window.userGrowthChart.data.datasets[0].data = data.providers;
            window.userGrowthChart.data.datasets[1].data = data.parents;
            window.userGrowthChart.update();
        })
        .catch(error => console.error('Error fetching chart data:', error));
}

function initializeEventListeners() {
    // View inquiry details
    const viewButtons = document.querySelectorAll('.view-inquiry');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inquiry = JSON.parse(this.dataset.inquiry);
            showInquiryDetails(inquiry);
            new bootstrap.Modal(document.getElementById('viewInquiryModal')).show();
        });
    });

    // Modal trigger
    const modalTriggers = document.querySelectorAll('[data-bs-target="#viewInquiryModal"]');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const inquiry = JSON.parse(this.dataset.inquiry);
            showInquiryDetails(inquiry);
        });
    });

    // Delete inquiry
    const deleteButtons = document.querySelectorAll('.delete-inquiry');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inquiryId = this.dataset.inquiryId;
            if (confirm('Are you sure you want to delete this inquiry?')) {
                deleteInquiry(inquiryId);
            }
        });
    });
}

function showInquiryDetails(inquiry) {
    const detailsContainer = document.getElementById('inquiryDetails');
    detailsContainer.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6>Parent Information</h6>
                <p><strong>Name:</strong> ${inquiry.parent_name}</p>
                <p><strong>Email:</strong> ${inquiry.parent_email}</p>
            </div>
            <div class="col-md-6">
                <h6>Inquiry Details</h6>
                <p><strong>ID:</strong> ${inquiry.inquiry_id}</p>
                <p><strong>Date:</strong> ${inquiry.date_time}</p>
                <p><strong>Status:</strong> <span class="badge bg-${getStatusColor(inquiry.status)}">${inquiry.status}</span></p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Provider</h6>
                <p><strong>Name:</strong> ${inquiry.provider_name}</p>
                <p><strong>Service Type:</strong> ${inquiry.service_type}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Message</h6>
                <div class="border rounded p-3 bg-light">
                    ${inquiry.message}
                </div>
            </div>
        </div>
    `;
}

function getStatusColor(status) {
    const colors = {
        'pending': 'info',
        'contacted': 'warning',
        'approved': 'success',
        'rejected': 'danger'
    };
    return colors[status] || 'secondary';
}

// Provider Approval/Rejection
function approveProvider(providerId) {
    if (!confirm('Are you sure you want to approve this provider?')) return;
    
    fetch(`/admin/providers/${providerId}/approve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Provider approved successfully!');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('error', 'Error approving provider');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Error approving provider');
    });
}

function rejectProvider(providerId) {
    if (!confirm('Are you sure you want to reject this provider?')) return;
    
    fetch(`/admin/providers/${providerId}/reject`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Provider rejected');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('error', 'Error rejecting provider');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Error rejecting provider');
    });
}

// Review Moderation
function moderateReview(reviewId, action) {
    const actionText = action === 'approve' ? 'approve' : action === 'hide' ? 'hide' : 'reject';
    if (!confirm(`Are you sure you want to ${actionText} this review?`)) return;
    
    fetch(`/admin/reviews/${reviewId}/moderate`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: action })
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            showNotification('success', `Review ${actionText}d successfully!`);
            setTimeout(() => location.reload(), 1500);
        } else {
            console.log(data)
            showNotification('error', 'Error moderating review');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Error moderating review');
    });
}

// Mark Inquiry as Resolved
function markResolved(inquiryId) {
    if (!confirm('Mark this inquiry as resolved?')) return;
    
    fetch(`/admin/inquiries/${inquiryId}/resolve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Inquiry marked as resolved!');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('error', 'Error updating inquiry');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Error updating inquiry');
    });
}

// Delete Inquiry
function deleteInquiry(inquiryId) {
    fetch(`/admin/inquiries/${inquiryId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Inquiry deleted successfully!');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('error', 'Error deleting inquiry');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Error deleting inquiry');
    });
}

// Export Revenue
function exportRevenue() {
    window.location.href = '/admin/dashboard/export-revenue?format=csv';
}

// Notification Helper
function showNotification(type, message) {
    // You can integrate with your existing notification system
    // For now, using a simple alert
    const bgColor = type === 'success' ? '#10b981' : '#ef4444';
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush