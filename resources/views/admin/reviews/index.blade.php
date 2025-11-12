@extends('layouts.admin')
@section('title','Reviews & Moderation')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Reviews & Moderation</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reviews & Moderation</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Enhanced Stats Cards -->
        <div class="row g-2 mb-3">
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Total Reviews</p>
                    <h6>{{ $totalReviews ?? 0 }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Pending</p>
                    <h6 class="text-warning">{{ $pendingCount ?? 0 }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Approved</p>
                    <h6 class="text-success">{{ $approvedCount ?? 0 }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Flagged</p>
                    <h6 class="text-danger">{{ $flaggedCount ?? 0 }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Hidden</p>
                    <h6 class="text-secondary">{{ $hiddenCount ?? 0 }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Avg Rating</p>
                    <h6 class="text-primary">{{ $avgRating ?? '0.00' }}/5</h6>
                </div>
            </div>
        </div>

        <!-- Charts row -->
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <div class="card card-h-100">
                    <div class="card-header">
                        <div class="card-title">Reviews by City</div>
                        <p class="mb-0 text-muted">Total reviews per city</p>
                    </div>
                    <div class="card-body">
                        @if(!empty($cityLabels) && count($cityLabels))
                            <canvas id="reviewsCityChart" height="250"></canvas>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="height:250px">No review location data available</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-h-100">
                    <div class="card-header">
                        <div class="card-title">Review Status Distribution</div>
                        <p class="mb-0 text-muted">Current status of all reviews</p>
                    </div>
                    <div class="card-body text-center">
                        @if(!empty($statusLabels) && count($statusLabels))
                            <canvas id="reviewStatusChart" height="250"></canvas>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="height:250px">No status distribution data available</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-h-100">
                    <div class="card-header">
                        <div class="card-title">Rating Distribution</div>
                        <p class="mb-0 text-muted">Reviews by star rating</p>
                    </div>
                    <div class="card-body">
                        @if($ratingDistribution->count())
                            <canvas id="ratingDistributionChart" height="250"></canvas>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="height:250px">No rating data available</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Row -->
        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Top Providers by Reviews</div>
                    </div>
                    <div class="card-body">
                        @forelse($topProviders as $provider)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <strong>{{ $provider->first_name }}</strong>
                                    <div class="text-muted small">
                                        <span class="text-warning">{{ str_repeat('★', round($provider->avg_rating)) . str_repeat('☆', 5 - round($provider->avg_rating)) }}</span>
                                        ({{ number_format($provider->avg_rating, 1) }})
                                    </div>
                                </div>
                                <span class="badge bg-primary">{{ $provider->review_count }} reviews</span>
                            </div>
                        @empty
                            <div class="text-muted text-center py-3">No provider data available</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Recent Activity (30 days)</div>
                    </div>
                    <div class="card-body">
                        @if($recentActivity->count())
                            <canvas id="recentActivityChart" height="250"></canvas>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="height:250px">No recent activity data</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Review Management</h6>
                <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex align-items-center gap-2">
                    <input type="search" name="q" class="form-control form-control-sm" placeholder="Search reviews..." value="{{ request('q') }}">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All statuses</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
                        <option value="flagged" {{ request('status')=='flagged' ? 'selected' : '' }}>Flagged</option>
                        <option value="hidden" {{ request('status')=='hidden' ? 'selected' : '' }}>Hidden</option>
                        <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <select name="rating" class="form-select form-select-sm">
                        <option value="">All ratings</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                    <button class="btn btn-sm btn-primary">Filter</button>
                    @if(request()->hasAny(['status', 'rating', 'q']))
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    @endif
                </form>
            </div>
            
            <!-- Bulk Actions -->
            <div class="card-body border-bottom">
                <form id="bulkActionForm" method="POST" action="{{ route('admin.reviews.bulk-update') }}">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Select all <span id="selectedCount" class="text-muted">(0 selected)</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <select name="status" class="form-select form-select-sm" id="bulkStatus">
                                <option value="">Bulk status change...</option>
                                <option value="approved">Approve</option>
                                <option value="pending">Mark as Pending</option>
                                <option value="flagged">Flag</option>
                                <option value="hidden">Hide</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-sm btn-primary" id="bulkUpdateBtn" disabled>Apply</button>
                            <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn" disabled>Delete</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable mb-0">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input" id="selectAllHeader">
                                </th>
                                <th>Parent</th>
                                <th>Provider</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Review</th>
                                <th>Date</th>
                                <th class="no-sort">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $r)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input review-checkbox" name="review_ids[]" value="{{ $r->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('vendor/admin/img/profiles/avatar-12.jpg') }}" class="avatar-sm rounded-circle me-2" alt="">
                                            <div>
                                                <div class="fw-semibold">{{ $r->parent->name ?? 'Parent' }}</div>
                                                <small class="text-muted">{{ $r->parent->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $r->provider->name ?? 'Provider' }}</td>
                                    <td>
                                        <span class="text-warning">{{ str_repeat('★', $r->rating) . str_repeat('☆', max(0,5-$r->rating)) }}</span>
                                        <small class="text-muted">({{ $r->rating }})</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $r->getStatusBadgeClass() }}">{{ ucfirst($r->status) }}</span>
                                    </td>
                                    <td>{{ Str::limit($r->comment, 80) }}</td>
                                    <td>{{ $r->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.reviews.show', $r) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form method="POST" action="{{ route('admin.reviews.update', $r) }}" style="display:inline">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="dropdown-item text-success">Approve</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.reviews.update', $r) }}" style="display:inline">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="dropdown-item text-warning">Mark Pending</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.reviews.update', $r) }}" style="display:inline">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="flagged">
                                                        <button type="submit" class="dropdown-item text-danger">Flag</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}" onsubmit="return confirm('Are you sure?')" style="display:inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-muted text-center py-3">No reviews found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 pagination-row">
                    <div class="admin-pagination">
                        {{ $reviews->onEachSide(1)->links() }}
                    </div>
                    <div class="results-summary text-muted ms-3">
                        Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} of {{ $reviews->total() ?? 0 }} results
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<style>
    .pagination-row { display:flex; align-items:center; gap:1rem; justify-content:flex-start; margin-top:0.5rem; }
    .admin-pagination .pagination { margin:0; }
    .admin-pagination .page-link { padding: .28rem .6rem; font-size: .9rem; }
    .admin-pagination .page-item.active .page-link { background-color:#0d6efd; border-color:#0d6efd; }
    .table-responsive { max-height: 58vh; overflow:auto; }
    .badge { font-size: 0.75em; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Bulk selection functionality
        const selectAll = document.getElementById('selectAll');
        const selectAllHeader = document.getElementById('selectAllHeader');
        const checkboxes = document.querySelectorAll('.review-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const bulkUpdateBtn = document.getElementById('bulkUpdateBtn');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const bulkStatus = document.getElementById('bulkStatus');

        function updateSelection() {
            const checked = document.querySelectorAll('.review-checkbox:checked');
            selectedCount.textContent = `(${checked.length} selected)`;
            bulkUpdateBtn.disabled = checked.length === 0 || !bulkStatus.value;
            bulkDeleteBtn.disabled = checked.length === 0;
        }

        selectAll?.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelection();
        });

        selectAllHeader?.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelection();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateSelection);
        });

        bulkStatus?.addEventListener('change', updateSelection);

        // Bulk delete
        bulkDeleteBtn?.addEventListener('click', function() {
            if(confirm(`Are you sure you want to delete ${document.querySelectorAll('.review-checkbox:checked').length} reviews?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.reviews.bulk-destroy") }}';
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                checkboxes.forEach(cb => {
                    if(cb.checked) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'review_ids[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    }
                });

                document.body.appendChild(form);
                form.submit();
            }
        });

        // Charts
        try{
            // Reviews by City
            var cityLabels = @json($cityLabels ?? []);
            var approvedCounts = @json($approvedCounts ?? []);
            var flaggedCounts = @json($flaggedCounts ?? []);
            var ctx = document.getElementById('reviewsCityChart');
            if(ctx && cityLabels.length){
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: { 
                        labels: cityLabels, 
                        datasets: [
                            { label: 'Approved', data: approvedCounts, backgroundColor: 'rgba(25,135,84,0.8)' },
                            { label: 'Flagged', data: flaggedCounts, backgroundColor: 'rgba(220,53,69,0.8)' }
                        ] 
                    },
                    options: { 
                        responsive: true, 
                        plugins: { legend: { position: 'top' } }, 
                        scales: { x: { stacked: true }, y: { stacked: true } } 
                    }
                });
            }
        }catch(e){console.warn(e)}

        try{
            // Status distribution
            var statusLabels = @json($statusLabels ?? []);
            var statusCounts = @json($statusCounts ?? []);
            var ctx2 = document.getElementById('reviewStatusChart');
            if(ctx2 && statusLabels.length){
                var colorMap = { 
                    approved: '#198754', 
                    pending: '#ffc107', 
                    hidden: '#6c757d', 
                    flagged: '#dc3545', 
                    rejected: '#0d6efd' 
                };
                var colors = statusLabels.map(function(l){ return colorMap[l] || '#adb5bd'; });
                new Chart(ctx2.getContext('2d'), {
                    type: 'doughnut',
                    data: { 
                        labels: statusLabels, 
                        datasets: [{ 
                            data: statusCounts, 
                            backgroundColor: colors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }] 
                    },
                    options: { 
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }catch(e){console.warn(e)}

        try{
            // Rating distribution
            var ratingData = @json($ratingDistribution ?? []);
            if(ratingData.length){
                var ratingLabels = ratingData.map(r => r.rating + ' Star' + (r.rating > 1 ? 's' : ''));
                var ratingCounts = ratingData.map(r => r.count);
                var ctx3 = document.getElementById('ratingDistributionChart');
                if(ctx3){
                    new Chart(ctx3.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ratingLabels,
                            datasets: [{
                                label: 'Number of Reviews',
                                data: ratingCounts,
                                backgroundColor: 'rgba(255,193,7,0.8)',
                                borderColor: 'rgba(255,193,7,1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
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
                }
            }
        }catch(e){console.warn(e)}

        try{
            // Recent activity
            var recentActivity = @json($recentActivity ?? []);
            if(recentActivity.length){
                var activityDates = recentActivity.map(a => new Date(a.date).toLocaleDateString());
                var activityCounts = recentActivity.map(a => a.count);
                var ctx4 = document.getElementById('recentActivityChart');
                if(ctx4){
                    new Chart(ctx4.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: activityDates,
                            datasets: [{
                                label: 'Reviews per Day',
                                data: activityCounts,
                                borderColor: 'rgba(13,110,253,1)',
                                backgroundColor: 'rgba(13,110,253,0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
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
                }
            }
        }catch(e){console.warn(e)}
    });
</script>
@endpush

@endsection