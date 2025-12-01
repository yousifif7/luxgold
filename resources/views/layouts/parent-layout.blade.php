<!DOCTYPE html>
<html lang="en">



<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('parent-title', 'Dashboard - Parent Portal')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="DreamsEMR is a flexible, powerful, modern, and responsive Bootstrap 5 admin template with endless potential.">
    <meta name="keywords"
        content="DreamsEMR admin template, admin template, dashboard template, responsive admin template, medical admin template, web app">
    <meta name="author" content="dreamstechnologies">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/luxgold-trans.png') }}">

    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="{{ asset('assets/images/luxgold-trans.png') }}">

    <!-- Theme Config JS -->
    <script src="{{ asset('panel/assets/js/theme-script.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/css/bootstrap.min.css') }}">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/plugins/flatpickr/flatpickr.min.css') }}">

    <!-- Choices CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/plugins/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/plugins/select2/css/select2.min.css') }}">

    <!-- Tabler Icons CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/plugins/simplebar/simplebar.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('panel/assets/css/style.css') }}" id="app-style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @stack('styles')

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
                                <img src="{{ asset('assets/images/luxgold-trans.png') }}" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/luxgold-trans.png') }}" alt="small logo">
                            </span>
                        </span>

                        <!-- Logo Dark -->
                        <span class="logo-dark">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/luxgold-trans.png') }}" alt="dark logo">
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
                        <button class="topbar-link btn" data-bs-toggle="modal" data-bs-target="#searchModal"
                            type="button">
                            <i class="ti ti-search fs-16"></i>
                        </button>
                    </div>





                    <!-- Notification Dropdown -->
                    <div class="header-item">
                        <div class="dropdown me-2">
                            <button class="topbar-link btn topbar-link dropdown-toggle drop-arrow-none"
                                data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" aria-haspopup="false"
                                aria-expanded="false">
                                <i class="ti ti-bell-check fs-16 animate-ring"></i>
                                @if (auth()->user()->unreadNotificationsCount() > 0)
                                    <span
                                        class="notification-badge">{{ auth()->user()->unreadNotificationsCount() }}</span>
                                @endif
                            </button>

                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg"
                                style="min-height: 300px;">
                                <div class="p-2 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold">Notifications</h6>
                                        </div>
                                        <div class="col-auto">
                                            <span
                                                class="badge bg-primary">{{ auth()->user()->unreadNotificationsCount() }}
                                                Unread</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Body -->
                                <div class="notification-body position-relative z-2 rounded-0" data-simplebar
                                    style="max-height: 400px;">
                                    @php
                                        $notifications = auth()->user()->recentNotifications(10);
                                    @endphp

                                    @forelse($notifications as $notification)
                                        <div class="dropdown-item notification-item py-3 text-wrap border-bottom 
                                {{ $notification->isUnread() ? 'notification-unread' : '' }}"
                                            id="notification-{{ $notification->id }}">
                                            <div class="d-flex">
                                                <div class="me-2 position-relative flex-shrink-0">
                                                    <div
                                                        class="avatar-md rounded-circle d-flex align-items-center justify-content-center 
                                            {{ $notification->getBadgeColor() }} text-white">
                                                        <i class="{{ $notification->getIcon() }} fs-18"></i>
                                                    </div>
                                                    @if ($notification->isUnread())
                                                        <span
                                                            class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
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
                                                        <span class="fs-12"><i
                                                                class="ti ti-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}</span>
                                                        <div
                                                            class="notification-action d-flex align-items-center float-end gap-2">
                                                            @if ($notification->isUnread())
                                                                <a href="javascript:void(0);"
                                                                    class="notification-read rounded-circle bg-danger"
                                                                    data-bs-toggle="tooltip" title="Mark as Read"
                                                                    onclick="markAsRead({{ $notification->id }})">
                                                                    <span class="visually-hidden">Mark as Read</span>
                                                                </a>
                                                            @endif
                                                            <button class="btn rounded-circle p-0"
                                                                onclick="dismissNotification({{ $notification->id }})">
                                                                <i class="ti ti-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @if ($notification->action_url)
                                                            <div class="ms-2">
                                                                <p class="fw-medium text-dark mb-0">{{ auth()->user()->name ?? 'User' }}
                                                                    @includeWhen(auth()->check(), 'components.verified-badge', ['user' => auth()->user()])
                                                                </p>
                                                                <span class="d-block fs-13">{{ optional(auth()->user())->roles->pluck('name')->first() ?? 'Member' }}</span>
                                                            </div>
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
                                    @if ($notifications->count() > 0)
                                        <a href="javascript:void(0);"
                                            class="text-center text-decoration-underline fs-14 mb-0"
                                            onclick="markAllAsRead()">
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
                    <div class="dropdown profile-dropdown d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);"
                            class="topbar-link dropdown-toggle drop-arrow-none position-relative"
                            data-bs-toggle="dropdown" data-bs-offset="0,22" aria-haspopup="false"
                            aria-expanded="false">
                            @if(!empty(auth()->user()->profile_picture)) <img src="{{ asset(auth()->user()->profile_picture) }}" width="32"
                                class="rounded-2 d-flex" alt="user-image"> @else
                            <img src="{{ asset('panel/assets/img/users/avatar-5.jpg') }}" width="32"
                                class="rounded-2 d-flex" alt="user-image">@endif
                            <span class="online text-success">
                                <i
                                    class="ti ti-circle-filled d-flex bg-white rounded-circle border border-1 border-white"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                            <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                                <img src="{{ asset('panel/assets/img/users/avatar-5.jpg') }}" class="rounded-circle"
                                    width="42" height="42" alt="Profile">
                                <div class="ms-2">
                                    <a href={{ route('customer-profile') }}
                                        class="fw-medium text-dark mb-0">{{ Auth::user()->first_name ?? '' }}
                                        {{ Auth::user()->last_name ?? '' }}</a>
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
                            <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="ti ti-x fs-22"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidenav Menu Start -->
        <div class="sidebar" id="sidebar">

            <!-- Start Logo -->
            <div class="sidebar-logo">
                <div>
                    <!-- Logo Normal -->
                    <a href="/home" class="logo logo-normal">
                        <img src="{{ asset('panel/assets/luxgold.jpg') }}" height="40px" alt="Logo">
                    </a>

                    <!-- Logo Small -->
                    <a href="/home" class="logo-small">
                        <img src="{{ asset('panel/assets/luxgold.jpg') }}" alt="Logo">
                    </a>

                    <!-- Logo Dark -->
                    <a href="/home" class="dark-logo">
                        <img src="{{ asset('panel/assets/luxgold.jpg') }}" alt="Logo">
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
                                    <a href="{{ route('customer-home') }}">
                                        <i class="ti ti-layout-board"></i><span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer-saved-items') }}">
                                        <i class="ti ti-heart"></i><span>Saved Items</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('customer-compare') }}">
                                        <i class="ti ti-git-compare"></i><span>Comparison</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('customer-reviews') }}">
                                        <i class="ti ti-star"></i><span>Reviews</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer-messages') }}">
                                        <i class="ti ti-message-2"></i><span>Messages</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('hire-requests.index') }}">
                                        <i class="fa fa-question"></i><span>Hire Requests</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('support') }}">
                                        <i class="ti ti-headset"></i><span>Support</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer-profile') }}">
                                        <i class="ti ti-user"></i><span>Profile</span>
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
        <!-- Trust & Safety / Feedback toasts (Bootstrap) -->
        <div class="page-wrapper">
            <div aria-live="polite" aria-atomic="true" class="position-relative">
                <!-- Position it -->
                <div id="askroro-toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
                    @if(auth()->check() && !auth()->user()->is_verified)
                    <div id="toast-verify" class="toast askroro-toast" role="alert" aria-live="assertive" aria-atomic="true" data-storage-key="askroro_verify_dismissed">
                        <div class="toast-header">
                            <strong class="me-auto">Verify your profile</strong>
                            <small class="text-muted">Recommended</small>
                            <button type="button" class="btn-close ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body d-flex justify-content-between align-items-center">
                            <div>
                                Completing your profile helps us match you with the best providers.
                            </div>
                            <div class="ms-3">
                                <a href="{{ route('customer-profile') }}" class="btn btn-sm btn-primary">Verify Profile</a>
                            </div>
                        </div>
                    </div>
                    @endif
    
                    <div id="toast-feedback" class="toast askroro-toast" role="alert" aria-live="assertive" aria-atomic="true" data-storage-key="askroro_feedback_dismissed">
                        <div class="toast-header">
                            <strong class="me-auto">Help us improve AskRoro</strong>
                            <small class="text-muted">We value your feedback</small>
                            <button type="button" class="btn-close ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body d-flex justify-content-between align-items-center">
                            <div>
                                Share feedback to help us improve recommendations and features.
                            </div>
                            <div class="ms-3">
                                <a href="mailto:feedback@askroro.example" class="btn btn-sm btn-outline-dark">Give Feedback</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')
        <!-- ========================
   End Page Content
  ========================= -->

    </div>
    <!-- End Wrapper -->



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
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

    <!-- ApexChart JS -->
    <script src="{{ asset('provider/assets/plugins/apexchart/apexcharts.min.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>
    <script src="{{ asset('provider/assets/plugins/apexchart/chart-data.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Main JS -->
    <script src="{{ asset('provider/assets/js/script.js') }}" type="04dbc81d7559b6c889b410c1-text/javascript"></script>

    <!-- Cloudflare Rocket Loader -->
    <script src="{{ asset('admin/assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
        data-cf-settings="04dbc81d7559b6c889b410c1-|49" defer></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"97f804d548a25cdb","version":"2025.8.0","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>

    <!-- Cloudflare Insights -->
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"97f804d548a25cdb","version":"2025.8.0","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>

    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>



    <!-- Datatable JS -->
    <script src="{{ asset('admin/assets/plugins/datatables/js/jquery.dataTables.min.js') }}" type="b3e2be4978e0c4f64e5ccd88-text/javascript"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/js/dataTables.bootstrap5.min.js') }}" type="b3e2be4978e0c4f64e5ccd88-text/javascript"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin/assets/js/script.js') }}" type="b3e2be4978e0c4f64e5ccd88-text/javascript"></script>

    <script>
        // Feedback/verify banner dismiss persistence
        document.addEventListener('DOMContentLoaded', function() {
            try {
                if (localStorage.getItem('askroro_feedback_dismissed') === '1') {
                    const fb = document.getElementById('feedback-banner');
                    if (fb) fb.style.display = 'none';
                }
                if (localStorage.getItem('askroro_verify_dismissed') === '1') {
                    const vb = document.getElementById('verify-banner');
                    if (vb) vb.style.display = 'none';
                }

                // Show Bootstrap toasts and wire dismissal that persists to localStorage
                document.querySelectorAll('.askroro-toast').forEach(function (el) {
                    try {
                        const storageKey = el.getAttribute('data-storage-key');
                        // If dismissed already, remove/skip
                        if (storageKey && localStorage.getItem(storageKey) === '1') {
                            el.remove();
                            return;
                        }

                        // If Bootstrap's Toast is available, use it. Otherwise fallback to manual show/hide.
                        if (typeof bootstrap !== 'undefined' && bootstrap && typeof bootstrap.Toast === 'function') {
                            const bsToast = new bootstrap.Toast(el, { autohide: false });
                            // When toast hidden, persist dismissal and remove element
                            el.addEventListener('hidden.bs.toast', function () {
                                try {
                                    if (storageKey) localStorage.setItem(storageKey, '1');
                                } catch (e) { /* ignore */ }
                                el.remove();
                            });
                            // Show it
                            bsToast.show();
                        } else {
                            // Fallback: make visible and wire close button to remove and persist
                            el.style.display = 'block';
                            const closeBtn = el.querySelector('[data-bs-dismiss="toast"]') || el.querySelector('.btn-close');
                            if (closeBtn) {
                                closeBtn.addEventListener('click', function () {
                                    try { if (storageKey) localStorage.setItem(storageKey, '1'); } catch (e) {}
                                    el.remove();
                                });
                            }
                        }
                    } catch (err) {
                        // ignore JS errors for older browsers
                    }
                });
            } catch (e) {
                /* ignore storage errors */ }
        });
    </script>

    <script src="{{ asset('admin/assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
        data-cf-settings="b3e2be4978e0c4f64e5ccd88-|49" defer></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"97f808959cf33fb8","version":"2025.8.0","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
    @stack('scripts')

</body>


<!-- Mirrored from dreamsemr.dreamstechnologies.com/html/template/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Sep 2025 12:10:51 GMT -->

</html>
