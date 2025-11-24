@extends('layouts.parent-layout')

@section('parent-title', 'Dashboard - Cleaner Portal')
@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Welcome, {{ Auth::user()->first_name }}</h4>
                <p class="mb-0">Here's your activity summary for this week</p>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Activity Summary Widget -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-title">Activity Summary - This Week</div>
                    <div class="section-subtitle">Your engagement overview</div>
                    
                    <div class="row">
                        <!-- Providers Viewed -->
                        <div class="col-md-3 col-6">
                            <div class="activity-stat-card">
                                <div class="activity-icon bg-primary">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="activity-info">
                                    <div class="activity-number">{{ $activityStats['providers_viewed'] }}</div>
                                    <div class="activity-label">Cleaners Viewed</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Messages Received -->
                        <div class="col-md-3 col-6">
                            <div class="activity-stat-card">
                                <div class="activity-icon bg-success">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="activity-info">
                                    <div class="activity-number">{{ $activityStats['messages_received'] }}</div>
                                    <div class="activity-label">Messages Received</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Inquiries Sent -->
                        <div class="col-md-3 col-6">
                            <div class="activity-stat-card">
                                <div class="activity-icon bg-info">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="activity-info">
                                    <div class="activity-number">{{ $activityStats['inquiries_sent'] }}</div>
                                    <div class="activity-label">Inquiries Sent</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Average Rating Given -->
                        <div class="col-md-3 col-6">
                            <div class="activity-stat-card">
                                <div class="activity-icon bg-warning">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="activity-info">
                                    <div class="activity-number">{{ number_format($activityStats['avg_rating_given'], 1) }}</div>
                                    <div class="activity-label">Avg Rating Given</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Row -->
        <div class="row">
            <!-- Saved Providers -->
            <div class="col-md-4">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-heart fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Saved Cleaners</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['saved_providers'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Upcoming Events -->
            <div class="col-md-4">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-calendar fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Upcoming Events</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['upcoming_events'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Reviews Given -->
            <div class="col-md-4">
                <div class="card pb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 pb-0 mb-1">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-icon bg-primary rounded-circle flex-shrink-0">
                                <i class="ti ti-star fs-20"></i>
                            </span>
                            <div class="ms-3">
                               <p class="mb-1 text-truncate">Reviews Provided</p>
                               <h6 class="mb-0 fw-semibold">{{ $stats['reviews_given'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Recently Viewed Column -->
            <div class="col-lg-6">
                <div class="section-card">
                    <div class="section-title">Recently Viewed</div>
                    <div class="section-subtitle">Cleaners you've looked at recently</div>
                    
                    @forelse($recentlyViewed as $viewed)
                    <div class="provider-card">
                        <div class="provider-avatar bg-primary">
                            {{ substr($viewed->provider->name, 0, 1) }}
                        </div>
                        <div class="provider-info">
                            <div class="provider-name">{{ $viewed->provider->name }}</div>
                            <div class="provider-type">{{ $viewed->provider->type }}</div>
                        </div>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <span class="rating-number">{{ number_format($viewed->provider->reviews_avg_rating ?? 0, 1) }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-eye-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No recently viewed Cleaners</p>
                    </div>
                    @endforelse

                    @if($recentlyViewed->count() > 0)
                    <a href="{{ url('cleaners.recent') }}" class="btn btn-primary w-100 mt-3">View All Recent</a>
                    @else
                    <a href="{{ route('website.find-cleaner') }}" class="btn btn-primary w-100 mt-3">Browse Cleaners</a>
                    @endif
                </div>
            </div>

            <!-- Provider Recommendations & Events Column -->
            <div class="col-lg-6">
                <!-- Provider Recommendations -->
                <div class="section-card">
                    <div class="section-title">Cleaner Recommendations</div>
                    <div class="section-subtitle">Personalized suggestions just for you</div>
                    
                    <!-- Top Rated in Your City Carousel -->
                    @if($recommendations['top_rated']->count() > 0)
                    <div class="recommendation-section">
                        <div class="recommendation-header">
                            <h6 class="mb-2">⭐ Top Rated in {{ $user->city ?? 'Your City' }}</h6>
                            <p class="text-muted small mb-3">Highly recommended by other customers</p>
                        </div>
                        <div class="recommendation-carousel">
                            @foreach($recommendations['top_rated'] as $provider)
                            <div class="recommendation-card">
                                <div class="recommendation-avatar bg-primary">
                                    {{ substr($provider->name, 0, 1) }}
                                </div>
                                <div class="recommendation-info">
                                    <div class="recommendation-name">{{ $provider->name }}</div>
                                    <div class="recommendation-type">{{ $provider->type }}</div>
                                    <div class="recommendation-rating">
                                        <i class="fas fa-star text-warning"></i>
                                        <span>{{ number_format($provider->reviews_avg_rating ?? 0, 1) }}</span>
                                        <span class="text-muted">({{ $provider->reviews_count ?? 0 }} reviews)</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Newly Joined Providers Carousel -->
                    @if($recommendations['new_providers']->count() > 0)
                    <div class="recommendation-section mt-4">
                        <div class="recommendation-header">
                            <h6 class="mb-2">🆕 Newly Joined Cleaners</h6>
                            <p class="text-muted small mb-3">Fresh options to explore</p>
                        </div>
                        <div class="recommendation-carousel">
                            @foreach($recommendations['new_providers'] as $provider)
                            <div class="recommendation-card">
                                <div class="recommendation-avatar bg-success">
                                    {{ substr($provider->name, 0, 1) }}
                                </div>
                                <div class="recommendation-info">
                                    <div class="recommendation-name">{{ $provider->name }}</div>
                                    <div class="recommendation-type">{{ $provider->type }}</div>
                                    <div class="recommendation-new-badge">
                                        <span class="badge bg-success">NEW</span>
                                        <span class="text-muted small">Joined {{ $provider->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Based on What Parents Near You Viewed Carousel -->
                    @if($recommendations['trending_nearby']->count() > 0)
                    <div class="recommendation-section mt-4">
                        <div class="recommendation-header">
                            <h6 class="mb-2">👀 Trending Nearby</h6>
                            <p class="text-muted small mb-3">What other customers in your area are viewing</p>
                        </div>
                        <div class="recommendation-carousel">
                            @foreach($recommendations['trending_nearby'] as $provider)
                            <div class="recommendation-card">
                                <div class="recommendation-avatar bg-info">
                                    {{ substr($provider->name, 0, 1) }}
                                </div>
                                <div class="recommendation-info">
                                    <div class="recommendation-name">{{ $provider->name }}</div>
                                    <div class="recommendation-type">{{ $provider->type }}</div>
                                    <div class="recommendation-trending">
                                        <i class="fas fa-chart-line text-info"></i>
                                        <span class="text-muted small">{{ $provider->recent_views }} views this week</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($recommendations['top_rated']->count() == 0 && 
                        $recommendations['new_providers']->count() == 0 && 
                        $recommendations['trending_nearby']->count() == 0)
                    <div class="text-center py-4">
                        <i class="fas fa-lightbulb fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No recommendations available yet</p>
                        <p class="text-muted small">Complete your profile to get personalized suggestions</p>
                    </div>
                    @endif

                    <a href="{{ route('website.find-cleaner') }}" class="btn btn-primary w-100 mt-3">Explore All Cleaners</a>
                </div>

                <!-- Upcoming Events -->
                <div class="section-card mt-3">
                    <div class="section-title">Saved Events</div>
                    <div class="section-subtitle">Don't miss these important dates</div>

                    @forelse($upcomingEvents as $event)
                    <div class="event-card">
                        <div class="d-flex align-items-center">
                            <div class="event-icon">
                                <i class="ti ti-calendar text-primary"></i>
                            </div>
                            <div class="event-details">
                                <div class="event-title">{{ $event->title }}</div>
                                <div class="event-subtitle">{{ $event->provider->name }}</div>
                            </div>
                        </div>
                        <div class="event-date">
                            <div><strong>{{ $event->start_date->format('M d, Y') }}</strong></div>
                            <div>{{ $event->start_date->format('g:i A') }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No upcoming events</p>
                    </div>
                    @endforelse

                    @if($upcomingEvents->count() > 0)
                    <a href="{{ route('parent-saved-items') }}" class="btn btn-outline-primary w-100 mt-3">View All Events</a>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <!-- End Content -->            

</div>
@endsection

@push('styles')
<style>
.provider-card {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 10px;
    background: white;
    transition: all 0.3s ease;
}

.provider-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.provider-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    color: white;
    margin-right: 15px;
    flex-shrink: 0;
}

.provider-info {
    flex-grow: 1;
}

.provider-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.provider-type {
    color: #6c757d;
    font-size: 0.9rem;
}

.rating {
    text-align: right;
}

.rating-number {
    font-weight: 600;
    color: #333;
}

.badge-match {
    background: #28a745;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.event-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 10px;
    background: white;
}

.event-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.event-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.event-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
}

.event-date {
    text-align: right;
    font-size: 0.9rem;
}

.section-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.section-subtitle {
    color: #6c757d;
    margin-bottom: 15px;
    font-size: 0.9rem;
}

/* Activity Summary Styles */
.activity-stat-card {
    display: flex;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
}

.activity-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.activity-icon i {
    font-size: 1.25rem;
    color: white;
}

.activity-info {
    flex-grow: 1;
}

.activity-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    line-height: 1;
}

.activity-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 2px;
}

/* Recommendation Styles */
.recommendation-section {
    margin-bottom: 20px;
}

.recommendation-header h6 {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.recommendation-carousel {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding: 5px 0;
    scrollbar-width: thin;
}

.recommendation-carousel::-webkit-scrollbar {
    height: 6px;
}

.recommendation-carousel::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.recommendation-carousel::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.recommendation-card {
    flex: 0 0 auto;
    width: 200px;
    padding: 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    background: white;
    transition: all 0.3s ease;
}

.recommendation-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.recommendation-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    margin-bottom: 10px;
}

.recommendation-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
    font-size: 0.9rem;
}

.recommendation-type {
    color: #6c757d;
    font-size: 0.8rem;
    margin-bottom: 8px;
}

.recommendation-rating,
.recommendation-new-badge,
.recommendation-trending {
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.recommendation-new-badge .badge {
    font-size: 0.6rem;
    padding: 2px 6px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .activity-stat-card {
        padding: 12px;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        margin-right: 12px;
    }
    
    .activity-number {
        font-size: 1.25rem;
    }
    
    .activity-label {
        font-size: 0.8rem;
    }

    .recommendation-card {
        width: 180px;
    }

    .recommendation-carousel {
        gap: 8px;
    }
}

@media (max-width: 576px) {
    .recommendation-card {
        width: 160px;
        padding: 12px;
    }
}
</style>
@endpush