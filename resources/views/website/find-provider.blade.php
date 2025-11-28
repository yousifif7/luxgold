@extends('layouts.master')

@section('title', 'Find Cleaners - luxGold')
@section('content')
    @push('links')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.34.1/tabler-icons.min.css"
            integrity="sha512-s0zOeW/zxh8f817uykbgBqmx1dwmdvWwQYamh+lU9NzP8jeQ/ikNPE9dBK+C55A5WUtOetZAI09tLxKIj0r9WQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- noUiSlider for price range -->
        <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css" rel="stylesheet">
         <style>
             .mobile-filter-btn {
            display: none;
            background: #ff6b47;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 1rem;
            width: 100%;
        }
                /* Mobile Filter Modal */
        .filter-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .filter-modal-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 85%;
            height: 100%;
            background: white;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .filter-modal.active .filter-modal-content {
            transform: translateX(0);
        }

        .filter-modal-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: between;
            align-items: center;
            background: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .mobile-filter-btn {
            display: none;
            background: #3b82f6;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 1rem;
            width: 100%;
        }

        .filter-actions-mobile {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            background: white;
            position: sticky;
            bottom: 0;
            display: flex;
            gap: 0.75rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .left-col {
                display: none;
            }

            .mobile-filter-btn {
                display: block;
            }

            .filter-sidebar {
                padding: 1rem;
                box-shadow: none;
                border-radius: 0;
            }
        }
        </style>
    @endpush

  

    <div class="find-provider-page">
         <div class="container-fluid">
        <div class="site-header">
            <div class="left-head">
                <a href="/" class="back-btn" id="backBtn"><i class="ti ti-arrow-left"></i>Back to Home</a>
            </div>
    
            {{-- <div class="header-actions">
               
                <div class="pill compare-count-badge" onclick="showCompareModal()" id="comparePill">
                    0 to compare
                </div>
            </div> --}}
        </div>
    
        <!-- Mobile Filter Button -->
        <button class="mobile-filter-btn" id="mobileFilterBtn">
            <i class="ti ti-filter me-2"></i>Show Filters
        </button>

        <!-- Main layout -->
        <div class="layout-row">
    
            <!-- Left filters - Desktop -->
            <div class="left-col">
                <aside class="filter-sidebar">
                    <div class="filter-header">
                        <h5 class="mb-0">Filters</h5>
                        <span class="text-muted" style="font-size: 0.8rem;">Refine your search</span>
                    </div>

                    <form id="searchForm" method="GET" action="{{ route('website.find-cleaner') }}">
                           <input type="text" name="search" id="searchInput" class="input-ghost" 
                               placeholder="🔍 Search cleaners..." value="{{ request('search') }}">
                        <input type="text" name="location" id="locationInput" class="input-ghost" 
                               placeholder="📍 Enter location..." value="{{ request('location') }}">
            
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
            
                      
                          <h6 class="filter-title">Minimum Rating: <span id="ratingBadge">{{ request('rating', 0) }}+</span></h6>
                        <input type="range" name="rating" id="ratingRange" min="0" max="5" step="0.5" 
                               value="{{ request('rating', 0) }}" class="custom mb-2">
            
                        <h6 class="filter-title">Price Range</h6>
                        <div id="priceSlider" class="mb-3"></div>
                        <div class="d-flex gap-2">
                            <input type="number" name="price_min" id="priceMin" class="form-control input-ghost" 
                                   placeholder="Min price" value="{{ request('price_min') }}">
                            <input type="number" name="price_max" id="priceMax" class="form-control input-ghost" 
                                   placeholder="Max price" value="{{ request('price_max') }}">
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

                        <div class="mt-4">
                              <button type="submit" class="add-services-btn mt-3 w-100">Apply Filters</button>
                        <button type="button" id="resetFilters" class="btn btn-outline-secondary mt-2 w-100">Reset Filters</button>
                        </div>
                    </form>
                </aside>
            </div>
    
            <!-- Right content -->
            <div class="right-col">
                <div class="providers-header">
                    <div>
                        <div class="providers-left">{{ count($providers) }} cleaners found</div>
                        <div class="small-muted">Showing results for your search criteria</div>
                    </div>
    
                    <div class="controls">
                       
    
                        <div class="layout-toggle ms-1" role="group">
                            <button id="gridBtn" class="active" title="Grid"><i class="ti ti-layout-grid"> </i></button>
                            <button id="listBtn" title="List"><i class="ti ti-list"> </i></button>
                        </div>
                    </div>
                </div>
    
                <!-- cards wrapper -->
                <div id="cardsContainer">
                    <div id="cards" class="cards-grid">
                        @foreach($providers as $provider)
                        @php
                            // Calculate average rating and review count
                            $reviews = $provider->reviews()->where('status', 'approved')->get();
                            $averageRating = $provider->averageRating();
                            $reviewCount = $reviews->count();
                            
                            // Get provider category name
                            $category = $provider->category;
                            
                            // Parse service categories if available
                            $serviceCategories = $provider->service_categories ?? [];
                            $firstCategory = !empty($serviceCategories) ? $serviceCategories[0] : ($category ?: 'Provider');
                            
                            // Parse special features for tags (diversity badges removed from public lists)
                            $specialFeatures = $provider->special_features ??  [];
                            
                            // Combine tags from various sources
                            $allTags = $specialFeatures;
                            $displayTags = array_slice($allTags, 0, 4);
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
        <img class="provider-media" src="{{ asset($provider->logo_path) }}" alt="{{ $provider->name }}">
        @else
        <div style="height: 180px; display: flex; align-items: center; text-align: center; justify-content: center;"><h2 style="color:#337d7c; font-weight: 600; margin-top: 30px">                                    {{ $provider->name }} 
