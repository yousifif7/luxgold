@extends('layouts.master')

@section('title', 'For Cleaners - luxGold')
@section('content')
<!-- Hero Section -->
<section class="provider-hero-section" style="background: linear-gradient(135deg, rgba(212,175,55,0.95) 0%, rgba(184,134,11,0.95) 100%), url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1600&auto=format&fit=crop&q=80'); background-size: cover; background-position: center; background-attachment: fixed; padding: 8rem 0 6rem;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto text-center">
        <h1 class="display-3 fw-bold mb-4" style="color: white;">Grow Your Cleaning Business with luxGold</h1>
        <p class="lead mb-4" style="color: rgba(255,255,255,0.95); font-size: 1.3rem; max-width: 800px; margin: 0 auto;">Join Ireland's trusted marketplace connecting professional cleaners with customers actively searching for services. Get quality leads, manage bookings effortlessly, and build your reputation.</p>
        <div class="d-flex justify-content-center align-items-center gap-3 mt-5 flex-wrap">
          @if(Auth::user())
            <a href="{{ route('cleaner-home') }}" class="hero-btn primary">
              <i class="bi bi-speedometer2 me-2"></i>Go to Your Dashboard
            </a>
          @else
            <button class="hero-btn primary" onclick="openServiceProviderModal()">
              <i class="bi bi-person-plus me-2"></i>Create Your Profile — Free
            </button>
          @endif
          <a href="{{ route('website.find-cleaner') }}" class="hero-btn secondary">
            <i class="bi bi-search me-2"></i>See How Customers Find You
          </a>
        </div>
        <div class="mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
          <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 0.95rem;">
            <i class="bi bi-check-circle-fill me-2"></i>No listing fees for verified cleaners
            <span class="mx-3">•</span>
            <i class="bi bi-check-circle-fill me-2"></i>Simple transparent pricing
            <span class="mx-3">•</span>
            <i class="bi bi-check-circle-fill me-2"></i>Get paid on time
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Section -->
<section class="py-5" style="background: #FAF9F7;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="mb-3" style="color: var(--brand-dark); font-weight: 700; font-size: 2.5rem;">Why Cleaners Choose luxGold</h2>
      <p class="text-muted" style="max-width: 700px; margin: 0 auto;">Join hundreds of professional cleaners who are growing their business with Ireland's most trusted cleaning marketplace.</p>
    </div>
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="bi bi-people-fill"></i>
          </div>
          <h5 class="feature-title">Targeted Quality Leads</h5>
          <p class="feature-description">Receive verified customer requests in your service area. Every lead is a real person ready to book cleaning services.</p>
          <ul class="feature-benefits">
            <li><i class="bi bi-check2"></i> Location-based matching</li>
            <li><i class="bi bi-check2"></i> Pre-qualified customers</li>
            <li><i class="bi bi-check2"></i> Instant notifications</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="bi bi-calendar-check"></i>
          </div>
          <h5 class="feature-title">Flexible Scheduling</h5>
          <p class="feature-description">You're in control. Choose which jobs to accept, set your availability, and manage everything from one dashboard.</p>
          <ul class="feature-benefits">
            <li><i class="bi bi-check2"></i> One-off or recurring jobs</li>
            <li><i class="bi bi-check2"></i> Same-day bookings available</li>
            <li><i class="bi bi-check2"></i> Calendar integration</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="bi bi-cash-stack"></i>
          </div>
          <h5 class="feature-title">Transparent Payments</h5>
          <p class="feature-description">Clear pricing, fast payouts, and simple invoicing. Focus on cleaning while we handle the paperwork.</p>
          <ul class="feature-benefits">
            <li><i class="bi bi-check2"></i> Secure payment processing</li>
            <li><i class="bi bi-check2"></i> Fast weekly payouts</li>
            <li><i class="bi bi-check2"></i> Automated invoicing</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="https://images.unsplash.com/photo-1600880292089-90a7e086ee0c?w=800&auto=format&fit=crop&q=80" alt="How it works" class="img-fluid rounded-3 shadow-lg" style="border-radius: 16px;">
      </div>
      <div class="col-lg-6">
        <h2 class="mb-4" style="color: var(--brand-dark); font-weight: 700; font-size: 2.5rem;">How It Works</h2>
        <div class="steps-container">
          <div class="step-item">
            <div class="step-number">1</div>
            <div class="step-content">
              <h5 class="step-title">Create Your Profile</h5>
              <p class="step-description">Add your services, competitive pricing, professional photos, and define your service areas. It takes just 10 minutes to get started.</p>
            </div>
          </div>
          <div class="step-item">
            <div class="step-number">2</div>
            <div class="step-content">
              <h5 class="step-title">Receive & Accept Bookings</h5>
              <p class="step-description">Customers search by Eircode or city and send you quote requests. Review the details and accept jobs that fit your schedule.</p>
            </div>
          </div>
          <div class="step-item">
            <div class="step-number">3</div>
            <div class="step-content">
              <h5 class="step-title">Complete & Get Paid</h5>
              <p class="step-description">Finish the job, mark it complete in your dashboard, and request payment. Collect reviews to build your reputation and attract more customers.</p>
            </div>
          </div>
        </div>
        <div class="mt-4">
          @if(Auth::user())
            <a href="{{ route('cleaner-home') }}" class="cta-btn">
              <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
            </a>
          @else
            <button class="cta-btn" onclick="openServiceProviderModal()">
              <i class="bi bi-person-plus me-2"></i>Create Your Profile — Free
            </button>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Pricing Examples Section -->
