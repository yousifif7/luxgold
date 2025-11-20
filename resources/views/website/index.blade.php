@extends('layouts.master')
@section('title', 'Welcome to AskRoro - Find Trusted Family Services')
@section('content')
<section class="hero-section">
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
    <div class="circle circle-3"></div>
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Content -->
            <div class="col-lg-6">
                @if($heroContent)
                <h1 class="hero-title">
                <span class="highlight-orange">{{ $heroContent->title_part1 ?? 'Your Family\'s' }}</span><br>
                <span class="highlight-green">{{ $heroContent->title_part2 ?? 'trusted guide to care, learning,' }}</span>                </h1>
                <p class="mt-3" style="color: rgb(100, 116, 139);font-weight: 400;">
                    {{ $heroContent->description ?? 'Find and compare family services near you! Discover amazing daycare centers, fun activities, and wellness services that kids and parents love!' }}
                </p>
                @else
                <h1 class="hero-title">
                <span class="highlight-orange">Your Family's</span><br>
                <span class="highlight-green">trusted guide to care, learning,</span><br>
                <span class="highlight-green">activities & wellness services – all in one hub.</span>
                </h1>
                <p class="mt-3" style="color: rgb(100, 116, 139);font-weight: 400;">
                    Find and compare family services near you! Discover amazing daycare centers, fun activities, and wellness services that kids and parents love!
                </p>
                @endif
                <!-- Search Box -->
                <div class="search-box">
                    <form action="{{ route('website.find-provider') }}" class="row g-2">
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
  Search Providers
  <i class="bi bi-chevron-right ms-1"></i>
</button>

                        </div>
                    </form>
                </div>
                <!-- Stats -->
                <div class="d-flex gap-4 mt-4 stats-box">
                    <div style="background-color: #fff">
                        <h4 style="color: #337d7c">{{ $heroContent->providers_count ?? '500' }}+</h4>
                        <p style="color: #337d7c">Providers</p>
                    </div>
                    <div style="background-color: #fff">
                        <h4 style="color: #337d7c">{{ $heroContent->rating ?? '4.8' }}</h4>
                        <p style="color: #337d7c">Avg Rating</p>
                    </div>
                    <div style="background-color: #fff">
                        <h4 style="color: #337d7c">{{ $heroContent->support_text ?? '24/7' }}</h4>
                        <p style="color: #337d7c">Support</p>
                    </div>
                </div>
            </div>
            <!-- Right Icons -->
            <div class="col-lg-6 d-flex justify-content-center mt-5 mt-lg-0">
               

                    <img src="{{ asset('assets/images/2.png') }}" style="width:100%">
                  {{--   <div class="icon-card blue"><i class="bi bi-people"></i></div>
                    <div class="icon-card green"><i class="bi bi-mortarboard"></i></div>
                    <div class="icon-card purple"><i class="bi bi-book"></i></div>
                    <div class="icon-card pink"><i class="bi bi-heart"></i></div>
                    <div class="icon-card orange"><i class="bi bi-emoji-smile"></i></div>
                    <div class="icon-card yellow"><i class="bi bi-link-45deg"></i></div>
                    <div class="icon-card teal"><i class="bi bi-stars"></i></div>
                    <div class="icon-card blue"><i class="bi bi-calendar"></i></div>
                    <div class="icon-card red"><i class="bi bi-shield"></i></div> --}}
                
            </div>
        </div>
    </div>
</section>

<section class="second-section ">
    <div class="container">
        
    <h3>Featured Providers</h3>
    <p class="tagline">Discover some of our highest-rated family service providers trusted by parents in your community</p>
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
        $firstCategory = !empty($serviceCategories) ? $serviceCategories[0] : ($category ?: 'Provider');
        
        // Parse special features for tags
        $specialFeatures = $provider->special_features ?? [];
        $diversityBadges = $provider->diversity_badges ?? [];
        
        // Combine tags from various sources
        $allTags = array_merge($specialFeatures, $diversityBadges);
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
                <img class="provider-media" src="{{ asset($provider->logo_path) }}" alt="{{ $provider->business_name }}">
                @else
                <div class="provider-media placeholder-media">
                    <i class="ti ti-building-store"></i>
                </div>
                @endif
                @if($firstCategory)
                <div class="card-badge">{{ $firstCategory }}</div>
                @endif
                <div class="card-body">
                    <div class="program-title">  {{ $provider->business_name ?? $provider->name }}
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
                    <button data-id="p{{ $provider->id }}" data-provider-id="{{ $provider->id }}" class="btn-compare compare-btn">
                    Compare
                    </button>
                    <a class="btn-view" href="{{ route('website.provider-detail', $provider->id) }}">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <button class="view-all-providers_btn" onclick="window.location.href='{{ route('website.find-provider') }}'">View All Provider <i class="bi bi-chevron-right"></i></button>
    </div>
        </div>

