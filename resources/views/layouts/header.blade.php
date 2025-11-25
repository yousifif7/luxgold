<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/updated-logo.jpeg') }}" alt="luxGold" class="me-2 rounded">
      <span>luxGold</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav gap-3">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->is('find-cleaner') ? 'active' : '' }}" href="{{ route('website.find-cleaner') }}">Find Cleaners</a>
        </li>
         <li class="nav-item">
          <a class="nav-link {{ request()->is('find-event') ? 'active' : '' }}" href="{{ route('website.find-event') }}">Find Event</a>
        </li>

        @if (Request::is('/') || Request::is('home'))          
        <li class="nav-item">
          <a class="nav-link" href="#how-it-works-section">How It Works</a>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link {{ request()->is('for-cleaner') ? 'active' : '' }}" href="{{ route('website.for-cleaner') }}">For Cleaner</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->is('compare') ? 'active' : '' }}" href="{{ route('website.compare') }}">Compare</a>
        </li>


      </ul>
    </div>

    <div class="d-flex gap-2">
      @if(Auth::check())
        @php $currentUser = Auth::user(); @endphp
        @if($currentUser->hasRole('cleaner'))
          <a href="{{ route('cleaner-home') }}" id="listServiceBtn" class="add-services-btn d-flex align-items-center">Dashboard</a>
        @elseif($currentUser->hasRole('customer'))
          <a href="{{ route('customer-home') }}" id="listServiceBtn" class="add-services-btn d-flex align-items-center">Dashboard</a>
        @elseif($currentUser->hasRole('admin'))
          <a href="{{ route('admin-home') }}" id="listServiceBtn" class="add-services-btn d-flex align-items-center">Admin</a>
        @else
          <a href="{{ url('/home') }}" id="listServiceBtn" class="add-services-btn d-flex align-items-center">Dashboard</a>
        @endif
      @else
      <a href="#" onclick="openLoginModal()" class="register-btn">Sign In </a>
      <a href="#" id="listServiceBtn" onclick="openSignUpModal()" class="add-services-btn d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="lucide lucide-plus me-1">
          <path d="M5 12h14"></path>
          <path d="M12 5v14"></path>
        </svg>
        Register Now
      </a>
      @endif
    </div>
  </div>
</nav>
