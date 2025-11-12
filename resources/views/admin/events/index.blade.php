@extends('layouts.main')


@section('admin-title', 'Events - Admin Pnael')
@section('content')

<div class="page-wrapper">
  <!-- Start Content -->
  <div class="content">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
      <div class="breadcrumb-arrow">
        <h4 class="mb-1">Events</h4>
        <div class="text-end">
          <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Events</li>
          </ol>
        </div>
      </div>
      <div class="gap-2 d-flex align-items-center flex-wrap">
        
        <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
        <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Download" data-bs-original-title="Download"><i class="ti ti-cloud-download"></i></a>
        <a href="javascript:void(0);" data-size="lg" data-url="{{ route('admin.events.create') }}" data-ajax-popup="true"  data-title="{{__('New Parent')}}"  class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New Event</a>
      </div>
    </div>
    <div class="row g-2 mb-4">
      <div class="col-md-3">
        <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
          <p class="mb-2">Total Events</p>
          <h6>{{ $stats['total'] ?? '—' }}</h6>
        </div>
      </div>
      <div class="col-md-4">
        <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
          <p class="mb-2">Pending Approval</p>
          <h6>{{ $stats['pending'] ?? '—' }}</h6>
        </div>
      </div>
      <div class="col-md-4">
        <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
          <p class="mb-2">This Week</p>
          <h6>{{ $stats['this_week'] ?? '—' }}</h6>
        </div>
      </div>
     
    </div>
    
    <!-- End Page Header -->
    
    <!-- card start -->
    <div class="card mb-0">
      <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
        <h6 class="d-inline-flex align-items-center mb-0">Total Events <span class="badge bg-danger ms-2">{{ count($contents) }}</span></h6>
        <div class="search-set">
          <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="table-search d-flex align-items-center mb-0">
              <div class="search-input">
                <a href="javascript:void(0);" class="btn-searchset"><i class="ti ti-search"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- table header -->
      <div class="table-header border-bottom d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="d-flex align-items-center flex-wrap gap-2">
          <!-- status dropdown -->
          <div class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle btn btn-md btn-outline-light d-inline-flex align-items-center"
              data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="ti ti-shield-half me-1"></i> All Status
            </a>
            <ul class="dropdown-menu dropdown-menu-sm p-2">
              <li>
                <label class="dropdown-item px-2 d-flex align-items-center rounded-1">
                  <input class="form-check-input m-0 me-2" type="checkbox"> Active
                </label>
              </li>
              <li>
                <label class="dropdown-item px-2 d-flex align-items-center rounded-1">
                  <input class="form-check-input m-0 me-2" type="checkbox"> Inactive
                </label>
              </li>
              <li>
                <label class="dropdown-item px-2 d-flex align-items-center rounded-1">
                  <input class="form-check-input m-0 me-2" type="checkbox"> Pending
                </label>
              </li>
            </ul>
          </div>
          <!-- city dropdown -->
          <div class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle btn btn-md btn-outline-light d-inline-flex align-items-center"
              data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="ti ti-calendar-bolt me-1"></i> All Categories
            </a>
            <ul class="dropdown-menu dropdown-menu-md p-2">
              <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> All Categories</label></li>
              <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Sports</label></li>
              <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Educational</label></li>
              <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Art & Crafts</label></li>
            </ul>
          </div>
        </div>
        <!-- sort by -->
        <div class="dropdown">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-md btn-outline-light d-inline-flex align-items-center"
            data-bs-toggle="dropdown">
            <i class="ti ti-sort-descending-2 me-1"></i><span class="me-1">Sort By : </span> Newest
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-2">
            <li><a href="javascript:void(0);" class="dropdown-item">Newest</a></li>
            <li><a href="javascript:void(0);" class="dropdown-item">Oldest</a></li>
          </ul>
        </div>
      </div>
      <!-- table header -->
      <div class="card-body">
        <!-- table start -->
        <div class="table-responsive table-nowrap">
          <table class="table mb-0 datatable">
            <thead>
              <tr>
                <th class="no-sort">
                  <div class="form-check form-check-md">
                    <input class="form-check-input" type="checkbox" id="select-all">
                  </div>
                </th>
                <th>Event</th>
                <th>Date & Time</th>
                <th>Location</th>
                <th>Capacity</th>
                <th>Cost</th>
                <th>Status</th>
                <th class="no-sort">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($contents ?? [] as $c)
              <tr data-status="{{ $c->status }}" data-category="{{ $c->category }}" data-published="{{ optional($c->published_at)->format('Y-m-d H:i:s') }}">
                <td><input type="checkbox" class="form-check-input"></td>
                <td>
                  <div class="d-flex flex-column">
                    <span class="fw-semibold">{{ $c->title }}</span>
                    <span class="text-muted small">{{ $c->subtitle ?? '' }}</span>
                    <span class="badge border border-1 bg-transparent text-dark mt-1" style="width: fit-content;">{{ $c->category ?? '' }}</span>
                  </div>
                </td>
                <td>
                  <div class="d-flex flex-column">
                    <span><i class="ti ti-calendar me-1"></i> {{ optional($c->published_at)->format('n/j/Y') }}</span>
                    <span><i class="ti ti-clock-hour-10 me-1"></i> {{ optional($c->published_at)->format('g:i A') }}</span>
                  </div>
                </td>
                <td>
                  <div class="d-flex flex-column">
                    <span class="fw-semibold">{{ $c->location ?? '' }}</span>
                    <span class="text-muted small">{{ $c->city ?? '' }}</span>
                  </div>
                </td>
                <td>
                  <div class="d-flex flex-column">
                    <span><i class="ti ti-users me-1"></i> {{ $c->capacity ?? '-' }}</span>
                    <span class="text-muted small">{{ $c->age_range ?? '' }}</span>
                  </div>
                </td>
                <td><span class="fw-semibold">{{ $c->cost ? '$' . number_format($c->cost,2) : 'Free' }}</span></td>
                <td>
                  @if(Auth::user()->hasRole('admin'))
    @if($c->status == 'published')
        <span class="badge bg-success-subtle text-success">Active</span>
    @elseif($c->status == 'pending')
        <span class="badge bg-warning-subtle border border-1 text-warning">pending</span>
        <div class="d-flex gap-1 mt-2">
            <a href="{{ route('admin.events.approve', $c->id) }}" class="btn btn-primary btn-sm">
                <i class="ti ti-circle-check me-1"></i> Approve
            </a>
            <a href="{{ route('admin.events.reject', $c->id) }}" class="btn btn-danger btn-sm">
                <i class="ti ti-circle-x me-1"></i> Reject
            </a>
        </div>
    @else
        <span class="badge bg-secondary">{{ ucfirst($c->status) }}</span>
    @endif
    @else
     <span class="badge bg-secondary">{{ ucfirst($c->status) }}</span>
    @endif
</td>

                                     </td>
                                     <td class="text-end">
  <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ti ti-dots-vertical"></i>
  </a>
  <ul class="dropdown-menu p-2">

    <li>
      <a href="#" 
         data-size="lg" 
         data-url="{{ route('admin.events.show', $c->id) }}" 
         data-ajax-popup="true"  
         data-title="{{ __('View Event') }}" 
         class="dropdown-item">
         <i class="ti ti-eye me-1"></i> Show
      </a>
    </li>
    <li>
      <a href="#" 
         data-size="lg" 
         data-url="{{ route('admin.events.edit', $c->id) }}" 
         data-ajax-popup="true"  
         data-title="{{ __('Edit Event') }}" 
         class="dropdown-item">
         <i class="ti ti-edit me-1"></i> Edit
      </a>
    </li>
    <li>
      <form action="{{ route('admin.events.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="dropdown-item text-danger">
          <i class="ti ti-trash me-1"></i> Delete
        </button>
      </form>
    </li>
  </ul>
</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        <!-- table end -->
      </div>
    </div>
    <!-- card start -->
  </div>
  <!-- End Content -->
  
  <!-- End Footer -->
</div>
@endsection