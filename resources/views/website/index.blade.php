@extends('layouts.master')
@section('title', 'Welcome to luxGold - Find Trusted Cleaning Services')
@section('content')
<section id="hero-section" class="hero-section" style="background: linear-gradient(135deg, rgba(250, 249, 247, 0.97) 0%, rgba(255, 255, 255, 0.94) 50%, rgba(250, 249, 247, 0.96) 100%), url('{{ asset('images/luxgold-16.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed; position: relative;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Content -->
            <div class="col-lg-6">
                @if($heroContent)
                <h1 class="hero-title">
                <span class="highlight-orange">{{ $heroContent->title_part1 ?? 'Premium' }}</span><br>
                <span class="highlight-green">{{ $heroContent->title_part2 ?? 'cleaning services' }}</span></h1>
                <p class="mt-3" style="color: rgba(18,18,18,0.65);font-weight: 400;">
                    {{ $heroContent->description ?? 'Find and compare vetted cleaners near you. Book one-time or recurring cleanings with transparent pricing and verified reviews.' }}
                </p>
                @else
                <h1 class="hero-title">
                <span class="highlight-orange">Premium</span><br>
                <span class="highlight-green">cleaning services</span><br>
                <span class="highlight-green">trusted professionals for homes & businesses.</span>
                </h1>
                <p class="mt-3" style="color: rgba(18,18,18,0.65);font-weight: 400;">
                    Find and compare vetted cleaners near you. Book one-time or recurring cleanings with transparent pricing and verified reviews.
                </p>
                @endif
                <!-- Eircode quick box to start a general hire request -->
                <div class="mt-4">
                    <div class="quote-request-box">
                        <div class="quote-box-header mb-3">
                            <h5 class="quote-title mb-1">Get Your Free Quote</h5>
                            <p class="quote-subtitle mb-0">Enter your Eircode and we'll connect you with vetted cleaners</p>
                        </div>
                        <div class="input-group-modern">
                            <div class="input-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <input id="heroEircodeInput" class="form-control-modern" placeholder="Enter your Eircode (e.g., D02 XY45)">
                            <button id="heroQuoteBtn" type="button" class="btn-modern-primary">
                                <i class="bi bi-lightning-charge-fill me-2"></i>Get Quote
                            </button>
                        </div>
                        <div id="heroEircodeError" class="error-message mt-2" style="display:none;"></div>
                        <div class="trust-badges mt-3">
                            <span class="trust-badge"><i class="bi bi-shield-check me-1"></i>Vetted Cleaners</span>
                            <span class="trust-badge"><i class="bi bi-clock me-1"></i>Quick Response</span>
                            <span class="trust-badge"><i class="bi bi-star-fill me-1"></i>Top Rated</span>
                        </div>
                    </div>
                </div>
                <!-- Search Box -->
                <div class="search-box">
                    <form action="{{ route('website.find-cleaner') }}" class="row g-2">
                        <div class="col-md-6">
                            <div class="input-group-div">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search" placeholder="What service do you need?">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-div green">
                                <i class="bi bi-geo-alt"></i>
                                <input type="text" name="location" placeholder="Where do you need?">
                            </div>
                        </div>
                        <div class="col-md-12">
                                                     <button type="submit" class="search-provider_btn btn btn-success">
    <i class="bi bi-lightning-charge-fill me-1"></i>
    Search Cleaners
    <i class="bi bi-chevron-right ms-1"></i>
