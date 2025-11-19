<!DOCTYPE html>
<html lang="en">



<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('admin-title', 'Dashboard - Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DreamsEMR is a flexible, powerful, modern, and responsive Bootstrap 5 admin template with endless potential.">
    <meta name="keywords" content="DreamsEMR admin template, admin template, dashboard template, responsive admin template, medical admin template, web app">
    <meta name="author" content="dreamstechnologies">    

      <!-- Favicon -->
       <link rel="shortcut icon" href="{{ asset('provider/assets/updated-logo.jpeg') }}">

       <!-- Apple Icon -->
       <link rel="apple-touch-icon" href="{{ asset('provider/assets/updated-logo.jpeg') }}">
   
       <!-- Theme Config JS -->
       <script src="{{ asset('provider/assets/js/theme-script.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>
   
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/css/bootstrap.min.css') }}">
   
       <!-- Flatpickr CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/plugins/flatpickr/flatpickr.min.css') }}">
   
       <!-- Choices CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/plugins/choices.js/public/assets/styles/choices.min.css') }}">
   
       <!-- Select2 CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/plugins/select2/css/select2.min.css') }}">
   
       <!-- Tabler Icon CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/plugins/tabler-icons/tabler-icons.min.css') }}">
   
       <!-- Daterangepicker CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/plugins/daterangepicker/daterangepicker.css') }}">
   
       <!-- Simplebar CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/plugins/simplebar/simplebar.min.css') }}">

          <link rel="stylesheet" href="{{ asset('panel/assets/plugins/datatables/css/dataTables.bootstrap5.min.css')}}">

  
      <!-- Main CSS -->
     <!-- Main CSS -->
       <link rel="stylesheet" href="{{ asset('provider/assets/css/style.css') }}" id="app-style">

       
 
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    @stack('links')
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
/>
</head>


<body>

    <!-- Begin Wrapper -->
    <div class="main-wrapper">

        <!-- Topbar Start -->
        <header class="navbar-header">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Logo -->
                    <a href="index.html" class="logo">

                        <!-- Logo Normal -->
                        <span class="logo-light">
                            <span class="logo-lg">
                                <img src="{{ asset('provider/assets/updated-logo.jpeg') }}" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('provider/assets/updated-logo.jpeg') }}" alt="small logo">
                            </span>
                        </span>
                        
                        <!-- Logo Dark -->
                        <span class="logo-dark">
                            <span class="logo-lg">
                                <img src="{{ asset('provider/assets/updated-logo.jpeg') }}" alt="dark logo">
                            </span>
                        </span>
                        
                    </a>

                    <!-- Sidebar Mobile Button -->
                    <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                        <i class="ti ti-menu-deep fs-24"></i>
                    </a>

                    <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn2"> 
                        <i class="ti ti-arrow-bar-to-right"></i>
                    </button> 
					
                    <!-- Search -->
                   
					
                </div>

                <div class="d-flex align-items-center">
				
                    <!-- Search for Mobile -->
                    <div class="header-item d-flex d-lg-none me-2">
                        <button class="topbar-link btn" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                            <i class="ti ti-search fs-16"></i>
                        </button>
                    </div>   

                    
                     
              
				
					<!-- Notification Dropdown -->
                  <div class="header-item">
    <div class="dropdown me-2">
        <button class="topbar-link btn topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" aria-haspopup="false" aria-expanded="false">
            <i class="ti ti-bell-check fs-16 animate-ring"></i>
            @if(auth()->user()->unreadNotificationsCount() > 0)
                <span class="notification-badge">{{ auth()->user()->unreadNotificationsCount() }}</span>
            @endif
        </button>
        
        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">
            <div class="p-2 border-bottom">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 fs-16 fw-semibold">Notifications</h6>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-primary">{{ auth()->user()->unreadNotificationsCount() }} Unread</span>
                    </div>
                </div>
            </div>
            
            <!-- Notification Body -->
            <div class="notification-body position-relative z-2 rounded-0" data-simplebar style="max-height: 400px;">
                @php
                    $notifications = auth()->user()->recentNotifications(10);
                @endphp
                
                @forelse($notifications as $notification)
                    <div class="dropdown-item notification-item py-3 text-wrap border-bottom 
                                {{ $notification->isUnread() ? 'notification-unread' : '' }}" 
                         id="notification-{{ $notification->id }}">
                        <div class="d-flex">
                            <div class="me-2 position-relative flex-shrink-0">
                                <div class="avatar-md rounded-circle d-flex align-items-center justify-content-center 
                                            {{ $notification->getBadgeColor() }} text-white">
                                    <i class="{{ $notification->getIcon() }} fs-18"></i>
                                </div>
                                @if($notification->isUnread())
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-medium text-dark">{{ $notification->title }}</p>
                                <p class="mb-1 text-wrap">
                                    {{ $notification->message }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-12"><i class="ti ti-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}</span>
                                    <div class="notification-action d-flex align-items-center float-end gap-2">
                                        @if($notification->isUnread())
                                            <a href="javascript:void(0);" 
                                               class="notification-read rounded-circle bg-danger" 
                                               data-bs-toggle="tooltip" 
                                               title="Mark as Read"
                                               onclick="markAsRead({{ $notification->id }})">
                                                <span class="visually-hidden">Mark as Read</span>
                                            </a>
                                        @endif
                                        <button class="btn rounded-circle p-0" onclick="dismissNotification({{ $notification->id }})">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                                @if($notification->action_url)
                                    <div class="mt-2">
                                        <a href="{{ $notification->action_url }}" class="btn btn-sm btn-outline-primary">
                                            {{ $notification->action_text ?? 'View Details' }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="dropdown-item text-center py-5">
                        <i class="ti ti-bell-off fs-32 text-muted mb-2 d-block"></i>
                        <p class="text-muted mb-0">No notifications</p>
                    </div>
                @endforelse
            </div>
            
            <!-- View All-->
            <div class="p-2 rounded-bottom border-top text-center">
                @if($notifications->count() > 0)
                    <a href="javascript:void(0);" class="text-center text-decoration-underline fs-14 mb-0" onclick="markAllAsRead()">
                        Mark all as read
                    </a>
                @else
                    <a href="#" class="text-center text-decoration-underline fs-14 mb-0">
                        View all notifications
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
            
					
					<!-- User Dropdown -->
                    <div class="dropdown provider/-dropdown d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);" class="topbar-link dropdown-toggle drop-arrow-none position-relative" data-bs-toggle="dropdown" data-bs-offset="0,22" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('provider/assets/img/users/avatar-5.jpg') }}" width="32" class="rounded-2 d-flex" alt="user-image">
                            <span class="online text-success">
                                <i class="ti ti-circle-filled d-flex bg-white rounded-circle border border-1 border-white"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                            <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                                <img src="{{ asset('provider/assets/img/users/avatar-5.jpg') }}" class="rounded-circle" width="42" height="42" alt="provider/">
                                <div class="ms-2">
                                    <p class="fw-medium text-dark mb-0">{{ Auth::user()->first_name ?? 'Provider' }} {{ Auth::user()->last_name ?? '' }}</p>
                                </div>
                            </div>
                    
                            <!-- Item -->
                            <div class="pt-2 mt-2 border-top">
                                <a href="{{ url('logout') }}" class="dropdown-item text-danger">
                                    <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">Sign Out</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
						
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-transparent">
                    <div class="card shadow-none mb-0">
                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="search-top">
                            <i class="ti ti-search fs-22"></i>
                            <input type="search" class="form-control border-0" placeholder="Search">
                            <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x fs-22"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar" id="sidebar">

            <!-- Start Logo -->
            <div class="sidebar-logo">
                <div>
                    <!-- Logo Normal -->
                    <a href="/home" class="logo logo-normal">
                        <img src="{{ asset('panel/assets/updated-logo.jpeg') }}" height="40px" alt="Logo">
                        <h4>AskRoro</h4>
                    </a>
        
                    <!-- Logo Small -->
                    <a href="/home" class="logo-small">
                        <img src="{{ asset('panel/assets/updated-logo.jpeg') }}" alt="Logo">
                    </a>
        
                    <!-- Logo Dark -->
                    <a href="/home" class="dark-logo">
                        <img src="{{ asset('panel/assets/updated-logo.jpeg') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <!-- End Logo -->
        
            <!-- Sidenav Menu -->
            <div class="sidebar-inner" data-simplebar>
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li>
                            <ul>
                                <li>
                                    <a href="{{ route('provider-home') }}">
                                        <i class="ti ti-layout-board"></i><span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('provider.listings.profile') }}">
                                        <i class="ti ti-list"></i><span>Listing Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.events.index') }}">
                                        <i class="ti ti-calendar"></i><span>Events</span>
                                    </a>
                                </li>

                                 <li>
                                    <a href="{{ route('provider-inquiries') }}">
                                        <i class="ti ti-calendar"></i><span>Inqueries</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('provider-subscription') }}">
                                        <i class="ti ti-credit-card"></i><span>Subscription</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="#">
                                        <i class="ti ti-chart-bar-popular"></i><span>Analytics</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('provider-profile') }}">
                                        <i class="ti ti-user"></i><span>Profile & Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        
        </div>
        
        
        
        <!-- Sidenav Menu End -->

        <!-- ========================
			Start Page Content
		========================= -->
         
     
        @yield('content')
        <!-- ========================
			End Page Content
		========================= -->

    </div>
    <!-- End Wrapper -->
