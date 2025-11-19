@extends('layouts.master')

@section('title', 'For Provider - AskRoro')
@section('content')
<section class="for-providers-hero-section">
    <div class="container">
        <h1 class="mt-4">
            Stand Out Where Families Are<br> Actively Looking
        </h1>
      <p class="text-center">Join thousands of providers who trust ASKRORO to connect with families in their community.<br> Stand out where families are actively looking and grow your business.</p>
      <div class="d-flex justify-content-center align-items-center gap-2  mt-3">
        @if(auth()->check())
          @php
            $user = auth()->user();
            $isProvider = false;
            // attempt common role checks
            if (method_exists($user, 'hasRole')) {
                $isProvider = $user->hasRole('provider');
            } elseif (property_exists($user, 'role')) {
                $isProvider = ($user->role === 'provider');
            }
          @endphp

          @if($isProvider)
            <button onclick="window.location.href='{{ url('/provider/listing/profile') }}'">List Your Services - Free </button>
          @else
            <button id="joinProviderBtn">List Your Services - Free</button>
          @endif

        @else
          <button id="guestListBtn">List Your Services - Free</button>
        @endif

        <span class="text-muted small">Be part of the family ecosystem parents trust</span>
      </div>

      <!-- Guest login / redirect modal -->
      <div class="modal fade" id="guestLoginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Sign in to list your services</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Please sign in or register as a provider to create and manage your listings.</p>
            </div>
            <div class="modal-footer">
              <a href="{{ url('/login') }}?redirect={{ urlencode(url('/provider/service-listings')) }}" class="btn btn-primary">Sign in</a>
              <a href="{{ url('/register') }}?as=provider&redirect={{ urlencode(url('/provider/service-listings')) }}" class="btn btn-outline-secondary">Register as provider</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Toast for non-provider users -->
      <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div id="providerToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto">Become a Provider</strong>
            <small>Now</small>
            <button type="button" class="btn-close ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            To list services you must join as a provider. <a href="{{ url('/register') }}?as=provider">Register as a provider</a> or update your account.
          </div>
        </div>
      </div>

      @push('scripts')
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const guestBtn = document.getElementById('guestListBtn');
          const guestModal = new bootstrap.Modal(document.getElementById('guestLoginModal'));
          if (guestBtn) {
            guestBtn.addEventListener('click', function () {
              guestModal.show();
            });
          }

          const joinBtn = document.getElementById('joinProviderBtn');
          if (joinBtn) {
            joinBtn.addEventListener('click', function () {
              const toastEl = document.getElementById('providerToast');
              const toast = new bootstrap.Toast(toastEl);
              toast.show();
            });
          }
        });
      </script>
      @endpush
    </div>

</section>
<section class="fifth-section for-providers" style="background: #fff !important;">
    <div class="container">
      <h3>Why Join AskRoro?</h3>
    
      <div class="row justify-content-start mt-5">
        
        <!-- Step 1 -->
        <div class="col-md-4 mb-4 d-flex flex-column">
          <div class="how-it-works-card">
            
            <div class="how-it-works-icon-wrapper">
                <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="how-it-works-title">Curated Visibility</h3>
            <p class="how-it-works-description">
                Providers don’t get lost in the crowd. Verified businesses are spotlighted in a trusted, parent-first environment.
            </p>
          </div>
        </div>
        
        <!-- Step 2 -->
        <div class="col-md-4 mb-4 d-flex flex-column">
          <div class="how-it-works-card">
     
            <div class="how-it-works-icon-wrapper">
              <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="how-it-works-title">More Than Childcare</h3>
            <p class="how-it-works-description">
                From after-school programs and tutoring to wellness, family events, and activities.  AskRoro connects families with a wide spectrum of services, giving providers access to parents at every stage of family life.
            </p>
          </div>
        </div>
        
        <!-- Step 3 -->
        <div class="col-md-4 mb-4 d-flex flex-column">
          <div class="how-it-works-card">
         
            <div class="how-it-works-icon-wrapper">
                <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="how-it-works-title">Community-Driven</h3>
            <p class="how-it-works-description">
                Built around local cities and neighborhoods, AskRoro makes it easy for parents nearby to discover and choose providers they can trust.
            </p>
          </div>
        </div>
        <div class="col-md-4 mb-4 d-flex flex-column">
            <div class="how-it-works-card">
    
              <div class="how-it-works-icon-wrapper">
                <i class="bi bi-check2-circle"></i>
              </div>
              <h3 class="how-it-works-title">Smarter Discovery</h3>
              <p class="how-it-works-description">
                Side-by-side comparison tools help parents make confident decision-giving providers a stronger chance to convert visibility into clients.
              </p>
            </div>
          </div>
          <div class="col-md-4 mb-4 d-flex flex-column">
            <div class="how-it-works-card">
       
              <div class="how-it-works-icon-wrapper">
                <i class="bi bi-check2-circle"></i>
              </div>
              <h3 class="how-it-works-title">Flexible Memberships</h3>
              <p class="how-it-works-description">
                Transparent plans and featured placements ensure providers can grow their reach without overwhelming families with ads.
              </p>
            </div>
          </div>
      </div>
      {{-- <div class="d-flex justify-content-center align-items-center">
        <button >List Your Services - Free <i class="bi bi-chevron-right ms-1"></i></button>
      </div> --}}
    </div>
  </section>
@endsection