@extends('layouts.master')

@section('title', 'Services - luxGold')
@section('content')
<!-- Hero Section -->
<section class="services-hero-section" style="background: linear-gradient(135deg, rgba(212,175,55,0.15) 0%, rgba(250,249,247,0.95) 100%), url('https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=1600&auto=format&fit=crop&q=80'); background-size: cover; background-position: center; padding: 6rem 0 4rem;">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--brand-dark);">Premium Cleaning Services</h1>
            <p class="lead" style="max-width: 800px; margin: 0 auto; color: var(--text-color);">Discover our comprehensive range of professional cleaning services. From regular maintenance to deep cleans, we've got you covered with transparent pricing and exceptional quality.</p>
        </div>
    </div>
</section>

<!-- Services Grid Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Regular Home Clean -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://media.istockphoto.com/id/2184106435/photo/bright-minimalist-loft-living-room.webp?a=1&b=1&s=612x612&w=0&k=20&c=HhN1rA_ZJ88oD-6bdhfq2lE9AJAbvyOCQTpYFXT1LTk=" alt="Regular Home Clean">
                        <div class="service-badge">Most Popular</div>
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="bi bi-house-heart"></i>
                        </div>
                        <h4 class="service-title">Regular Home Clean</h4>
                        <p class="service-description">A routine clean covering bathrooms, kitchen, living areas and bedrooms to keep your home fresh and tidy.</p>
                        <div class="service-price">
                            <span class="price-label">Starting from</span>
                            <span class="price-amount">€35<span class="price-unit">/hour</span></span>
                        </div>
                        <ul class="service-features">
                            <li><i class="bi bi-check-circle-fill"></i> Dusting and vacuuming</li>
                            <li><i class="bi bi-check-circle-fill"></i> Kitchen surface cleaning</li>
                            <li><i class="bi bi-check-circle-fill"></i> Bathroom sanitation</li>
                            <li><i class="bi bi-check-circle-fill"></i> Light tidying</li>
                        </ul>
                        <a href="/#hero-section" class="service-btn">Get a Quote <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Deep Clean -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://plus.unsplash.com/premium_photo-1678742388597-d9d76a759d14?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8ZGVlcCUyMGNsZWFufGVufDB8fDB8fHww" alt="Deep Clean">
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="bi bi-stars"></i>
                        </div>
                        <h4 class="service-title">Deep Clean</h4>
                        <p class="service-description">Intensive cleaning focusing on neglected areas: skirting boards, behind appliances, descaling and heavy-duty surfaces.</p>
                        <div class="service-price">
                            <span class="price-label">Starting from</span>
                            <span class="price-amount">€70<span class="price-unit">/fixed</span></span>
                        </div>
                        <ul class="service-features">
                            <li><i class="bi bi-check-circle-fill"></i> Full kitchen & bathroom deep clean</li>
                            <li><i class="bi bi-check-circle-fill"></i> Baseboards & window sills</li>
                            <li><i class="bi bi-check-circle-fill"></i> Appliance exterior cleaning</li>
                            <li><i class="bi bi-check-circle-fill"></i> Behind furniture access</li>
                        </ul>
                        <a href="/#hero-section" class="service-btn">Get a Quote <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- End of Tenancy -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1722859179652-f188ed49e484?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="End of Tenancy Clean">
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        <h4 class="service-title">End-of-Tenancy Clean</h4>
                        <p class="service-description">Designed to meet landlord and letting agent expectations to help you secure your deposit back.</p>
                        <div class="service-price">
                            <span class="price-label">Starting from</span>
                            <span class="price-amount">€120<span class="price-unit"></span></span>
                        </div>
                        <ul class="service-features">
                            <li><i class="bi bi-check-circle-fill"></i> Full deep clean of all rooms</li>
                            <li><i class="bi bi-check-circle-fill"></i> Oven & appliance cleaning</li>
                            <li><i class="bi bi-check-circle-fill"></i> Carpet spot cleaning</li>
                            <li><i class="bi bi-check-circle-fill"></i> Deposit-ready guarantee</li>
                        </ul>
                        <a href="/#hero-section" class="service-btn">Get a Quote <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Oven & Appliance -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://plus.unsplash.com/premium_photo-1677683510936-82a2ccd6abb0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8b3ZlbiUyMCUyNiUyMGFwcGxpYW5jZSUyMGNsZWFuaW5nfGVufDB8fDB8fHww" alt="Oven Cleaning">
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="bi bi-fire"></i>
                        </div>
                        <h4 class="service-title">Oven & Appliance Cleaning</h4>
                        <p class="service-description">Professional oven cleaning using safe, eco-friendly degreasers with hand finishing for a spotless result.</p>
                        <div class="service-price">
                            <span class="price-label">Starting from</span>
                            <span class="price-amount">€40<span class="price-unit">/oven</span></span>
                        </div>
                        <ul class="service-features">
                            <li><i class="bi bi-check-circle-fill"></i> Interior oven degrease</li>
                            <li><i class="bi bi-check-circle-fill"></i> Removable trays & racks</li>
                            <li><i class="bi bi-check-circle-fill"></i> Exterior wipe & polish</li>
                            <li><i class="bi bi-check-circle-fill"></i> Safe, non-toxic products</li>
                        </ul>
                        <a href="/#hero-section" class="service-btn">Get a Quote <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Carpet Cleaning -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=600&auto=format&fit=crop&q=80" alt="Carpet Cleaning">
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="bi bi-droplet"></i>
                        </div>
                        <h4 class="service-title">Carpet Cleaning (Steam)</h4>
                        <p class="service-description">Hot water extraction for carpets and rugs to effectively remove stains, odors, and allergens.</p>
                        <div class="service-price">
                            <span class="price-label">Starting from</span>
                            <span class="price-amount">€30<span class="price-unit">/room</span></span>
                        </div>
                        <ul class="service-features">
                            <li><i class="bi bi-check-circle-fill"></i> Pre-treatment & stain removal</li>
                            <li><i class="bi bi-check-circle-fill"></i> Hot water extraction</li>
                            <li><i class="bi bi-check-circle-fill"></i> Allergen elimination</li>
                            <li><i class="bi bi-check-circle-fill"></i> Drying guidance included</li>
                        </ul>
                        <a href="/#hero-section" class="service-btn">Get a Quote <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Office Cleaning -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=600&auto=format&fit=crop&q=80" alt="Office Cleaning">
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <h4 class="service-title">Commercial & Office Cleaning</h4>
                        <p class="service-description">Professional cleaning for offices, commercial spaces, and business premises with flexible scheduling.</p>
                        <div class="service-price">
                            <span class="price-label">Starting from</span>
                            <span class="price-amount">€45<span class="price-unit">/hour</span></span>
                        </div>
                        <ul class="service-features">
                            <li><i class="bi bi-check-circle-fill"></i> After-hours availability</li>
                            <li><i class="bi bi-check-circle-fill"></i> Desk & workspace sanitization</li>
                            <li><i class="bi bi-check-circle-fill"></i> Restroom deep cleaning</li>
                            <li><i class="bi bi-check-circle-fill"></i> Recurring contracts available</li>
                        </ul>
                        <a href="/#hero-section" class="service-btn">Get a Quote <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #FFF9E6, #FAF9F7);">
    <div class="container text-center">
        <h3 class="mb-3" style="color: var(--brand-dark); font-weight: 700;">Need a Custom Quote?</h3>
        <p class="mb-4" style="color: var(--text-color); max-width: 700px; margin: 0 auto;">For exact pricing and availability, enter your postcode on our homepage and request a personalized quote. Additional services available for hoarding, heavy staining, or specialist cleaning needs.</p>
        <a href="/#hero-section" class="btn btn-lg" style="background: var(--brand-gold-200); color: var(--brand-dark); font-weight: 700; padding: 1rem 2.5rem; border-radius: 10px;">Request a Quote <i class="bi bi-arrow-right ms-2"></i></a>
    </div>
