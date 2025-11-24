@extends('layouts.admin-layout')

@section('admin-title', 'Providers Management - Admin Pnael')
@section('admin-content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Providers</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>                            
                        <li class="breadcrumb-item active">Providers</li>
                    </ol>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                
                <a id="providersRefreshBtn" href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                <a id="providersPrintBtn" href="javascript:void(0);" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Print" data-bs-original-title="Print"><i class="ti ti-printer"></i></a>
                <a id="providersDownloadBtn" href="{{ route('admin.cleaners.export') }}" class="btn btn-icon btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Download" data-bs-original-title="Download"><i class="ti ti-cloud-download"></i></a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addproviderModal"  class="btn btn-primary"><i class="ti ti-square-rounded-plus me-1"></i>New Provider</a>
            </div>
        </div>
        <!-- End Page Header -->
        
        <!-- card start -->
        <div class="card mb-0">

            <!-- Insights widgets -->
            <div class="card-body border-bottom">
              <div class="row g-3">
                <div class="col-md-3">
                  <div class="bg-white p-3 border rounded h-100">
                    <p class="mb-1 small text-muted">Top Performing Provider (This Month)</p>
                    <h6 class="mb-0">{{ $topProviderName ?? '—' }}</h6>
                    <div class="text-success">${{ number_format($topProviderRevenue ?? 0,2) }}</div>
                    <canvas id="topRevenueSpark" height="40"></canvas>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="bg-white p-3 border rounded h-100">
                    <p class="mb-1 small text-muted">Revenue Trend (30d)</p>
                    <h6 class="mb-0">Recent Revenue</h6>
                    <canvas id="revenueTrendChart" height="60"></canvas>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="bg-white p-3 border rounded h-100">
                    <p class="mb-1 small text-muted">Average Rating</p>
                    <h6 class="mb-0">{{ number_format($avgRating ?? 0,1) }} ★</h6>
                    <p class="small text-muted">Across approved reviews</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="bg-white p-3 border rounded h-100">
                    <p class="mb-1 small text-muted">Providers by City</p>
                    @foreach($byCity ?? [] as $city)
                      <div class="d-flex justify-content-between small"><div>{{ $city->city }}</div><div>{{ $city->cnt }}</div></div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>


            <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="d-inline-flex align-items-center mb-0">Total Providers <span class="badge bg-danger ms-2">280</span></h6>
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
    <th>Provider</th>
    <th>Contact</th>
    <th>Location</th>
    <th>Membership</th>
    <th>Status</th>
    <th>Rating</th>
    <th>Revenue</th>
    <th class="no-sort">Actions</th>
  </tr>
</thead>
<tbody>
    <tr>
      <td><input type="checkbox" class="form-check-input"></td>
      <td>
        <div class="d-flex align-items-center">
          <span class="avatar avatar-sm rounded-circle bg-success text-white me-2">LLA</span>
          <div class="d-flex flex-column">
            <span class="fw-semibold">Little Learners Academy</span>
            <span class="small text-muted">Daycare</span>
          </div>
        </div>
      </td>
      <td>
        <div class="d-flex flex-column">
          <span class="text-muted"><i class="ti ti-mail me-1"></i> contact@littlelearners.com</span>
          <span class="text-muted"><i class="ti ti-phone me-1"></i> (555) 123-4567</span>
        </div>
      </td>
      <td><i class="ti ti-map-pin me-1"></i> Frisco, TX</td>
      <td><span class="badge bg-primary">Basic Plan</span></td>
      <td><span class="badge bg-success-subtle text-success">Active</span></td>
      <td><i class="ti ti-star-filled text-warning"></i> 4.8 <span class="text-muted small">(127)</span></td>
      <td><span class="fw-semibold">$2,850</span></td>
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


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  try{
    var labels = @json($revenueTrendLabels ?? []);
    var data = @json($revenueTrendData ?? []);
    var ctx = document.getElementById('revenueTrendChart');
    if (ctx && labels.length) {
      new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: { labels: labels, datasets: [{ label: 'Revenue', data: data, borderColor: '#198754', backgroundColor: 'rgba(25,135,84,0.08)', fill:true, tension:0.3 }] },
        options: { plugins:{legend:{display:false}}, scales:{x:{display:false}, y:{display:false}} }
      });
    }
  } catch(e){ console.warn(e); }
});
// Refresh and Print handlers
document.addEventListener('DOMContentLoaded', function(){
  try {
    var refreshBtn = document.getElementById('providersRefreshBtn');
    var printBtn = document.getElementById('providersPrintBtn');
    if (refreshBtn) refreshBtn.addEventListener('click', function(){
      this.classList.add('disabled');
      window.location.reload();
    });
    if (printBtn) printBtn.addEventListener('click', function(){
      window.print();
    });
  } catch(e){ console.warn(e); }
});
</script>
@endpush


        </div>
        <!-- card start -->

    </div>
    <!-- End Content -->            
    <div id="addproviderModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header justify-content-between">
              <h4 class="text-dark modal-title fw-bold text-truncate">Add New Provider</h4>
              <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                <i class="ti ti-circle-x-filled"></i>
              </button>
            </div>
            <form action="providers.html">
              <div class="modal-body pb-0">
                <div class="row">
                  
                  <!-- Provider Name -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Provider Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter provider name">
                    </div>
                  </div>
      
                  <!-- Category -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Category <span class="text-danger">*</span></label>
                      <select class="form-select select2" style="width: 100%;">
                        <option>Select</option>
                        <option>Daycare</option>
                        <option>Clinic</option>
                        <option>Hospital</option>
                        <option>Specialist</option>
                      </select>
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
      
                  <!-- Membership -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Membership</label>
                      <select class="form-select select2" style="width: 100%;">
                        <option>Select</option>
                        <option>Premium</option>
                        <option>Silver</option>
                        <option>Basic</option>
                      </select>
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
      
                  <!-- Revenue -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Revenue</label>
                      <input type="number" class="form-control" placeholder="Enter revenue (USD)">
                    </div>
                  </div>
      
                  <!-- Rating -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Rating</label>
                      <input type="text" class="form-control" placeholder="e.g. 4.8 (127 reviews)">
                    </div>
                  </div>
      
                  <!-- Avatar / Logo -->
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Upload Logo / Avatar</label>
                      <input type="file" class="form-control">
                    </div>
                  </div>
      
                </div>
              </div>
              <div class="modal-footer d-flex align-items-center gap-1">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Provider</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      

    <!-- End Footer -->

</div>

@endsection