@extends('layouts.master')

@section('title', 'Find Provider - AskRoro')
@section('content')
    @push('links')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.34.1/tabler-icons.min.css"
            integrity="sha512-s0zOeW/zxh8f817uykbgBqmx1dwmdvWwQYamh+lU9NzP8jeQ/ikNPE9dBK+C55A5WUtOetZAI09tLxKIj0r9WQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- noUiSlider for price range -->
        <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css" rel="stylesheet">
    @endpush
    <div class="container-fluid">
    <div class="find-provider-page">
        <div class="site-header">
            <div class="left-head">
                <a href="/" class="back-btn" id="backBtn"><i class="ti ti-arrow-left"></i>Back to Home</a>
                <!-- <div class="brand">
                <img class="logo" src="assets/images/updated-logo.jpeg" alt="logo">
                <div>
                  <div class="brand-title">AskRoro</div>
                  <div class="tagline">Find the perfect childcare and family services</div>
                </div>
              </div> -->
            </div>
    
            <div class="header-actions">
                <div class="pill">
                    <i class="ti ti-heart me-2"></i>Favorites
                </div>
                <div class="pill compare-count-badge" onclick="showCompareModal()" id="comparePill">
                    0 to compare
                </div>
            </div>
        </div>
    
        <!-- Main layout -->
        <div class="layout-row">
    
            <!-- Left filters -->
         <div class="left-col">
         <aside class="filter-sidebar p-3">
                 <form id="searchForm" method="GET" action="{{ route('website.find-provider') }}">
               <input type="text" name="search" id="searchInput" class="input-ghost mb-3" 
                   placeholder="Search providers..." value="{{ request('search') }}">
               <input type="text" name="location" id="locationInput" class="input-ghost mb-3" 
                   placeholder="Enter location..." value="{{ request('location') }}">
            
                        <h6 class="filter-title">Service Category</h6>
                        <select name="category" id="categorySelect" class="form-select mb-3">
                            <option value="all">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
            
                        <h6 class="filter-title">Age Group</h6>
                        <select name="age_group" id="ageSelect" class="form-select mb-3">
                            <option value="all">All Ages</option>
                            @foreach($ages_served as $age)

                            <option value="{{ $age->id }}" {{ request('age_group') == $age->id ? 'selected' : '' }}>{{ $age->title }}</option>

                            @endforeach
                        </select>
            
                        <h6 class="filter-title">Distance: <span id="distanceBadge">25 miles</span></h6>
                        <input type="range" name="distance" id="distanceRange" min="1" max="100" value="{{ request('distance', 25) }}" class="custom mb-3">
            
               <h6 class="filter-title">Minimum Rating: <span id="ratingBadge">{{ request('rating', 0) }}+</span></h6>
               <input type="range" name="rating" id="ratingRange" min="0" max="5" step="0.5" 
                   value="{{ request('rating', 0) }}" class="custom mb-3">
            
               <h6 class="filter-title">Price Range</h6>
               <div id="priceSlider" class="mb-3"></div>
               <div class="d-flex gap-2 mt-2 mb-3">
                            <input type="number" name="price_min" id="priceMin" class="form-control" 
                                   placeholder="min" style="width:110px;" value="{{ request('price_min') }}">
                            <input type="number" name="price_max" id="priceMax" class="form-control" 
                                   placeholder="max" style="width:110px;" value="{{ request('price_max') }}">
                        </div>
            
                        <h6 class="filter-title mt-3 service-filter-title">Services Offered</h6>
                        <div style="max-height:140px; overflow:auto;" class="mb-3">
                            
                            @foreach($services_offerd as $service)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                           value="{{ $service->id }}"
                                           {{ in_array($service->id, (array)request('services', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $service->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="add-services-btn mt-3 w-100">Apply Filters</button>
                        <button type="button" id="resetFilters" class="btn btn-outline-secondary mt-2 w-100">Reset Filters</button>
                    </form>
                    </aside>
            </div>
    
            <!-- Right content -->
            <div class="right-col">
                <div class="providers-header">
                    <div>
                        <div class="providers-left">{{ count($providers) }} providers found</div>
                        <div class="small-muted">Showing results for your search criteria</div>
                    </div>
    
                    <div class="controls">
                        <select id="sortSelect" class="form-select form-select-sm" style="min-width:150px;">
                            <option>Top Rated</option>
                            <option>Distance</option>
                        </select>
    
                        <div class="layout-toggle ms-1" role="group">
                            <button id="gridBtn" class="active" title="Grid"><i class="ti ti-layout-grid"> </i></button>
                            <button id="listBtn" title="List"><i class="ti ti-list"> </i></button>
                        </div>
                    </div>
                </div>
    
                <!-- cards wrapper -->
                <div id="cardsContainer">
                    <div id="cards" class="cards-grid">
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
    $serviceCategories = $provider->sub_categories ?? [];
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

<div class="program-card provider-card position-relative" data-id="p{{ $provider->id }}">

    @if(!empty($provider->logo_path) && file_exists(public_path($provider->logo_path)) )
        <img class="provider-media" src="{{ asset($provider->logo_path) }}" alt="{{ $provider->business_name }}">
    
    @endif
    
    @if(isset($provider->category->name))
        <div class="card-badge provider-badge">{{ $provider->category->name??'' }}</div>
    @endif
    
    <div class="card-body">
        <div class="program-title card-title">
            {{ $provider->business_name ?? $provider->name }} 
            @if($provider->status === 'approved')
                <i style="color:#00bfa6" class="ms-1 bi bi-check2-circle"></i>
            @endif
        </div>
        
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
        
        <div class="meta-row">
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
        </div>
        
        @if($provider->ages)
            <div class="info">
                Ages: <b class="ageText-class">{{ $provider->ages->title??'' }}</b>
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
        
        @if($provider->service_description)
            <div class="service-description mt-2">
                <p class="small text-muted mb-0">
                    {{ \Illuminate\Support\Str::limit(strip_tags($provider->service_description), 80) }}
                </p>
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
@endforeach

                      
    
    
    
                    </div>
                   <div class="col-md-12">
                        @if($providers->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                        {{ $providers->links() }}
                    </div>
                @endif
                   </div>
                </div>

            </div>

    
        </div>
        </div>
    
        <!-- Enhanced Compare bottom bar -->
        <div id="compareBar" class="compare-bar" aria-hidden="true">
            <div class="compare-header">
                <h3 class="compare-title">Compare Providers</h3>
                <button id="closeCompare"
                    style="background:none; border:none; font-size:18px; color:#6b7280; cursor:pointer;">✕</button>
            </div>
    
            <div class="compare-list" id="compareList"></div>
    
            <div class="compare-actions">
                <button id="clearCompare" class="compare-clear">Clear All</button>
                <button id="doCompare" class="compare-final-btn">View Detail Comparision (0)</button>
            </div>
        </div>
    </div>
   

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>


      <script>
            const baseUrl='{{ url('/') }}';

        // Form auto-submit on filter change
        const searchForm = document.getElementById('searchForm');
        const filterElements = [
            'searchInput', 'locationInput', 'categorySelect', 'ageSelect', 
            'distanceRange', 'ratingRange', 'sortSelect'
        ];

        filterElements.forEach(elementId => {
            const element = document.getElementById(elementId);
            if (element) {
                element.addEventListener('change', () => {
                    searchForm.submit();
                });
            }
        });

        // Real-time search with debounce
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });

        // Reset filters
        document.getElementById('resetFilters')?.addEventListener('click', () => {
            // Clear all form inputs
            searchForm.reset();
            // Reset price slider if exists
            if (priceSlider && priceSlider.noUiSlider) {
                priceSlider.noUiSlider.set([0, 500]);
            }
            searchForm.submit();
        });

        // ---------- PRICE slider (noUiSlider) ----------
        const priceSlider = document.getElementById('priceSlider');
        if (priceSlider) {
            const priceMin = document.getElementById('priceMin');
            const priceMax = document.getElementById('priceMax');
            
            const minPrice = {{ request('price_min', 0) }};
            const maxPrice = {{ request('price_max', 500) }};

            noUiSlider.create(priceSlider, {
                start: [minPrice, maxPrice],
                connect: true,
                range: {
                    min: 0,
                    max: 2500
                },
                step: 5,
                format: {
                    to: v => Math.round(v),
                    from: v => Number(v)
                }
            });

            priceSlider.noUiSlider.on('update', (vals) => {
                priceMin.value = vals[0];
                priceMax.value = vals[1];
            });

            priceSlider.noUiSlider.on('change', () => {
                searchForm.submit();
            });

            priceMin.addEventListener('change', () => {
                priceSlider.noUiSlider.set([priceMin.value, null]);
                searchForm.submit();
            });
            
            priceMax.addEventListener('change', () => {
                priceSlider.noUiSlider.set([null, priceMax.value]);
                searchForm.submit();
            });
        }

        // Rest of your existing JavaScript code for range backgrounds, layout toggle, compare functionality...
        // ... [keep all your existing JavaScript code for UI interactions]
    </script>
    <script>


        // ---------- custom single-thumb slider background fill ----------
        function updateRangeBackground(rangeEl, color) {
            const val = Number(rangeEl.value);
            const min = Number(rangeEl.min) || 0;
            const max = Number(rangeEl.max) || 100;
            const percent = ((val - min) / (max - min)) * 100;
            rangeEl.style.background = `linear-gradient(90deg, ${color} ${percent}%, #d1d5db ${percent}%)`;
        }

        const distanceRange = document.getElementById('distanceRange');
        const ratingRange = document.getElementById('ratingRange');
        const distanceBadge = document.getElementById('distanceBadge');
        const ratingBadge = document.getElementById('ratingBadge');

        // init
        if (distanceRange) {
            updateRangeBackground(distanceRange, '#337d7c');
            distanceBadge.textContent = distanceRange.value + ' miles';
        }
        if (ratingRange) {
            updateRangeBackground(ratingRange, '#337d7c');
            ratingBadge.textContent = ratingRange.value + '+';
        }

        if (distanceRange) {
            distanceRange.addEventListener('input', () => {
                updateRangeBackground(distanceRange, '#337d7c');
                distanceBadge.textContent = distanceRange.value + ' miles';
            });
        }
        if (ratingRange) {
            ratingRange.addEventListener('input', () => {
                updateRangeBackground(ratingRange, '#337d7c');
                ratingBadge.textContent = ratingRange.value + '+';
            });
        }

        // ---------- Layout toggle ----------
        const gridBtn = document.getElementById('gridBtn');
        const listBtn = document.getElementById('listBtn');
        const cardsContainer = document.getElementById('cardsContainer');

        if (gridBtn && listBtn && cardsContainer) {
            gridBtn.addEventListener('click', () => {
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
                document.body.classList.remove('list-mode');
                cardsContainer.classList.remove('list-mode');
            });
            listBtn.addEventListener('click', () => {
                listBtn.classList.add('active');
                gridBtn.classList.remove('active');
                document.body.classList.add('list-mode');
                cardsContainer.classList.add('list-mode');
            });
        }

        // ---------- Enhanced Compare logic ----------
            document.querySelectorAll('.compare-btn').forEach(button => {
        button.addEventListener('click', function() {
            const providerId = this.getAttribute('data-provider-id');
            toggleCompareProvider(providerId, this);
        });
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
            
     
        } else {
            
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