<section class="py-5" style="background: linear-gradient(180deg, #FAF9F7 0%, #FFFFFF 100%);">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
        <div class="text-lg-start text-center">
          <h2 class="mb-4" style="color: var(--brand-dark); font-weight: 700; font-size: 2.5rem;">Sample Pricing Guide</h2>
          <p class="text-muted mb-4">These are example market rates to help you price competitively. You set your own prices in your dashboard based on your experience and service quality.</p>
        </div>
        <div class="pricing-examples">
          <div class="pricing-card">
            <div class="pricing-header">
              <div>
                <h5 class="pricing-service">Standard Clean</h5>
                <p class="pricing-details">30–60 mins • Residential</p>
              </div>
              <div class="pricing-amount">€35</div>
            </div>
            <p class="pricing-description">Basic tidying, dusting, vacuuming, kitchen and bathroom cleaning.</p>
          </div>
          <div class="pricing-card">
            <div class="pricing-header">
              <div>
                <h5 class="pricing-service">Deep Clean</h5>
                <p class="pricing-details">2–4 hours • Residential / End of Tenancy</p>
              </div>
              <div class="pricing-amount">€120</div>
            </div>
            <p class="pricing-description">Intensive cleaning including baseboards, behind appliances, windows, and all surfaces.</p>
          </div>
          <div class="pricing-card">
            <div class="pricing-header">
              <div>
                <h5 class="pricing-service">Commercial Hourly</h5>
                <p class="pricing-details">Hourly rate • Offices & Businesses</p>
              </div>
              <div class="pricing-amount">€25/hr</div>
            </div>
            <p class="pricing-description">Professional office cleaning, workspace sanitization, and commercial spaces.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 order-lg-1">
        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&auto=format&fit=crop&q=80" alt="Pricing dashboard" class="img-fluid rounded-3 shadow-lg" style="border-radius: 16px;">
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05));">
  <div class="container">
    <div class="cta-box">
      <div class="row align-items-center">
        <div class="col-lg-8 mb-4 mb-lg-0">
          <h3 class="mb-3" style="color: var(--brand-dark); font-weight: 700; font-size: 2rem;">Ready to Grow Your Business?</h3>
          <p class="mb-0 text-muted" style="font-size: 1.1rem;">Create a free profile today, add your service areas, and start receiving verified leads from customers in your city. Join Ireland's fastest-growing cleaning marketplace.</p>
          <div class="mt-3">
            <div class="d-flex gap-4 flex-wrap">
              <div class="benefit-badge">
                <i class="bi bi-shield-check me-2"></i>Verified customers only
              </div>
              <div class="benefit-badge">
                <i class="bi bi-clock me-2"></i>Setup in 10 minutes
              </div>
              <div class="benefit-badge">
                <i class="bi bi-star-fill me-2"></i>Build your reputation
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 text-lg-end text-center">
          @if(Auth::user())
            <a href="{{ route('cleaner-home') }}" class="cta-btn-large">
              <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
            </a>
          @else
            <button class="cta-btn-large" onclick="openServiceProviderModal()">
              <i class="bi bi-person-plus me-2"></i>Create Profile — Free
            </button>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
