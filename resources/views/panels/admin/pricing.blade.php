@extends('layouts.admin-layout')

@section('admin-title', 'Pricing - Admin Pnael')
@section('admin-content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

      <!-- Page Header -->
      <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="breadcrumb-arrow">
          <h4 class="mb-1">Monetization & Pricing</h4>
          <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Monetization & Pricing</li>
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
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addPlanModal"
            class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New Plan</a>
        </div>
      </div>
      <div class="row g-2 mb-3">
        <div class="col-md-3">
          <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
            <p class="mb-2">Monthly Recurring Revenue</p>
            <h6>$18,240</h6>
          </div>
        </div>
        <div class="col-md-3">
          <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
            <p class="mb-2">Annual Recurring Revenue</p>
            <h6>$218,880</h6>
          </div>
        </div>
        <div class="col-md-3">
          <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
            <p class="mb-2">Active Subscribers</p>
            <h6>823</h6>
          </div>
        </div>
        <div class="col-md-3">
          <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
            <p class="mb-2">Average Revenue Per User</p>
            <h6>$45</h6>
          </div>
        </div>
      </div>

      <!-- End Page Header -->
      <div class="container my-4">
        <ul class="nav nav-tabs custom-tabs w-100" id="pricingTab" role="tablist">
          <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link active" id="plans-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button"
              role="tab">
              Pricing Plans
            </button>
          </li>
          <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured" type="button"
              role="tab">
              Featured Listings
            </button>
          </li>
          <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link" id="revenue-tab" data-bs-toggle="tab" data-bs-target="#revenue" type="button"
              role="tab">
              Revenue Analytics
            </button>
          </li>
        </ul>

        <div class="tab-content mt-4 " id="pricingTabContent">
          <div class="tab-pane fade show active" id="plans" role="tabpanel">
            <!-- card start -->
            <div class="card mb-0">

              <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Subscription Plans <span
                    class="badge bg-danger ms-2">03</span></h6>

              </div>



              <div class="card-body">
                <!-- table start -->
                <div class="table-responsive table-nowrap">
                  <table class="table mb-0 datatable">
                    <thead>
                      <tr>

                        <th>Plan</th>
                        <th>Pricing</th>
                        <th>Features</th>
                        <th>Status</th>
                        <th>Subscribers</th>

                        <th class="no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Row 1: Basic -->
                      <tr>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">Basic</span>
                            <span class="text-muted small">Perfect for new providers getting started on the
                              platform</span>
                          </div>
                        </td>
                        <td>
                          <span class="fw-semibold">$0/month</span>
                        </td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="text-muted small">5 features</span>
                            <span class="text-muted small">Max 1 listing</span>
                          </div>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">active</span></td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">420</span>
                            <span class="text-muted small">$0/mo</span>
                          </div>
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

                      <!-- Row 2: Premium -->
                      <tr>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">Premium</span>
                            <span class="text-muted small">Great for growing providers who need more exposure</span>
                          </div>
                        </td>
                        <td>
                          <span class="fw-semibold">$49/month</span>
                        </td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="text-muted small">20 features</span>
                            <span class="text-muted small">Max 10 listings</span>
                          </div>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">active</span></td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">1,250</span>
                            <span class="text-muted small">$49/mo</span>
                          </div>
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

                      <!-- Row 3: Featured -->
                      <tr>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">Featured</span>
                            <span class="text-muted small">Top visibility for providers who want maximum reach</span>
                          </div>
                        </td>
                        <td>
                          <span class="fw-semibold">$99/month</span>
                        </td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="text-muted small">Unlimited features</span>
                            <span class="text-muted small">Unlimited listings</span>
                          </div>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">active</span></td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">3,500</span>
                            <span class="text-muted small">$99/mo</span>
                          </div>
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
                <h6 class="d-inline-flex align-items-center mb-0">Featured Listings<span
                    class="badge bg-danger ms-2">01</span></h6>

              </div>



              <div class="card-body">
                <!-- table start -->
                <div class="table-responsive table-nowrap">
                  <table class="table mb-0 datatable">
                    <thead>
                      <tr>

                        <th>Provider</th>
                        <th>Duration</th>
                        <th>Cost</th>
                        <th>Performance</th>
                        <th>Status</th>

                        <th class="no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Row 1: Basic -->
                      <tr>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">Little Learners Academy</span>
                            <span class="text-muted small">ID: 1</span>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold">30 days</span>
                            <span class="text-muted small">6/1/2024 - 7/1/2024</span>
                          </div>
                        </td>
                        <td>

                          <span class="fw-semibold">
                            $149.99
                          </span>
                        </td>
                        <td>
                          <div class="d-flex flex-column">
                            <span class=" small">1,247 views</span>
                            <span class=" small">89 clicks</span>
                            <span class="text-muted small">CTR: 7.1%</span>

                          </div>
                        </td>
                        <td><span class="badge bg-success-subtle text-success">active</span></td>

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
          <!-- Include Chart.js -->
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <div class="tab-pane fade" id="revenue" role="tabpanel">
            <div class="card mb-0">
              <div class="card-body">
                <div class="row g-3">
       <!-- Revenue Trends -->
<div class="col-md-6">
<div class="card h-100">
  <div class="card-header bg-white border-0">
    <h6 class="mb-0">Revenue Trends</h6>
    <small class="text-muted">Monthly revenue by subscription plan</small>
  </div>
  <div class="card-body">
    <div style="height:400px;">
      <canvas id="revenueTrends"></canvas>
    </div>
  </div>
</div>
</div>

<!-- Subscription Distribution -->
<div class="col-md-6">
<div class="card h-100">
  <div class="card-header bg-white border-0">
    <h6 class="mb-0">Subscription Distribution</h6>
    <small class="text-muted">Active subscribers by plan type</small>
  </div>
  <div class="card-body d-flex flex-column align-items-center">
    <div style="height:300px; width:100%; max-width:400px;">
      <canvas id="subscriptionDist"></canvas>
    </div>
    <ul class="list-unstyled mt-3 text-center">
      <li><span class="legend-dot bg-dark me-1"></span>420 subscribers <small>$0/mo</small></li>
      <li><span class="legend-dot bg-teal me-1"></span>280 subscribers <small>$8400/mo</small></li>
      <li><span class="legend-dot bg-warning me-1"></span>123 subscribers <small>$9840/mo</small></li>
    </ul>
  </div>
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
    <div id="addPlanModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header border-0 pb-0">
            <div>
              <h4 class="text-dark modal-title fw-bold">Add New Pricing Plan</h4>
              <p class="text-muted mb-0 small">Configure plan pricing and features</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Form -->
          <form action="#">
            <div class="modal-body">
              <div class="row g-3">

                <!-- Plan Name -->
                <div class="col-md-6">
                  <label class="form-label">Plan Name</label>
                  <input type="text" class="form-control" placeholder="Plan name">
                </div>

                <!-- Plan Type -->
                <div class="col-md-6">
                  <label class="form-label">Plan Type</label>
                  <select class="form-select">
                    <option>Basic</option>
                    <option>Standard</option>
                    <option>Premium</option>
                  </select>
                </div>

                <!-- Monthly Fee -->
                <div class="col-md-6">
                  <label class="form-label">Monthly Fee ($)</label>
                  <input type="number" class="form-control" value="0">
                </div>

                <!-- Annual Fee -->
                <div class="col-md-6">
                  <label class="form-label">Annual Fee ($)</label>
                  <input type="number" class="form-control" value="0">
                </div>

                <!-- Description -->
                <div class="col-12">
                  <label class="form-label">Description</label>
                  <textarea class="form-control" rows="2" placeholder="Plan description"></textarea>
                </div>

                <!-- Features -->
                <div class="col-12">
                  <label class="form-label">Features</label>
                  <div id="features-wrapper">
                    <div class="d-flex align-items-center mb-2 feature-item">
                      <input type="text" class="form-control" placeholder="Feature description">
                      <button type="button" class="btn btn-sm btn-link text-danger ms-2 remove-feature">
                        <i class="ti ti-x"></i>
                      </button>
                    </div>
                  </div>
                  <button type="button" class="btn btn-light border border-1 btn-sm mt-2" id="addFeature">
                    <i class="ti ti-plus"></i> Add Feature
                  </button>
                </div>

                <!-- Active Toggle -->
                <div class="col-12 d-flex align-items-center mt-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="planActive" checked>
                    <label class="form-check-label" for="planActive">Plan is active</label>
                  </div>
                </div>

              </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create Plan</button>
            </div>
          </form>
        </div>
      </div>
    </div>








    <!-- End Footer -->

  </div>
@endsection

@push("parentscripts")
      <!-- FLATPICKR CSS (place in <head> or before inputs) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


  <!-- FLATPICKR JS (place before closing body) -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <!-- Init script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // Helper: parse boolean-like strings
      function boolAttr(val) {
        return String(val) === 'true' || val === true;
      }

      // Initialize date flatpickr
      document.querySelectorAll('input[data-provider="flatpickr"]').forEach(function (el) {
        var df = el.dataset.dateFormat || 'd M, Y';
        var allowInput = boolAttr(el.dataset.allowInput);
        var enableTime = boolAttr(el.dataset.enableTime); // optional if you want time on date picker

        flatpickr(el, {
          dateFormat: df,
          allowInput: allowInput,
          enableTime: enableTime,
          time_24hr: false,
          // IMPORTANT for modals: append to body so z-index doesn't hide calendar
          appendTo: document.body
        });
      });

      // Initialize time pickers using flatpickr (noCalendar)
      document.querySelectorAll('input[data-provider="timepickr"], input[data-provider="timepicker"]').forEach(function (el) {
        var basic = boolAttr(el.dataset.timeBasic);          // if true => simple time style
        var withSeconds = boolAttr(el.dataset.timeSeconds);  // set data-time-seconds="true" if you want seconds
        var timeFormat = withSeconds ? 'H:i:S' : 'H:i';

        flatpickr(el, {
          enableTime: true,
          noCalendar: true,
          dateFormat: timeFormat,
          time_24hr: false,        // use 12-hour AM/PM by default; set data-time-24="true" for 24hr
          enableSeconds: withSeconds,
          // small UI tweaks for basic vs advanced (you can expand if needed)
          // If you want a compact "basic" timepicker, you can use "wrap" option and custom markup.
          appendTo: document.body
        });
      });

      // OPTIONAL: if modal content is injected dynamically later, re-init on modal show
      // This ensures inputs added after page load get initialized.
      document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('shown.bs.modal', function () {
          // re-run initialization for inputs inside this modal that might not be initialized
          modal.querySelectorAll('input[data-provider]').forEach(function (el) {
            if (!el._flatpickr) { // not initialized yet
              if (el.dataset.provider === 'flatpickr') {
                flatpickr(el, { dateFormat: el.dataset.dateFormat || 'd M, Y', appendTo: document.body });
              } else {
                flatpickr(el, { enableTime: true, noCalendar: true, dateFormat: el.dataset.timeSeconds === 'true' ? 'H:i:S' : 'H:i', appendTo: document.body });
              }
            }
          });
        }, { once: false });
      });

    });
  </script>
  <!-- Script for dynamic features -->
  <script>
    document.getElementById("addFeature").addEventListener("click", function () {
      const wrapper = document.getElementById("features-wrapper");
      const feature = document.createElement("div");
      feature.className = "d-flex align-items-center mb-2 feature-item";
      feature.innerHTML = `
            <input type="text" class="form-control" placeholder="Feature description">
            <button type="button" class="btn btn-sm text-danger ms-2 remove-feature">
              <i class="ti ti-x"></i>
            </button>
          `;
      wrapper.appendChild(feature);
    });

    // Event delegation for remove buttons
    document.addEventListener("click", function (e) {
      if (e.target.closest(".remove-feature")) {
        e.target.closest(".feature-item").remove();
      }
    });
  </script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
      // Bar Chart
      const ctxBar = document.getElementById('revenueTrends').getContext('2d');
      new Chart(ctxBar, {
        type: 'bar',

        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [
            {
              label: 'Premium',
              backgroundColor: '#5f7f7a',
              data: [2400, 2800, 3300, 3600, 4200, 4800]
            },
            {
              label: 'Featured',
              backgroundColor: '#f5c16c',
              data: [3200, 3600, 4100, 4800, 5600, 6400]
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,

          scales: {
            y: { beginAtZero: true, ticks: { stepSize: 2000 } }
          },
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: (ctx) => `$${ctx.parsed.y}`
              }
            }
          }
        }
      });

      // Doughnut Chart
      const ctxDoughnut = document.getElementById('subscriptionDist').getContext('2d');
      new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
          labels: ['Basic', 'Premium', 'Featured'],
          datasets: [{
            data: [420, 280, 123],
            backgroundColor: ['#555a64', '#5f7f7a', '#f5c16c'],
            borderWidth: 0
          }]
        },
        options: {
          cutout: '65%',
          plugins: { legend: { display: false } },
          responsive: true,
          maintainAspectRatio: false
        }
      });
    });
  </script>
@endpush