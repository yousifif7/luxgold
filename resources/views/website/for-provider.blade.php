@extends('layouts.master')

@section('title', 'For Cleaners - luxGold')
@section('content')
<section class="for-providers-hero-section py-5" style="background: linear-gradient(180deg, #0074C8 0%, #005bb5 100%); color: #fff;">
  <div class="container text-center">
    <h1 class="mt-2 mb-3">Grow Your Cleaning Business with luxGold</h1>
    <p class="lead mb-3 text-light" style="max-width:900px;margin:0 auto;">Join a trusted local marketplace that connects you with customers actively searching for cleaning services — one-off, recurring, or commercial jobs. Get more leads, manage bookings, and get paid on time.</p>
    <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
      @if(Auth::user())
        <a href="{{ route('cleaner-home') }}" class="p2-button">Go to your dashboard</a>
      @else
        <button class="p2-button" onclick="openServiceProviderModal()">Create your profile — Free</button>
      @endif
      <a href="{{ route('website.find-cleaner') }}" class="btn btn-outline-light">See how customers find you</a>
    </div>
    <div class="mt-3"><small class="text-white-50">No listing fees for verified cleaners. Simple transparent plans.</small></div>
  </div>
</section>

<section class="container py-5">
  <h3 class="text-center mb-4">Why cleaners choose luxGold</h3>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="feature-card p-4 h-100 text-center border rounded">
        <div class="feature-icon mb-3"><i class="bi bi-people-fill" style="font-size:1.6rem;color:#0074C8"></i></div>
        <h5 class="mb-2">Targeted Leads</h5>
        <p class="small text-muted mb-0">Receive customer requests in your city — high-intent leads ready to book.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="feature-card p-4 h-100 text-center border rounded">
        <div class="feature-icon mb-3"><i class="bi bi-clock-history" style="font-size:1.6rem;color:#0074C8"></i></div>
        <h5 class="mb-2">Flexible Scheduling</h5>
        <p class="small text-muted mb-0">Offer one-off, recurring, or same-day services and control your availability from the dashboard.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="feature-card p-4 h-100 text-center border rounded">
        <div class="feature-icon mb-3"><i class="bi bi-currency-pound" style="font-size:1.6rem;color:#0074C8"></i></div>
        <h5 class="mb-2">Transparent Payments</h5>
        <p class="small text-muted mb-0">Clear pricing, fast payouts, and simple invoicing — so you can focus on cleaning.</p>
      </div>
    </div>
  </div>

  <div class="row g-4 mt-5">
    <div class="col-md-6">
      <h4>How it works</h4>
      <ol class="mt-3">
        <li><strong>Create your profile:</strong> Add services, prices, photos and your service area.</li>
        <li><strong>Get booked:</strong> Customers request quotes by Eircode or city; accept jobs you want.</li>
        <li><strong>Complete & get paid:</strong> Mark jobs complete, request payment, and collect reviews to grow your rating.</li>
      </ol>
      <div class="mt-3">
        @if(Auth::user())
          <a href="{{ route('cleaner-home') }}" class="p2-button">Go to dashboard</a>
        @else
          <button class="p2-button" onclick="openServiceProviderModal()">Create your profile — Free</button>
        @endif
      </div>
    </div>

    <div class="col-md-6">
      <h4>Sample Pricing (Example)</h4>
      <div class="row g-3">
        <div class="col-12">
          <div class="p-3 border rounded">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <strong>Standard Clean</strong>
                <div class="small text-muted">30–60 mins | Residential</div>
              </div>
              <div class="fw-bold">€35</div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="p-3 border rounded">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <strong>Deep Clean</strong>
                <div class="small text-muted">2–4 hours | Residential / End of tenancy</div>
              </div>
              <div class="fw-bold">€120</div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="p-3 border rounded">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <strong>Commercial Hourly</strong>
                <div class="small text-muted">Hourly rate for offices and businesses</div>
              </div>
              <div class="fw-bold">€25 / hr</div>
            </div>
          </div>
        </div>
      </div>
      <div class="small text-muted mt-2">(These are example prices to help customers understand market rates — set your own prices in the dashboard.)</div>
    </div>
  </div>

  <hr class="my-5">

  <div class="row">
    <div class="col-md-8">
      <h4>Ready to grow?</h4>
      <p class="text-muted">Create a free profile, add your service area, and start receiving verified leads from customers in your city.</p>
    </div>
    <div class="col-md-4 d-flex align-items-center">
      @if(Auth::user())
        <a href="{{ route('cleaner-home') }}" class="p2-button">Go to dashboard</a>
      @else
        <button class="p2-button" onclick="openServiceProviderModal()">Create your profile — Free</button>
      @endif
    </div>
  </div>
</section>
@endsection