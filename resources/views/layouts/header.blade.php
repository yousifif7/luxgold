<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/updated-logo.jpeg') }}" alt="AskRoro" class="me-2 rounded">
      <span>AskRoro</span>
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
          <a class="nav-link {{ request()->is('for-cleaner') ? 'active' : '' }}" href="{{ route('website.for-cleaner') }}">For Provider</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->is('compare') ? 'active' : '' }}" href="{{ route('website.compare') }}">Compare</a>
        </li>


      </ul>
    </div>

    <div class="d-flex gap-2">
      @if(Auth::user())
<a href="{{ url('parent/dashboard') }}" id="listServiceBtn" class="add-services-btn d-flex align-items-center">Dashboard</a>
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