</button>

                        </div>
                    </form>
                </div>
                <!-- Stats -->
                    <div class="d-flex gap-4 mt-4 stats-box">
                    <div style="background-color: #fff">
                        <h4 style="color: var(--brand-gold-200)">{{ $totalProvider ?? '500' }}+</h4>
                        <p style="color: var(--brand-gold-200)">Cleaners</p>
                    </div>
                    <div style="background-color: #fff">
                        <h4 style="color: var(--brand-gold-200)">{{ $avgRating??0 }}</h4>
                        <p style="color: var(--brand-gold-200)">Avg Rating</p>
                    </div>
                    <div style="background-color: #fff">
                        <h4 style="color: var(--brand-gold-200)">{{ $heroContent->support_text ?? '24/7' }}</h4>
                        <p style="color: var(--brand-gold-200)">Support</p>
                    </div>
                </div>
            </div>
            <!-- Right Images -->
            <div class="col-lg-6 d-flex justify-content-center mt-5 mt-lg-0">
                <div class="hero-images-grid">
                    <div class="hero-img-item hero-img-main">
                        <img src="{{ asset('images/luxgold-02.jpeg') }}" alt="Professional Cleaning Service">
                    </div>
                    <div class="hero-img-item hero-img-secondary">
                        <img src="{{ asset('images/luxgold-03.jpeg') }}" alt="Deep Cleaning">
                    </div>
                    <div class="hero-img-item hero-img-secondary">
                        <img src="{{ asset('images/luxgold-04.jpeg') }}" alt="Home Cleaning">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.hire_request_modal')

    @push('styles')
    <style>
    /* Quote Request Box - Hero Section */
    .quote-request-box {
        max-width: 720px;
        background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(250,249,247,0.95) 100%);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 20px 60px rgba(212,175,55,0.15), 0 0 0 1px rgba(212,175,55,0.1);
        border: 2px solid rgba(212,175,55,0.2);
        backdrop-filter: blur(10px);
    }
    .quote-box-header {
        text-align: center;
    }
    .quote-title {
        color: var(--brand-dark);
        font-weight: 700;
        font-size: 1.3rem;
        margin: 0;
    }
    .quote-subtitle {
        color: var(--text-color);
        opacity: 0.75;
        font-size: 0.95rem;
    }
    .input-group-modern {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(18,18,18,0.08);
        overflow: hidden;
        border: 2px solid rgba(212,175,55,0.15);
        transition: all 0.3s ease;
    }
    .input-group-modern:focus-within {
        border-color: var(--brand-gold-200);
        box-shadow: 0 12px 32px rgba(212,175,55,0.25);
        transform: translateY(-2px);
    }
    .input-icon {
        padding: 0 1.25rem;
        color: var(--brand-gold-200);
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        background: rgba(212,175,55,0.08);
    }
    .form-control-modern {
        flex: 1;
        border: none;
        padding: 1.25rem 1rem;
        font-size: 1.05rem;
        color: var(--brand-dark);
        background: transparent;
        outline: none;
    }
    .form-control-modern::placeholder {
        color: #94a3b8;
    }
    .btn-modern-primary {
        background: linear-gradient(135deg, var(--brand-gold-200), var(--brand-gold-300));
        color: white;
        border: none;
        padding: 1.25rem 2rem;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }
    .btn-modern-primary:hover {
        background: linear-gradient(135deg, var(--brand-gold-300), var(--brand-gold-200));
        box-shadow: 0 8px 24px rgba(212,175,55,0.4);
        transform: translateX(4px);
    }
    .error-message {
        color: #dc2626;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        background: rgba(220,38,38,0.1);
        border-radius: 8px;
        border-left: 3px solid #dc2626;
    }
    .trust-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
    }
    .trust-badge {
        background: rgba(212,175,55,0.1);
        color: var(--brand-gold-300);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .trust-badge i {
        color: var(--brand-gold-200);
    }

    /* CTA Quote Box */
    .cta-quote-box {
        max-width: 800px;
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 24px 80px rgba(212,175,55,0.2);
        border: 2px solid rgba(212,175,55,0.2);
    }
    .quote-box-header-cta {
        text-align: center;
    }
    .quote-title-cta {
        color: var(--brand-dark);
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .quote-title-cta i {
        color: var(--brand-gold-200);
    }
    .quote-subtitle-cta {
        color: var(--text-color);
        opacity: 0.75;
        font-size: 1rem;
    }
    .input-group-modern-cta {
        display: flex;
        align-items: center;
        background: #FAF9F7;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(18,18,18,0.08);
        overflow: hidden;
        border: 2px solid rgba(212,175,55,0.2);
        transition: all 0.3s ease;
    }
    .input-group-modern-cta:focus-within {
        border-color: var(--brand-gold-200);
        box-shadow: 0 12px 40px rgba(212,175,55,0.3);
        transform: translateY(-2px);
    }
    .input-icon-cta {
        padding: 0 1.5rem;
        color: var(--brand-gold-200);
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        background: rgba(212,175,55,0.12);
    }
    .form-control-modern-cta {
        flex: 1;
        border: none;
        padding: 1.4rem 1rem;
        font-size: 1.1rem;
        color: var(--brand-dark);
        background: transparent;
        outline: none;
        font-weight: 500;
    }
    .form-control-modern-cta::placeholder {
        color: #94a3b8;
    }
    .btn-modern-primary-cta {
        background: linear-gradient(135deg, var(--brand-gold-200), var(--brand-gold-300));
        color: white;
        border: none;
        padding: 1.4rem 2.5rem;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }
    .btn-modern-primary-cta:hover {
        background: linear-gradient(135deg, var(--brand-gold-300), #b8860b);
        box-shadow: 0 8px 32px rgba(212,175,55,0.5);
        transform: scale(1.02);
    }
    .error-message-cta {
        color: #dc2626;
        font-size: 0.95rem;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        background: rgba(220,38,38,0.1);
        border-radius: 10px;
        border-left: 4px solid #dc2626;
    }
    .trust-badges-cta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
    }
    .trust-badge-cta {
        background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.08));
        color: var(--brand-gold-300);
        padding: 0.6rem 1.2rem;
        border-radius: 24px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(212,175,55,0.2);
    }
    .trust-badge-cta i {
        color: var(--brand-gold-200);
    }

    @media (max-width: 768px) {
        .quote-request-box {
            padding: 1.5rem;
        }
        .input-group-modern, .input-group-modern-cta {
            flex-direction: column;
        }
        .input-icon, .input-icon-cta {
            width: 100%;
            padding: 1rem;
            justify-content: center;
        }
        .form-control-modern, .form-control-modern-cta {
            padding: 1rem;
            text-align: center;
        }
        .btn-modern-primary, .btn-modern-primary-cta {
            width: 100%;
            justify-content: center;
            padding: 1rem 2rem;
        }
        .cta-quote-box {
            padding: 1.5rem;
        }
        .quote-title-cta {
            font-size: 1.3rem;
        }
        .trust-badges, .trust-badges-cta {
            justify-content: center;
        }
    }

    /* Hero Images Grid */
    .hero-images-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 240px 240px;
        gap: 1.25rem;
        width: 100%;
        max-width: 550px;
    }
    .hero-img-item {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(18,18,18,0.12);
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        position: relative;
    }
    .hero-img-item:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 50px rgba(212,175,55,0.25);
        z-index: 2;
    }
    .hero-img-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .hero-img-main {
        grid-column: 1 / 2;
        grid-row: 1 / 3;
    }
    .hero-img-secondary {
        grid-column: 2 / 3;
    }
    @media (max-width: 991px) {
        .hero-images-grid {
            grid-template-rows: 200px 200px;
            max-width: 450px;
            margin: 0 auto;
        }
    }
    @media (max-width: 576px) {
        .hero-images-grid {
            grid-template-columns: 1fr;
            grid-template-rows: 250px 200px 200px;
            gap: 1rem;
        }
        .hero-img-main, .hero-img-secondary {
            grid-column: 1;
            grid-row: auto;
        }
    }

    .eircode-hero-box .input-group {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(16,24,40,0.12);
        background: linear-gradient(180deg, #ffffff 0%, #f7fbfa 100%);
        border: 1px solid rgba(212,175,55,0.12); /* subtle gold ring */
    }
    .eircode-hero-box .input-group-text {
        background: transparent;
        border: none;
        color: var(--brand-dark);
        padding: 0 1rem;
        font-size: 1.1rem;
    }
    .eircode-hero-box .form-control {
        border: none;
        padding: 1.25rem 1rem;
        font-size: 1.05rem;
        background: transparent;
        color: var(--brand-dark);
    }
    .eircode-hero-box .form-control::placeholder { color: #94a3b8; }
    .eircode-hero-box .btn {
        padding: 0.85rem 1.6rem;
        font-weight:700;
        background: var(--brand-gold-200);
        border: 2px solid rgba(18,18,18,0.06);
        color: var(--brand-dark);
        border-radius: 0; /* keep sharp to match group */
    }
    /* Focus state */
    .eircode-hero-box .form-control:focus { outline: none; box-shadow: none; }
    .eircode-hero-box:focus-within { box-shadow: 0 22px 60px rgba(212,175,55,0.12); border-color: rgba(212,175,55,0.18); }

    @media (max-width: 767px) {
        .eircode-hero-box .input-group { flex-direction: row; }
        .eircode-hero-box .btn { padding: 0.75rem 1rem; }
    }

    /* City icon styles: make image fill the circle and crop nicely */
    .city-icon-container {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.06);
    }
    .city-icon {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Gallery Section Styles */
    .luxgold-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .gallery-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(18,18,18,0.08);
        transition: all 0.35s ease;
        height: 320px;
        width: 100%;
    }
    .gallery-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(212,175,55,0.25);
        z-index: 10;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .gallery-item:hover img {
        transform: scale(1.08);
    }
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(18,18,18,0.9) 0%, rgba(18,18,18,0.4) 70%, transparent 100%);
        padding: 2rem 1.5rem 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-overlay h5 {
        color: var(--brand-gold-200);
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    @media (max-width: 992px) {
        .luxgold-gallery {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
        .gallery-item {
            height: 280px;
        }
    }
    @media (max-width: 576px) {
        .luxgold-gallery {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .gallery-item {
            height: 300px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Homepage Eircode -> open generic hire request modal
document.getElementById('heroQuoteBtn')?.addEventListener('click', function(){
    const value = document.getElementById('heroEircodeInput').value.trim();
    const errorEl = document.getElementById('heroEircodeError');
    errorEl.style.display = 'none';
    if(!value){ errorEl.textContent = 'Please enter an Eircode'; errorEl.style.display='block'; return; }

    fetch('{{ route('check.eircode') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json' },
        body: JSON.stringify({ eircode: value })
    })
    .then(r=>r.json())
    .then(data=>{
        if(data && data.valid){
            // Safely pick the normalized eircode value (controller may return `eircode`)
            const normalized = data.normalized || data.eircode || data.eircode_normalized || null;
            const zipEl = document.getElementById('hr_zip_code');
            if(zipEl && normalized) zipEl.value = normalized;

            // Fill either the legacy fields or the checkout-specific fields if present
            const email = '{{ Auth::check() ? Auth::user()->email : '' }}';
            const name = '{{ Auth::check() ? Auth::user()->first_name : '' }}';
            const hrEmail = document.getElementById('hr_email');
            const hrName = document.getElementById('hr_name');
            const hrCheckoutEmail = document.getElementById('hr_checkout_email');
            const hrCheckoutName = document.getElementById('hr_checkout_name');
            if(email){ if(hrEmail) hrEmail.value = email; if(hrCheckoutEmail) hrCheckoutEmail.value = email; }
            if(name){ if(hrName) hrName.value = name; if(hrCheckoutName) hrCheckoutName.value = name; }

            const modal = new bootstrap.Modal(document.getElementById('hireRequestModal'));
            modal.show();
        } else {
            errorEl.textContent = (data && data.message) ? data.message : 'Invalid Eircode'; errorEl.style.display='block';
        }
    })
    .catch(err=>{ console.error(err); errorEl.textContent='Error checking Eircode'; errorEl.style.display='block'; });
});

// Reuse modal submit handler if not present (defensive)
document.getElementById('hr_submitBtn')?.addEventListener('click', function(){
    const btn = this; btn.disabled = true; const original = btn.innerHTML; btn.innerHTML = 'Sending...';
    const payload = new FormData(document.getElementById('hireRequestForm'));
    const date = document.getElementById('hr_preferred_date')?.value;
    const time = document.getElementById('hr_preferred_time')?.value;
    if(date && time){ payload.append('scheduled_at', date + ' ' + time); }

    fetch('{{ route('hire-requests.store') }}', { method: 'POST', body: payload, headers: { 'Accept':'application/json' } })
    .then(r=>r.json())
    .then(data=>{
        if(data.success){
            const modal = bootstrap.Modal.getInstance(document.getElementById('hireRequestModal'));
            if(modal) modal.hide();
            alert('Request sent — the admin will assign a cleaner and get back to you.');
        } else {
            document.getElementById('hr_formErrors').textContent = data.message || 'Failed to send';
        }
    })
    .catch(err=>{ console.error(err); document.getElementById('hr_formErrors').textContent = 'Error sending request'; })
    .finally(()=>{ btn.disabled = false; btn.innerHTML = original; });
});

// CTA section Quote Me handler: use CTA Eircode input, validate, and open hire request modal
document.getElementById('ctaQuoteBtn')?.addEventListener('click', function(){
    const input = document.getElementById('ctaEircodeInput');
    const value = input ? input.value.trim() : '';
    const errorEl = document.getElementById('ctaEircodeError') || document.getElementById('heroEircodeError');
    if(errorEl) { errorEl.style.display = 'none'; }
    if(!value){ if(errorEl){ errorEl.textContent = 'Please enter an Eircode'; errorEl.style.display='block'; } return; }

    fetch('{{ route('check.eircode') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json' },
        body: JSON.stringify({ eircode: value })
    })
    .then(r=>r.json())
    .then(data=>{
        if(data && data.valid){
            const normalized = data.normalized || data.eircode || data.eircode_normalized || null;
            const zipEl = document.getElementById('hr_zip_code');
            if(zipEl && normalized) zipEl.value = normalized;

            // Prefill if possible
            const email = '{{ Auth::check() ? Auth::user()->email : '' }}';
            const name = '{{ Auth::check() ? Auth::user()->first_name : '' }}';
            const hrEmail = document.getElementById('hr_email');
            const hrName = document.getElementById('hr_name');
            const hrCheckoutEmail = document.getElementById('hr_checkout_email');
            const hrCheckoutName = document.getElementById('hr_checkout_name');
            if(email){ if(hrEmail) hrEmail.value = email; if(hrCheckoutEmail) hrCheckoutEmail.value = email; }
            if(name){ if(hrName) hrName.value = name; if(hrCheckoutName) hrCheckoutName.value = name; }

            const modal = new bootstrap.Modal(document.getElementById('hireRequestModal'));
            modal.show();
        } else {
            if(errorEl){ errorEl.textContent = (data && data.message) ? data.message : 'Invalid Eircode'; errorEl.style.display='block'; }
            else alert((data && data.message) ? data.message : 'Invalid Eircode');
        }
    })
    .catch(err=>{ console.error(err); if(errorEl){ errorEl.textContent='Error checking Eircode'; errorEl.style.display='block'; } else alert('Error checking Eircode'); });
});

// Open hire request modal and prefill with selected city (from city cards)
function openHireModalWithCity(cityName){
    try{
        const zipEl = document.getElementById('hr_zip_code');
        const cityEls = [
            document.getElementById('hr_city'),
            document.getElementById('hr_location'),
            document.getElementById('hr_address')
        ];
        if(zipEl) zipEl.value = cityName;
        for(const el of cityEls){ if(el) el.value = cityName; }

        // Prefill email/name if available
        const email = '{{ Auth::check() ? Auth::user()->email : '' }}';
        const name = '{{ Auth::check() ? Auth::user()->first_name : '' }}';
        if(email){ if(document.getElementById('hr_email')) document.getElementById('hr_email').value = email; if(document.getElementById('hr_checkout_email')) document.getElementById('hr_checkout_email').value = email; }
        if(name){ if(document.getElementById('hr_name')) document.getElementById('hr_name').value = name; if(document.getElementById('hr_checkout_name')) document.getElementById('hr_checkout_name').value = name; }

        const modalEl = document.getElementById('hireRequestModal');
        if(modalEl){ const modal = new bootstrap.Modal(modalEl); modal.show(); }
        else { console.warn('hireRequestModal not found'); }
    }catch(err){ console.error('openHireModalWithCity error', err); }
}
</script>
@endpush

<section class="second-section">
    <div class="container">
        
    <h3>Meet our best Cleaners</h3>
    <p class="tagline">Discover some of our highest-rated cleaning professionals trusted by customers in your community</p>
    <div class="row g-4 mt-4">
        <!-- Card 1 -->
        @foreach($providers as $provider)
        @php
        // Calculate average rating and review count
        $reviews = $provider->reviews()->where('status', 'approved')->get();
        $averageRating = $reviews->avg('rating');
        $reviewCount = $reviews->count();
        
        // Get provider category name
        $category = $provider->category;
        
        // Parse service categories if available
        $serviceCategories = $provider->service_categories ?? [];
        $firstCategory = !empty($serviceCategories) ? $serviceCategories[0] : ($category ?: 'Cleaner');
        
        // Parse special features for tags (diversity badges removed from public lists)
        $specialFeatures = $provider->special_features ?? [];

        // Combine tags from various sources
        $allTags = $specialFeatures;
        $displayTags = array_slice($allTags, 0, 4); // Show max 4 tags
        $remainingTags = count($allTags) - count($displayTags);
        
        // Get pricing information
        $priceDisplay = $provider->price_amount ? '$' . number_format($provider->price_amount, 0) : 'Contact for pricing';
        $pricingDescription = $provider->pricing_description ?: 'Price varies';
        
        // Get availability information
        $availableDays = $provider->available_days ?? [];
        $startTime = $provider->start_time ? \Carbon\Carbon::parse($provider->start_time)->format('g:i A') : 'N/A';
        $endTime = $provider->end_time ? \Carbon\Carbon::parse($provider->end_time)->format('g:i A') : 'N/A';
        $hoursDisplay = $startTime . ' - ' . $endTime;
        
        // Age group information
        $ageGroup = $provider->age_group ?: 'Contact for ages';
        @endphp
        <div class="col-md-4">
            <div class="program-card position-relative">
                @if(!empty($provider->logo_path))
                <img class="provider-media" src="{{ asset($provider->logo_path) }}" alt="{{ $provider->name }}">
                @else
                <div class="provider-media placeholder-media">
                    <i class="ti ti-building-store"></i>
                </div>
                @endif
                @if($firstCategory)
                <div class="card-badge">{{ $firstCategory }}</div>
                @endif
                <div class="card-body">
                    <div class="program-title">  {{ $provider->name }}
                        @if($provider->status === 'approved')
                        <i style="color:#00bfa6" class="ms-1 bi bi-check2-circle"></i>
                    @endif</div>
                    @if($averageRating)
                    <div class="rating rating-text">
                        <i class="bi bi-star-fill"></i>
                        {{ number_format($averageRating, 1) }}
                        @if($reviewCount > 0)
                        ({{ $reviewCount }})
                        @endif
                    </div>
                    @else
                    <div class="rating rating-text text-muted">
                        <i class="bi bi-star"></i>
                        No reviews yet
                    </div>
                    @endif
                    @if($provider->physical_address)
                    <div class="info small-muted">
                        <i class="bi bi-geo-alt"></i>
                        {{ \Illuminate\Support\Str::limit($provider->physical_address, 30) }}
                    </div>
                    @endif
                    @if($provider->start_time && $provider->end_time)
                    <div class="info small-muted">
                        <i class="bi bi-clock"></i>
                        {{ $hoursDisplay }}
                    </div>
                    @endif
                    @if($provider->price_amount)
                    <div class="info small-muted">
                        <i class="bi bi-currency-dollar"></i>
                        {{ $priceDisplay }}
                        @if($provider->pricing_description)
                        <small>({{ $provider->pricing_description }})</small>
                        @endif
                    </div>
                    @endif
                    @if($ageGroup)
                    <div class="info">
                        Ages: <b class="ageText-class">{{ $ageGroup }}</b>
                    </div>
                    @endif
                    
                    @if(!empty($displayTags))
                    <div class="tags">
                        @foreach($displayTags as $tag)
                        <div class="tag tag-gray">{{ ucfirst($tag) }}</div>
                        @endforeach
                        
                        @if($remainingTags > 0)
                        <div class="tag tag-gray">+{{ $remainingTags }} more</div>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a class="btn-view" href="{{ route('website.cleaner-detail', $provider->id) }}">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
        <div class="d-flex justify-content-center align-items-center">
        <button class="view-all-providers_btn" onclick="window.location.href='{{ route('website.find-cleaner') }}'">View All Cleaners <i class="bi bi-chevron-right"></i></button>
    </div>
        </div>

</section>


<!-- Categories Section (Keeping Static as requested) -->
<section class="third-section">
    <div class="container">
        <h3>Services we provide</h3>
        <p class="tagline">From early learning to wellness services, find everything your family needs in one place</p>
        <div class="row g-4 mt-4">
            @foreach($categories as $category)
            @if($category->customer_id === null) <!-- Only show main categories -->
            <div class="col-md-4">
                <div class="edu-card position-relative">
                    <!-- Category Image -->
                    <img src="{{ $category->image_url ?? 'https://images.unsplash.com/photo-1650504148053-ae51b12dc1d4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080' }}" alt="{{ $category->name }}">
                    
                    <!-- Providers Count Badge -->
                    <div class="edu-badge">{{ $category->totalCleaners() }}+ Cleaners</div>
                    
                    <div class="edu-body">
                        <!-- Category Icon -->
                        <div class="edu-icon">
                            @if($category->icon)
                            <i class="{{ $category->icon }}"></i>
                            @else
                            <!-- Fallback icons based on category name -->
                            @if(str_contains(strtolower($category->name), 'learning') || str_contains(strtolower($category->name), 'care'))
                            <i class="bi bi-people-fill"></i>
                            @elseif(str_contains(strtolower($category->name), 'school') || str_contains(strtolower($category->name), 'education'))
                            <i class="bi bi-mortarboard-fill"></i>
                            @elseif(str_contains(strtolower($category->name), 'tutoring') || str_contains(strtolower($category->name), 'after'))
                            <i class="bi bi-journal-text"></i>
                            @elseif(str_contains(strtolower($category->name), 'wellness') || str_contains(strtolower($category->name), 'health'))
                            <i class="bi bi-heart-pulse"></i>
                            @elseif(str_contains(strtolower($category->name), 'event') || str_contains(strtolower($category->name), 'activity'))
                            <i class="bi bi-lightbulb"></i>
                            @else
                            <i class="bi bi-grid"></i>
                            @endif
                            @endif
                        </div>
                        
                        <!-- Category Title -->
                        <div class="edu-title">{{ $category->name }}</div>
                        
                        <!-- Category Subtitle -->
                        <div class="edu-subtitle">{{ $category->subtitle ?? 'Discover amazing services' }}</div>
                        
                        <!-- Category Description -->
                        <div class="edu-desc">{{ $category->description ?? 'Find trusted cleaners for your home and business needs.' }}</div>
                        
                        <!-- Category Tags -->
                        @if($category->tags && count($category->tags) > 0)
                        <div class="edu-tags">
                            @foreach(array_slice($category->tags, 0, 3) as $tag)
                            <div class="edu-tag">{{ $tag }}</div>
                            @endforeach
                            @if(count($category->tags) > 3)
                            <div class="edu-tag">+{{ count($category->tags) - 3 }} more</div>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Explore Providers Link -->
                        <div onclick="window.location.href='{{ route('website.find-cleaner', ['category' => $category->id]) }}'" class="edu-footer">
                            Explore cleaners <i class="bi bi-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>



<!-- Featured Providers Section (Keeping Static as requested) -->

<!-- Cities Section - Dynamic -->
<section class="forth-section py-5 bg-light">
    <div class="container">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <h3 class="mb-1">Now Serving These Cities</h3>
                <p class="tagline mb-0">luxGold connects customers with trusted cleaning professionals across Ireland.</p>
            </div>
            <div class="text-end">
                <a href="{{ route('website.locations') }}" class="btn btn-outline-secondary btn-sm">View all locations</a>
            </div>
        </div>

        @if($cities->count() > 0)
        <div class="row g-3">
            @foreach($cities->where('is_coming_soon', false)->take(12) as $city)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 city-icon-container">
                                <img src="{{ $city->icon_url }}" alt="{{ $city->name }}" class="city-icon">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $city->name }}</h5>
                                {{-- <small class="text-muted">{{ $city->state }}</small> --}}
                            </div>
                        </div>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="badge bg-primary">{{ $city->cleaners_count ?? $city->totalCleaner() }} cleaners</span>
                                </div>
                                <div class="text-muted small">{{ $city->families_count ?? 0 }}+ customers</div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('website.find-cleaner', ['city' => $city->name]) }}" class="btn btn-sm btn-outline-primary">View Cleaners</a>
                                <button type="button" class="btn btn-sm btn-primary" onclick="openHireModalWithCity({{ json_encode($city->name) }})">Request Service</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-secondary">No locations available yet. Please check back soon or contact us to request service in your area.</div>
        @endif

        @if($cities->where('is_coming_soon', true)->count() > 0)
        <div class="mt-4">
            <h6 class="mb-2">Launching Soon</h6>
            <div class="row g-3">
                @foreach($cities->where('is_coming_soon', true)->take(6) as $city)
                <div class="col-md-3 col-sm-4">
                    <div class="d-flex align-items-center gap-3 p-2 border rounded">
                        <img src="{{ $city->icon_url }}" alt="{{ $city->name }}" width="36" height="36">
                        <div>
                            <div class="fw-semibold">{{ $city->name }}</div>
                            <div class="small text-muted">Launching soon</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>
