@extends('layouts.provider-layout')

@section('provider-title', 'Listings - Cleaner Portal')
@section('provider-content')





<div class="page-wrapper">

    <!-- Start Content -->
        <!-- Start Content -->
        <div class="content">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
                <div class="breadcrumb-arrow">
                    <h4 class="mb-1">My Listings</h4>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>                            
                            <li class="breadcrumb-item active">My Listings</li>
                        </ol>
                    </div>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                   
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addListingModal"  class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>Add New Listing</a>
                </div>
            </div>
        
            
            <!-- End Page Header -->
            
            <!-- card start -->
            <div class="card mb-0">

                <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <h6 class="d-inline-flex align-items-center mb-0">Your Listings (3) </h6>
                    
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

<div class="card-body p-0" >
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
            <th>Name</th>
            <th>Category</th>
            <th>Status</th>
            <th>Views</th>
            <th>Inquiries</th>
            <th>Date Created</th>
            <th class="no-sort">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Row 1 -->
          <tr>
            <td><input type="checkbox" class="form-check-input"></td>
            <td>
              <div class="d-flex flex-column">
                <span class="fw-semibold">Sunshine Daycare Center</span>
                <span class="text-muted small"><i class="ti ti-map-pin me-1"></i>123 Main St, Springfield</span>
                
              </div>
            </td>
            <td>
              <span class="fw-semibold">
                Daycare
              </span>
            </td>
            <td><span class="badge bg-success-subtle text-success">Approved</span></td>
            <td><i class="ti ti-eye pe-1"></i>1,247</td>
            <td><i class="ti ti-message pe-1"></i>20</td>
<td>2024-01-15</td>
           
            <td class="text-end">
              <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical"></i>
              </a>
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
        <!-- End Content -->            
        <div id="addListingModal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header justify-content-between">
                  <h4 class="text-dark modal-title fw-bold text-truncate">Create New Listing</h4>
                  <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-circle-x-filled"></i>
                  </button>
                </div>
          
                <form action="listings.html">
                    <div class="modal-body">
                        <p class="text-muted mb-4">Add a new business listing to your account.</p>
                        <form id="listingForm">
                            <div class="mb-3">
                                <label class="form-label">Business Name</label>
                                <input type="text" class="form-control" placeholder="Enter business name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" required>
                                    <option value="">Select category</option>
                                    <option>Daycare</option>
                                    <option>Preschool</option>
                                    <option>Activity Center</option>
                                    <option>After School Program</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3" placeholder="Describe your business" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="Business address" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Timings</label>
                                <input type="text" class="form-control" placeholder="e.g., Mon-Fri 7AM-6PM" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pricing</label>
                                <input type="text" class="form-control" placeholder="e.g., $45/day" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Services</label>
                                <textarea class="form-control" rows="2" placeholder="List your services" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Logo/Images</label>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-primary">
                                        <i class="ti ti-upload me-1"></i> Upload Images
                                    </button>
                                    <small class="text-muted">Max 5 images, 2MB each</small>
                                </div>
                            </div>
                        </form>
                    </div>
          
                  <div class="modal-footer d-flex align-items-center gap-1">
                    <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Listing</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
    <!-- End Content -->            


</div>
@endsection