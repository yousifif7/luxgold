@extends('layouts.master')

@section('title', 'Cleaner Detail - luxGold')
@section('content')
<style>
    .compare-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #00bfa6;
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        z-index: 10;
    }
    
    .inquiry-success-alert {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    }
</style>

<!-- Success Alert -->
<div class="alert alert-success inquiry-success-alert" id="inquirySuccessAlert">
    <i class="ti ti-check me-2"></i>
    <span id="inquirySuccessMessage">Your inquiry has been sent successfully!</span>
</div>

<div class="find-provider-page">
  <div class="site-header">
    <div class="left-head">
        <a href="{{route('website.find-cleaner')}}" class="back-btn" id="backBtn"><i class="ti ti-arrow-left"></i>Back to Results</a>
    </div>

    <div class="header-actions">
        <div class="pill" onclick="downloadProviderInfo()">
            <i class="ti ti-download me-2"></i>Download 
        </div>
        <div class="pill" onclick="printProviderInfo()">
            <i class="ti ti-printer me-2"></i>Print
        </div>
    </div>
</div>

<div class="container school-profile-section-main-wrapper">
    <div class="row g-4 align-items-start">

        <!-- Left: Image Gallery -->
        <div class="col-lg-8">
            <div class="school-profile-image-gallery-container position-relative">
                <!-- Compare Badge -->
                @if($provider->isInCompare())
                    <div class="compare-badge">
                        <i class="ti ti-check me-1"></i>In Compare List
                    </div>
                @endif
                
                @if($provider->status === 'approved')
                <div class="image-side-icon">
                    <i style="color:#00bfa6" class=" bi bi-check2-circle"></i>
                </div>
                @endif
                
                @php
                    $facilityPhotos = $provider->facility_photos_paths ?? [];
                    $mainImage = !empty($facilityPhotos) ? ($facilityPhotos[0]) : ($provider->logo_path);
                @endphp
                @if($mainImage && file_exists(public_path($mainImage)))
    <img src="{{ asset($mainImage) }}"
         class="school-profile-main-image-large"
         id="mainImage"
         alt="{{ $provider->business_name ?? 'Provider' }} Main Image">