<!-- How It Works Section - Dynamic -->
<section class="fifth-section" id="how-it-works-section">
    <div class="container">
        <h3>How it Works – Customers</h3>
        <p class="tagline">Request a cleaner in three simple steps</p>
        <div class="row justify-content-center mt-5">
            <!-- Step 1: Choose Service -->
            <div class="col-md-4">
                <div class="how-it-works-card">
                    <div class="how-it-works-icon-wrapper">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <h3 class="how-it-works-title">Choose Your Service</h3>
                    <p class="how-it-works-description">
                        Pick the cleaning service you need (regular clean, deep clean, oven, carpet, etc.), enter your postcode or city, and request a quote.
                    </p>
                </div>
            </div>

            <!-- Step 2: Assignment & Service -->
            <div class="col-md-4">
                <div class="how-it-works-card">
                    <div class="how-it-works-icon-wrapper">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="how-it-works-title">We Assign Cleaners</h3>
                    <p class="how-it-works-description">
                        Our team assigns available, vetted cleaners to your request and they will complete the job at the scheduled time.
                    </p>
                </div>
            </div>

            <!-- Step 3: Rate & Review -->
            <div class="col-md-4">
                <div class="how-it-works-card">
                    <div class="how-it-works-icon-wrapper">
                        <i class="bi bi-star"></i>
                    </div>
                    <h3 class="how-it-works-title">Rate &amp; Review</h3>
                    <p class="how-it-works-description">
                        After the service, search for your cleaner on the "Find Cleaners" page and leave a rating and review to help others choose with confidence.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose LuxGold Section -->
