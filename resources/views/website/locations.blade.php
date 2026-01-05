@extends('layouts.master')

@section('title', 'Locations - luxGold')
@section('content')
<!-- Hero Section -->
<section class="locations-hero-section" style="background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, rgba(250,249,247,0.95) 100%), url('https://images.unsplash.com/photo-1569025743873-ea3a9ade89f9?w=1600&auto=format&fit=crop&q=80'); background-size: cover; background-position: center; padding: 6rem 0 4rem;">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--brand-dark);">Our Locations Across Ireland</h1>
            <p class="lead" style="max-width: 800px; margin: 0 auto; color: var(--text-color);">luxGold operates in major cities across Ireland with vetted, professional cleaners ready to serve you. We're continually expanding — if your city isn't listed yet, let us know and we'll prioritize it.</p>
        </div>
    </div>
</section>

<!-- Cities Grid Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($cities as $city)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="location-card">
                    <div class="location-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="location-name">{{ $city }}</h5>
                    <div class="location-badge">Available Now</div>
                    <p class="location-info">Vetted cleaners ready to serve</p>
                    <a href="/find-cleaner?search={{ urlencode($city) }}" class="location-btn">Find Cleaners <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>We're launching soon! Check back for available locations.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Section -->
<section class="py-5" style="background: linear-gradient(180deg, #FAF9F7 0%, #FFFFFF 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&auto=format&fit=crop&q=80" alt="Ireland Map" class="img-fluid rounded-3 shadow-lg" style="border-radius: 16px;">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4" style="color: var(--brand-gold-200); font-weight: 700;">Why luxGold in Your City?</h2>
                <div class="feature-list">
                    <div class="feature-item mb-4">
                        <div class="feature-icon-wrapper">
                            <i class="bi bi-shield-check" style="color: var(--brand-gold-200); font-size: 2rem;"></i>
                        </div>
                        <div class="feature-content">
                            <h5 class="mb-2">Vetted & Garda-Checked Cleaners</h5>
                            <p class="text-muted mb-0">Every cleaner is background-checked and verified with genuine customer reviews you can trust.</p>
                        </div>
                    </div>
                    <div class="feature-item mb-4">
                        <div class="feature-icon-wrapper">
                            <i class="bi bi-currency-dollar" style="color: var(--brand-gold-200); font-size: 2rem;"></i>
                        </div>
                        <div class="feature-content">
                            <h5 class="mb-2">Transparent Pricing</h5>
                            <p class="text-muted mb-0">Clear upfront quotes with no hidden fees. Easy online booking and secure payment.</p>
                        </div>
                    </div>
                    <div class="feature-item mb-4">
                        <div class="feature-icon-wrapper">
                            <i class="bi bi-lightning-charge" style="color: var(--brand-gold-200); font-size: 2rem;"></i>
                        </div>
                        <div class="feature-content">
                            <h5 class="mb-2">Local Availability & Fast Response</h5>
                            <p class="text-muted mb-0">Regional teams ensuring quick response times and dedicated support for your area.</p>
                        </div>
                    </div>
                </div>
                <div class="alert mt-4" style="background: linear-gradient(135deg, #FFF9E6, #FAF9F7); border-left: 4px solid var(--brand-gold-200); border-radius: 8px;">
                    <h6 style="color: var(--brand-gold-300);"><i class="bi bi-geo me-2"></i>Don't see your city?</h6>
                    <p class="mb-0">We prioritize cities with high demand. Enter your postcode on our homepage to register interest and we'll notify you when we launch in your area.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Info Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h4>Holiday Lets & Short-Term Rentals</h4>
                    <p class="text-muted">Dedicated turnover services with flexible scheduling for Airbnb hosts, property managers, and holiday rental owners. Same-day and next-day availability in most locations.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4>Regional Quality Management</h4>
                    <p class="text-muted">Each city has dedicated regional managers who ensure cleaner quality, handle escalations, and maintain our high standards across all locations.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.location-card {
    background: white;
    border-radius: 16px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 4px 16px rgba(18,18,18,0.06);
    transition: all 0.3s ease;
    border: 1px solid rgba(212,175,55,0.1);
    height: 100%;
}
.location-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(212,175,55,0.2);
    border-color: rgba(212,175,55,0.3);
}
.location-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--brand-gold-200), var(--brand-gold-300));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.75rem;
    color: white;
}
.location-name {
    font-weight: 700;
    color: var(--brand-dark);
    margin-bottom: 0.5rem;
}
.location-badge {
    display: inline-block;
    background: rgba(212,175,55,0.15);
    color: var(--brand-gold-300);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}
.location-info {
    color: var(--text-color);
    opacity: 0.7;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}
.location-btn {
    display: inline-block;
    background: var(--brand-gold-200);
    color: var(--brand-dark);
    padding: 0.6rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}
.location-btn:hover {
    background: var(--brand-gold-300);
    color: white;
    transform: translateX(4px);
}
.feature-item {
    display: flex;
    gap: 1rem;
}
.feature-icon-wrapper {
    flex-shrink: 0;
}
.info-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(18,18,18,0.06);
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(212,175,55,0.1);
}
.info-card:hover {
    box-shadow: 0 8px 24px rgba(212,175,55,0.15);
    border-color: rgba(212,175,55,0.3);
}
.info-icon {
    width: 50px;
    height: 50px;
    background: rgba(212,175,55,0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    color: var(--brand-gold-200);
}
.info-card h4 {
    color: var(--brand-dark);
    font-weight: 700;
    margin-bottom: 1rem;
}
</style>
@endpush
