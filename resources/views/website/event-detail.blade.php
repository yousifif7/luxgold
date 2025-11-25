@extends('layouts.master')

@section('title', 'Event Detail - luxGold')
@section('content')
<style>

:root {
    --primary-color: #00bfa6;
    --primary-dark: #00a892;
    --primary-light: #e6f7f5;
    --secondary-color: #6c757d;
    --dark-text: #2d3748;
    --light-bg: #f8f9fa;
    --border-radius: 16px;
    --shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --gradient-primary: linear-gradient(135deg, #00bfa6 0%, #00a892 100%);
    --gradient-secondary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
    .event-detail-section-main-wrapper {
        padding: 2rem 0;
    }
    
    .event-detail-image-container {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    
    .event-detail-main-image {
        width: 100%;
        height: 450px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .event-detail-image-container:hover .event-detail-main-image {
        transform: scale(1.03);
    }
    
    .event-detail-placeholder-image {
        width: 100%;
        height: 450px;
        border-radius: var(--border-radius);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    
    .event-details-card {
        margin-top: 2rem;
    }
    
    .event-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 1rem;
        line-height: 1.2;
    }
    
    .event-subtitle {
        font-size: 1.25rem;
        color: var(--secondary-color);
        margin-bottom: 2rem;
    }
    
    .event-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .event-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    
    .meta-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        font-size: 1.25rem;
    }
    
    .meta-label {
        font-size: 0.875rem;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .meta-value {
        font-weight: 600;
        color: var(--dark-text);
        line-height: 1.5;
    }
    
    .capacity-indicator {
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
        background: #e9ecef;
        margin-top: 0.5rem;
    }
    
    .capacity-fill {
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        transition: width 0.5s ease;
    }
    
    .section-title {
        color: var(--dark-text);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--light-bg);
        font-weight: 600;
        position: relative;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background: var(--primary-color);
    }
    
    .event-description {
        line-height: 1.7;
        color: #495057;
        font-size: 1.05rem;
    }
    
    .event-registration-section {
        margin-top: 2rem;
    }
    

    
    .event-action-buttons-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    
    .event-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem;
        border: 1px solid #e9ecef;
        border-radius: var(--border-radius);
        background: white;
        transition: var(--transition);
        cursor: pointer;
    }
    
    .event-action-btn:hover {
        border-color: var(--primary-color);
        background: #f8f9fa;
        transform: translateY(-3px);
    }
    
    .event-action-btn.saved {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    
    .action-icon {
        font-size: 1.5rem;
    }
    
    .action-text {
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .quick-actions-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .quick-action-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .quick-action-item:hover {
        background: var(--light-bg);
        transform: translateX(5px);
    }
    
    .event-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    
    .stat-item {
        padding: 1rem;
        background: var(--light-bg);
        border-radius: 8px;
        transition: var(--transition);
    }
    
    .stat-item:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modal-content {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    .modal-header {
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem;
    }
    
    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 1.5rem;
    }
    
    .form-control {
        border-radius: 8px;
        border: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: var(--transition);
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25);
    }
    
    .event-success-alert {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        border-radius: var(--border-radius);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        border: none;
    }
    
    @media (max-width: 768px) {
        .event-title {
            font-size: 2rem;
        }
        
        .event-meta-grid {
            grid-template-columns: 1fr;
        }
        
        .event-action-buttons-grid {
            grid-template-columns: 1fr;
        }
        
        .header-actions {
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
        }
        
        .pill {
            justify-content: center;
        }
    }
</style>


<div class="find-provider-page">
    <div class="site-header">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="left-head mb-3 mb-md-0">
                    <a href="{{ url()->previous() }}" class="back-btn" id="backBtn">
                        <i class="ti ti-arrow-left"></i>Back to Previous
                    </a>
                </div>

                <div class="header-actions">
                    <div class="pill" onclick="downloadEventInfo()">
                        <i class="ti ti-download me-2"></i>Download 
                    </div>
                    <div class="pill" onclick="printEventInfo()">
                        <i class="ti ti-printer me-2"></i>Print
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container event-detail-section-main-wrapper">
        <div class="row g-4 align-items-start">

            <!-- Left: Event Content -->
            <div class="col-lg-8">
                <div class="event-detail-image-container position-relative">
                    @if($event->image_url)
                        <img src="{{ asset($event->image_url) }}"
                             class="event-detail-main-image"
                             alt="{{ $event->title }}">
                    @else
                        <div class="event-detail-placeholder-image bg-light d-flex align-items-center justify-content-center">
                            <i class="ti ti-calendar-event" style="font-size: 4rem; color: rgba(255,255,255,0.8);"></i>
                        </div>
                    @endif
                    
                    @if($event->cost == 0)
                        <div class="event-badge">
                            <i class="ti ti-gift me-1"></i>Free Event
                        </div>
                    @endif
                </div>

                <!-- Event Details Card -->
                <div class="event-details-card">
                    <div class="card border-0" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="event-title">{{ $event->title }}</h1>
                            
                            @if($event->subtitle)
                                <p class="event-subtitle">{{ $event->subtitle }}</p>
                            @endif

                            <!-- Event Meta Information -->
                            <div class="event-meta-grid">
                                <div class="event-meta-item">
                                    <div class="meta-icon">
                                        <i class="ti ti-calendar"></i>
                                    </div>
                                    <div class="meta-content">
                                        <div class="meta-label">Date & Time</div>
                                        <div class="meta-value">
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y') }}
                                            <br>
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }}
                                            @if($event->end_date)
                                                - {{ \Carbon\Carbon::parse($event->end_date)->format('g:i A') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="event-meta-item">
                                    <div class="meta-icon">
                                        <i class="ti ti-map-pin"></i>
                                    </div>
                                    <div class="meta-content">
                                        <div class="meta-label">Location</div>
                                        <div class="meta-value">
                                            {{ $event->location }}
                                            @if($event->city)
                                                <br>{{ $event->city }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="event-meta-item">
                                    <div class="meta-icon">
                                        <i class="ti ti-currency-dollar"></i>
                                    </div>
                                    <div class="meta-content">
                                        <div class="meta-label">Cost</div>
                                        <div class="meta-value">
                                            @if($event->cost > 0)
                                                ${{ number_format($event->cost, 2) }}
                                            @else
                                                Free
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($event->max_capacity)
                                <div class="event-meta-item">
                                    <div class="meta-icon">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <div class="meta-content">
                                        <div class="meta-label">Capacity</div>
                                        <div class="meta-value">
                                            {{ $event->current_capacity }}/{{ $event->max_capacity }} spots
                                            <div class="capacity-indicator bg-light mt-2">
                                                <div class="capacity-fill" 
                                                     style="width: {{ ($event->current_capacity / $event->max_capacity) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($event->age_group)
                                <div class="event-meta-item">
                                    <div class="meta-icon">
                                        <i class="ti ti-user"></i>
                                    </div>
                                    <div class="meta-content">
                                        <div class="meta-label">Age Group</div>
                                        <div class="meta-value">{{ $event->age_group }}</div>
                                    </div>
                                </div>
                                @endif

                                <div class="event-meta-item">
                                    <div class="meta-icon">
                                        <i class="ti ti-building"></i>
                                    </div>
                                    <div class="meta-content">
                                        <div class="meta-label">Organizer</div>
                                        <div class="meta-value">{{ $event->provider_name }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Description -->
                            @if($event->description)
                            <div class="event-description-section mt-4">
                                <h5 class="section-title">About This Event</h5>
                                <div class="event-description">
                                    {!! nl2br(e($event->description)) !!}
                                </div>
                            </div>
                            @endif

                            <!-- Event Registration Button -->
                            <div class="event-registration-section">
                                @if($event->max_capacity && $event->current_capacity >= $event->max_capacity)
                                    <button class="btn btn-secondary w-100 py-3" disabled>
                                        <i class="ti ti-user-off me-2"></i>Event Full
                                    </button>
                                @elseif($event->start_date < now())
                                    <button class="btn btn-secondary w-100 py-3" disabled>
                                        <i class="ti ti-clock-off me-2"></i>Event Ended
                                    </button>
                                @else
                                    <button class="btn btn-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#registrationModal">
                                        <i class="ti ti-ticket me-2"></i>Register for Event
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Provider Information -->
                @if($event->provider)
                <div class="provider-info-card mt-4">
                    <div class="card border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 d-flex align-items-center">
                                <div class="meta-icon me-3">
                                    <i class="ti ti-building"></i>
                                </div>
                                About the Organizer
                            </h5>
                            
                            <div class="provider-info-content">
                                <div class="provider-basic-info mb-3">
                                    <h6 class="provider-name mb-2">{{ $event->provider->business_name ?? $event->provider->name }}</h6>
                                    @if($event->provider->service_description)
                                        <p class="text-muted mb-3">{{ Str::limit($event->provider->service_description, 200) }}</p>
                                    @endif
                                </div>
                                
                                <div class="provider-contact-info mb-3">
                                    @if($event->provider->phone)
                                    <div class="contact-item mb-2 d-flex align-items-center">
                                        <i class="ti ti-phone me-3 text-muted"></i>
                                        <span>{{ $event->provider->phone }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($event->provider->email)
                                    <div class="contact-item mb-2 d-flex align-items-center">
                                        <i class="ti ti-mail me-3 text-muted"></i>
                                        <span>{{ $event->provider->email }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($event->provider->website)
                                    <div class="contact-item mb-2 d-flex align-items-center">
                                        <i class="ti ti-world me-3 text-muted"></i>
                                        <a href="{{ $event->provider->website }}" target="_blank" class="link">
                                            Visit Website
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="provider-actions">
                                    <a href="{{ route('website.cleaner-detail', $event->provider->id) }}" class="btn btn-outline-primary">
                                        <i class="ti ti-external-link me-1"></i>View Provider Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Action Sidebar -->
            <div class="col-lg-4">
                <div class="event-action-sidebar">
                    <!-- Event Status Card -->
                    <div class="event-status-card mb-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center py-4">
                                @if($event->start_date < now())
                                    <div class="meta-icon mx-auto mb-3" style="background: #6c757d;">
                                        <i class="ti ti-clock-off"></i>
                                    </div>
                                    <h6 class="text-muted mb-1">Event Ended</h6>
                                    <p class="small text-muted mb-0">
                                        This event has already taken place
                                    </p>
                                @elseif($event->max_capacity && $event->current_capacity >= $event->max_capacity)
                                    <div class="meta-icon mx-auto mb-3" style="background: #6c757d;">
                                        <i class="ti ti-user-off"></i>
                                    </div>
                                    <h6 class="text-muted mb-1">Event Full</h6>
                                    <p class="small text-muted mb-0">
                                        All spots have been filled
                                    </p>
                                @else
                                    <div class="meta-icon mx-auto mb-3">
                                        <i class="ti ti-clock"></i>
                                    </div>
                                    <h6 class="text-primary mb-1">Happening Soon</h6>
                                    <p class="small text-muted mb-0">
                                        {{ \Carbon\Carbon::parse($event->start_date)->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="event-action-buttons-card mb-4">
                        <div class="card border-0">
                            <div class="card-body p-3">
                                <div class="event-action-buttons-grid">
                                    <!-- Save Event Button -->
                                    <button class="event-action-btn save-event-btn {{ $event->isSavedByUser() ? 'saved' : '' }}" 
                                            data-event-id="{{ $event->id }}">
                                        <div class="action-icon">
                                            <i class="ti ti-bookmark"></i>
                                        </div>
                                        <span class="action-text">
                                            {{ $event->isSavedByUser() ? 'Saved' : 'Save Event' }}
                                        </span>
                                    </button>

                                    <!-- Share Event Button -->
                                    <button class="event-action-btn share-event-btn" onclick="shareEvent()">
                                        <div class="action-icon">
                                            <i class="ti ti-share"></i>
                                        </div>
                                        <span class="action-text">Share Event</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions-card mb-4">
                        <div class="card border-0">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-3">Quick Actions</h6>
                                
                                <div class="quick-actions-list">
                                    @if($event->provider && $event->provider->phone)
                                    <div class="quick-action-item" onclick="makePhoneCall('{{ $event->provider->phone }}')">
                                        <i class="ti ti-phone"></i>
                                        <span>Call Organizer</span>
                                    </div>
                                    @endif
                                    
                                    
                                    <div class="quick-action-item" onclick="addToCalendar()">
                                        <i class="ti ti-calendar-plus"></i>
                                        <span>Add to Calendar</span>
                                    </div>
                                    
                                    <div class="quick-action-item" onclick="getDirections()">
                                        <i class="ti ti-map-pin"></i>
                                        <span>Get Directions</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Stats -->
                    <div class="event-stats-card">
                        <div class="card border-0">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-3">Event Stats</h6>
                                
                                <div class="event-stats-grid">
                                    <div class="stat-item text-center">
                                        <div class="stat-number text-primary">{{ $event->current_capacity ?? 0 }}</div>
                                        <div class="stat-label">Registered</div>
                                    </div>
                                    
                                    @if($event->max_capacity)
                                    <div class="stat-item text-center">
                                        <div class="stat-number text-info">{{ $event->max_capacity }}</div>
                                        <div class="stat-label">Capacity</div>
                                    </div>
                                    @endif
                                    
                                    <div class="stat-item text-center">
                                        <div class="stat-number text-success">
                                            {{ $event->savedByUsers()->count() }}
                                        </div>
                                        <div class="stat-label">Saved</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration Modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="registrationModalLabel">
                    <div class="meta-icon me-3">
                        <i class="ti ti-ticket"></i>
                    </div>
                    Register for Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="registrationForm">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                
                <div class="modal-body">
                    <div class="event-summary mb-4 p-3 bg-light rounded">
                        <h6 class="mb-2">{{ $event->title }}</h6>
                        <p class="small text-muted mb-1">
                            <i class="ti ti-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                        </p>
                        <p class="small text-muted mb-0">
                            <i class="ti ti-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }}
                        </p>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="registrant_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="registrant_name" name="name" 
                                   value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                        </div>
                        
                        <div class="col-12">
                            <label for="registrant_email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="registrant_email" name="email"
                                   value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                        </div>
                        
                        <div class="col-12">
                            <label for="registrant_phone" class="form-label">Phone *</label>
                            <input type="tel" class="form-control" id="registrant_phone" name="phone" required>
                        </div>
                        
                        <div class="col-12">
                            <label for="registrant_guests" class="form-label">Number of Guests</label>
                            <input type="number" class="form-control" id="registrant_guests" name="guests" 
                                   min="0" max="10" value="0">
                            <div class="form-text">Including yourself</div>
                        </div>
                        
                        <div class="col-12">
                            <label for="registrant_notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control" id="registrant_notes" name="notes" rows="3" 
                                      placeholder="Any special requirements or questions..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitRegistrationBtn">
                        <i class="ti ti-send me-2"></i>
                        Complete Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
function downloadEventInfo() {
    // Implement download functionality
    const eventTitle = "{{ $event->title }}";
    const eventDate = "{{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y') }}";
    const eventLocation = "{{ $event->location }}";
    const eventDescription = "{{ Str::limit(strip_tags($event->description), 200) }}";
    
    const content = `
Event: ${eventTitle}
Date: ${eventDate}
Location: ${eventLocation}
Description: ${eventDescription}

Organizer: {{ $event->provider_name }}
Cost: {{ $event->cost > 0 ? '$' . number_format($event->cost, 2) : 'Free' }}

Downloaded from luxGold on ${new Date().toLocaleDateString()}
    `;
    
    const blob = new Blob([content], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${eventTitle.replace(/\s+/g, '_')}_details.txt`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    showToast('Event details downloaded!', 'success');
}

function printEventInfo() {
    const printContent = `
        <div style="padding: 20px; font-family: Arial, sans-serif;">
            <h1 style="color: #00bfa6; margin-bottom: 10px;">{{ $event->title }}</h1>
            <p style="color: #666; margin-bottom: 20px;">{{ $event->subtitle }}</p>
            
            <div style="margin-bottom: 20px;">
                <strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y g:i A') }}<br>
                <strong>Location:</strong> {{ $event->location }}{{ $event->city ? ', ' . $event->city : '' }}<br>
                <strong>Cost:</strong> {{ $event->cost > 0 ? '$' . number_format($event->cost, 2) : 'Free' }}<br>
                <strong>Organizer:</strong> {{ $event->provider_name }}
            </div>
            
            <div style="margin-bottom: 20px;">
                <strong>Description:</strong><br>
                {{ strip_tags($event->description) }}
            </div>
            
            <hr>
                <p style="font-size: 12px; color: #999; text-align: center;">
                Printed from luxGold on ${new Date().toLocaleDateString()}
            </p>
        </div>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>{{ $event->title }} - luxGold</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    @media print { body { margin: 0; } }
                </style>
            </head>
            <body>${printContent}</body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}

function shareEvent() {
    const eventTitle = "{{ $event->title }}";
    const eventUrl = window.location.href;
    const eventDate = "{{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y') }}";
    
    const shareText = `Check out "${eventTitle}" on ${eventDate}. ${eventUrl}`;
    
    if (navigator.share) {
        navigator.share({
            title: eventTitle,
            text: `Check out "${eventTitle}" event`,
            url: eventUrl
        });
    } else {
        navigator.clipboard.writeText(shareText);
        showToast('Event link copied to clipboard!', 'success');
    }
}

function addToCalendar() {
    const eventTitle = "{{ $event->title }}";
    const eventStart = "{{ $event->start_date->format('Ymd\THis') }}";
    const eventEnd = "{{ $event->end_date ? $event->end_date->format('Ymd\THis') : $event->start_date->addHours(2)->format('Ymd\THis') }}";
    const eventLocation = "{{ $event->location }}";
    const eventDescription = "{{ Str::limit(strip_tags($event->description), 100) }}";
    
    const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${eventStart}/${eventEnd}&details=${encodeURIComponent(eventDescription)}&location=${encodeURIComponent(eventLocation)}`;
    
    window.open(googleCalendarUrl, '_blank');
}

function getDirections() {
    const location = "{{ $event->location }}, {{ $event->city }}";
    const mapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(location)}`;
    window.open(mapsUrl, '_blank');
}

function makePhoneCall(phoneNumber) {
    if (phoneNumber) {
        window.location.href = `tel:${phoneNumber}`;
    } else {
        showToast('Phone number not available', 'error');
    }
}

// Event Save Functionality
document.addEventListener('DOMContentLoaded', function() {
    const saveEventBtn = document.querySelector('.save-event-btn');
    
    if (saveEventBtn) {
        saveEventBtn.addEventListener('click', function() {
            const eventId = this.getAttribute('data-event-id');
            saveEvent(eventId, this);
        });
    }
    
    // Registration Form
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitRegistration(this, 'submitRegistrationBtn');
        });
    }
    
    // Inquiry Form
    const eventInquiryForm = document.getElementById('eventInquiryForm');
    if (eventInquiryForm) {
        eventInquiryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitEventInquiry(this, 'submitEventInquiryBtn');
        });
    }
});

function saveEvent(eventId, button) {
    fetch(`/events/${eventId}/save`, {
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
            button.querySelector('.action-text').textContent = 'Saved';
            showEventSuccess('Event saved successfully!');
        } else {
            button.classList.remove('saved');
            button.querySelector('.action-text').textContent = 'Save Event';
            showToast('Event removed from saved list', 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Kindly login first', 'error');
    });
}

function submitRegistration(form, submitBtnId) {
    const submitBtn = document.getElementById(submitBtnId);
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="ti ti-loader me-2"></i>Processing...';
    submitBtn.disabled = true;

    const formData = new FormData(form);
    
    fetch('{{ route("event.registration.store") }}', {
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
            showToast('Registration completed successfully!', 'success');
            
            // Reset form
            form.reset();
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('registrationModal'));
            modal.hide();
            
            // Update capacity if needed
            if (data.updated_capacity) {
                // You could update the capacity display here
            }
        } else {
            throw new Error(data.message || 'Failed to complete registration');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Error completing registration. Please try again.', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}


function showEventSuccess(message) {
    const alert = document.getElementById('eventSuccessAlert');
    const messageSpan = document.getElementById('eventSuccessMessage');
    
    messageSpan.textContent = message;
    alert.style.display = 'flex';
    
    // Hide alert after 5 seconds
    setTimeout(() => {
        alert.style.display = 'none';
    }, 5000);
}

function showToast(message, type = 'info') {
    // Remove existing toasts
    document.querySelectorAll('.custom-toast').forEach(toast => toast.remove());
    
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} custom-toast position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); border: none;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="ti ti-${type === 'success' ? 'check' : type === 'error' ? 'alert-triangle' : 'info-circle'} me-2"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}
</script>
@endsection
