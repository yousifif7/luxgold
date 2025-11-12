@extends('layouts.admin-layout')

@section('admin-title', 'Integrations - Admin Pnael')
@section('admin-content')

<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

      <!-- Page Header -->
      <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="breadcrumb-arrow">
          <h4 class="mb-1">Integrations</h4>
          <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Integrations</li>
            </ol>
          </div>
        </div>
      
      </div>

      <!-- End Page Header -->
      <div class="container my-4">
      
          <div class="card mb-0">

              <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Available Integrations (10)</h6>
              
              </div>



              <div class="card-body">
                  <div class="table-responsive table-nowrap">
                    <table class="table mb-0 align-middle">
                      <thead>
                        <tr>
                          <th>Service</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Last Sync</th>
                          <th>Active</th>
                          <th class="text-end">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                
                        <!-- Stripe -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">Stripe</span>
                              <span class="text-muted small">Payment processing for subscription plans and featured listings</span>
                            </div>
                          </td>
                          <td><span class="badge bg-primary-subtle text-primary">payment</span></td>
                          <td><span class="badge bg-primary-subtle text-primary">connected</span></td>
                          <td><span class="text-muted">6/15/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" checked>
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-primary">Test</a>
                          </td>
                        </tr>
                
                        <!-- PayPal -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">PayPal</span>
                              <span class="text-muted small">Alternative payment method for providers and parents</span>
                            </div>
                          </td>
                          <td><span class="badge bg-primary-subtle text-primary">payment</span></td>
                          <td><span class="badge bg-secondary-subtle text-secondary">disconnected</span></td>
                          <td><span class="text-muted">5/20/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox">
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-success">Connect</a>
                          </td>
                        </tr>
                
                        <!-- SendGrid -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">SendGrid</span>
                              <span class="text-muted small">Transactional email delivery service</span>
                            </div>
                          </td>
                          <td><span class="badge bg-info-subtle text-info">email</span></td>
                          <td><span class="badge bg-primary-subtle text-primary">connected</span></td>
                          <td><span class="text-muted">6/15/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" checked>
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-primary">Test</a>
                          </td>
                        </tr>
                
                        <!-- Postmark -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">Postmark</span>
                              <span class="text-muted small">Backup email service provider</span>
                            </div>
                          </td>
                          <td><span class="badge bg-info-subtle text-info">email</span></td>
                          <td><span class="badge bg-danger-subtle text-danger">error</span></td>
                          <td><span class="text-muted">6/10/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox">
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-success">Connect</a>
                          </td>
                        </tr>
                
                        <!-- Google Analytics 4 -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">Google Analytics 4</span>
                              <span class="text-muted small">Website analytics and user behavior tracking</span>
                            </div>
                          </td>
                          <td><span class="badge bg-purple text-white">analytics</span></td>
                          <td><span class="badge bg-primary-subtle text-primary">connected</span></td>
                          <td><span class="text-muted">6/15/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" checked>
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-primary">Test</a>
                          </td>
                        </tr>
                
                        <!-- Plausible Analytics -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">Plausible Analytics</span>
                              <span class="text-muted small">Privacy-focused alternative analytics platform</span>
                            </div>
                          </td>
                          <td><span class="badge bg-purple text-white">analytics</span></td>
                          <td><span class="badge bg-warning-subtle text-warning">pending</span></td>
                          <td><span class="text-muted">Never</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox">
                            </div>
                          </td>
                          <td class="text-end">—</td>
                        </tr>
                
                        <!-- Cloudinary -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">Cloudinary</span>
                              <span class="text-muted small">Image and video management service</span>
                            </div>
                          </td>
                          <td><span class="badge bg-warning-subtle text-warning">cdn</span></td>
                          <td><span class="badge bg-primary-subtle text-primary">connected</span></td>
                          <td><span class="text-muted">6/14/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" checked>
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-primary">Test</a>
                          </td>
                        </tr>
                
                        <!-- Imgix -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">Imgix</span>
                              <span class="text-muted small">Alternative image optimization and delivery</span>
                            </div>
                          </td>
                          <td><span class="badge bg-warning-subtle text-warning">cdn</span></td>
                          <td><span class="badge bg-secondary-subtle text-secondary">disconnected</span></td>
                          <td><span class="text-muted">4/15/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox">
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-success">Connect</a>
                          </td>
                        </tr>
                
                        <!-- Google Maps -->
                        <tr>
                          <td>
                            <div class="d-flex flex-column">
                              <span class="fw-semibold">Google Maps</span>
                              <span class="text-muted small">Location services and mapping functionality</span>
                            </div>
                          </td>
                          <td><span class="badge bg-info-subtle text-info">maps</span></td>
                          <td><span class="badge bg-primary-subtle text-primary">connected</span></td>
                          <td><span class="text-muted">6/15/2024</span></td>
                          <td>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" checked>
                            </div>
                          </td>
                          <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-primary">Test</a>
                          </td>
                        </tr>
                
                      </tbody>
                    </table>
                  </div>
                </div>
                


            </div> 
      </div>


    </div>







    <!-- End Footer -->

  </div>


@endsection