</section>

<section class="sixth-section">
    <div class="container">
        <h3>Latest Events</h3>
        <p class="tagline">Discover some of our latest events happening near you</p>

        <div class="row g-4 mt-4">
            @foreach($latestEvents as $event)
                <div class="col-md-4">
                    <div class="program-card position-relative">
                        {{-- Event Image --}}
                        @if(!empty($event->image_url))
                            <img class="provider-media" 
                                 src="{{ $event->image_url }}" 
                                 alt="{{ $event->title }}">
                        @else
                            <div class="provider-media placeholder-media">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            {{-- Event Title --}}
                            <div class="program-title">
                                {{ $event->title }}
                                @if($event->provider && $event->provider->status === 'approved')
                                    <i style="color:#00bfa6" class="ms-1 bi bi-check2-circle"></i>
                                @endif
                            </div>

                            {{-- Provider Name --}}
                            @if($event->provider)
                                <div class="info small-muted">
                                    <i class="bi bi-building"></i>
                                    {{ $event->provider->business_name ?? $event->provider_name }}
                                </div>
                            @endif

                            {{-- Event Dates --}}
                            @if($event->start_date && $event->end_date)
                                <div class="info small-muted">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $event->start_date->format('M d, Y') }} - {{ $event->end_date->format('M d, Y') }}
                                </div>
                            @endif

                            {{-- Event Location --}}
                            @if($event->location)
                                <div class="info small-muted">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ \Illuminate\Support\Str::limit($event->location, 40) }}
                                </div>
                            @endif

                            {{-- Event Cost --}}
                            @if(!is_null($event->cost))
                                <div class="info small-muted">
                                    <i class="bi bi-currency-dollar"></i>
                                    {{ number_format($event->cost, 2) }}
                                </div>
                            @endif

                            {{-- Age Group --}}
                            @if($event->age_group)
                                <div class="info">
                                    Ages: <b>{{ $event->age_group }}</b>
                                </div>
                            @endif

                            {{-- Category --}}
                            @if($event->category)
                                <div class="tags mt-2">
                                    <div class="tag tag-gray">{{ ucfirst($event->category) }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <a class="btn-view" href="{{ route('website.event-detail', $event->id) }}">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- View All --}}
        <div class="d-flex justify-content-center align-items-center">
            <button class="view-all-providers_btn" 
                    onclick="window.location.href='{{ route('website.find-event') }}'">
                View All Events <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</section>
