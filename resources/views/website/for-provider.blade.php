@extends('layouts.master')

@section('title', 'For Cleaners - luxGold')
@section('content')
<section class="for-providers-hero-section">
    <div class="container">
        <h1 class="mt-4 mb-4">
            Stand Out Where Customers Are<br> Actively Looking
        </h1>
      <p class="text-center">Join thousands of cleaners who trust luxGold to connect with customers in their community.<br> Stand out where customers are actively looking and grow your business.</p>
      <div class="d-flex justify-content-center align-items-center gap-2  mt-3">
        @if(Auth::user()) <a href="{{ route('cleaner-home') }}" class="p2-button">List Your Services - Free </a>@else <button class="p2-button" onclick="openLoginModal()">List Your Services - Free </button> @endif
      <span class="text-muted small">Be part of the local marketplace customers trust</span>
      </div>
    </div>

</section>
<section class="fifth-section for-providers" style="background: #fff !important;">
    <div class="container">
      <h3>Why Join luxGold?</h3>
    
      <div class="row justify-content-start mt-5">
        
        <!-- Step 1 -->
        <div class="col-md-4 mb-4 d-flex flex-column">
          <div class="how-it-works-card">
            
            <div class="how-it-works-icon-wrapper">
                <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="how-it-works-title">Curated Visibility</h3>
            <p class="how-it-works-description">
                Cleaners don’t get lost in the crowd. Verified businesses are spotlighted in a trusted, customer-first environment.
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
                From one-off cleanings to recurring commercial services, luxGold connects customers with a wide spectrum of cleaning solutions, giving cleaners access to clients across every neighborhood.
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
                Built around local cities and neighborhoods, luxGold makes it easy for customers nearby to discover and choose cleaners they can trust.
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
                Side-by-side comparison tools help customers make confident decisions — giving cleaners a stronger chance to convert visibility into clients.
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
                Transparent plans and featured placements ensure cleaners can grow their reach without overwhelming customers with ads.
              </p>
            </div>
          </div>
      </div>
      <div class="d-flex justify-content-center align-items-center">
    @if(Auth::user()) <a href="{{ route('cleaner-home') }}" class="p2-button">List Your Services - Free </a>@else <button class="p2-button" onclick="openLoginModal()">List Your Services - Free </button> @endif      </div>
    </div>
  </section>
@endsection