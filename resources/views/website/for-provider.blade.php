@extends('layouts.master')

@section('title', 'For Provider - AskRoro')
@section('content')
<section class="for-providers-hero-section">
    <div class="container">
        <h1 class="mt-4 mb-4">
            Stand Out Where Families Are<br> Actively Looking
        </h1>
      <p class="text-center">Join thousands of providers who trust ASKRORO to connect with families in their community.<br> Stand out where families are actively looking and grow your business.</p>
      <div class="d-flex justify-content-center align-items-center gap-2  mt-3">
        <button onclick="openLoginModal()">List Your Services - Free </button>
      <span class="text-muted small">Be part of the family ecosystem parents trust</span>
      </div>
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
      <div class="d-flex justify-content-center align-items-center">
        <button >List Your Services - Free <i class="bi bi-chevron-right ms-1"></i></button>
      </div>
    </div>
  </section>
@endsection