</section>
@endsection

@push('styles')
<style>
.service-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(18,18,18,0.08);
    transition: all 0.35s ease;
    border: 1px solid rgba(212,175,55,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}
.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(212,175,55,0.25);
    border-color: rgba(212,175,55,0.3);
}
.service-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}
.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.service-card:hover .service-image img {
    transform: scale(1.1);
}
.service-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--brand-gold-200);
    color: var(--brand-dark);
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(212,175,55,0.3);
}
.service-content {
    padding: 2rem 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.service-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.25));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: var(--brand-gold-200);
    margin-bottom: 1rem;
}
.service-title {
    color: var(--brand-dark);
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 0.75rem;
}
.service-description {
    color: var(--text-color);
    opacity: 0.8;
    margin-bottom: 1.25rem;
    line-height: 1.6;
}
.service-price {
    background: rgba(212,175,55,0.1);
    padding: 1rem;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 1.25rem;
}
.price-label {
    display: block;
    font-size: 0.8rem;
    color: var(--brand-gold-300);
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.price-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--brand-gold-200);
}
.price-unit {
    font-size: 1rem;
    font-weight: 500;
    opacity: 0.8;
}
.service-features {
    list-style: none;
    padding: 0;
    margin-bottom: 1.5rem;
    flex: 1;
}
.service-features li {
    padding: 0.5rem 0;
    color: var(--text-color);
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}
.service-features li i {
    color: var(--brand-gold-200);
    font-size: 1rem;
    margin-top: 0.2rem;
    flex-shrink: 0;
}
.service-btn {
    display: block;
    text-align: center;
    background: var(--brand-gold-200);
    color: var(--brand-dark);
    padding: 0.85rem 1.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
}
.service-btn:hover {
    background: var(--brand-gold-300);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(212,175,55,0.3);
}
</style>
@endpush
