@extends('layouts.admin-layout')

@section('admin-title', 'Settings - Admin Pnael')
@section('admin-content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

      <!-- Page Header -->
      <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="breadcrumb-arrow">
          <h4 class="mb-1">System Settings</h4>
          <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">System Settings</li>
            </ol>
          </div>
        </div>
        <div class="gap-2 d-flex align-items-center flex-wrap">

          <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip"
            data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i
              class="ti ti-refresh"></i></a>
          <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip"
            data-bs-placement="top" aria-label="Print" data-bs-original-title="Print"><i
              class="ti ti-printer"></i></a>
          <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip"
            data-bs-placement="top" aria-label="Download" data-bs-original-title="Download"><i
              class="ti ti-cloud-download"></i></a>
          
        </div>
      </div>

      <!-- End Page Header -->
      <div class="container my-4">
        <ul class="nav nav-tabs custom-tabs w-100" id="pricingTab" role="tablist">
          <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link active" id="plans-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button"
              role="tab">
              Admin Users
            </button>
          </li>
          <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured" type="button"
              role="tab">
              Email Templates
            </button>
          </li>
          <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link" id="revenue-tab" data-bs-toggle="tab" data-bs-target="#revenue" type="button"
              role="tab">
              API Keys
            </button>
          </li>
          <li class="nav-item flex-fill text-center" role="presentation">
              <button class="nav-link" id="global-set" data-bs-toggle="tab" data-bs-target="#globalset" type="button"
                role="tab">
               Global Settings
              </button>
            </li>
            
        </ul>

        <div class="tab-content mt-4 " id="pricingTabContent">
          <div class="tab-pane fade show active" id="plans" role="tabpanel">
            <!-- card start -->
            <div class="card mb-0">

              <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Admin Users</h6>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addUserModal"
                class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New User</a>
              </div>



              <div class="card-body">
                <!-- table start -->
                <div class="table-responsive table-nowrap">
                  <table class="table mb-0 datatable">
                    <thead>
                      <tr>

                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Permissions</th>

                        <th class="no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Row 1: Basic -->
                      <tr>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">John Admin</span>
                            <span class="text-muted small">john@askroro.com</span>
                          </div>
                        </td>
                        <td>
                          <span class="fw-semibold">Admin</span>
                        </td>
                        
                        <td><span class="badge bg-success-subtle text-success">active</span></td>
                        <td>
                          <span class="text-muted">
                              6/15/2024
                          </span>
                        </td>
                        <td>
                          <span class="text-muted">
                              All Permissions
                          </span>
                        </td>
                        <td class="text-end">
                          <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                          </a>
                          <ul class="dropdown-menu p-2">
                            <li><a href="#" class="dropdown-item"><i class="ti ti-edit me-1"></i> Edit</a></li>
                            <li><a href="#" class="dropdown-item"><i class="ti ti-eye me-1"></i> View</a></li>
                            <li><a href="#" class="dropdown-item text-danger"><i class="ti ti-trash me-1"></i>
                                Delete</a></li>
                          </ul>
                        </td>
                      </tr>

    
                    </tbody>

                  </table>

                </div>
                <!-- table end -->
              </div>


            </div>
            <!-- card end -->
          </div>
          <div class="tab-pane fade" id="featured" role="tabpanel">
            <!-- card start -->
            <div class="card mb-0">

              <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Email Templates</h6>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addTemplateModal"
                class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New Template</a>
              </div>



              <div class="card-body">
                <!-- table start -->
                <div class="table-responsive table-nowrap">
                  <table class="table mb-0 datatable">
                    <thead>
                      <tr>

                        <th>Template</th>
                        <th>Type</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Last Updated</th>

                        <th class="no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Row 1: Basic -->
                      <tr>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">Parent Welcome Email</span>
                            <span class="text-muted small">Email Template</span>
                          </div>
                        </td>
                        <td>
                          <span class="fw-semibold">Welcome</span>
                        </td>
                        <td>
                              
Welcome to AskRoro!
                        </td>
                        <td><span class="badge bg-success-subtle text-success">active</span></td>
                        <td>
                          <span class="text-muted">
                              6/15/2024
                          </span>
                        </td>
                       
                        <td class="text-end">
                          <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                          </a>
                          <ul class="dropdown-menu p-2">
                            <li><a href="#" class="dropdown-item"><i class="ti ti-edit me-1"></i> Edit</a></li>
                            <li><a href="#" class="dropdown-item"><i class="ti ti-eye me-1"></i> View</a></li>
                            <li><a href="#" class="dropdown-item text-danger"><i class="ti ti-trash me-1"></i>
                                Delete</a></li>
                          </ul>
                        </td>
                      </tr>

    
                    </tbody>

                  </table>

                </div>
                <!-- table end -->
              </div>


            </div>
            <!-- card end -->
          </div>
   

          <div class="tab-pane fade" id="revenue" role="tabpanel">
              <div class="card mb-0">

                  <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <h6 class="d-inline-flex align-items-center mb-0">API Keys</h6>
                    
                  </div>
  
  
  
                  <div class="card-body">
                    <!-- table start -->
                    <div class="table-responsive table-nowrap">
                      <table class="table mb-0 datatable">
                        <thead>
                          <tr>
  
                            <th>Service</th>
                            <th>Key Name</th>
                            <th>Status</th>
                            <th>Last Used</th>
                            <th>Created</th>
  
                            <th class="no-sort">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Row 1: Basic -->
                          <tr>
                            <td>
                              <div class="d-flex flex-column">
                                <span class="fw-semibold">Google Maps</span>
                         
                              </div>
                            </td>
                            <td>
                              <span class="fw-semibold">maps_api_key</span>
                            </td>
                            
                            <td><span class="badge bg-success-subtle text-success">active</span></td>
                            <td>
                              <span class="text-muted">
                                  6/15/2024
                              </span>
                            </td>
                            <td>
                              <span class="text-muted">
                                   
1/15/2024
                              </span>
                            </td>
                            <td class="text-end">
                              <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                              </a>
                              <ul class="dropdown-menu p-2">
                                <li><a href="#" class="dropdown-item"><i class="ti ti-edit me-1"></i> Edit</a></li>
                                
                                <li><a href="#" class="dropdown-item text-danger"><i class="ti ti-trash me-1"></i>
                                    Delete</a></li>
                              </ul>
                            </td>
                          </tr>
  
        
                        </tbody>
  
                      </table>
  
                    </div>
                    <!-- table end -->
                  </div>
  
  
                </div>
          </div>
          <div class="tab-pane fade" id="globalset" role="tabpanel">
              <div class="row g-3">

                  <!-- Site Settings -->
                  <div class="col-md-6">
                    <div class="settings-card">
                      <h5>Site Settings</h5>
                      <small>Basic site configuration</small>
                      <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" class="form-control" value="AskRoro" disabled>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Site Description</label>
                        <input type="text" class="form-control" value="Find trusted childcare and family services in your neighborhood" disabled>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Default City</label>
                        <input type="text" class="form-control" value="Frisco, TX" disabled>
                      </div>
                    </div>
                  </div>
              
                  <!-- Security Settings -->
                  <div class="col-md-6">
                    <div class="settings-card">
                      <h5>Security Settings</h5>
                      <small>Authentication and security options</small>
                      <div class="switch-label">
                        <span>Allow Registrations</span>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" checked>
                        </div>
                      </div>
                      <div class="switch-label">
                        <span>Email Verification</span>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" checked>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Session Timeout (minutes)</label>
                        <input type="text" class="form-control" value="30" disabled>
                      </div>
                    </div>
                  </div>
              
                  <!-- Provider Settings -->
                  <div class="col-md-6">
                    <div class="settings-card">
                      <h5>Provider Settings</h5>
                      <small>Provider-specific configuration</small>
                      <div class="switch-label">
                        <span>Auto-approve Providers</span>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Max File Upload Size (MB)</label>
                        <input type="text" class="form-control" value="5" disabled>
                      </div>
                    </div>
                  </div>
              
                  <!-- System Features -->
                  <div class="col-md-6">
                    <div class="settings-card">
                      <h5>System Features</h5>
                      <small>Enable or disable system features</small>
                      <div class="switch-label">
                        <span>Maintenance Mode</span>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox">
                        </div>
                      </div>
                      <div class="switch-label">
                        <span>Enable Notifications</span>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" checked>
                        </div>
                      </div>
                      <div class="switch-label">
                        <span>Enable Analytics</span>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" checked>
                        </div>
                      </div>
                    </div>
                  </div>
              
                </div>
          </div>

        </div>
      </div>


    </div>
    <!-- End Content -->
    <div id="addUserModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header border-0 pb-0">
            <div>
              <h4 class="text-dark modal-title fw-bold">Add User</h4>
              <p class="text-muted mb-0 small">Configure admin user settings and permissions</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Form -->
          <form action="#">
            <div class="modal-body">
              <div class="row g-3">

                <!-- Plan Name -->
                <div class="col-md-6">
                  <label class="form-label">Name</label>
                  <input type="text" class="form-control" placeholder="Full Name">
                </div>

                <!-- Plan Type -->
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" placeholder="email@askroro.com">
                </div>

                <div class="col-md-6">
                  <label class="form-label">Role</label>
                 <select name="" class="form-select" id="">
                  <option value="">Moderator</option>
                  <option value="">Super Admin</option>
                  <option value="">Content Manager</option>

                 </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Status</label>
                 <select name="" class="form-select" id="">
                  <option value="">Active</option>
                  <option value="">Inactive</option>
                  <option value="">Suspended</option>

                 </select>
                </div>

         

              </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create User</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="addTemplateModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header border-0 pb-0">
            <div>
              <h4 class="text-dark modal-title fw-bold">Add Email Template</h4>
              <p class="text-muted mb-0 small">Configure email template content and settings</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Form -->
          <form action="#">
            <div class="modal-body">
              <div class="row g-3">

                <!-- Plan Name -->
                <div class="col-md-6">
                  <label class="form-label">Template Name</label>
                  <input type="text" class="form-control" placeholder="Template Name">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Type</label>
                 <select name="" class="form-select" id="">
                  <option value="">Welcome</option>
                  <option value="">Notification</option>
                  <option value="">Confirmation</option>
                  <option value="">Reminder</option>


                 </select>
                </div>
                <!-- Plan Type -->
                <div class="col-md-12">
                  <label class="form-label">Subject</label>
                  <input type="text" class="form-control">
                </div>
                <div class="col-md-12">
                  <label class="form-label">Content</label>
                  <textarea name="" id="" cols="30" rows="4" class="form-control"></textarea>
              <span class="text-muted small">Use variables like parent_name, provider_name, inquiry_message in your template


              </span>  
              </div>
               
                

         

              </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create Template</button>
            </div>
          </form>
        </div>
      </div>
    </div>






    <!-- End Footer -->

  </div>
@endsection