/* Hero Section */
.hero-btn {
  padding: 1rem 2rem;
  border-radius: 10px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.3s ease;
  border: none;
  font-size: 1rem;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
}
.hero-btn.primary {
  background: white;
  color: var(--brand-gold-200);
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}
.hero-btn.primary:hover {
  background: var(--brand-gold-200);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(0,0,0,0.2);
}
.hero-btn.secondary {
  background: transparent;
  color: white;
  border: 2px solid white;
}
.hero-btn.secondary:hover {
  background: white;
  color: var(--brand-gold-200);
  transform: translateY(-2px);
}

/* Feature Cards */
.feature-card {
  background: white;
  border-radius: 16px;
  padding: 2.5rem 2rem;
  box-shadow: 0 4px 16px rgba(18,18,18,0.08);
  transition: all 0.35s ease;
  border: 1px solid rgba(212,175,55,0.1);
  height: 100%;
}
.feature-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 32px rgba(212,175,55,0.25);
  border-color: rgba(212,175,55,0.3);
}
.feature-icon-wrapper {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, var(--brand-gold-200), var(--brand-gold-300));
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.5rem;
  font-size: 2rem;
  color: white;
}
.feature-title {
  color: var(--brand-dark);
  font-weight: 700;
  margin-bottom: 1rem;
  font-size: 1.3rem;
}
.feature-description {
  color: var(--text-color);
  opacity: 0.8;
  margin-bottom: 1.5rem;
  line-height: 1.6;
}
.feature-benefits {
  list-style: none;
  padding: 0;
  margin: 0;
}
.feature-benefits li {
  padding: 0.5rem 0;
  color: var(--text-color);
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.feature-benefits li i {
  color: var(--brand-gold-200);
  font-size: 1.1rem;
}

/* Steps */
.step-item {
  display: flex;
  gap: 1.5rem;
  margin-bottom: 2rem;
}
.step-number {
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, var(--brand-gold-200), var(--brand-gold-300));
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.3rem;
  flex-shrink: 0;
}
.step-content {
  flex: 1;
}
.step-title {
  color: var(--brand-dark);
  font-weight: 700;
  margin-bottom: 0.5rem;
}
.step-description {
  color: var(--text-color);
  opacity: 0.8;
  margin: 0;
  line-height: 1.6;
}

/* Pricing Cards */
.pricing-card {
  background: white;
  border-radius: 12px;
  padding: 1.75rem;
  margin-bottom: 1rem;
  box-shadow: 0 4px 12px rgba(18,18,18,0.06);
  border: 1px solid rgba(212,175,55,0.15);
  transition: all 0.3s ease;
}
.pricing-card:hover {
  box-shadow: 0 8px 24px rgba(212,175,55,0.2);
  border-color: rgba(212,175,55,0.3);
  transform: translateX(8px);
}
.pricing-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 0.75rem;
}
.pricing-service {
  color: var(--brand-dark);
  font-weight: 700;
  margin-bottom: 0.25rem;
  font-size: 1.1rem;
}
.pricing-details {
  color: var(--text-color);
  opacity: 0.7;
  margin: 0;
  font-size: 0.9rem;
}
.pricing-amount {
  background: rgba(212,175,55,0.15);
  color: var(--brand-gold-200);
  font-weight: 700;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-size: 1.2rem;
}
.pricing-description {
  color: var(--text-color);
  opacity: 0.7;
  margin: 0;
  font-size: 0.9rem;
  line-height: 1.5;
}

/* CTA Box */
.cta-box {
  background: white;
  border-radius: 16px;
  padding: 3rem 2.5rem;
  box-shadow: 0 8px 32px rgba(212,175,55,0.15);
  border: 1px solid rgba(212,175,55,0.2);
}
.benefit-badge {
  background: rgba(212,175,55,0.1);
  color: var(--brand-gold-300);
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
}

/* CTA Buttons */
.cta-btn, .cta-btn-large {
  background: var(--brand-gold-200);
  color: var(--brand-dark);
  padding: 0.85rem 2rem;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 700;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
}
.cta-btn-large {
  padding: 1.1rem 2.5rem;
  font-size: 1.1rem;
}
.cta-btn:hover, .cta-btn-large:hover {
  background: var(--brand-gold-300);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(212,175,55,0.3);
}

@media (max-width: 992px) {
  .hero-btn {
    padding: 0.85rem 1.5rem;
    font-size: 0.95rem;
  }
  .step-item {
    margin-bottom: 1.5rem;
  }
}
</style>
@endpush