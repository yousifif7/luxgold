@extends('layouts.admin-layout')

@section('admin-title', 'Dashboard - Admin Pnael')
@section('admin-content')


<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Welcome, Admin</h4>
                <!-- <p class="mb-0">Today you have 10 visits, <a href="visits.html" class="link-info text-decoration-underline fw-medium">View Details</a></p> -->
            </div>
            <div id="reportrange" class="reportrange-picker d-flex align-items-center">
                <i class="ti ti-calendar text-body fs-14 me-1"></i><span class="reportrange-picker-field">16 Apr 25 - 16 Apr 25</span>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
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
                               <p class="mb-1 text-truncate">Total Providers</p>
                               <h6 class="mb-0 fw-semibold">245</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
            <!-- Total Parents -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-users fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Total Parents</p>
                               <h6 class="mb-0 fw-semibold">1,320</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
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
                               <h6 class="mb-0 fw-semibold">87</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
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
                               <h6 class="mb-0 fw-semibold">$12,430</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
            <!-- Pending Approvals -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-hourglass-high fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Pending Approvals</p>
                               <h6 class="mb-0 fw-semibold">18</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
            <!-- Featured Providers -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-star fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Featured Providers</p>
                               <h6 class="mb-0 fw-semibold">52</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
            <!-- Inquiries -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-mail fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">New Inquiries</p>
                               <h6 class="mb-0 fw-semibold">73</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
            <!-- Reported Reviews -->
            <div class="col-xl-3 col-md-6">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-flag fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Reported Reviews</p>
                               <h6 class="mb-0 fw-semibold">9</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        
        </div>
        
        
        <!-- row end -->



        <!-- row start -->
        <div class="row">

            <!-- All Providers -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="providers.html" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2"><i class="ti ti-building-store"></i></span>
                       <p class="text-dark fw-semibold mb-0">All Providers</p>
                    </div>
                </a>
            </div>
            <!-- col end -->
        
            <!-- All Parents -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="parents.html" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2"><i class="ti ti-users"></i></span>
                       <p class="text-dark fw-semibold mb-0">All Parents</p>
                    </div>
                </a>
            </div>
            <!-- col end -->
        
            <!-- Events -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="events.html" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2"><i class="ti ti-calendar-event"></i></span>
                       <p class="text-dark fw-semibold mb-0">Events</p>
                    </div>
                </a>
            </div>
            <!-- col end -->
        
            <!-- Reviews -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="reviews.html" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2"><i class="ti ti-star"></i></span>
                       <p class="text-dark fw-semibold mb-0">Reviews</p>
                    </div>
                </a>
            </div>
            <!-- col end -->
        
            <!-- City Pages -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="content-management.html" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2"><i class="ti ti-map"></i></span>
                       <p class="text-dark fw-semibold mb-0">Content</p>
                    </div>
                </a>
            </div>
            <!-- col end -->
        
            <!-- Monetization -->
            <div class="col-xl-2 col-md-4 col-6">
                <a href="pricing.html" class="card hover-shadow">
                    <div class="card-body text-center">
                       <span class="bg-gradient-primary rounded w-100 d-flex p-3 justify-content-center fs-32 text-primary mb-2"><i class="ti ti-currency-dollar"></i></span>
                       <p class="text-dark fw-semibold mb-0 text-truncate">Monetization</p>
                    </div>
                </a>
            </div>
            <!-- col end -->
        
        </div>
        
        <!-- row end -->



        <!-- card start -->
        <div class="card shadow flex-fill w-100 mb-0">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-truncate">Last 5 Provider Inquiries</h5> 
                <a href="all-inquiries.html" class="btn btn-sm btn-outline-light flex-shrink-0">View All</a>
            </div>
            <div class="card-body">
                <!-- table start -->
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="javascript:void(0);" class="link-muted" data-bs-toggle="modal" data-bs-target="#view_inquiry_modal">#INQ105</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        
                                        <div>
                                            <h6 class="fs-14 mb-0 fw-medium"><a href="parent-details.html">James Carter</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                       
                                        <div>
                                            <h6 class="fs-14 mb-0 fw-medium"><a href="provider-details.html">Bright Kids Daycare</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Daycare</td>
                                <td>17 Sep 2025, 09:00 AM</td>
                                <td><span class="badge badge-soft-info border border-info text-info py-1 ps-1">New</span></td>
                                <td class="text-end">
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                    <ul class="dropdown-menu p-2">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#view_inquiry_modal"><i class="ti ti-eye me-1"></i>View Details</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-1"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <!-- More sample rows -->
                            <tr>
                                <td>#INQ104</td>
                                <td>Emily Davis</td>
                                <td>Little Stars Preschool</td>
                                <td>Preschool</td>
                                <td>10 Sep 2025, 11:30 AM</td>
                                <td><span class="badge badge-soft-success border border-success text-success py-1 ps-1">Responded</span></td>
                                <td class="text-end"><a href="javascript:void(0);" class="btn btn-sm btn-outline-light">View</a></td>
                            </tr>
                            <tr>
                                <td>#INQ103</td>
                                <td>Michael Johnson</td>
                                <td>Happy Learners Tutoring</td>
                                <td>Tutoring</td>
                                <td>08 Sep 2025, 04:15 PM</td>
                                <td><span class="badge badge-soft-warning border border-warning text-warning py-1 ps-1">Pending</span></td>
                                <td class="text-end"><a href="javascript:void(0);" class="btn btn-sm btn-outline-light">View</a></td>
                            </tr>
                            <tr>
                                <td>#INQ102</td>
                                <td>Olivia Miller</td>
                                <td>Mindful Wellness Center</td>
                                <td>Wellness</td>
                                <td>02 Sep 2025, 02:00 PM</td>
                                <td><span class="badge badge-soft-danger border border-danger text-danger py-1 ps-1">Closed</span></td>
                                <td class="text-end"><a href="javascript:void(0);" class="btn btn-sm btn-outline-light">View</a></td>
                            </tr>
                            <tr>
                                <td>#INQ101</td>
                                <td>David Smith</td>
                                <td>Fun & Play Events</td>
                                <td>Events</td>
                                <td>30 Aug 2025, 06:00 PM</td>
                                <td><span class="badge badge-soft-success border border-success text-success py-1 ps-1">Responded</span></td>
                                <td class="text-end"><a href="javascript:void(0);" class="btn btn-sm btn-outline-light">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- table end -->
            </div>
        </div>
        
        <!-- card end -->

    </div>
    <!-- End Content -->            


</div>
@endsection