@endif
                @if(!empty($facilityPhotos) && count($facilityPhotos) > 1)
                <div class="school-profile-thumbnail-gallery-row">
                    @foreach($facilityPhotos as $photo)
                        <img src="{{ asset($photo) }}"
                            class="school-profile-thumbnail-small-image" onclick="changeImage(this)">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Quick Inquiry Card -->
            <div class="quick-inquiry-card mt-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">
                            <i class="ti ti-message-circle text-primary me-2"></i>
                            Quick Inquiry
                        </h5>
                        
                        <form id="quickInquiryForm">
                            @csrf
                            <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="inquiry_name" class="form-label">Your Name *</label>
                                    <input type="text" class="form-control" id="inquiry_name" name="name" 
                                           value="{{ auth()->user() ? auth()->user()->name : '' }}" 
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inquiry_email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="inquiry_email" name="email"
                                           value="{{ auth()->user() ? auth()->user()->email : '' }}" 
                                           required>
                                </div>
                                <div class="col-md-12">
                                    <label for="inquiry_phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="inquiry_phone" name="phone">
                                </div>
                                
                                <div class="col-12">
                                    <label for="inquiry_message" class="form-label">Message *</label>
                                    <textarea class="form-control" id="inquiry_message" name="message" rows="4" 
                                              placeholder="Tell the cleaner about your needs, preferred start date, or any specific requirements..." 
                                              required>Hi, I'm interested in learning more about your services. Could you please provide more information about availability and pricing?</textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inquiry_newsletter" name="newsletter">
                                        <label class="form-check-label" for="inquiry_newsletter">
                                            Send me updates about new features and cleaners
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="add-services-btn w-100" id="submitInquiryBtn">
                                        <i class="ti ti-send me-2"></i>
                                        Send Inquiry
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Provider Events Section -->
            @php
                $providerEvents = $provider->events()->where('status', 'active')->where('start_date', '>=', now())->orderBy('start_date')->get();
            @endphp
            
            @if($providerEvents->count() > 0)
            <div class="provider-events-card mt-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">
                            <i class="ti ti-calendar-event text-primary me-2"></i>
                            Upcoming Events
                        </h5>
                        
                        <div class="events-list">
                            @foreach($providerEvents as $event)
                            <div class="event-item border-bottom pb-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="event-date text-center">
                                            <div class="event-month text-primary fw-bold">
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('M') }}
                                            </div>
                                            <div class="event-day fs-3 fw-bold">
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('d') }}
                                            </div>
                                            <div class="event-year text-muted">
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="event-title mb-1">{{ $event->title }}</h6>
                                        <p class="event-subtitle text-muted mb-1">{{ $event->subtitle }}</p>
                                        <div class="event-meta">
                                            <small class="text-muted">
                                                <i class="ti ti-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }}
                                                @if($event->end_date)
                                                - {{ \Carbon\Carbon::parse($event->end_date)->format('g:i A') }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @if($event->cost > 0)
                                        <div class="event-cost mb-2">
                                            <span class="fw-bold text-success">${{ number_format($event->cost, 2) }}</span>
                                        </div>
                                        @else
                                        <div class="event-cost mb-2">
                                            <span class="fw-bold text-success">Free</span>
                                        </div>
                                        @endif
                                        
                                        @if($event->max_capacity)
                                        <div class="event-capacity mb-2">
                                            <small class="text-muted">
                                                {{ $event->current_capacity }}/{{ $event->max_capacity }} spots
                                            </small>
                                        </div>
                                        @endif
                                        
                                        <a href="{{ route('event.detail', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($providerEvents->count() > 3)
                        <div class="text-center mt-3">
                            <a href="{{ route('provider.events', $provider->id) }}" class="btn btn-primary">
                                View All Events ({{ $providerEvents->count() }})
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right: Info Card -->
        <div class="col-lg-4">
            <div class="school-information-detail-card">
                @php
                    // Normalize stored category IDs (some records store JSON arrays)
                    $categoryIds = $provider->sub_categories ?? [];
                    if (is_string($categoryIds)) {
                        $categoryIds = json_decode($categoryIds, true) ?: [];
                    }

                    // Resolve category models (fall back to provider->category relation)
                    $serviceCategories = \App\Models\Category::whereIn('id', (array) $categoryIds)->get();
                    $primaryCategory = $serviceCategories->first() ?? ($provider->category ?? null);
                    $primaryCategoryName = $primaryCategory ? ($primaryCategory->name ?? $primaryCategory) : 'Provider';
                @endphp

                @if($primaryCategoryName)
                <div class="school-information-badge-category">{{ $primaryCategoryName }}</div>
                @endif
                
                <h2 class="school-information-name-heading">{{ $provider->business_name ?? $provider->name }}</h2>

                @php
                    $reviews = $provider->reviews()->where('status', 'approved')->get();
                    $averageRating = $reviews->avg('rating');
                    $reviewCount = $reviews->count();
                @endphp
                
                <div class="school-rating-wrapper">
                    @if($averageRating)
                    <div class="rating rating-text">
                        <i class="bi bi-star-fill"></i>{{ number_format($averageRating, 1) }} ({{ $reviewCount }})
                    </div>
                    @endif
                    
                    @if($provider->status === 'approved')
                    <i style="color:#00bfa6" class="ms-1 bi bi-check2-circle"></i>
                    @endif
                </div>
                
                <div class="school-action-info-parent">
                    @if($provider->physical_address)
                    <div class="school-action-info">
                        <div class="icon">
                            <i class="ti ti-map-pin"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <p>{{ $provider->physical_address }}</p>
                            @if($provider->city)
                            <span>{{ $provider->city }}, {{ $provider->state }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    @if($provider->phone || $provider->phone_number)
                    <div class="school-action-info">
                        <div class="icon">
                            <i class="ti ti-phone"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <p>{{ $provider->phone ?? $provider->phone_number }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($provider->website)
                    <div class="school-action-info">
                        <div class="icon">
                            <i class="ti ti-world"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="{{ $provider->website }}" target="_blank" class="link">{{ $provider->website }}</a>
                        </div>
                    </div>
                    @endif

                    @if($provider->start_time && $provider->end_time)
                    <div class="school-action-info">
                        <div class="icon">
                            <i class="ti ti-clock"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <p>
                                {{ \Carbon\Carbon::parse($provider->start_time)->format('g:i A') }} - 
                                {{ \Carbon\Carbon::parse($provider->end_time)->format('g:i A') }}
                            </p>
                            <span class="text-success fw-medium">Open now</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($provider->price_amount)
                    <div class="school-action-info">
                        <div class="icon">
                            <i class="ti ti-currency-dollar"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <p>${{ number_format($provider->price_amount, 0) }}{{ $provider->pricing_description ? ' - ' . $provider->pricing_description : '' }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="school-action-buttons-row">
                    @if($provider->phone || $provider->phone_number)
                    <button class="school-action-btn-call" onclick="makePhoneCall('{{ $provider->phone ?? $provider->phone_number }}')">
                        <i class="ti ti-phone me-1"></i> Call Now
                    </button>
                    @endif
                    
                    <button class="school-action-btn-email" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                        <i class="ti ti-mail me-1"></i> Send Inquiry
                    </button>
                </div>

                <div class="school-lower-action-buttons">
                    <button class="save-provider-btn {{ $provider->isSavedByUser() ? 'saved' : '' }}" data-provider-id="{{ $provider->id }}">
                        <i class="ti ti-bookmark me-1"></i> 
                        <span>{{ $provider->isSavedByUser() ? 'Saved' : 'Save' }}</span>
                    </button>
                    <button class="share-provider-btn" onclick="shareProvider()">
                        <i class="ti ti-share me-1"></i> Share
                    </button>
                    <button class="follow-provider-btn {{ $provider->isFollowedByUser() ? 'following' : '' }}" data-provider-id="{{ $provider->id }}">
                        <i class="ti ti-bell me-1"></i> 
                        <span>{{ $provider->isFollowedByUser() ? 'Following' : 'Follow' }}</span>
                    </button>
                </div>

                <button class="school-add-to-compare-btn {{ $provider->isInCompare() ? 'in-compare' : '' }}" 
                        data-provider-id="{{ $provider->id }}" 
                        id="compareButton">
                    <i class="ti ti-{{ $provider->isInCompare() ? 'check' : 'adjustments' }} me-1"></i>
                    {{ $provider->isInCompare() ? 'Remove from Compare' : 'Add to Compare' }}
                </button>
            </div>
            
            <div class="quick-action-card_detail-page">
                <h6>Quick Actions</h6>
                <div class="quick-actions-item-parent">
                    @auth
                    <div class="quick-action-item" data-bs-toggle="modal" data-bs-target="#reviewModal">
                        <i class="ti ti-star"></i>
                        <span>Write a review</span>
                    </div>
                    @else
                    <div class="quick-action-item" onclick="showLoginAlert()">
                        <i class="ti ti-star"></i>
                        <span>Write a review</span>
                    </div>
                    @endauth
                    
                    <div class="quick-action-item" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                        <i class="ti ti-message-circle"></i>
                        <span>Send Inquiry</span>
                    </div>
                    
                    @if($providerEvents->count() > 0)
                    <div class="quick-action-item" onclick="scrollToEvents()">
                        <i class="ti ti-calendar-event"></i>
                        <span>View Events</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Provider Response Time -->
            <div class="response-time-card mt-3">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center py-3">
                        <i class="ti ti-clock text-primary me-2"></i>
                        <small class="text-muted">
                            Average response time: <strong class="text-dark">2-4 hours</strong>
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <ul class="nav nav-pills school-tab-navigation-container" id="schoolTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button">Overview</button>
        </li>
        
        @if($provider->price_amount || $provider->pricing_description)
        <li class="nav-item">
            <button class="nav-link" id="pricing-tab" data-bs-toggle="pill" data-bs-target="#pricing" type="button">Pricing</button>
        </li>
        @endif
        
        <li class="nav-item">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" type="button">Reviews</button>
        </li>
        
        @if(!empty($facilityPhotos))
        <li class="nav-item">
            <button class="nav-link" id="photos-tab" data-bs-toggle="pill" data-bs-target="#photos" type="button">Photos</button>
        </li>
        @endif
        
        @if($provider->start_time && $provider->end_time)
        <li class="nav-item">
            <button class="nav-link" id="hours-tab" data-bs-toggle="pill" data-bs-target="#hours" type="button">Hours</button>
        </li>
        @endif
        
        @php
            $specialFeatures = $provider->special_features ?? [];
            $diversityBadges = $provider->diversity_badges ?? [];
            $amenities = array_merge($specialFeatures ?? [], $diversityBadges ?? []);
        @endphp
        
        @if(!empty($amenities))
        <li class="nav-item">
            <button class="nav-link" id="amenities-tab" data-bs-toggle="pill" data-bs-target="#amenities" type="button">Amenities</button>
        </li>
        @endif
        
        @if($providerEvents->count() > 0)
        <li class="nav-item">
            <button class="nav-link" id="events-tab" data-bs-toggle="pill" data-bs-target="#events" type="button">Events</button>
        </li>
        @endif
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="schoolTabsContent">

        <!-- Overview -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <!-- About Section -->
            @if($provider->service_description)
            <div class="school-about-card">
                <div class="provider-detail-tab-content-card-title">About {{ $provider->business_name ?? $provider->name }}</div>
                <p class="text-muted">{{ $provider->service_description }}</p>
                
                <div class="row g-3 mt-3">
                    @if($provider->years_operation)
                    <div class="col-md-3">
                        <div class="school-about-stats-box">
                            <i class="ti ti-calendar"></i>
                            <div>{{ $provider->years_operation }}</div>
                            <small>Years Operating</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($provider->license_number)
                    <div class="col-md-3">
                        <div class="school-about-stats-box">
                            <i class="ti ti-shield-check"></i>
                            <div>Licensed</div>
                            <small>Provider</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($averageRating)
                    <div class="col-md-3">
                        <div class="school-about-stats-box">
                            <i class="ti ti-star"></i>
                            <div>{{ number_format($averageRating, 1) }}/5</div>
                            <small>Rating</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($provider->status === 'approved')
                    <div class="col-md-3">
                        <div class="school-about-stats-box">
                            <i class="ti ti-check"></i>
                            <div>Verified</div>
                            <small>Provider</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Services Section -->
            @php
                $services = array_merge($specialFeatures ?? [], $serviceCategories ?? []);
            @endphp
            
            @if(!empty($services))
            <div class="school-services-card">
                <h6 class="provider-detail-tab-content-card-title">Services Offered</h6>
                <div>
                    @foreach(array_slice($services, 0, 8) as $service)
                        <span class="school-service-badge"> 
                            <i style="color:#00bfa6" class="ms-1 bi bi-check2-circle"></i> 
                            {{ ucfirst(str_replace('_', ' ', $service)) }}
                        </span>
                    @endforeach
                    
                    @if(count($services) > 8)
                        <span class="school-service-badge"> 
                            +{{ count($services) - 8 }} more
                        </span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Pricing Tab - Only show if pricing data exists -->
        @if($provider->price_amount || $provider->pricing_description)
        <div class="tab-pane fade" id="pricing" role="tabpanel">
            <section class="pricing-info">
                <div class="">
                    <div class="card p-4 rounded-4">
                        <h5 class="mb-3 fw-semibold">Pricing Information</h5>

                        @if($provider->price_amount)
                        <div class="p-4 rounded-3 mb-4" style="background:#fff;border: 1px solid #ddd;">
                            <h6 class="fw-bold">Standard Rates</h6>
                            <h2 class="fw-bold text-success mb-1">${{ number_format($provider->price_amount, 0) }}{{ $provider->pricing_description ? ' - ' . $provider->pricing_description : '' }}</h2>
                            @if($provider->pricing_description)
                            <p class="mb-0 text-muted">{{ $provider->pricing_description }}</p>
                            @endif
                        </div>
                        @endif

                        @if($provider->availability_notes)
                        <div class="p-3 rounded-3" style="background:#fff; border:1px solid #ddd;">
                            <h6 class="fw-bold text-dark">Additional Information</h6>
                            <p class="mb-0 text-muted">{{ $provider->availability_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
        @endif

        <!-- Reviews Tab -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            <div class="long-keyword-rating-container-box">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6>Reviews & Ratings</h6>
                    @auth
                        <button class="add-services-btn btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            <i class="ti ti-star me-1"></i>Write Review
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="add-services-btn btn-sm">
                            <i class="ti ti-star me-1"></i>Login to Review
                        </a>
                    @endauth
                </div>
                
                @if($reviewCount > 0)
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <div class="long-keyword-rating-score-big">{{ number_format($averageRating, 1) }}</div>
                        <div>
                            @php
                                $fullStars = floor($averageRating);
                                $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="bi bi-star-fill long-keyword-star-icon"></i>
                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                    <i class="bi bi-star-half long-keyword-star-icon"></i>
                                @else
                                    <i class="bi bi-star long-keyword-star-icon"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="mt-2">{{ $reviewCount }} reviews</p>
                    </div>
                    <div class="col-md-9">
                        @php
                            $ratingDistribution = [
                                5 => $reviews->where('rating', 5)->count(),
                                4 => $reviews->where('rating', 4)->count(),
                                3 => $reviews->where('rating', 3)->count(),
                                2 => $reviews->where('rating', 2)->count(),
                                1 => $reviews->where('rating', 1)->count(),
                            ];
                        @endphp
                        <!-- Bars -->
                        @for($i = 5; $i >= 1; $i--)
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2">{{ $i }}★</span>
                                <div class="flex-grow-1 long-keyword-progress-bar">
                                    <div class="long-keyword-progress-bar-fill" 
                                         style="width:{{ ($ratingDistribution[$i] / $reviewCount) * 100 }}%; height:6px;"></div>
                                </div>
                                <span class="ms-2">{{ $ratingDistribution[$i] }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Reviews List -->
                @foreach($reviews as $review)
                    <div class="long-keyword-review-box">
                        <h6><i class="bi bi-person-circle me-1"></i> {{ $review->user->first_name ?? 'Anonymous' }} <small class="text-muted">• {{ $review->created_at->diffForHumans() }}</small></h6>
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="mt-2">{{ $review->comment }}</p>
                    </div>
                @endforeach
                @else
                <div class="text-center py-4">
                    <i class="ti ti-star" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-2">No reviews yet. Be the first to review!</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Photos Tab - Only show if photos exist -->
        @if(!empty($facilityPhotos))
        <div class="tab-pane fade" id="photos" role="tabpanel">
            <div class="school-updates-card">
                <h6>Photos ({{ count($facilityPhotos) }})</h6>
                <div class="provider-detail-images-parent">
                    @foreach($facilityPhotos as $photo)
                        <img src="{{ asset($photo) }}" alt="{{ $provider->business_name ?? 'Provider' }} photo">
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Hours Tab - Only show if hours exist -->
        @if($provider->start_time && $provider->end_time)
        <div class="tab-pane fade" id="hours" role="tabpanel">
            <div class="long-keyword-hours-box">
                <h6>Hours of Operation</h6>
                @php
                    $availableDays = $provider->available_days ?? [];
                    $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    $startTime = \Carbon\Carbon::parse($provider->start_time)->format('g:i A');
                    $endTime = \Carbon\Carbon::parse($provider->end_time)->format('g:i A');
                @endphp
                <div class="row mt-4">
                    @foreach($daysOfWeek as $day)
                        <div class="col-6 long-keyword-hours-day">{{ ucfirst($day) }}</div>
                        <div class="col-6 {{ in_array($day, $availableDays) ? 'text-success' : 'text-muted' }}">
                            @if(in_array($day, $availableDays))
                                {{ $startTime }} - {{ $endTime }}
                            @else
                                Closed
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Amenities Tab - Only show if amenities exist -->
        @if(!empty($amenities))
        <div class="tab-pane fade" id="amenities" role="tabpanel">
            <div class="long-keyword-amenities-box">
                <h6>Amenities & Features</h6>
                <div class="row g-3 mt-2">
                    @foreach($amenities as $amenity)
                        <div class="col-md-6">
                            <div class="long-keyword-amenity-active">
                                <i class="bi bi-check2-circle"></i> 
                                {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Events Tab - Only show if events exist -->
        @if($providerEvents->count() > 0)
        <div class="tab-pane fade" id="events" role="tabpanel">
            <div class="provider-events-tab">
                <h6>Upcoming Events ({{ $providerEvents->count() }})</h6>
                
                <div class="events-grid mt-4">
                    @foreach($providerEvents as $event)
                    <div class="event-card">
                        <div class="event-date">
                            <div class="event-month">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</div>
                            <div class="event-day">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</div>
                        </div>
                        <div class="event-details">
                            <h6 class="event-title">{{ $event->title }}</h6>
                            <p class="event-time text-muted">
                                <i class="ti ti-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }}
                                @if($event->end_date)
                                - {{ \Carbon\Carbon::parse($event->end_date)->format('g:i A') }}
                                @endif
                            </p>
                            @if($event->location)
                            <p class="event-location text-muted">
                                <i class="ti ti-map-pin me-1"></i>
                                {{ $event->location }}
                            </p>
                            @endif
                            <div class="event-actions">
                                <a href="{{ route('event.detail', $event->id) }}" class="btn btn-sm btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
</div>

<script>
function changeImage(element) {
    document.getElementById('mainImage').src = element.src;
}

function makePhoneCall(phoneNumber) {
    window.location.href = 'tel:' + phoneNumber;
}

function shareProvider() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $provider->business_name }}',
            text: 'Check out this provider on our platform',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
}

function scrollToEvents() {
    document.getElementById('events-tab').click();
    document.getElementById('events').scrollIntoView({ behavior: 'smooth' });
}

function downloadProviderInfo() {
    // Implement download functionality
    alert('Download functionality would be implemented here.');
}

function printProviderInfo() {
    window.print();
}

function showLoginAlert() {
    alert('Please login to write a review.');
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
});
</script>

<style>
.provider-events-card .event-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

.event-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    display: flex;
    gap: 1rem;
}

.event-date {
    text-align: center;
    min-width: 60px;
}

.event-month {
    font-size: 0.875rem;
    font-weight: 600;
}

.event-day {
    font-size: 1.5rem;
    font-weight: 700;
}

.event-details {
    flex: 1;
}

.event-title {
    margin-bottom: 0.5rem;
}

.event-actions {
    margin-top: 0.5rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .events-grid {
        grid-template-columns: 1fr;
    }
    
    .event-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<!-- Review Modal -->
<<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reviewForm" action="{{ route('reviews.store', $provider->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="review_id" id="review_id">
                    
                    <div class="mb-4 text-center">
                        <label class="form-label d-block">Your Rating</label>
                        <div class="rating-stars" id="ratingStars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="ti ti-star rating-star" data-rating="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating" required>
                        <div class="invalid-feedback text-center" id="ratingError">Please select a rating</div>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Your Review</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Share your experience with this provider..." required></textarea>
                        <div class="form-text">Minimum 10 characters</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="add-services-btn">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryModalLabel">
                    <i class="ti ti-message-circle text-primary me-2"></i>
                    Send Inquiry to {{ $provider->business_name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="inquiryModalForm">
                @csrf
                <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="modal_inquiry_name" class="form-label">Your Name *</label>
                            <input type="text" class="form-control" id="modal_inquiry_name" name="name" 
                                   value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_inquiry_email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="modal_inquiry_email" name="email"
                                   value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_inquiry_phone" class="form-label">Phone *</label>
                            <input type="tel" class="form-control" id="modal_inquiry_phone" name="phone" required>
                        </div>
                       
                        <div class="col-12">
                            <label for="modal_inquiry_message" class="form-label">Your Message *</label>
                            <textarea class="form-control" id="modal_inquiry_message" name="message" rows="5" 
                                      placeholder="Please provide details about your needs, schedule requirements, and any specific questions you have for the provider..." 
                                      required>Hello, I'm interested in learning more about your childcare services. Could you please provide information about:

- Current availability
- Detailed pricing
- Program details
- Enrollment process

Thank you!</textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="modal_inquiry_newsletter" name="newsletter" checked>
                                <label class="form-check-label" for="modal_inquiry_newsletter">
                                    Send me updates about new features and cleaners
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="add-services-btn" id="submitModalInquiryBtn">
                        <i class="ti ti-send me-2"></i>
                        Send Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Compare Modal -->
   <div id="compareBar" class="compare-bar" aria-hidden="true">
            <div class="compare-header">
                <h3 class="compare-title">Compare Cleaners</h3>
                <button id="closeCompare"
                    style="background:none; border:none; font-size:18px; color:#6b7280; cursor:pointer;">✕</button>
            </div>
    
            <div class="compare-list" id="compareList"></div>
    
            <div class="compare-actions">
                <button id="clearCompare" class="compare-clear">Clear All</button>
                <button id="doCompare" class="compare-final-btn">View Detail Comparision (0)</button>
            </div>
        </div>


@endsection

@push('styles')
<style>
.rating-stars {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
}

.rating-star {
    transition: color 0.2s;
}

.rating-star:hover,
.rating-star.active {
    color: #ffc107;
}


.save-provider-btn.saved,
.follow-provider-btn.following,
.school-add-to-compare-btn.in-compare {
    background-color: #00bfa6;
    color: white;
}

.long-keyword-review-box.bg-light {
    background-color: #f8f9fa !important;
    border-left: 4px solid #00bfa6;
}

/* Compare badge styles */
.compare-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #00bfa6, #009688);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0, 191, 166, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Inquiry form styles */
.quick-inquiry-card {
    border-radius: 12px;
}

.quick-inquiry-card .card {
    border-radius: 12px;
}

.inquiry-success-alert {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.response-time-card .card {
    border-radius: 8px;
}

/* Form focus styles */
.form-control:focus,
.form-select:focus {
    border-color: #00bfa6;
    box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25);
}

/* Loading button styles */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-right-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
    const baseUrl='{{ url('/') }}';
function changeImage(element) {
    document.getElementById("mainImage").src = element.src;
}

// Make phone call function
function makePhoneCall(phoneNumber) {
    if (phoneNumber) {
        window.location.href = `tel:${phoneNumber}`;
    } else {
        showToast('Phone number not available', 'error');
    }
}

// Inquiry Form Handling
document.addEventListener('DOMContentLoaded', function() {
    // Quick Inquiry Form
    const quickInquiryForm = document.getElementById('quickInquiryForm');
    if (quickInquiryForm) {
        quickInquiryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitInquiry(this, 'submitInquiryBtn');
        });
    }

    // Modal Inquiry Form
    const inquiryModalForm = document.getElementById('inquiryModalForm');
    if (inquiryModalForm) {
        inquiryModalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitInquiry(this, 'submitModalInquiryBtn');
        });
    }

    // Set minimum date for preferred start date to today
    const preferredDateInput = document.getElementById('modal_inquiry_preferred_date');
    if (preferredDateInput) {
        const today = new Date().toISOString().split('T')[0];
        preferredDateInput.min = today;
    }

    // Initialize other event listeners (rating stars, save, follow, compare)
    initializeOtherEventListeners();
});

function submitInquiry(form, submitBtnId) {
    const submitBtn = document.getElementById(submitBtnId);
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="ti ti-loader me-2"></i>Sending...';
    submitBtn.classList.add('btn-loading');
    submitBtn.disabled = true;

    const formData = new FormData(form);
    
    fetch('{{ route("inquiries.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showInquirySuccess('Your inquiry has been sent successfully! The provider will contact you soon.');
            
            // Reset form
            form.reset();
            
            // Close modal if it's the modal form
            if (form.id === 'inquiryModalForm') {
                const modal = bootstrap.Modal.getInstance(document.getElementById('inquiryModal'));
                modal.hide();
            }
            
            // Track inquiry in analytics (if you have any)
            trackInquiry(data.inquiry_id);
        } else {
            throw new Error(data.message || 'Failed to send inquiry');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Error sending inquiry. Please try again.', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.classList.remove('btn-loading');
        submitBtn.disabled = false;
    });
}

function showInquirySuccess(message) {
    const alert = document.getElementById('inquirySuccessAlert');
    const messageSpan = document.getElementById('inquirySuccessMessage');
    
    messageSpan.textContent = message;
    alert.style.display = 'block';
    
    // Hide alert after 5 seconds
    setTimeout(() => {
        alert.style.display = 'none';
    }, 5000);
}

function trackInquiry(inquiryId) {
    // You can integrate with Google Analytics or other analytics here
    if (typeof gtag !== 'undefined') {
        gtag('event', 'inquiry_sent', {
            'event_category': 'engagement',
            'event_label': 'Provider Inquiry',
            'value': inquiryId
        });
    }
    
    // Log to console for development
    console.log('Inquiry sent with ID:', inquiryId);
}

// Initialize other event listeners (your existing code)
function initializeOtherEventListeners() {
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            // Update stars display
            ratingStars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
        
        star.addEventListener('mouseover', function() {
            const rating = this.getAttribute('data-rating');
            ratingStars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
        
        star.addEventListener('mouseout', function() {
            const currentRating = ratingInput.value;
            ratingStars.forEach(s => {
                if (currentRating && s.getAttribute('data-rating') <= currentRating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    });
    function changeImage(element) {
    document.getElementById("mainImage").src = element.src;
}
}

// Rating Stars
document.addEventListener('DOMContentLoaded', function() {



    // Review Modal
    const reviewModal = document.getElementById('reviewModal');
    if (reviewModal) {
        reviewModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const reviewId = button ? button.getAttribute('data-review-id') : null;
            
            if (reviewId) {
                document.getElementById('review_id').value = reviewId;
                document.getElementById('reviewModalLabel').textContent = 'Edit Review';
            } else {
                document.getElementById('review_id').value = '';
                document.getElementById('reviewModalLabel').textContent = 'Write a Review';
                ratingInput.value = '';
                document.getElementById('comment').value = '';
                ratingStars.forEach(star => star.classList.remove('active'));
            }
        });
    }


    document.querySelectorAll('.save-provider-btn').forEach(button => {
        button.addEventListener('click', function() {
            const providerId = this.getAttribute('data-provider-id');
            saveProvider(providerId, this);
        });
    });

    // Follow Provider
    document.querySelectorAll('.follow-provider-btn').forEach(button => {
        button.addEventListener('click', function() {
            const providerId = this.getAttribute('data-provider-id');
            followProvider(providerId, this);
        });
    });

    // Compare Provider
    document.querySelectorAll('.school-add-to-compare-btn').forEach(button => {
        button.addEventListener('click', function() {
            const providerId = this.getAttribute('data-provider-id');
            toggleCompareProvider(providerId, this);
        });
    });

    // Form validation
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            if (!ratingInput.value) {
                e.preventDefault();
                document.getElementById('ratingError').style.display = 'block';
            }
        });
    }

    // Load compare list count on page load
    updateCompareBadge();
});


// Compare Provider Functionality
function toggleCompareProvider(providerId, button) {
    fetch(`/providers/${providerId}/compare`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.in_compare) {
            button.classList.add('in-compare');
            button.innerHTML = '<i class="ti ti-check me-1"></i>Remove from Compare';
            showToast('Provider added to compare list!', 'success');
            
            // Show compare badge
            if (!document.querySelector('.compare-badge')) {
                const badge = document.createElement('div');
                badge.className = 'compare-badge';
                badge.innerHTML = '<i class="ti ti-check me-1"></i>In Compare List';
                document.querySelector('.school-profile-image-gallery-container').appendChild(badge);
            }
        } else {
            button.classList.remove('in-compare');
            button.innerHTML = '<i class="ti ti-adjustments me-1"></i>Add to Compare';
            showToast('Provider removed from compare list', 'info');
            
            // Remove compare badge
            const badge = document.querySelector('.compare-badge');
            if (badge) {
                badge.remove();
            }
        }
        
        updateCompareBadge();
        updateCompareButtonText();
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error updating compare list', 'error');
    });
}

function updateCompareBadge() {
    fetch('/compare/count')
        .then(response => response.json())
        .then(data => {
            const compareCount = data.count || 0;
            const badge = document.querySelector('.compare-count-badge');
            
            if (compareCount > 0) {
                if (!badge) {
                    // Create badge in header
                    const headerActions = document.querySelector('.header-actions');
                    const compareBadge = document.createElement('div');
                    compareBadge.className = 'pill compare-count-badge';
                    compareBadge.innerHTML = `<i class="ti ti-adjustments me-2"></i>Compare (${compareCount})`;
                    compareBadge.style.cursor = 'pointer';
                    compareBadge.onclick = showCompareModal;
                    headerActions.appendChild(compareBadge);
                } else {
                    badge.innerHTML = `<i class="ti ti-adjustments me-2"></i>Compare (${compareCount})`;
                }
            } else if (badge) {
                badge.remove();
            }
        });
}

function showCompareModal() {
    fetch('/compare/list')
        .then(res => res.json())
        .then(data => {
            const compareList = document.getElementById('compareList');
            const compareBar = document.getElementById('compareBar');
            const compareCount = document.getElementById('compareCount');
            console.log(data.providers.length)

            compareList.innerHTML = '';
            if (data.providers && data.providers.length > 0) {
                compareBar.classList.add('open');

                data.providers.forEach(provider => {
                    const item = document.createElement('div');
                    item.className = 'compare-item';
                    item.innerHTML = `
                        <img src="${baseUrl+'/'+provider.logo_path || '/default.png'}" alt="">
                        <div class="small fw-bold mt-1">${provider.business_name}</div>
                        <div class="small text-muted">${provider.physical_address || ''}</div>
                    `;
                    console.log(item)
                    compareList.appendChild(item);
                });
            } else {
                compareBar.classList.remove('active');
            }
        })
        .catch(err => console.error(err));
}

function removeFromCompare(providerId) {
    fetch(`/providers/${providerId}/compare`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (!data.in_compare) {
            showToast('Provider removed from compare list', 'info');
            showCompareModal(); // Refresh the modal
            updateCompareBadge();
            
            // Update the current page if we're on the provider's detail page
            if (window.location.pathname.includes(providerId)) {
                const compareButton = document.getElementById('compareButton');
                if (compareButton) {
                    compareButton.classList.remove('in-compare');
                    compareButton.innerHTML = '<i class="ti ti-adjustments me-1"></i>Add to Compare';
                    
                    const badge = document.querySelector('.compare-badge');
                    if (badge) {
                        badge.remove();
                    }
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error removing from compare list', 'error');
    });
}

function clearCompareList() {
    fetch('/compare/clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Compare list cleared', 'info');
            updateCompareBadge();
            
            // Close modal
            const compareModal = bootstrap.Modal.getInstance(document.getElementById('compareModal'));
            compareModal.hide();
            
            // Update current page if needed
            const compareButton = document.getElementById('compareButton');
            if (compareButton) {
                compareButton.classList.remove('in-compare');
                compareButton.innerHTML = '<i class="ti ti-adjustments me-1"></i>Add to Compare';
                
                const badge = document.querySelector('.compare-badge');
                if (badge) {
                    badge.remove();
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error clearing compare list', 'error');
    });
}

function updateCompareButtonText() {
    const compareButton = document.getElementById('compareButton');
    if (compareButton) {
        if (compareButton.classList.contains('in-compare')) {
            compareButton.innerHTML = '<i class="ti ti-check me-1"></i>Remove from Compare';
        } else {
            compareButton.innerHTML = '<i class="ti ti-adjustments me-1"></i>Add to Compare';
        }
    }
}

// Existing functions (keep these as they are)
function saveProvider(providerId, button) {
    fetch(`/providers/${providerId}/save`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.saved) {
            button.classList.add('saved');
            button.querySelector('span').textContent = 'Saved';
            showToast('Provider saved successfully!', 'success');
        } else {
            button.classList.remove('saved');
            button.querySelector('span').textContent = 'Save';
            showToast('Provider removed from saved list', 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Kindly login first', 'error');
    });
}

function followProvider(providerId, button) {
    fetch(`/providers/${providerId}/follow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.followed) {
            button.classList.add('following');
            button.querySelector('span').textContent = 'Following';
            showToast('You are now following this provider!', 'success');
        } else {
            button.classList.remove('following');
            button.querySelector('span').textContent = 'Follow';
            showToast('You have unfollowed this provider', 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Kindly login first', 'error');
    });
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
// Keep all your existing functions (saveProvider, followProvider, compare functions, etc.)
// ... (keep all your existing JavaScript functions) ...

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `<i class="ti ti-${type === 'success' ? 'check' : 'alert-triangle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

</script>
@endpush