<section class="why-choose-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h3>Why Choose luxGold Cleaning Services</h3>
            <p class="tagline">Trusted, vetted cleaners and transparent service designed for busy homes and businesses.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center border rounded">
                    <div class="feature-icon mb-3"><i class="bi bi-shield-check" style="font-size:1.6rem;color:#0b7285"></i></div>
                    <h5 class="mb-2">Vetted & Garda-Checked</h5>
                    <p class="small text-muted mb-0">All cleaners are identity-checked, background screened and verified to give you peace of mind.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center border rounded">
                    <div class="feature-icon mb-3"><i class="bi bi-currency-pound" style="font-size:1.6rem;color:#0b7285"></i></div>
                    <h5 class="mb-2">Transparent Pricing</h5>
                    <p class="small text-muted mb-0">Clear, upfront pricing and easy quotes so there are no surprises after the job is done.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center border rounded">
                    <div class="feature-icon mb-3"><i class="bi bi-calendar-check" style="font-size:1.6rem;color:#0b7285"></i></div>
                    <h5 class="mb-2">Flexible Scheduling</h5>
                    <p class="small text-muted mb-0">Book one-off, recurring, or same-day cleans — manage bookings easily through your dashboard.</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-3">
            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center border rounded">
                    <div class="feature-icon mb-3"><i class="bi bi-journal-check" style="font-size:1.6rem;color:#0b7285"></i></div>
                    <h5 class="mb-2">Satisfaction Guarantee</h5>
                    <p class="small text-muted mb-0">If something isn’t right, tell us and we’ll make it right—customer satisfaction is our priority.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center border rounded">
                    <div class="feature-icon mb-3"><i class="bi bi-droplet" style="font-size:1.6rem;color:#0b7285"></i></div>
                    <h5 class="mb-2">Eco-Friendly Options</h5>
                    <p class="small text-muted mb-0">Choose cleaners who use non-toxic and biodegradable products for a healthier home.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center border rounded">
                    <div class="feature-icon mb-3"><i class="bi bi-headset" style="font-size:1.6rem;color:#0b7285"></i></div>
                    <h5 class="mb-2">Local Support</h5>
                    <p class="small text-muted mb-0">Regional support teams to help with booking, changes, and any post-job follow-up.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Gallery Section -->
