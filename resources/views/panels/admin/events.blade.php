@extends('layouts.admin-layout')

@section('admin-title', 'Events - Admin Pnael')
@section('admin-content')
       
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
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Print" data-bs-original-title="Print"><i class="ti ti-printer"></i></a>
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Download" data-bs-original-title="Download"><i class="ti ti-cloud-download"></i></a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addEventModal"  class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New Event</a>
            </div>
        </div>
        <div class="row g-2 mb-3">
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Total Events</p>
              <h6>156</h6>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Pending Approval</p>
              <h6>12</h6>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">This Week</p>
              <h6>28</h6>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Average Attendance</p>
              <h6>78%</h6>
            </div>
          </div>
        </div>
        
        <!-- End Page Header -->
        
        <!-- card start -->
        <div class="card mb-0">

            <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Total Events <span class="badge bg-danger ms-2">03</span></h6>
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
      <!-- Row 1 -->
      <tr>
        <td><input type="checkbox" class="form-check-input"></td>
        <td>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Summer Art Workshop for Kids</span>
            <span class="text-muted small">Creative Kids Studio</span>
            <span class="badge border border-1 bg-transparent text-dark mt-1 " style="width: fit-content;">Art & Crafts</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><i class="ti ti-calendar me-1"></i> 7/15/2024</span>
            <span><i class="ti ti-clock-hour-10 me-1"></i> 10:00 AM</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Creative Kids Studio</span>
            <span class="text-muted small">Frisco, TX</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><i class="ti ti-users me-1"></i> 12/15</span>
            <span class="text-muted small">4–8 years</span>
          </div>
        </td>
        <td><span class="fw-semibold">$25</span></td>
        <td><span class="badge bg-success-subtle text-success">active</span></td>
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
  
      <!-- Row 2 -->
      <tr>
        <td><input type="checkbox" class="form-check-input"></td>
        <td>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Soccer Skills Training</span>
            <span class="text-muted small">Little Athletes Academy</span>
            <span class="badge border border-1 bg-transparent text-dark mt-1 " style="width: fit-content;">Sports</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><i class="ti ti-calendar me-1"></i> 7/20/2024</span>
            <span><i class="ti ti-clock-hour-10 me-1"></i> 2:00 PM</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Community Sports Complex</span>
            <span class="text-muted small">Plano, TX</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><i class="ti ti-users me-1"></i> 8/20</span>
            <span class="text-muted small">5–10 years</span>
          </div>
        </td>
        <td><span class="fw-semibold">$15</span></td>
        <td>
          <span class="badge bg-warning-subtle border border-1 text-warning">pending</span>
          <div class="d-flex gap-1 mt-2">
            <button class="btn btn-primary btn-sm"><i class="ti ti-circle-check me-1"></i> Approve</button>
            <button class="btn btn-danger btn-sm"><i class="ti ti-circle-x me-1"></i> Reject</button>
          </div>
        </td>
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
  
      <!-- Row 3 -->
      <tr>
        <td><input type="checkbox" class="form-check-input"></td>
        <td>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Science Discovery Day</span>
            <span class="text-muted small">Fun Learning Center</span>
            <span class="badge border border-1 bg-transparent text-dark mt-1 " style="width: fit-content;">Educational</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><i class="ti ti-calendar me-1"></i> 7/25/2024</span>
            <span><i class="ti ti-clock-hour-10 me-1"></i> 11:00 AM</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Fun Learning Center</span>
            <span class="text-muted small">McKinney, TX</span>
          </div>
        </td>
        <td>
          <div class="d-flex flex-column">
            <span><i class="ti ti-users me-1"></i> 15/12</span>
            <span class="text-muted small">6–12 years</span>
          </div>
        </td>
        <td><span class="fw-semibold">$30</span></td>
        <td><span class="badge bg-success-subtle text-success">active</span></td>
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
    <div id="addEventModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header justify-content-between">
              <h4 class="text-dark modal-title fw-bold text-truncate">Add New Event</h4>
              <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                <i class="ti ti-circle-x-filled"></i>
              </button>
            </div>
      
            <form action="events.html">
              <div class="modal-body pb-0">
                <div class="row">
      
                  <!-- Event Title -->
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Event Title <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter event title" required>
                    </div>
                  </div>
      
                  <!-- Start Date -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Start Date</label>
                      <div class="input-group w-auto input-group-flat">
                        <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" placeholder="Select start date">
                        <span class="input-group-text">
                          <i class="ti ti-calendar"></i>
                        </span>
                      </div>
                    </div>
                  </div>
      
                  <!-- Start Time -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Start Time</label>
                      <div class="input-icon-end position-relative">
                        <!-- set data-time-basic="true" for simple time (no seconds). Set data-time-seconds="true" if you need seconds -->
                        <input type="text" class="form-control" data-provider="timepickr" data-time-basic="true" placeholder="-- : -- : --">
                        <span class="input-icon-addon">
                          <i class="ti ti-clock-hour-10 text-dark"></i>
                        </span>
                      </div>
                    </div>
                  </div>
      
                  <!-- End Date -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">End Date</label>
                      <div class="input-group w-auto input-group-flat">
                        <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" placeholder="Select end date">
                        <span class="input-group-text">
                          <i class="ti ti-calendar"></i>
                        </span>
                      </div>
                    </div>
                  </div>
      
                  <!-- End Time -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">End Time</label>
                      <div class="input-icon-end position-relative">
                        <input type="text" class="form-control" data-provider="timepickr" data-time-basic="true" placeholder="-- : -- : --">
                        <span class="input-icon-addon">
                          <i class="ti ti-clock-hour-10 text-dark"></i>
                        </span>
                      </div>
                    </div>
                  </div>
      
                  <!-- Location -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Location</label>
                      <input type="text" class="form-control" placeholder="Enter location">
                    </div>
                  </div>
      
                  <!-- Status -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select class="form-select" style="width:100%;">
                        <option value="">Select</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                      </select>
                    </div>
                  </div>
      
                  <!-- Description -->
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Description</label>
                      <textarea class="form-control" rows="3" placeholder="Enter event details"></textarea>
                    </div>
                  </div>
      
                </div>
              </div>
      
              <div class="modal-footer d-flex align-items-center gap-1">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Event</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      
      
      
      

    <!-- End Footer -->

</div>
@endsection