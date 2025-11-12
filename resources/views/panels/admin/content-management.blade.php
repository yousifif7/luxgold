@extends('layouts.admin-layout')

@section('admin-title', 'Content Management - Admin Pnael')
@section('admin-content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Content Management</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>                            
                        <li class="breadcrumb-item active">Content Management</li>
                    </ol>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>

                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addContentModal"  class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>Add Content</a>
            </div>
        </div>
        <div class="row g-2 mb-3">
          <div class="col-md-2">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Homepage</p>
              <h6>3</h6>
            </div>
          </div>
          <div class="col-md-2">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Resources</p>
              <h6>3</h6>
            </div>
          </div>
          <div class="col-md-2">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Testimonials</p>
              <h6>5</h6>
            </div>
          </div>
          <div class="col-md-2">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Pages</p>
              <h6>10</h6>
            </div>
          </div>
          <div class="col-md-2">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">FAQs</p>
              <h6>4</h6>
            </div>
          </div>
          <div class="col-md-2">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Providers</p>
              <h6>13</h6>
            </div>
          </div>
        </div>
        
        <!-- End Page Header -->
        
        <!-- card start -->
        <div class="card mb-0">

            <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
               <h6 class="d-inline-flex align-items-center mb-0">Total Content <span class="badge bg-danger ms-2">15</span></h6> 
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

<div class="dropdown">
    <a href="#" class="dropdown-toggle btn btn-md btn-outline-light" data-bs-toggle="dropdown">
      <i class="ti ti-layers"></i> All Types
    </a>
    <ul class="dropdown-menu p-2">
      <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Hero Section</label></li>
      <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Carousel Item</label></li>
      <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Resource</label></li>
      <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Testimonial</label></li>
    </ul>
  </div>
  <div class="dropdown">
    <a href="#" class="dropdown-toggle btn btn-md btn-outline-light" data-bs-toggle="dropdown">
      <i class="ti ti-shield-half"></i> All Status
    </a>
    <ul class="dropdown-menu p-2">
      <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Draft</label></li>
      <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Published</label></li>
      <li><label class="dropdown-item"><input type="checkbox" class="form-check-input me-2"> Pending</label></li>
    </ul>
  </div>
</div>
</div>
</div>
<!-- table header -->

<div class="card-body">
<!-- table start -->
<div class="table-responsive table-nowrap">
<table class="table mb-0 datatable">
    <thead>
      <tr>
        <th><input type="checkbox" id="select-all" class="form-check-input"></th>
        <th>Content</th>
        <th>Type</th>
        <th>Category</th>
        <th>Status</th>
        <th class="no-sort">Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Example Row -->
      <tr>
        <td><input type="checkbox" class="form-check-input"></td>
        <td>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Choosing the Right Daycare</span>
            <span class="text-muted small">Guide for parents evaluating daycare options.</span>
          </div>
        </td>
        <td><span class="badge bg-info-subtle text-info">Resource</span></td>
        <td><span class="badge border text-dark">Daycare</span></td>
        <td><span class="badge bg-success-subtle text-success">Published</span></td>
        <td class="text-end">
          <a href="#" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
          <ul class="dropdown-menu p-2">
            <li><a href="#" class="dropdown-item"><i class="ti ti-edit me-1"></i> Edit</a></li>
            <li><a href="#" class="dropdown-item"><i class="ti ti-eye me-1"></i> View</a></li>
            <li><a href="#" class="dropdown-item text-danger"><i class="ti ti-trash me-1"></i> Delete</a></li>
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
    <div id="addContentModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header justify-content-between">
            <h4 class="modal-title fw-bold">Add New Content</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
    
          <form>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12 mb-3">
                  <label class="form-label">Title</label>
                  <input type="text" class="form-control" placeholder="Enter content title">
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="form-label">Type</label>
                  <select class="form-select">
                    <option>Resource</option>
                    <option>Hero Section</option>
                    <option>Carousel Item</option>
                    <option>Testimonial</option>
                  </select>
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="form-label">Status</label>
                  <select class="form-select">
                    <option>Draft</option>
                    <option>Published</option>
                    <option>Pending</option>
                  </select>
                </div>
                <div class="col-lg-12 mb-3">
                  <label class="form-label">Category</label>
                  <input type="text" class="form-control" placeholder="Enter category (optional)">
                </div>
                <div class="col-lg-12 mb-3">
                  <label class="form-label">Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter description"></textarea>
                </div>
                <div class="col-lg-12 mb-3">
                  <label class="form-label">Image URL</label>
                  <input type="url" class="form-control" placeholder="https://images.unsplash.com/...">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Content</button>
            </div>
          </form>
        </div>
      </div>
    </div>
@endsection