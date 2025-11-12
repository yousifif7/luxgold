@extends('layouts.provider-layout')

@section('provider-title', 'Analytics - Provider Portal')
@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Analytics & Reporting</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>                            
                        <li class="breadcrumb-item active">Analytics & Reporting</li>
                    </ol>
                </div>
            </div>
           
        </div>
        <div class="row g-2 mb-3">
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Total Page Views</p>
              <h6>47,823</h6>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Total Inquiries</p>
              <h6>1,847</h6>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Conversion Rate</p>
              <h6>3.86%</h6>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
              <p class="mb-2">Active Users</p>
              <h6>12,456</h6>
            </div>
          </div>
        </div>
        <div class="row g-2 mb-3">
            <!-- Subscription Performance -->
            <div class="col-md-6">
              <div class="card card-h-100">
                <div class="card-header">
                  <div class="card-title">Subscription Performance</div>
                  <p class="mb-0 text-muted">Premium and Featured plan growth over time</p>
                </div>
                <div class="card-body" style="height:300px;">
                  <canvas id="subscriptionPerformanceChart"></canvas>
                </div>
              </div>
            </div>
          
            <!-- Provider Categories -->
            <div class="col-md-6">
              <div class="card card-h-100">
                <div class="card-header">
                  <div class="card-title">Provider Categories</div>
                  <p class="mb-0 text-muted">Distribution by service category</p>
                </div>
                <div class="card-body text-center" style="height:300px;">
                  <canvas id="providerCategoriesChart"></canvas>
                </div>
              </div>
            </div>
          
            <!-- ARPU -->
            <div class="col-md-12">
              <div class="card card-h-100">
                <div class="card-header">
                  <div class="card-title">Average Revenue Per User (ARPU)</div>
                  <p class="mb-0 text-muted">Monthly ARPU trend for subscription plans</p>
                </div>
                <div class="card-body" style="height:300px;">
                  <canvas id="arpuChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script>
            // Subscription Performance Line Chart
            new Chart(document.getElementById('subscriptionPerformanceChart'), {
              type: 'line',
              data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                  {
                    label: 'Premium',
                    data: [45, 58, 66, 78, 89, 97],
                    borderColor: '#4e8ca0',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 2
                  },
                  {
                    label: 'Featured',
                    data: [18, 22, 28, 34, 41, 48],
                    borderColor: '#f5c97c',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 2
                  }
                ]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
              }
            });
          
            // Provider Categories Doughnut Chart
            new Chart(document.getElementById('providerCategoriesChart'), {
              type: 'doughnut',
              data: {
                labels: ['Daycare', 'After School Care', 'Activity Centers', 'Preschool', 'Tutoring', 'Other'],
                datasets: [{
                  data: [156, 67, 34, 89, 45, 23],
                  backgroundColor: ['#27ae60', '#f5c97c', '#4e8ca0', '#95a5a6', '#1abc9c', '#bdc3c7'],
                  borderWidth: 1
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  legend: { position: 'right' }
                },
                cutout: '70%'
              }
            });
          
            // ARPU Line Chart
            new Chart(document.getElementById('arpuChart'), {
              type: 'line',
              data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                  label: 'ARPU',
                  data: [45, 47, 49, 51, 53, 55],
                  borderColor: '#27ae60',
                  backgroundColor: 'transparent',
                  tension: 0.3,
                  borderWidth: 2,
                  pointRadius: 3
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
              }
            });
          </script>
          
   
        
        
        <!-- End Page Header -->
        
        <!-- card start -->
        <div class="card">
            <div class="card-header">
              <h5 class="mb-1">Top Performing Providers</h5>
              <p class="mb-0 text-muted">Views, clicks, inquiries, and conversion rates</p>
            </div>
            <div class="card-body">
              <table class="table mb-0 align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Provider</th>
                    <th>Views</th>
                    <th>Clicks</th>
                    <th>Inquiries</th>
                    <th>Conversion Rate</th>
                    <th>Performance</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Row 1 -->
                  <tr>
                    <td>
                      <div class="fw-semibold">Little Learners Academy</div>
                      <span class="badge bg-light text-dark">Rank #1</span>
                    </td>
                    <td>1,247</td>
                    <td>89<br><small class="text-muted">7.1% CTR</small></td>
                    <td>23</td>
                    <td>1.8%</td>
                    <td><span class="text-danger">↘ Low</span></td>
                  </tr>
          
                  <!-- Row 2 -->
                  <tr>
                    <td>
                      <div class="fw-semibold">ABC Childcare Center</div>
                      <span class="badge bg-light text-dark">Rank #2</span>
                    </td>
                    <td>892</td>
                    <td>67<br><small class="text-muted">7.5% CTR</small></td>
                    <td>18</td>
                    <td><span class="text-success">2%</span></td>
                    <td><span class="text-success">↗ High</span></td>
                  </tr>
          
                  <!-- Row 3 -->
                  <tr>
                    <td>
                      <div class="fw-semibold">Bright Stars Preschool</div>
                      <span class="badge bg-light text-dark">Rank #3</span>
                    </td>
                    <td>756</td>
                    <td>45<br><small class="text-muted">6.0% CTR</small></td>
                    <td>12</td>
                    <td>1.6%</td>
                    <td><span class="text-danger">↘ Low</span></td>
                  </tr>
          
                  <!-- Row 4 -->
                  <tr>
                    <td>
                      <div class="fw-semibold">Fun Time Activities</div>
                      <span class="badge bg-light text-dark">Rank #4</span>
                    </td>
                    <td>634</td>
                    <td>38<br><small class="text-muted">6.0% CTR</small></td>
                    <td>15</td>
                    <td><span class="text-success">2.4%</span></td>
                    <td><span class="text-success">↗ High</span></td>
                  </tr>
          
                  <!-- Row 5 -->
                  <tr>
                    <td>
                      <div class="fw-semibold">Creative Kids Studio</div>
                      <span class="badge bg-light text-dark">Rank #5</span>
                    </td>
                    <td>523</td>
                    <td>29<br><small class="text-muted">5.5% CTR</small></td>
                    <td>8</td>
                    <td>1.5%</td>
                    <td><span class="text-danger">↘ Low</span></td>
                  </tr>
          
                  <!-- Row 6 -->
                  <tr>
                    <td>
                      <div class="fw-semibold">Happy Hearts Academy</div>
                      <span class="badge bg-light text-dark">Rank #6</span>
                    </td>
                    <td>478</td>
                    <td>33<br><small class="text-muted">6.9% CTR</small></td>
                    <td>9</td>
                    <td><span class="text-success">1.9%</span></td>
                    <td><span class="text-danger">↘ Low</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
        <!-- card start -->

    </div>
    <!-- End Content -->            
 
      
      
      
      

    <!-- End Footer -->

</div>
@endsection