<section class="gallery-section py-5" style="background: linear-gradient(180deg, #FAF9F7 0%, #FFFFFF 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h3>Our Premium Cleaning Services</h3>
            <p class="tagline">Delivering excellence in every detail - see our professional cleaning in action</p>
        </div>
        <div class="luxgold-gallery">
            <!-- Row 1 -->
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-19.jpeg') }}" alt="Professional Cleaning Service">
                <div class="gallery-overlay">
                    <h5>Professional Excellence</h5>
                </div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-20.jpeg') }}" alt="Deep Cleaning">
                <div class="gallery-overlay">
                    <h5>Deep Cleaning</h5>
                </div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-08.jpeg') }}" alt="Home Cleaning">
                <div class="gallery-overlay">
                    <h5>Kitchen Clean</h5>
                </div>
            </div>
            <!-- Row 2 -->
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-16.jpeg') }}" alt="Office Cleaning">
                <div class="gallery-overlay">
                    <h5>Office Spaces</h5>
                </div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-10.jpeg') }}" alt="Sanitization Service">
                <div class="gallery-overlay">
                    <h5>Sanitization</h5>
                </div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-05.jpeg') }}" alt="Detail Cleaning">
                <div class="gallery-overlay">
                    <h5>Detail Work</h5>
                </div>
            </div>
            <!-- Row 3 -->
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-07.jpeg') }}" alt="Kitchen Cleaning">
                <div class="gallery-overlay">
                    <h5>Home Care</h5>
                </div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-13.jpeg') }}" alt="Bathroom Cleaning">
                <div class="gallery-overlay">
                    <h5>Bathroom Care</h5>
                </div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('images/luxgold-19.jpeg') }}" alt="Window Cleaning">
                <div class="gallery-overlay">
                    <h5>Windows</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Provider Section - Dynamic -->
