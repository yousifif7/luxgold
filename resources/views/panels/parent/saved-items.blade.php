@extends('layouts.parent-layout')

@section('parent-title', 'Saved Items - Customer Portal')
@section('content')

<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <div class="section-card">
            <div class="section-title">Saved Items</div>
            <div class="section-subtitle">Your saved cleaners and events for easy access</div>

            <ul class="nav nav-pills mb-4" id="savedTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="saved-providers-tab" data-bs-toggle="pill" data-bs-target="#saved-providers" type="button">
                        Saved Cleaners ({{ $savedProviders->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="saved-events-tab" data-bs-toggle="pill" data-bs-target="#saved-events" type="button">
                        Saved Events ({{ count($savedEvents) }})
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Saved Providers Tab -->
                <div class="tab-pane fade show active" id="saved-providers">
                    @forelse($savedProviders as $savedProvider)
                    <div class="provider-card mb-3">
                        <div class="provider-avatar bg-primary">
                            {{ substr($savedProvider->cleaner->name, 0, 1) }}
                        </div>
                        <div class="provider-info">
                            <div class="provider-name">{{ $savedProvider->cleaner->name }}</div>
                            <div class="provider-type">{{ $savedProvider->cleaner->type ?? 'Childcare Provider' }}</div>
                            <div class="mt-2">
                                <i class="fas fa-star text-warning"></i>
                                <span class="rating-number">{{ number_format($savedProvider->cleaner->averageRating() ?? 0, 1) }}</span>
                                <span class="ms-3"><i class="fas fa-map-marker-alt"></i> {{ $savedProvider->cleaner->location ?? 'N/A' }}</span>
                            </div>
                            <div class="mt-1">
                                <strong>
                                    @if($savedProvider->cleaner->pricing_type === 'hourly')
                                        ${{ number_format($savedProvider->cleaner->price ?? 0) }}/hour
                                    @elseif($savedProvider->cleaner->pricing_type === 'monthly')
                                        ${{ number_format($savedProvider->cleaner->price ?? 0) }}/month
                                    @else
                                        Contact for pricing
                                    @endif
                                </strong>
                                <span class="ms-3">
                                    <i class="fas fa-users"></i> 
                                    {{ $savedProvider->cleaner->capacity ?? 'N/A' }} children
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small mb-2">Saved {{ $savedProvider->created_at->format('M d, Y') }}</div>
                            <a href="{{ route('website.cleaner-detail', $savedProvider->cleaner->id) }}" class="btn btn-outline-custom btn-sm me-2">View Details</a>
                            <form action="{{ route('saved-cleaners.destroy', $savedProvider->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove this cleaner from saved items?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h5>No Saved Cleaners</h5>
                        <p class="text-muted">You haven't saved any cleaners yet.</p>
                        <a href="{{ route('website.find-cleaner') }}" class="btn btn-primary">Browse Cleaners</a>
                    </div>
                    @endforelse
                </div>

                <!-- Saved Events Tab -->
                <div class="tab-pane fade" id="saved-events">
                    @forelse($savedEvents as $savedEvent)
                    <div class="event-card mb-3">
                        <div class="d-flex align-items-center flex-grow-1">
                            <div class="event-icon">
                                <i class="fas fa-calendar text-primary"></i>
                            </div>
                            <div class="event-details">
                                <div class="event-title">{{ $savedEvent->event->title }}</div>
                                <div class="event-subtitle">{{ $savedEvent->event->provider->name ?? 'Cleaner' }}</div>
                                <div class="event-meta text-muted small mt-1">
                                    <i class="fas fa-map-marker-alt"></i> {{ $savedEvent->event->location }}
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div><strong>{{ $savedEvent->event->created_at->format('M d, Y') }}</strong></div>
                            <div class="text-muted">{{ $savedEvent->event->start_time }}</div>
                            <form action="{{ route('saved-events.destroy', $savedEvent->id) }}" method="POST" class="d-inline mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove this event from saved items?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <h5>No Saved Events</h5>
                        <p class="text-muted">You haven't saved any events yet.</p>
                        <a href="#" class="btn btn-primary">Browse Events</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- card end -->

    </div>
    <!-- End Content -->            

</div>

@endsection

@push('styles')
<style>
.provider-card {
    display: flex;
    align-items: center;
    padding: 20px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    background: white;
    transition: all 0.3s ease;
}

.provider-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.provider-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.5rem;
    color: white;
    margin-right: 20px;
    flex-shrink: 0;
}

.provider-info {
    flex-grow: 1;
}

.provider-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 4px;
}

.provider-type {
    color: #6c757d;
    font-size: 0.9rem;
}

.rating-number {
    font-weight: 600;
    color: #333;
}

.event-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    background: white;
    transition: all 0.3s ease;
}

.event-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.event-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 1.25rem;
}

.event-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 4px;
}

.event-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
}

.event-meta {
    font-size: 0.85rem;
}

.btn-outline-custom {
    border-color: #007bff;
    color: #007bff;
}

.btn-outline-custom:hover {
    background-color: #007bff;
    color: white;
}

.nav-pills .nav-link.active {
    background-color: #007bff;
    color: white;
}

.nav-pills .nav-link {
    color: #6c757d;
}

.text-muted {
    color: #6c757d !important;
}
</style>
@endpush