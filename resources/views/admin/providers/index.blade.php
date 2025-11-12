@extends('layouts.admin')

@section('admin-title', 'Providers Management - Admin Panel')
@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Providers</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Home</a></li>                            
                        <li class="breadcrumb-item active">Providers</li>
                    </ol>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh" onclick="refreshTable()">
                    <i class="ti ti-refresh"></i>
                </a>
              
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Download" data-bs-original-title="Download" onclick="exportToCSV()">
                    <i class="ti ti-cloud-download"></i>
                </a>
                <a href="#" data-size="lg" data-url="{{ route('admin.providers.create') }}" data-ajax-popup="true" data-title="{{__('New Provider')}}" class="btn btn-primary">New Provider</a>
            </div>
        </div>
        <!-- End Page Header -->
        
        <!-- Stats Cards -->
        <div class="row g-2 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted fw-semibold">Total Providers</h6>
                                <h4 class="mb-0" id="total-providers">{{ $providers->total() }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="ti ti-users text-primary fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted fw-semibold">Pending Approval</h6>
                                <h4 class="mb-0" id="pending-providers">0</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="ti ti-clock text-warning fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted fw-semibold">Active Providers</h6>
                                <h4 class="mb-0" id="active-providers">0</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="ti ti-check text-success fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted fw-semibold">Total Revenue</h6>
                                <h4 class="mb-0" id="total-revenue">$0</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="ti ti-currency-dollar text-info fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card start -->
        <div class="card mb-0">

            <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Total Providers <span class="badge bg-danger ms-2">{{ $providers->total() }}</span></h6>
                <div class="search-set">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="table-search d-flex align-items-center mb-0">
                            <div class="search-input">
                                <form method="GET" action="{{ route('admin.providers.index') }}" id="searchForm">
                                    <a href="javascript:void(0);" class="btn-searchset" onclick="document.getElementById('searchForm').submit()">
                                        <i class="ti ti-search"></i>
                                    </a>
                                    <input type="text" class="form-control" name="search" placeholder="Search providers..." value="{{ request('search') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- table header -->
            <div class="table-header border-bottom d-flex align-items-center justify-content-between gap-2 flex-wrap p-3">
                <div class="d-flex align-items-center flex-wrap gap-2">

                    <!-- status dropdown -->
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-md btn-outline-light d-inline-flex align-items-center" 
                           data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="ti ti-shield-half me-1"></i> 
                            <span id="status-filter-text">All Status</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sm p-2">
                            <li>
                                <label class="dropdown-item px-2 d-flex align-items-center rounded-1">
                                    <input class="form-check-input m-0 me-2 status-filter" type="checkbox" value="approved" 
                                           {{ in_array('approved', (array)request('status', [])) ? 'checked' : '' }}> 
                                    Active
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item px-2 d-flex align-items-center rounded-1">
                                    <input class="form-check-input m-0 me-2 status-filter" type="checkbox" value="pending"
                                           {{ in_array('pending', (array)request('status', [])) ? 'checked' : '' }}> 
                                    Pending
                                </label>
                            </li>
                            <li>
                                <label class="dropdown-item px-2 d-flex align-items-center rounded-1">
                                    <input class="form-check-input m-0 me-2 status-filter" type="checkbox" value="rejected"
                                           {{ in_array('rejected', (array)request('status', [])) ? 'checked' : '' }}> 
                                    Rejected
                                </label>
                            </li>
                        </ul>
                    </div>

                    <!-- city dropdown -->
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-md btn-outline-light d-inline-flex align-items-center" 
                           data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="ti ti-map-pin me-1"></i> 
                            <span id="city-filter-text">All Cities</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-md p-2">
                            <li>
                                <div class="mb-2">
                                    <div class="input-icon-start input-icon position-relative">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-md" placeholder="Search city" id="city-search">
                                    </div>
                                </div>
                            </li>
                            <div id="city-list" style="max-height: 200px; overflow-y: auto;">
                                @php
                                    $cities = \App\Models\Provider::distinct('city')->whereNotNull('city')->pluck('city');
                                @endphp
                                @foreach($cities as $city)
                                    <li>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="form-check-input me-2 city-filter" value="{{ $city }}"
                                                   {{ in_array($city, (array)request('city', [])) ? 'checked' : '' }}>
                                            {{ $city }}
                                        </label>
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="dropdown" id="bulk-actions" style="display: none;">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-md btn-outline-primary d-inline-flex align-items-center" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-playlist-add me-1"></i> 
                            Bulk Actions
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sm p-2">
                            <li><a href="javascript:void(0);" class="dropdown-item" onclick="bulkAction('approve')"><i class="ti ti-check me-1"></i> Approve Selected</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item" onclick="bulkAction('reject')"><i class="ti ti-x me-1"></i> Reject Selected</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item text-danger" onclick="bulkAction('delete')"><i class="ti ti-trash me-1"></i> Delete Selected</a></li>
                        </ul>
                    </div>

                </div>

                <!-- sort by -->
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-md btn-outline-light d-inline-flex align-items-center" 
                     data-bs-toggle="dropdown">
                        <i class="ti ti-sort-descending-2 me-1"></i>
                        <span class="me-1">Sort By : </span> 
                        <span id="sort-text">
                            @switch(request('sort', 'newest'))
                                @case('oldest') Oldest @break
                                @case('name') Name @break
                                @case('revenue') Revenue @break
                                @default Newest
                            @endswitch
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2">
                        <li><a href="javascript:void(0);" class="dropdown-item sort-option {{ request('sort') == 'newest' ? 'active' : '' }}" data-sort="newest">Newest</a></li>
                        <li><a href="javascript:void(0);" class="dropdown-item sort-option {{ request('sort') == 'oldest' ? 'active' : '' }}" data-sort="oldest">Oldest</a></li>
                        <li><a href="javascript:void(0);" class="dropdown-item sort-option {{ request('sort') == 'name' ? 'active' : '' }}" data-sort="name">Name</a></li>
                        <li><a href="javascript:void(0);" class="dropdown-item sort-option {{ request('sort') == 'revenue' ? 'active' : '' }}" data-sort="revenue">Revenue</a></li>
                    </ul>
                </div>
            </div>
            <!-- table header -->

            <div class="card-body">
                <!-- table start -->
                <div class="table-responsive table-nowrap">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="no-sort" width="50">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Provider</th>
                                <th>Contact</th>
                                <th>Location</th>
                                <th>Membership</th>
                                <th>Status</th>
                                <th>Rating</th>
                                <th>Revenue</th>
                                <th class="no-sort" width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($providers as $provider)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input row-checkbox" value="{{ $provider->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm rounded-circle bg-success text-white me-2">
                                            {{ strtoupper(substr($provider->business_name ?? $provider->name, 0, 2)) }}
                                        </span>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">
                                                <a href="{{ route('admin.providers.show', $provider->id) }}">
                                                    {{ $provider->business_name ?? $provider->name }}
                                                </a>
                                            </span>
                                            <span class="small text-muted">{{ $provider->category }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-muted">
                                            <i class="ti ti-mail me-1"></i> {{ $provider->email }}
                                        </span>
                                        <span class="text-muted">
                                            <i class="ti ti-phone me-1"></i> {{ $provider->phone ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <i class="ti ti-map-pin me-1"></i> 
                                    {{ $provider->city ? $provider->city . ', ' . $provider->state : 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ isset($provider->subscription->plan) ? $provider->subscription->plan->name : 'Basic' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($provider->status == 'approved') bg-success-subtle text-success
                                        @elseif($provider->status == 'pending') bg-warning-subtle text-warning
                                        @else bg-danger-subtle text-danger @endif">
                                        {{ ucfirst($provider->status) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $rating = $provider->reviews()->avg('rating');
                                    @endphp
                                    @if($rating)
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-star-filled text-warning me-1"></i> 
                                            <span>{{ number_format($rating, 1) }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">No reviews</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-semibold">${{ number_format($provider->revenue, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu p-2">
                                            <li>
                                                <a href="#" data-size="lg" 
                                                   data-url="{{ route('admin.providers.show', $provider->id) }}" 
                                                   data-ajax-popup="true"  
                                                   data-title="{{ __('Show Provider') }}"  class="dropdown-item">
                                                    <i class="ti ti-eye me-1"></i> View
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-size="lg" 
                                                   data-url="{{ route('admin.providers.edit', $provider->id) }}" 
                                                   data-ajax-popup="true"  
                                                   data-title="{{ __('Edit Provider') }}" 
                                                   class="dropdown-item">
                                                    <i class="ti ti-edit me-1"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                @if($provider->status == 'pending')
                                                <a href="javascript:void(0);" class="dropdown-item text-success" onclick="updateStatus({{ $provider->id }}, 'approved')">
                                                    <i class="ti ti-check me-1"></i> Approve
                                                </a>
                                                @endif
                                                @if($provider->status == 'approved')
                                                <a href="javascript:void(0);" class="dropdown-item text-warning" onclick="updateStatus({{ $provider->id }}, 'pending')">
                                                    <i class="ti ti-clock me-1"></i> Set Pending
                                                </a>
                                                @endif
                                                @if($provider->status != 'rejected')
                                                <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="updateStatus({{ $provider->id }}, 'rejected')">
                                                    <i class="ti ti-x me-1"></i> Reject
                                                </a>
                                                @endif
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.providers.destroy', $provider->id) }}" method="POST" id="delete-form-{{ $provider->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $provider->id }})">
                                                        <i class="ti ti-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="ti ti-users-off fs-32 mb-2 d-block"></i>
                                        No providers found
                                    </div>
                                    @if(request()->anyFilled(['search', 'status', 'city']))
                                        <a href="{{ route('admin.providers.index') }}" class="btn btn-sm btn-primary mt-2">
                                            Clear Filters
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- table end -->

                <!-- Pagination -->
                @if($providers->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $providers->firstItem() }} to {{ $providers->lastItem() }} of {{ $providers->total() }} entries
                    </div>
                    <div>
                        {{ $providers->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- card end -->

    </div>
    <!-- End Content -->

</div>

<!-- Hidden Filter Form -->
<form id="filterForm" method="GET" action="{{ route('admin.providers.index' ) }}">
    <input type="hidden" name="search" id="filter-search" value="{{ request('search') }}">
    <input type="hidden" name="sort" id="filter-sort" value="{{ request('sort', 'newest') }}">
    @foreach((array)request('status', []) as $status)
        <input type="hidden" name="status[]" value="{{ $status }}">
    @endforeach
    @foreach((array)request('city', []) as $city)
        <input type="hidden" name="city[]" value="{{ $city }}">
    @endforeach
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
    initializeFilters();
    initializeBulkActions();
});

// Load dashboard stats
function loadStats() {
    fetch('{{ route("admin.providers.stats") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-providers').textContent = data.total;
            document.getElementById('pending-providers').textContent = data.pending;
            document.getElementById('active-providers').textContent = data.approved;
            document.getElementById('total-revenue').textContent = '$' + data.revenue;
        })
        .catch(error => console.error('Error loading stats:', error));
}

// Initialize filters
function initializeFilters() {
    // Status filter
    const statusFilters = document.querySelectorAll('.status-filter');
    statusFilters.forEach(filter => {
        filter.addEventListener('change', updateStatusFilterText);
    });
    updateStatusFilterText();

    // City filter
    const cityFilters = document.querySelectorAll('.city-filter');
    cityFilters.forEach(filter => {
        filter.addEventListener('change', updateCityFilterText);
    });
    updateCityFilterText();

    // City search
    const citySearch = document.getElementById('city-search');
    if (citySearch) {
        citySearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cityItems = document.querySelectorAll('#city-list .dropdown-item');
            
            cityItems.forEach(item => {
                const cityName = item.textContent.toLowerCase();
                if (cityName.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Sort options
    const sortOptions = document.querySelectorAll('.sort-option');
    sortOptions.forEach(option => {
        option.addEventListener('click', function() {
            document.getElementById('filter-sort').value = this.dataset.sort;
            document.getElementById('sort-text').textContent = this.textContent;
            document.getElementById('filterForm').submit();
        });
    });
}

function updateStatusFilterText() {
    const selectedStatus = Array.from(document.querySelectorAll('.status-filter:checked'))
        .map(cb => cb.parentElement.textContent.trim());
    
    const textElement = document.getElementById('status-filter-text');
    if (selectedStatus.length === 0) {
        textElement.textContent = 'All Status';
    } else {
        textElement.textContent = selectedStatus.join(', ');
    }
}

function updateCityFilterText() {
    const selectedCities = Array.from(document.querySelectorAll('.city-filter:checked'))
        .map(cb => cb.value);
    
    const textElement = document.getElementById('city-filter-text');
    if (selectedCities.length === 0) {
        textElement.textContent = 'All Cities';
    } else if (selectedCities.length === 1) {
        textElement.textContent = selectedCities[0];
    } else {
        textElement.textContent = selectedCities.length + ' cities';
    }
}

// Bulk actions
function initializeBulkActions() {
    // Select all checkbox
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });
    }

    // Individual checkboxes
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });
}

function toggleBulkActions() {
    const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
    const bulkActions = document.getElementById('bulk-actions');
    
    if (selectedCount > 0) {
        bulkActions.style.display = 'block';
    } else {
        bulkActions.style.display = 'none';
    }
}

function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
        .map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('Please select at least one provider.');
        return;
    }

    if (action === 'delete' && !confirm('Are you sure you want to delete the selected providers? This action cannot be undone.')) {
        return;
    }

    fetch('{{ route("admin.providers.bulk-action") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: action,
            ids: selectedIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('Error performing bulk action', 'error');
    });
}

// Individual actions
function updateStatus(providerId, status) {
    fetch(`/admin/providers/${providerId}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('Error updating status', 'error');
    });
}

function confirmDelete(providerId) {
    if (confirm('Are you sure you want to delete this provider? This action cannot be undone.')) {
        document.getElementById(`delete-form-${providerId}`).submit();
    }
}

// Utility functions
function refreshTable() {
    location.reload();
}

function printTable() {
    window.print();
}

function exportToCSV() {
    // Implement CSV export functionality
    alert('CSV export functionality would be implemented here.');
}

function showToast(message, type = 'info') {
    // Implement toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}

// Apply filters when checkboxes change
document.querySelectorAll('.status-filter, .city-filter').forEach(filter => {
    filter.addEventListener('change', function() {
        // Update hidden form fields
        updateFilterForm();
        // Submit form
        document.getElementById('filterForm').submit();
    });
});

function updateFilterForm() {
    // Clear existing status and city inputs
    document.querySelectorAll('input[name="status[]"], input[name="city[]"]').forEach(input => input.remove());
    
    // Add status filters
    document.querySelectorAll('.status-filter:checked').forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'status[]';
        input.value = checkbox.value;
        document.getElementById('filterForm').appendChild(input);
    });
    
    // Add city filters
    document.querySelectorAll('.city-filter:checked').forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'city[]';
        input.value = checkbox.value;
        document.getElementById('filterForm').appendChild(input);
    });
}
</script>

<style>
.table-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.no-sort {
    pointer-events: none;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.dropdown-item.active {
    background-color: #5f7f7a;
    color: white;
}

@media print {
    .card-header, .table-header, .dropdown, .btn {
        display: none !important;
    }
    
    table {
        width: 100% !important;
    }
}
</style>
@endpush