<section class="sixth-section">
    <div class="container">
        <div class="tag tag-red mb-4" style="width: fit-content;margin: 0 auto;">
            For Cleaners
        </div>
        <h3>
        Are you a Cleaner? Join luxGold
        </h3>
        <p class="tagline">Join thousands of cleaners who trust luxGold to connect with customers in their community.
        Stand out where customers are actively looking and grow your business.</p>
        <div class="d-flex justify-content-center align-items-center">
           @if(Auth::user()) <a href="{{ route('cleaner-home') }}" class="p1-button">Become a cleaner - Free <i
            class="bi bi-chevron-right ms-1"></i></a> @else <button class="p1-button" onclick="openServiceProviderModal()" >Become a cleaner - Free <i
            class="bi bi-chevron-right ms-1"></i></button> @endif
        </div>
    </div>
</section>
<!-- Resources Section - Dynamic -->
<section class="seventh-section container">
    <h3>Customer Resources</h3>
    <p class="tagline">Expert advice, tips, and insights to help you get the most from cleaning services</p>
    <div class="row g-3 mt-4">
        @if($resources->count() > 0)
        @foreach($resources->take(3) as $resource)
        <div class="col-md-4">
            <div class="custom-card">
                <div class="custom-card-image">
                    <img src="{{ $resource->image_url }}" alt="{{ $resource->title }}">
                </div>
                <div class="custom-card-body">
                    <h3 class="custom-card-title">{{ $resource->title }}</h3>
                    <p class="custom-card-text">{{ $resource->description }}</p>
                    <a href="{{ route('website.resource',$resource->slug) }}" class="custom-card-link">
                        Read More <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <!-- Fallback static resources -->
        <div class="col-md-4">
            <div class="custom-card">
                <div class="custom-card-image">
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhZnRlcnNjaG9vbCUyMGFjdGl2aXRpZXN8ZW58MXx8fHwxNzU2MTcwNTU5fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" alt="Daycare">
                </div>
                <div class="custom-card-body">
                    <h3 class="custom-card-title">Choosing the Right Daycare: A Customer's Guide</h3>
                    <p class="custom-card-text">Essential tips and questions to ask when selecting a cleaner or cleaning service for your home.</p>
                    <a href="#" class="custom-card-link">Read More <i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <!-- Add more fallback resources as needed -->
        @endif
    </div>
