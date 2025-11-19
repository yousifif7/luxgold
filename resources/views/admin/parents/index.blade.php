@extends('layouts.admin')

@section('admin-title', 'Parents Management - Admin Pnael')
@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Parents</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>                            
                        <li class="breadcrumb-item active">Parents</li>
                    </ol>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Print" data-bs-original-title="Print"><i class="ti ti-printer"></i></a>
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Download" data-bs-original-title="Download"><i class="ti ti-cloud-download"></i></a>
                <a href="javascript:void(0);"  data-size="lg" data-url="{{ route('admin.parents.create') }}" data-ajax-popup="true"  data-title="{{__('New Parent')}}" class="btn btn-primary"  class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New Parent</a>
            </div>
        </div>
        <!-- End Page Header -->
        
        <!-- card start -->
        <div class="card mb-0">

            <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Total Parents <span class="badge bg-danger ms-2">{{ $users->count() }}</span></h6>
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
  <i class="ti ti-map-pin me-1"></i> All Cities
</a>
<ul class="dropdown-menu dropdown-menu-md p-2">
  <li>
    <div class="mb-2">
      <div class="input-icon-start input-icon position-relative">
        <span class="input-icon-addon">
          <i class="ti ti-search"></i>
        </span>
        <input type="text" class="form-control form-control-md" placeholder="Search city">
      </div>
    </div>
  </li>
  <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> New York</label></li>
  <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Chicago</label></li>
  <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Houston</label></li>
  <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Los Angeles</label></li>
  <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Miami</label></li>
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
                        <th></th>
                        <th>Parent</th>
                        <th>Contact</th>
                        <th>Children</th>
                        <th>Activity</th>
                        <th>Reviews</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $p)
                    <tr>
                        <td><input type="checkbox" class="form-check-input"></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-sm rounded-circle bg-primary text-white me-2">{{ strtoupper(substr($p->name,0,2)) }}</span>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold"><a href="{{ route('admin.parents.show', $p) }}">{{ $p->name }}</a></span>
                                    <span class="small text-muted"><i class="ti ti-map-pin me-1"></i> {{ $p->city ?? '—' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-muted"><i class="ti ti-mail me-1"></i> {{ $p->email }}</span>
                                <span class="text-muted"><i class="ti ti-calendar me-1"></i> Joined {{ $p->created_at->format('n/j/Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                {{-- children listing: assuming relation 'children' or child_count column --}}
                                @if(method_exists($p,'children'))
                                    @foreach($p->children as $c)
                                    <span><strong>{{ $c->name }}</strong> <span class="small text-muted">({{ $c->age ?? '' }}y)</span></span>
                                    @endforeach
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span><i class="ti ti-heart text-danger me-1"></i> {{ $p->saved_count ?? 0 }} saved</span>
                                <span class="text-muted small">Last active: {{ $p->last_active_at ? $p->last_active_at->diffForHumans() : '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <i class="ti ti-star-filled text-warning"></i> {{ $p->rating ?? '—' }}
                            <span class="text-muted small">{{ $p->reviews_count ?? 0 }} reviews</span>
                        </td>
                        <td>
                            @if(($p->status ?? '') == 'active')
                                <span class="badge bg-success-subtle text-success">active</span>
                            @elseif(($p->status ?? '') == 'pending')
                                <span class="badge bg-warning-subtle text-warning">pending</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">inactive</span>
                            @endif
                        </td>
                                     <td class="text-end">
  <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ti ti-dots-vertical"></i>
  </a>
  <ul class="dropdown-menu p-2">
    <li>
      <a href="#" 
         data-size="md" 
         data-url="{{ route('admin.parents.edit', $p->id) }}" 
         data-ajax-popup="true"  
         data-title="{{ __('Edit Parent') }}" 
         class="dropdown-item">
         <i class="ti ti-edit me-1"></i> Edit
      </a>
    </li>
    <li>
      <form action="{{ route('admin.parents.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
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


</div>
@endsection