@extends('layouts.master')

@section('title', 'About Us - luxGold')
@section('content')
<!-- Hero Section with Image -->
<section class="about-hero-section" style="background: linear-gradient(rgba(212,175,55,0.15), rgba(250,249,247,0.95)), url('{{ asset('images/luxgold-15.jpeg') }}'); background-size: cover; background-position: center; padding: 6rem 0 4rem;">
    <div class="container">
        <h1 class="mt-4 text-center" style="color: var(--brand-dark); font-size: 3rem; font-weight: 700;">
            About luxGold
        </h1>
        <p class="text-center fw-semibold" style="font-size: 1.25rem; color: var(--brand-gold-300);">Premium Cleaning Services — Reliable, Trusted, Professional</p>
        <p class="text-center" style="max-width: 800px; margin: 1rem auto; font-size: 1.1rem; color: var(--brand-dark);">At luxGold, we connect homeowners and businesses with vetted cleaning professionals to make spaces cleaner, safer, and more comfortable. Whether you need a one-time deep clean or recurring service, luxGold makes finding, booking, and managing cleaning services simple and secure.</p>
    </div>
</section>

<section class="about-content-section container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="{{ asset('images/luxgold-16.jpeg') }}" alt="Our Story" class="img-fluid rounded-3 shadow-lg" style="border-radius: 16px;">
        </div>
        <div class="col-lg-6">
            <h3 class="mb-4" style="color: var(--brand-gold-200); font-weight: 700;">Our Story</h3>
            <p class="mb-3">
                luxGold was created to solve a simple problem: finding trustworthy, professional cleaners can be time consuming and uncertain. Homeowners deserve a fast way to discover qualified cleaners with clear pricing, verified reviews, and dependable scheduling.
            </p>
            <p class="mb-3">
                Over time we built a marketplace that brings together independent cleaners and small cleaning businesses with customers who need reliable service. Our platform emphasizes safety, transparency, and quality so both customers and cleaners can succeed.
            </p>
            <p class="mb-4">
                luxGold is more than a directory — it's a trusted cleaning marketplace that helps users find, compare, and book cleaning services confidently.
            </p>
            <ul class="list-unstyled">
                <li class="mb-2"><i style="color: var(--brand-gold-200); font-size: 1.25rem;" class="bi bi-check2-circle me-2"></i>A reliable place to discover professional cleaning services.</li>
                <li class="mb-2"><i style="color: var(--brand-gold-200); font-size: 1.25rem;" class="bi bi-check2-circle me-2"></i>Transparent pricing and verified reviews to help you choose with confidence.</li>
                <li class="mb-2"><i style="color: var(--brand-gold-200); font-size: 1.25rem;" class="bi bi-check2-circle me-2"></i>A platform that empowers cleaners and small cleaning businesses to grow and be trusted by customers.</li>
            </ul>
        </div>
    </div>

    <div class="row align-items-center mb-5 flex-lg-row-reverse">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="{{ asset('images/luxgold-17.jpeg') }}" alt="Our Mission" class="img-fluid rounded-3 shadow-lg" style="border-radius: 16px;">
        </div>
        <div class="col-lg-6">
            <h3 class="mb-4" style="color: var(--brand-gold-200); font-weight: 700;">Our Mission</h3>
            <p class="mb-3" style="font-size: 1.1rem;">
                Our mission is to make professional cleaning services accessible, transparent, and reliable. We connect customers with vetted cleaners, streamline booking and payments, and foster quality through reviews and support.
            </p>
            <p class="mb-0" style="font-size: 1rem; color: var(--brand-dark); line-height: 1.8;">
                luxGold was built on the belief that everyone deserves a clean, healthy space and a straightforward way to get it.
            </p>
        </div>
    </div>

    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="{{ asset('images/luxgold-18.jpeg') }}" alt="Our Promise" class="img-fluid rounded-3 shadow-lg" style="border-radius: 16px;">
        </div>
        <div class="col-lg-6">
            <h3 class="mb-4" style="color: var(--brand-gold-200); font-weight: 700;">Our Promise</h3>
            <ul class="list-unstyled mb-4">
                <li class="mb-3"><strong style="color: var(--brand-gold-300);">For Families:</strong> A safe, inclusive space to explore trusted services.</li>
                <li class="mb-3"><strong style="color: var(--brand-gold-300);">For Cleaners:</strong> A platform to showcase offerings and build community trust.</li>
                <li class="mb-3"><strong style="color: var(--brand-gold-300);">For Communities:</strong> Stronger connections that support families, children, and growth.</li>
            </ul>
            <p class="text-center mb-0 p-4" style="background: linear-gradient(135deg, #FFF9E6, #FAF9F7); border-left: 4px solid var(--brand-gold-200); font-size: 1.15rem; border-radius: 8px;">
                With luxGold, you don't just hire a cleaner — you gain a <strong style="color: var(--brand-gold-300);">trusted partner for a cleaner home.</strong>
            </p>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section py-5" style="background: linear-gradient(180deg, #FAF9F7 0%, #FFFFFF 100%);">
    <div class="container text-center">
        <h3 class="mb-5" style="color: var(--brand-dark); font-weight: 700;">Why Choose luxGold</h3>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="value-card p-4 h-100 text-center">
                    <div class="value-icon mb-3"><i class="bi bi-shield-check" style="font-size: 2.5rem; color: var(--brand-gold-200);"></i></div>
                    <h5 class="mb-2">Trusted</h5>
                    <p class="small text-muted mb-0">Verified cleaners you can rely on</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="value-card p-4 h-100 text-center">
                    <div class="value-icon mb-3"><i class="bi bi-star-fill" style="font-size: 2.5rem; color: var(--brand-gold-200);"></i></div>
                    <h5 class="mb-2">Quality</h5>
                    <p class="small text-muted mb-0">Premium service every time</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="value-card p-4 h-100 text-center">
                    <div class="value-icon mb-3"><i class="bi bi-clock-history" style="font-size: 2.5rem; color: var(--brand-gold-200);"></i></div>
                    <h5 class="mb-2">Flexible</h5>
                    <p class="small text-muted mb-0">Book on your schedule</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="value-card p-4 h-100 text-center">
                    <div class="value-icon mb-3"><i class="bi bi-currency-dollar" style="font-size: 2.5rem; color: var(--brand-gold-200);"></i></div>
                    <h5 class="mb-2">Transparent</h5>
                    <p class="small text-muted mb-0">Clear pricing, no surprises</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.value-card {
    background: white;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid rgba(212,175,55,0.1);
}
.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(212,175,55,0.15);
    border-color: rgba(212,175,55,0.3);
}
</style>
@endpush