</section>
<!-- Testimonials Section - Dynamic -->
<section class="testimonial-section">
    <div class="container">
        <h3>Customer Testimonials</h3>
        <p class="tagline">See what customers in your community are saying about luxGold</p>
        <div class="row g-4 mt-4">
            @if($testimonials->count() > 0)
            @foreach($testimonials->take(3) as $testimonial)
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}">
                        </div>
                        <div>
                            <p class="testimonial-name">{{ $testimonial->name }}</p>
                            <p class="testimonial-location">{{ $testimonial->location }}</p>
                        </div>
                    </div>
                    <div class="testimonial-stars">
                        {{ $testimonial->star_rating }}
                    </div>
                    <p class="testimonial-text">"{{ $testimonial->content }}"</p>
                </div>
            </div>
            @endforeach
            @else
            <!-- Fallback static testimonials -->
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            <img src="https://via.placeholder.com/100x100?text=Img" alt="Sarah Johnson">
                        </div>
                        <div>
                            <p class="testimonial-name">Sarah Johnson</p>
                            <p class="testimonial-location">Frisco, TX</p>
                        </div>
                    </div>
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"luxGold made finding the perfect cleaner so much easier. The verified cleaners and detailed reviews gave me confidence in my choice."</p>
                </div>
            </div>
            <!-- Add more fallback testimonials as needed -->
            @endif
        </div>
    </div>