<!-- Categories Section (Keeping Static as requested) -->
<section class="third-section">
    <div class="container">
        <h3>Browse by Category</h3>
        <p class="tagline">From early learning to wellness services, find everything your family needs in one place</p>
        <div class="row g-4 mt-4">
            @foreach($categories as $category)
            @if($category->parent_id === null) <!-- Only show main categories -->
            <div class="col-md-4">
                <div class="edu-card position-relative">
                    <!-- Category Image -->
                    <img src="{{ $category->image_url ?? 'https://images.unsplash.com/photo-1650504148053-ae51b12dc1d4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080' }}" alt="{{ $category->name }}">
                    
                    <!-- Providers Count Badge -->
                    <div class="edu-badge">{{ $category->providers_count }}+ providers</div>
                    
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
                        <div class="edu-desc">{{ $category->description ?? 'Find trusted providers for your family needs.' }}</div>
                        
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
                        @else
                        <!-- Fallback tags based on category name -->
                        <div class="edu-tags">
                            @if(str_contains(strtolower($category->name), 'learning') || str_contains(strtolower($category->name), 'care'))
                            <div class="edu-tag">Daycare</div>
                            <div class="edu-tag">Child-care</div>
                            <div class="edu-tag">Preschool</div>
                            @elseif(str_contains(strtolower($category->name), 'school') || str_contains(strtolower($category->name), 'education'))
                            <div class="edu-tag">Private Elementary</div>
                            <div class="edu-tag">Private Middle School</div>
                            <div class="edu-tag">Private High School</div>
                            @elseif(str_contains(strtolower($category->name), 'tutoring') || str_contains(strtolower($category->name), 'after'))
                            <div class="edu-tag">Afterschool Programs</div>
                            <div class="edu-tag">Tutoring Services</div>
                            <div class="edu-tag">Enrichment Activities</div>
                            @elseif(str_contains(strtolower($category->name), 'wellness') || str_contains(strtolower($category->name), 'health'))
                            <div class="edu-tag">Pediatric Wellness</div>
                            <div class="edu-tag">Therapy</div>
                            <div class="edu-tag">Yoga</div>
                            @elseif(str_contains(strtolower($category->name), 'event') || str_contains(strtolower($category->name), 'activity'))
                            <div class="edu-tag">Birthday Parties</div>
                            <div class="edu-tag">Summer Camps</div>
                            <div class="edu-tag">Family Events</div>
                            @else
                            <div class="edu-tag">Services</div>
                            <div class="edu-tag">Providers</div>
                            <div class="edu-tag">Family Care</div>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Explore Providers Link -->
                        <div onclick="window.location.href='{{ route('website.find-provider', ['category' => $category->id]) }}'" class="edu-footer">
                            Explore providers <i class="bi bi-chevron-right"></i>
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
<section class="forth-section">
    <div class="container">
        <h3>Now Serving These Cities</h3>
        <p class="tagline">AskRoro connects families with trusted providers across North Texas!</p>
        @if($cities->count() > 0)
        <div class="row gap-4 justify-content-center mt-4">
            @foreach($cities->where('is_coming_soon', false)->take(5) as $city)
            <div class="col-md-2 col-6">
                <div class="city-card">
                    <div class="city-icon green-bg">
                        <img src="{{ $city->icon_url }}" alt="{{ $city->name }}" width="30">
                    </div>
                    <div class="city-title">{{ $city->name }}, {{ $city->state }}</div>
                    <a href="#" class="city-link">{{ $city->providers_count }}+ providers</a>
                    <div class="city-families">{{ $city->families_count }}+ families</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback static cities -->
        <div class="row g-4 mt-4">
            <div class="col-md-2 col-6">
                <div class="city-card">
                    <div class="city-icon green-bg"><img src="https://cdn-icons-png.flaticon.com/512/1040/1040230.png" width="30"></div>
                    <div class="city-title">Aubrey, TX</div>
                    <a href="#" class="city-link">42 providers</a>
                    <div class="city-families">850+ families</div>
                </div>
            </div>
            <!-- Add more fallback cities as needed -->
        </div>
        @endif
        @if($cities->where('is_coming_soon', true)->count() > 0)
      <div class="coming-soon text-warning fw-bold">
  <i class="bi bi-clock me-2" style="font-size: 1.5rem;"></i>
  Coming Soon!
  <i class="bi bi-clock ms-2" style="font-size: 1.5rem;"></i>
</div>

        <div class="row justify-content-center gap-4 mt-4">
            @foreach($cities->where('is_coming_soon', true)->take(3) as $city)
            <div class="col-md-2 col-6">
                <div class="soon-card">
                    <div class="city-icon yellow-bg">
                        <img src="{{ $city->icon_url }}" alt="{{ $city->name }}" width="30">
                    </div>
                    <div class="soon-card-title">{{ $city->name }}, {{ $city->state }}</div>
                    <div class="soon-badge">Launching Soon!</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback static coming soon cities -->
        <div class="coming-soon">🚀 Coming Soon! 🚀</div>
        <div class="row justify-content-center gap-4 mt-4">
            <div class="col-md-2 col-6">
                <div class="soon-card">
                    <div class="city-icon yellow-bg"><img src="https://cdn-icons-png.flaticon.com/512/1040/1040230.png" width="30"></div>
                    <div class="soon-card-title">Allen, TX</div>
                    <div class="soon-badge">Launching Soon!</div>
                </div>
            </div>
            <!-- Add more fallback coming soon cities as needed -->
        </div>
        @endif
        <div class="request-city">😟 Don't see your city? We're expanding rapidly across Texas!</div>
        <button class="request-btn">🚀 Request Your City</button>
    </div>
