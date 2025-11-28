@extends('layouts.admin')

@section('admin-title', 'Dashboard - Admin Panel')

@section('content')
<div class="page-wrapper">
    <!-- Start Content -->
    <div class="content">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Welcome, Admin</h4>
                <p class="mb-0">Today you have {{ $stats['new_inquiries'] }} new inquiries</p>
            </div>
           {{--  <div id="reportrange" class="reportrange-picker d-flex align-items-center">
                <i class="ti ti-calendar text-body fs-14 me-1"></i>
                <span class="reportrange-picker-field">{{ now()->format('d M Y') }}</span>
            </div> --}}
        </div>
        <!-- End Page Header -->

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Providers -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-building-store fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Total Cleaners</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['total_providers'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Parents -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-users fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Total Customers</p>
                               <h6 class="mb-0 fsw-semibold">{{ $stats['total_parents'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Events -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
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
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
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
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
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
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-success rounded-circle flex-shrink-0">
                                <i class="ti ti-star fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Featured Cleaners</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['featured_providers'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Inquiries -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
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
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
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

        <!-- Admin Quick Controls (expanded) -->
        <div class="row mt-3">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Pending Approvals</h6>
                    </div>
                    <div class="card-body">
                        @if($pendingProviders->isEmpty())
                            <div class="text-muted">No pending Cleaners</div>
                        @else
                            <ul class="list-unstyled mb-0">
                                @foreach($pendingProviders as $p)
                                    <li class="d-flex align-items-center justify-content-between py-2">
                                        <div>
                                            <div class="fw-medium">
                                                <a href="{{ route('admin.cleaners.show', $p->id) }}" class="text-decoration-none">
                                                    {{ $p->name ?? $p->business_name ?? 'Unnamed' }}
                                                </a>
                                            </div>
                                            <small class="text-muted">{{ $p->created_at->format('d M') }}</small>
                                        </div>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-success btn-approve" data-id="{{ $p->id }}">Approve</button>
                                            <button class="btn btn-danger btn-reject" data-id="{{ $p->id }}">Reject</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Reported Reviews</h6>
                        <a href="{{ route('admin.reviews.index', ['status' => 'flagged']) }}" class="small">View all</a>
                    </div>
                    <div class="card-body">
                        @if($reportedReviews->isEmpty())
                            <div class="text-muted">No reported reviews</div>
                        @else
                            @foreach($reportedReviews as $rv)
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>{{ $rv->cleaner->name ?? $rv->cleaner->business_name ?? 'Cleaner' }}</strong>
                                            <div class="small text-muted">{{ \Illuminate\Support\Str::limit($rv->comment ?? $rv->content ?? '', 80) }}</div>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.reviews.show', $rv->id) }}" class="btn btn-sm btn-outline-primary">Moderate</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">New Inquiries</h6>
                        <a href="{{ route('admin.inquiries.index') }}" class="small">View all</a>
                    </div>
                    <div class="card-body">
                        @if($newInquiries->isEmpty())
                            <div class="text-muted">No new inquiries</div>
                        @else
                            @foreach($newInquiries as $inq)
                                <div class="d-flex align-items-center justify-content-between py-2">
                                    <div>
                                        <div class="fw-medium">{{ $inq->name }} — <small class="text-muted">{{ $inq->cleaner->name ?? $inq->cleaner->business_name ?? 'N/A' }}</small></div>
                                        <small class="text-muted">{{ $inq->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-danger btn-delete-inquiry" data-id="{{ $inq->id }}">Delete</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Revenue Actions</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.payments.export') }}" class="btn btn-outline-secondary w-100 mb-2">Export CSV</a>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-primary w-100">View Transaction Log</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <!-- All Providers -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="{{ route('admin.cleaners.index') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-building-store"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0">All Cleaners</p>
                    </div>
                </a>
            </div>

            <!-- All Parents -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="{{ route('admin.customers.index') }}" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2">
                           <i class="ti ti-users"></i>
                       </span>
                       <p class="text-dark fw-semibold mb-0">All Customers</p>
                    </div>
                </a>
            </div>

            <!-- Events -->
            <div class="col-xl-2 col-md-4 col-6">
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
            <div class="col-xl-2 col-md-4 col-6">
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
            <div class="col-xl-2 col-md-4 col-6">
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
            <div class="col-xl-2 col-md-4 col-6">
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

        <!-- Real-Time Feed -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Real-Time Feed Panel</h5>
                        <small class="text-muted">What's happening right now</small>
                    </div>
                    <div class="card-body">
                        <div id="realtimeFeed" class="row">
                            <div class="col-md-4">
                                <h6 class="mb-2">New Users</h6>
                                <ul id="feed-users" class="list-unstyled small text-muted"></ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-2">Recent Inquiries</h6>
                                <ul id="feed-inquiries" class="list-unstyled small text-muted"></ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-2">Flagged Reviews</h6>
                                <ul id="feed-reviews" class="list-unstyled small text-muted"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-truncate">Opened Support Tickets</p>
                            <h6 class="mb-0 fw-semibold">{{ $openSupportCount ?? 0 }}</h6>
                        </div>
                        <div>
                            <a href="{{ route('admin.support.index') }}" class="btn btn-sm btn-primary">View Tickets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-6">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">New Users (Providers + Parents)</h5>
                        <small class="text-muted">Monthly / Weekly</small>
                    </div>
                    <div class="card-body">
                        <canvas id="usersChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Providers by Category</h5>
                        <small class="text-muted">Distribution</small>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <canvas id="categoriesPie" height="120" style="max-width:360px; height: 225px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Revenue Trend</h5>
                        <small class="text-muted">Monthly revenue (cumulative)</small>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Engagement by City</h5>
                        <small class="text-muted">Top cities</small>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="engagementTable">
                                <thead>
                                    <tr>
                                        <th>City</th>
                                        <th>Inquiries</th>
                                        <th>Reviews</th>
                                        <th>Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Inquiries Table -->
        <div class="card shadow flex-fill w-100 mb-0 mt-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-truncate">Last 5 Provider Inquiries</h5> 
                <a href="#" class="btn btn-sm btn-outline-light flex-shrink-0">View All</a>
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
                                                <a href="{{ route('admin.cleaners.show', $inquiry['cleaner_id']) }}">
                                                    {{ $inquiry['cleaner_name'] }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                @php
                                    $serviceType = $inquiry['service_type'] ?? null;
                                    if (is_object($serviceType)) {
                                        $serviceDisplay = $serviceType->name ?? '-';
                                    } elseif (is_array($serviceType)) {
                                        $serviceDisplay = $serviceType['name'] ?? '-';
                                    } else {
                                        $serviceDisplay = $serviceType ?? '-';
                                    }
                                @endphp
                                <td>{{ $serviceDisplay }}</td>
                                <td>{{ $inquiry['date_time'] }}</td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'pending' => ['class' => 'badge-soft-info', 'text' => 'New'],
                                            'contacted' => ['class' => 'badge-soft-warning', 'text' => 'Contacted'],
                                            'approved' => ['class' => 'badge-soft-success', 'text' => 'Approved'],
                                            'rejected' => ['class' => 'badge-soft-danger', 'text' => 'Rejected']
                                        ];
                                        $config = $statusConfig[$inquiry['status']] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="badge {{ $config['class'] }} border border-{{ explode('-', $config['class'])[1] }} text-{{ explode('-', $config['class'])[1] }} py-1 ps-1">
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
                                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center view-inquiry" 
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View inquiry details
    const viewButtons = document.querySelectorAll('.view-inquiry');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inquiry = JSON.parse(this.dataset.inquiry);
            showInquiryDetails(inquiry);
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
                    <p><strong>Name:</strong> ${inquiry.cleaner_name}</p>
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

    // Delete inquiry
    const deleteButtons = document.querySelectorAll('.delete-inquiry');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inquiryId = this.dataset.inquiryId;
            if (confirm('Are you sure you want to delete this inquiry?')) {
                // AJAX call to delete inquiry
                fetch(`/admin/inquiries/${inquiryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting inquiry');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting inquiry');
                });
            }
        });
    });
});
</script>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch chart data and render charts
    fetch("{{ route('dashboard.chart-data') }}")
        .then(res => res.json())
        .then(data => {
            renderUsersChart(data);
            renderCategoriesPie(data);
            renderRevenueChart(data);
            renderEngagementTable(data.engagement_by_city || []);
        }).catch(err => console.error('Chart data error', err));

    function renderUsersChart(data) {
        const ctx = document.getElementById('usersChart');
        if (!ctx) return;
        const labels = data.labels || [];
        const providers = data.providers || [];
        const parents = data.parents || [];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Providers',
                        data: providers,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.08)',
                        tension: 0.3
                    },
                    {
                        label: 'Parents',
                        data: parents,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.08)',
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } }
            }
        });
    }
function renderCategoriesPie(data) {
    const ctx = document.getElementById('categoriesPie');
    if (!ctx) return;

    ctx.style.height = "220px"; // 👈 set height here

    const categories = data.categories || {};
    const labels = Object.keys(categories);
    const values = Object.values(categories);
    const colors = labels.map((_,i) => getColor(i));

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false // 👈 required when setting custom height
        }
    });
}


    function renderRevenueChart(data) {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;
        const labels = data.labels || [];
        const revenue = data.revenue || [];

        // cumulative
        let cum = 0;
        const cumulative = revenue.map(v => cum = cum + Number(v));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Monthly Revenue',
                        data: revenue,
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249,115,22,0.06)',
                        tension: 0.25
                    },
                    {
                        label: 'Cumulative Revenue',
                        data: cumulative,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.06)',
                        tension: 0.25
                    }
                ]
            },
            options: { responsive: true }
        });
    }

    function renderEngagementTable(rows) {
        const tbody = document.querySelector('#engagementTable tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        let max = 0;
        rows.forEach(r => {
            const total = (r.inquiries||0) + (r.reviews||0) + (r.events||0);
            if (total > max) max = total;
        });

        rows.forEach(r => {
            const tr = document.createElement('tr');
            const total = (r.inquiries||0) + (r.reviews||0) + (r.events||0);
            tr.innerHTML = `
                <td>${r.city}</td>
                <td style="background:${shadeForValue(r.inquiries, max)}">${r.inquiries}</td>
                <td style="background:${shadeForValue(r.reviews, max)}">${r.reviews}</td>
                <td style="background:${shadeForValue(r.events, max)}">${r.events}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function getColor(i) {
        const palette = ['#6366f1','#ef4444','#f97316','#10b981','#06b6d4','#8b5cf6','#ec4899','#f59e0b'];
        return palette[i % palette.length];
    }

    function shadeForValue(value, max) {
        if (!max || value <= 0) return 'transparent';
        const ratio = value / max;
        const alpha = 0.15 + (ratio * 0.6);
        return `rgba(59,130,246,${alpha})`;
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = '{{ csrf_token() }}';

    // Approve / Reject provider
    document.querySelectorAll('.btn-approve, .btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const isApprove = this.classList.contains('btn-approve');
            const status = isApprove ? 'approved' : 'rejected';
            if (!confirm(`${isApprove ? 'Approve' : 'Reject'} this cleaner?`)) return;
            fetch(`/admin/cleaners/${id}/status`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ status })
            }).then(r => r.json()).then(resp => {
                if (resp.success ?? true) location.reload();
                else alert('Error');
            }).catch(e => { console.error(e); alert('Error'); });
        });
    });

    // Resolve inquiry
    document.querySelectorAll('.btn-resolve-inquiry').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (!confirm('Mark inquiry as resolved?')) return;
            fetch(`/admin/inquiries/${id}/resolve`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token }
            }).then(r => r.json()).then(resp => { if (resp.success) location.reload(); else alert('Error'); }).catch(e => { console.error(e); alert('Error'); });
        });
    });

    // Delete inquiry (admin)
    document.querySelectorAll('.btn-delete-inquiry').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (!confirm('Permanently delete this inquiry?')) return;
            fetch(`/admin/inquiries/${id}`, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token }
            }).then(r => r.json()).then(resp => { if (resp.success) location.reload(); else alert('Error'); }).catch(e => { console.error(e); alert('Error'); });
        });
    });
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const feedEl = {
        users: document.getElementById('feed-users'),
        inquiries: document.getElementById('feed-inquiries'),
        reviews: document.getElementById('feed-reviews')
    };

    function renderFeed(payload) {
        if (!payload) return;
        feedEl.users && (feedEl.users.innerHTML = payload.users.map(u => `<li><strong>${u.name}</strong> <div class="small text-muted">${u.created_at}</div></li>`).join(''));
        feedEl.inquiries && (feedEl.inquiries.innerHTML = payload.inquiries.map(i => `<li><strong>${i.name}</strong> <div class="small text-muted">${i.provider} • ${i.created_at}</div></li>`).join(''));
        feedEl.reviews && (feedEl.reviews.innerHTML = payload.flagged_reviews.map(r => `<li><strong>${r.provider}</strong> <div class="small text-muted">${r.snippet} • ${r.created_at}</div></li>`).join(''));
    }

    async function fetchFeed() {
        try {
            const res = await fetch("{{ route('admin.realtime.feed') }}");
            if (!res.ok) return;
            const data = await res.json();
            renderFeed(data);
        } catch (e) {
            console.error('Realtime feed error', e);
        }
    }

    fetchFeed();
    setInterval(fetchFeed, 30000); // poll every 30s
});
</script>
@endpush