</section>
<!-- CTA Section - Dynamic -->
<section class="cta-section">
    <div class="container">
        <h3>Ready to find the perfect cleaner for your<br> home or business?</h3>
        <p class="tagline">
            Join thousands of customers who trust luxGold to connect with trusted cleaning professionals
            in their community.
        </p>
        <div class="cta-quote-box mx-auto">
            <div class="quote-box-header-cta mb-3">
                <h5 class="quote-title-cta mb-1"><i class="bi bi-star-fill me-2"></i>Request Your Free Quote</h5>
                <p class="quote-subtitle-cta mb-0">Enter your Eircode and get matched with professional cleaners in minutes</p>
            </div>
            <div class="input-group-modern-cta">
                <div class="input-icon-cta">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <input id="ctaEircodeInput" class="form-control-modern-cta" placeholder="Enter your Eircode (e.g., D02 XY45)">
                <button id="ctaQuoteBtn" type="button" class="btn-modern-primary-cta">
                    <i class="bi bi-lightning-charge-fill me-2"></i>Get Free Quote
                </button>
            </div>
            <div id="ctaEircodeError" class="error-message-cta mt-2" style="display:none;"></div>
            <div class="trust-badges-cta mt-3">
                <span class="trust-badge-cta"><i class="bi bi-shield-check me-1"></i>100% Verified</span>
                <span class="trust-badge-cta"><i class="bi bi-clock me-1"></i>Fast Booking</span>
                <span class="trust-badge-cta"><i class="bi bi-star-fill me-1"></i>Highly Rated</span>
                <span class="trust-badge-cta"><i class="bi bi-award me-1"></i>Satisfaction Guaranteed</span>
            </div>
        </div>
    </div>
</section>
<!-- Cookie Banner -->
<div id="cookieBanner" class="cookie-banner bg-light border-top shadow-sm p-3 fixed-bottom d-flex justify-content-between align-items-center">
    <div class="cookie-text">
        <strong>Your privacy matters.</strong><br>
        luxGold uses cookies to provide a better service and personalize your experience.
        <a href="cookies-policy.html" class="text-primary">Learn more in our Cookie Policy</a>.
    </div>
    <button id="acceptCookies" class="btn btn-primary btn-sm ms-3">Accept</button>
</div>
@endsection