</section>
<!-- How It Works Section - Dynamic -->
<section class="fifth-section" id="how-it-works-section">
    <div class="container">
        <h3>How it Works – Parents</h3>
        <p class="tagline">Finding the right family services has never been easier</p>
        <div class="row justify-content-center mt-5">
            <!-- Step 1 -->
            <div class="col-md-4">
                <div class="how-it-works-card">
                    <div class="how-it-works-icon-wrapper">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3 class="how-it-works-title">Search &amp; Filter</h3>
                    <p class="how-it-works-description">
                        Find nearby options by category, location, price, and ratings that match your family's needs.
                    </p>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="col-md-4">
                <div class="how-it-works-card">
                    <div class="how-it-works-icon-wrapper">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <h3 class="how-it-works-title">Compare &amp; Shortlist</h3>
                    <p class="how-it-works-description">
                        See key details, insights, and reviews on providers to make informed decisions.
                    </p>
                </div>
            </div>
            <!-- Step 3 -->
            <div class="col-md-4">
                <div class="how-it-works-card">
                    <div class="how-it-works-icon-wrapper">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h3 class="how-it-works-title">Reach Providers</h3>
                    <p class="how-it-works-description">
                        Connect directly via phone or email to ask questions and schedule visits.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Service Provider Section - Dynamic -->
<section class="sixth-section">
    <div class="container">
        <div class="tag tag-red mb-4" style="width: fit-content;margin: 0 auto;">
            For Service Providers
        </div>
        <h3>
        Are you a Provider? Use AskRoro
        </h3>
        <p class="tagline">Join thousands of providers who trust AskRoro to connect with families in their community.
        Stand<br> out where families are actively looking and grow your business.</p>
        <div class="d-flex justify-content-center align-items-center">
            <button >List Your Services - Free <i
            class="bi bi-chevron-right ms-1"></i></button>
        </div>
    </div>
</section>
<!-- Resources Section - Dynamic -->
<section class="seventh-section container">
    <h3>Parent Resources</h3>
    <p class="tagline">Expert advice, tips, and insights to help you make the best decisions for your family</p>
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
                    <a href="#" class="custom-card-link">
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
                    <h3 class="custom-card-title">Choosing the Right Daycare: A Parent's Guide</h3>
                    <p class="custom-card-text">Essential tips and questions to ask when selecting a daycare provider for your child.</p>
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
        <h3>Parent Testimonials</h3>
        <p class="tagline">See what parents in your community are saying about AskRoro</p>
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
                    <p class="testimonial-text">"AskRoro made finding the perfect daycare so much easier. The verified providers and detailed reviews gave me confidence in my choice."</p>
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
        <h3>Ready to find the perfect provider for your<br> family?</h3>
        <p class="tagline">
            Join thousands of parents who trust AskRoro to connect with quality childcare and<br> family service providers
            in their community.
        </p>
        <div class="button-group">
            <button onclick="window.location.href='{{ route('website.find-provider') }}'">Start Searching <i
            class="bi bi-chevron-right ms-1"></i></button>
            <button onclick="window.location.href='{{ route('website.find-provider') }}'">Learn More</button>
        </div>
    </div>
</section>
<!-- Cookie Banner -->
<div id="cookieBanner" class="cookie-banner bg-light border-top shadow-sm p-3 fixed-bottom d-flex justify-content-between align-items-center">
    <div class="cookie-text">
        <strong>Your family's privacy matters.</strong><br>
        AskRoro uses cookies only to provide a better service and personalize your experience.
        <a href="cookies-policy.html" class="text-primary">Learn more in our Cookie Policy</a>.
    </div>
    <button id="acceptCookies" class="btn btn-primary btn-sm ms-3">Accept</button>
</div>
@endsection