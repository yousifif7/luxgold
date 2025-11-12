@extends('layouts.admin-layout')

@section('admin-title', 'Parents Management - Admin Pnael')
@section('admin-content')
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
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addParentModal"  class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New Parent</a>
            </div>
        </div>
        <!-- End Page Header -->
        
        <!-- card start -->
        <div class="card mb-0">

            <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Total Parents <span class="badge bg-danger ms-2">280</span></h6>
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
      <th class="no-sort">
        <div class="form-check form-check-md">
          <input class="form-check-input" type="checkbox" id="select-all">
        </div>
      </th>
      <th>Parent</th>
      <th>Contact</th>
      <th>Children</th>
      <th>Activity</th>
      <th>Reviews</th>
      <th>Status</th>
      <th class="no-sort">Actions</th>
    </tr>
  </thead>
<tbody>
    <tr>
        <td><input type="checkbox" class="form-check-input"></td>
        <td>
          <div class="d-flex align-items-center">
            <span class="avatar avatar-sm rounded-circle bg-primary text-white me-2">SJ</span>
            <div class="d-flex flex-column">
              <span class="fw-semibold">Sarah Johnson</span>
              <span class="small text-muted"><i class="ti ti-map-pin me-1"></i> Frisco, TX</span>
            </div>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span class="text-muted"><i class="ti ti-mail me-1"></i> sarah.johnson@email.com</span>
            <span class="text-muted"><i class="ti ti-calendar me-1"></i> Joined 1/15/2024</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><strong>Emma</strong> <span class="small text-muted">(4y)</span></span>
            <span><strong>Liam</strong> <span class="small text-muted">(2y)</span></span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><i class="ti ti-heart text-danger me-1"></i> 12 saved</span>
            <span class="text-muted small">Last active: 2 hours ago</span>
          </div>
        </td>
        <td>
          <i class="ti ti-star-filled text-warning"></i> 4.6
          <span class="text-muted small">8 reviews</span>
        </td>
        <td><span class="badge bg-success-subtle text-success">active</span></td>
        <td class="text-end">
          <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown">
            <i class="ti ti-dots-vertical"></i>
          </a>
          <ul class="dropdown-menu p-2">
            <li><a href="#" class="dropdown-item"><i class="ti ti-edit me-1"></i> Edit</a></li>
            <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-1"></i> Delete</a></li>
          </ul>
        </td>
      </tr>
  

  </tbody>
  
</table>
</div>
<!-- table end -->
</div>


        </div>
        <!-- card start -->

    </div>
    <!-- End Content -->            
    <div id="addParentModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header justify-content-between">
              <h4 class="text-dark modal-title fw-bold text-truncate">Add New Parent</h4>
              <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                <i class="ti ti-circle-x-filled"></i>
              </button>
            </div>
            <form action="parents.html">
              <div class="modal-body pb-0">
                <div class="row">
      
                  <!-- Parent Name -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Parent Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter parent full name">
                    </div>
                  </div>
      
                  <!-- Email -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Email <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" placeholder="Enter email">
                    </div>
                  </div>
      
                  <!-- Phone -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Phone <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter phone number">
                    </div>
                  </div>
      
                  <!-- Location -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Location</label>
                      <input type="text" class="form-control" placeholder="City, State">
                    </div>
                  </div>
      
                  <!-- Children Info -->
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Children Details</label>
                      <textarea class="form-control" rows="2" placeholder="e.g. Emma (4y), Liam (2y)"></textarea>
                    </div>
                  </div>
      

      
                  <!-- Status -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select class="form-select select2" style="width: 100%;">
                        <option value="">Select</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                      </select>
                    </div>
                  </div>
      
                  <!-- Avatar -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Upload Avatar</label>
                      <input type="file" class="form-control">
                    </div>
                  </div>
      
                </div>
              </div>
              <div class="modal-footer d-flex align-items-center gap-1">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Parent</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      

    <!-- End Footer -->

</div>
@endsection