<div class="modal fade" id="commonModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="body">
                    </div>
                  </div>
                </div>
              </div>



    <!-- jQuery -->


    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('provider/assets/js/bootstrap.bundle.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>    

    <!-- Simplebar JS -->
    <script src="{{ asset('provider/assets/plugins/simplebar/simplebar.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Daterangepicker JS -->
    <script src="{{ asset('provider/assets/js/moment.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>
    <script src="{{ asset('provider/assets/plugins/daterangepicker/daterangepicker.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Choices JS -->
    <script src="{{ asset('provider/assets/plugins/choices.js/public/assets/scripts/choices.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Flatpickr JS -->
    <script src="{{ asset('provider/assets/plugins/flatpickr/flatpickr.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('provider/assets/plugins/select2/js/select2.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- ApexChart JS -->
    <script src="{{ asset('provider/assets/plugins/apexchart/apexcharts.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>
    <script src="{{ asset('provider/assets/plugins/apexchart/chart-data.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Main JS -->
    <script src="{{ asset('provider/assets/js/script.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>
            <script src="{{ asset('js/custom.js') }}" ></script>

    <!-- Cloudflare Rocket Loader -->
    <script src="{{ asset('provider/assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}" data-cf-settings="04dbc81d7559b6c889b410c1-|49" defer></script>

    <!-- Cloudflare Insights -->
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"97f804d548a25cdb","version":"2025.8.0","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      // Current page file name (without query/hash)
      let currentPage = window.location.pathname.split("/").pop().split("?")[0].split("#")[0];
    
      // Agar URL empty hai (root) to index.html samjho
      if (!currentPage || currentPage === "/") {
        currentPage = "index.html";
      }
    
      // Sidebar ke saare links
      const links = document.querySelectorAll("#sidebar-menu a");
    
      links.forEach(link => {
        let linkPage = link.getAttribute("href");
    
        // normalize: sirf file name lo (query/hash ignore karo)
        linkPage = linkPage.split("/").pop().split("?")[0].split("#")[0];
    
        // Match karke active class lagao
        if (linkPage === currentPage) {
          link.parentElement.classList.add("active");
        }
      });
    });
    </script>
@stack("scripts")

</body>


<!-- Mirrored from dreamsemr.dreamstechnologies.com/html/template/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Sep 2025 12:10:51 GMT -->
</html>