</h2></div>
    
    @endif
                               
                            
                            @if($firstCategory)
                                <div class="card-badge provider-badge">{{ data_get($firstCategory, 'name', $firstCategory) }}</div>
                            @endif
                            
                            <div class="card-body">
                                <div class="program-title card-title">
                                    {{ $provider->name }} 
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
                                
                                @if($provider->service_description)
                                    <div class="service-description mt-2">
                                        <p class="small text-muted mb-0">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($provider->service_description), 80) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="card-footer">
                                {{-- <button data-id="p{{ $provider->id }}" data-provider-id="{{ $provider->id }}" class="btn-compare compare-btn">
                                    Compare
                                </button> --}}
                                <a class="btn-view" href="{{ route('website.cleaner-detail', $provider->id) }}">
                                    View Details
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                 <div class="col-md-12">
                        @if($providers->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                        {{ $providers->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Mobile Filter Modal -->
        <div class="filter-modal" id="filterModal">
            <div class="filter-modal-content">
                <div class="filter-modal-header">
                    <h5 class="mb-0">Filters</h5>
                    <button id="closeFilterModal" style="background:none; border:none; font-size:1.5rem; color:#6b7280;">✕</button>
                </div>
                <div class="filter-sidebar">
                    <!-- Same filter form content as desktop -->
                    <form id="mobileSearchForm" method="GET" action="{{ route('website.find-cleaner') }}">
                           <input type="text" name="search" class="input-ghost" 
                               placeholder="🔍 Search cleaners..." value="{{ request('search') }}">
                        <input type="text" name="location" class="input-ghost" 
                               placeholder="📍 Enter location..." value="{{ request('location') }}">
            
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
            
                       
            
                        <h6 class="filter-title">Minimum Rating: <span id="ratingBadge">{{ request('rating', 0) }}+</span></h6>
                        <input type="range" name="rating" id="ratingRange" min="0" max="5" step="0.5" 
                               value="{{ request('rating', 0) }}" class="custom mb-2">
            
                        <h6 class="filter-title">Price Range</h6>
                        <div id="priceSlider" class="mb-3"></div>
                        <div class="d-flex gap-2">
                            <input type="number" name="price_min" id="priceMin" class="form-control input-ghost" 
                                   placeholder="Min price" value="{{ request('price_min') }}">
                            <input type="number" name="price_max" id="priceMax" class="form-control input-ghost" 
                                   placeholder="Max price" value="{{ request('price_max') }}">
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
                    </form>
                </div>
                <div class="filter-actions-mobile">
                    <button type="submit" class="add-services-btn mt-3 w-100">Apply Filters</button>
                        <button type="button" id="resetFilters" class="btn btn-outline-secondary mt-2 w-100">Reset Filters</button>
                </div>
            </div>
        </div>
    
        <!-- Enhanced Compare bottom bar -->
        {{-- <div id="compareBar" class="compare-bar" aria-hidden="true">
            <div class="compare-header">
                <h3 class="compare-title">Compare Cleaners</h3>
                <button id="closeCompare" onclick="hideCompareModal()" 
                    style="background:none; border:none; font-size:18px; color:#6b7280; cursor:pointer;">✕</button>
            </div>
    
            <div class="compare-list" id="compareList"></div>
    
            <div class="compare-actions">
                <button id="clearCompare" onclick="clearCompareList()" class="compare-clear">Clear All</button>
                <button id="doCompare" class="compare-final-btn">View Detail Comparision (0)</button>
            </div>
        </div> --}}
    </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>
    <script>
  


        // Mobile filter modal handlers
        function initializeMobileFilters() {
            const filterModal = document.getElementById('filterModal');
            const mobileFilterBtn = document.getElementById('mobileFilterBtn');
            const closeFilterModal = document.getElementById('closeFilterModal');
            const mobileApplyFilters = document.getElementById('mobileApplyFilters');
            const mobileResetFilters = document.getElementById('mobileResetFilters');

            if (mobileFilterBtn) {
                mobileFilterBtn.addEventListener('click', function() {
                    filterModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            if (closeFilterModal) {
                closeFilterModal.addEventListener('click', function() {
                    filterModal.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }

            if (mobileApplyFilters) {
                mobileApplyFilters.addEventListener('click', function() {
                    document.getElementById('mobileSearchForm').submit();
                });
            }

            if (mobileResetFilters) {
                mobileResetFilters.addEventListener('click', function() {
                    const form = document.getElementById('mobileSearchForm');
                    form.reset();
                    // Reset price slider
                    if (window.mobilePriceSlider) {
                        window.mobilePriceSlider.set([0, 1000]);
                    }
                    // Reset range badges
                    document.getElementById('mobileDistanceBadge').textContent = '25 miles';
                    document.getElementById('mobileRatingBadge').textContent = '0+';
                });
            }

            // Close modal when clicking outside
            filterModal.addEventListener('click', function(e) {
                if (e.target === filterModal) {
                    filterModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }

        // Reset filters handler
        document.getElementById('resetFilters')?.addEventListener('click', function() {
            document.getElementById('searchForm').reset();
            if (window.priceSlider) {
                window.priceSlider.set([0, 1000]);
            }
            document.getElementById('distanceBadge').textContent = '25 miles';
            document.getElementById('ratingBadge').textContent = '0+';
        });

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {

            initializeMobileFilters();
        });
    </script>
    @endpush
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
            showToast('Cleaner added to compare list!', 'success');
            
     
        } else {
                        showToast(data.message, 'warning');

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

function hideCompareModal(){
                const compareBar = document.getElementById('compareBar');
                compareBar.classList.remove('open');

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
                        <div class="small fw-bold mt-1">${provider.name || provider.business_name}</div>
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
            showToast('Cleaner removed from compare list', 'info');
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
            const compareModal = document.getElementById('compareBar');
            compareModal.classList.remove('open');
            
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
