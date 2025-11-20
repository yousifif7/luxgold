@extends('layouts.provider-layout')

@section('provider-title', 'Edit Service - Provider Portal')
@section('content')

<div class="page-wrapper">
    <!-- Start Content -->
    <div class="content">
      <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
      <div class="breadcrumb-arrow">
        <h4 class="mb-1">Listing Profile</h4>
        <div class="text-end">
          <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('provider-home') }}">Home</a></li>
            <li class="breadcrumb-item active">Listing Profile</li>
          </ol>
        </div>
      </div>
      <div class="gap-2 d-flex align-items-center flex-wrap">
        
        
      </div>
    </div>

    <!-- Validation Errors Display -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Step Indicators -->
    <div class="service-listing-step-indicator-container">
        <div class="service-listing-step-indicator-item service-listing-step-active" data-step="1">
            <div class="service-listing-step-indicator-circle">
                <i class="fas fa-info-circle"></i>
            </div>
            <span class="service-listing-step-indicator-label">Basic Info</span>
        </div>
        <div class="service-listing-step-connector"></div>
        <div class="service-listing-step-indicator-item" data-step="2">
            <div class="service-listing-step-indicator-circle">
                <i class="fas fa-users"></i>
            </div>
            <span class="service-listing-step-indicator-label">Services</span>
        </div>
        <div class="service-listing-step-connector"></div>
        <div class="service-listing-step-indicator-item" data-step="3">
            <div class="service-listing-step-indicator-circle">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <span class="service-listing-step-indicator-label">Pricing</span>
        </div>
        <div class="service-listing-step-connector"></div>
        <div class="service-listing-step-indicator-item" data-step="4">
            <div class="service-listing-step-indicator-circle">
                <i class="fas fa-certificate"></i>
            </div>
            <span class="service-listing-step-indicator-label">Credentials</span>
        </div>
        <div class="service-listing-step-connector"></div>
        <div class="service-listing-step-indicator-item" data-step="5">
            <div class="service-listing-step-indicator-circle">
                <i class="fas fa-camera"></i>
            </div>
            <span class="service-listing-step-indicator-label">Media</span>
        </div>
        <div class="service-listing-step-connector"></div>
        <div class="service-listing-step-indicator-item" data-step="6">
            <div class="service-listing-step-indicator-circle">
                <i class="fas fa-star"></i>
            </div>
            <span class="service-listing-step-indicator-label">Review</span>
        </div>
    </div>

    <!-- Step Form -->
    <form id="serviceListingForm" method="POST" action="{{ route('provider.listings.update', $serviceListing->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Step Content -->
        <div class="service-listing-step-content-area">
            <!-- Step 1: Basic Info -->
            <div class="service-listing-step-content-panel service-listing-step-active-content" style="display:none" id="step1Content">
                <div class="service-listing-step-title-text">
                    <div class="service-listing-step-title-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    Basic Business Information
                </div>
                <p class="service-listing-step-description-text">Tell us about your business and how families can reach you</p>

                <div class="row">
                    <div class="col-12">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">
                                Business/Organization Name <span class="service-listing-required-field-indicator">*</span>
                            </label>
                            <input type="text" class="service-listing-form-input-field @error('business_name') is-invalid @enderror" 
                                   id="businessName" name="business_name" 
                                   value="{{ old('business_name', $serviceListing->business_name) }}" 
                                   placeholder="Enter your business name" required>
                            @error('business_name')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @else
                                <div class="service-listing-error-message-text">Business name is required</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">
                                Contact Person <span class="service-listing-required-field-indicator">*</span>
                            </label>
                            <input type="text" class="service-listing-form-input-field @error('contact_person') is-invalid @enderror" 
                                   id="contactPerson" name="contact_person" 
                                   value="{{ old('contact_person', $serviceListing->contact_person) }}" 
                                   placeholder="Full name" required>
                            @error('contact_person')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @else
                                <div class="service-listing-error-message-text">Contact person name is required</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">Role/Title</label>
                            <input type="text" class="service-listing-form-input-field @error('role_title') is-invalid @enderror" 
                                   id="roleTitle" name="role_title" 
                                   value="{{ old('role_title', $serviceListing->role_title) }}" 
                                   placeholder="Owner, Director, etc.">
                            @error('role_title')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">
                                Phone Number <span class="service-listing-required-field-indicator">*</span>
                            </label>
                            <input type="tel" class="service-listing-form-input-field @error('phone_number') is-invalid @enderror" 
                                   id="phoneNumber" name="phone_number" 
                                   value="{{ old('phone_number', $serviceListing->phone_number) }}" 
                                   placeholder="(xxx) xxx-xxxx" required>
                            @error('phone_number')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @else
                                <div class="service-listing-error-message-text">Phone number is required</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
    <div class="service-listing-form-group-container">
        <label class="service-listing-form-label-text">
            Care Type <span class="service-listing-required-field-indicator">*</span>
        </label>
        <select class="service-listing-form-input-field @error('care_types_id') is-invalid @enderror" 
                id="careType" name="care_types_id" required>
            <option value="">Select Care Type</option>
            @foreach($care_types as $care)
                <option value="{{ $care->id }}" {{ old('care_types_id', $serviceListing->care_types_id) == $care->id ? 'selected' : '' }}>
                    {{ $care->name }}
                </option>
            @endforeach
        </select>
        @error('care_types_id')
            <div class="service-listing-error-message-text show">{{ $message }}</div>
        @else
            <div class="service-listing-error-message-text">Care Type is required</div>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="service-listing-form-group-container">
        <label class="service-listing-form-label-text">
            Category <span class="service-listing-required-field-indicator">*</span>
        </label>
        <select class="service-listing-form-input-field @error('categories_id') is-invalid @enderror" 
                id="programOffered" name="categories_id" required>
            <option value="">Select Program</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('categories_id', $serviceListing->categories_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('categories_id')
            <div class="service-listing-error-message-text show">{{ $message }}</div>
        @else
            <div class="service-listing-error-message-text">Category is required</div>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="service-listing-form-group-container">
        <label class="service-listing-form-label-text">
            Ages Served <span class="service-listing-required-field-indicator">*</span>
        </label>
        <select class="service-listing-form-input-field @error('ages_served_id') is-invalid @enderror" 
                id="agesServed" name="ages_served_id" required>
            <option value="">Select Ages Served</option>
            @foreach($ages_served as $age)
                <option value="{{ $age->id }}" {{ old('ages_served_id', $serviceListing->ages_served_id) == $age->id ? 'selected' : '' }}>
                    {{ $age->title }}
                </option>
            @endforeach
        </select>
        @error('ages_served_id')
            <div class="service-listing-error-message-text show">{{ $message }}</div>
        @else
            <div class="service-listing-error-message-text">Ages Served is required</div>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="service-listing-form-group-container">
        <label class="service-listing-form-label-text">
            Program Offered <span class="service-listing-required-field-indicator">*</span>
        </label>
        <select class="service-listing-form-input-field @error('programs_offered_id') is-invalid @enderror" 
                id="serviceOffered" name="programs_offered_id" required>
            <option value="">Select Service</option>
            @foreach($programs_offerd as $program_offerd)
                <option value="{{ $program_offerd->id }}" {{ old('programs_offered_id', $serviceListing->programs_offered_id) == $program_offerd->id ? 'selected' : '' }}>
                    {{ $program_offerd->name }}
                </option>
            @endforeach
        </select>
        @error('programs_offered_id')
            <div class="service-listing-error-message-text show">{{ $message }}</div>
        @else
            <div class="service-listing-error-message-text">Program Offered is required</div>
        @enderror
    </div>
</div>

                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">
                                Email Address <span class="service-listing-required-field-indicator">*</span>
                            </label>
                            <input type="email" class="service-listing-form-input-field @error('email') is-invalid @enderror" 
                                   id="emailAddress" name="email" 
                                   value="{{ old('email', $serviceListing->email) }}" 
                                   placeholder="your@email.com" required>
                            @error('email')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @else
                                <div class="service-listing-error-message-text">Valid email address is required</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">
                                Physical Address <span class="service-listing-required-field-indicator">*</span>
                            </label>
                            <input type="text" class="service-listing-form-input-field @error('physical_address') is-invalid @enderror" 
                                   id="physicalAddress" name="physical_address" 
                                   value="{{ old('physical_address', $serviceListing->physical_address) }}" 
                                   placeholder="Street Address" required>
                            @error('physical_address')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @else
                                <div class="service-listing-error-message-text">Valid physical address is required</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">
                                City <span class="service-listing-required-field-indicator">*</span>
                            </label>
                            <input type="text" class="service-listing-form-input-field @error('city') is-invalid @enderror" 
                                   id="cityinfo" name="city" 
                                   value="{{ old('city', $serviceListing->city) }}" 
                                   placeholder="City" required>
                            @error('city')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @else
                                <div class="service-listing-error-message-text">Valid city is required</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">State</label>
                            <select class="service-listing-form-input-field @error('state') is-invalid @enderror" name="state" id="state">
                                <option value="TX" {{ old('state', $serviceListing->state) == 'TX' ? 'selected' : '' }}>TX</option>
                            </select>
                            @error('state')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">
                                ZIP Code <span class="service-listing-required-field-indicator">*</span>
                            </label>
                            <input type="text" class="service-listing-form-input-field @error('zip_code') is-invalid @enderror" 
                                   id="zipCode" name="zip_code" 
                                   value="{{ old('zip_code', $serviceListing->zip_code) }}" 
                                   maxlength="5" minlength="5" placeholder="75XXX" required>
                            @error('zip_code')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @else
                                <div class="service-listing-error-message-text">Valid ZIP code is required</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Services -->
            <div class="service-listing-step-content-panel" id="step2Content" style="display: none;">
                <div class="service-listing-step-title-text">
                    <div class="service-listing-step-title-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    Services You Provide
                </div>
                <p class="service-listing-step-description-text">Select all the services you offer to families</p>

                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">
                        Service Categories <span class="service-listing-required-field-indicator">*</span>
                    </label>
                    <div class="service-listing-checkbox-group-container">
                        @php
                            $oldServices = old('sub_categories', ($serviceListing->sub_categories) ?? []);

                        @endphp
                        @foreach(\App\Models\Category::whereNotNull('parent_id')->get() as $category)
                        <div class="service-listing-checkbox-item-wrapper" data-service="{{ $category->id }}">
                            <input type="checkbox" id="service-{{ $category->slug }}" name="sub_categories[]" value="{{ $category->id }}" 
                                   class="service-listing-service-checkbox form-check-input mt-0 @error('sub_categories') is-invalid @enderror"
                                   {{ in_array($category->id, $oldServices) ? 'checked' : '' }}>
                            <label for="service-{{ $category->slug }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('sub_categories')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @else
                        <div class="service-listing-error-message-text">Please select at least one category</div>
                    @enderror
                </div>

                                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">
                        Services Offerd <span class="service-listing-required-field-indicator">*</span>
                    </label>
                    <div class="service-listing-checkbox-group-container">
                        @php
                            $oldServices = old('services_offerd', ($serviceListing->services_offerd) ?? []);

                        @endphp
                        @foreach($services_offerd as $service)
                        <div class="service-listing-checkbox-item-wrapper" data-service="{{ $service->id }}">
                            <input type="checkbox" id="service-{{ $service->slug }}" name="services_offerd[]" value="{{ $service->id }}" 
                                   class="service-listing-service-checkbox form-check-input mt-0 @error('services_offerd') is-invalid @enderror"
                                   {{ in_array($service->id, $oldServices) ? 'checked' : '' }}>
                            <label for="service-{{ $service->slug }}">{{ $service->title }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('services_offerd')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @else
                        <div class="service-listing-error-message-text">Please select at least one service</div>
                    @enderror
                </div>


                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Service Description</label>
                    <textarea class="service-listing-form-textarea-field @error('service_description') is-invalid @enderror" 
                              id="serviceDescription" name="service_description" rows="4" 
                              placeholder="Describe your services in detail...">{{ old('service_description', $serviceListing->service_description) }}</textarea>
                    @error('service_description')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Step 3: Pricing & Schedule -->
            <div class="service-listing-step-content-panel" id="step3Content" style="display: none;">
                <div class="service-listing-step-title-text">
                    <div class="service-listing-step-title-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    Pricing & Schedule
                </div>
                
                <!-- Pricing Options Section -->
                <div class="pricing-section">
                    <h4 class="service-listing-form-label-text">Pricing Options</h4>
                    <p class="service-listing-step-description-text">Select how you'd like to structure your pricing:</p>
                    
                    <div class="pricing-options">
                        <div class="pricing-option @if(old('pricing_type', $serviceListing->pricing_type ?? 'package') == 'hourly') selected @endif" data-type="hourly">
                            <div class="pricing-option-name">Hourly Rate</div>
                            <div class="pricing-option-price">$<span>25</span></div>
                            <ul class="pricing-option-features">
                                <li>Charge by the hour</li>
                                <li>Flexible scheduling</li>
                                <li>Best for variable services</li>
                            </ul>
                        </div>
                        
                        <div class="pricing-option @if(old('pricing_type', $serviceListing->pricing_type ?? 'package') == 'fixed') selected @endif" data-type="fixed">
                            <div class="pricing-option-name">Fixed Price</div>
                            <div class="pricing-option-price">$<span>150</span></div>
                            <ul class="pricing-option-features">
                                <li>Flat fee per session</li>
                                <li>Clear pricing for clients</li>
                                <li>Great for standard packages</li>
                            </ul>
                        </div>
                        
                        <div class="pricing-option @if(old('pricing_type', $serviceListing->pricing_type ?? 'package') == 'package') selected @endif" data-type="package">
                            <div class="pricing-option-name">Package Deal</div>
                            <div class="pricing-option-price">$<span>500</span></div>
                            <ul class="pricing-option-features">
                                <li>Multiple sessions bundled</li>
                                <li>Discount for commitment</li>
                                <li>Encourages long-term engagement</li>
                            </ul>
                        </div>
                        
                        <div class="pricing-option @if(old('pricing_type', $serviceListing->pricing_type ?? 'package') == 'custom') selected @endif" data-type="custom">
                            <div class="pricing-option-name">Custom Pricing</div>
                            <div class="pricing-option-price">$<span>0</span></div>
                            <ul class="pricing-option-features">
                                <li>Set your own terms</li>
                                <li>Negotiate with clients</li>
                                <li>Perfect for unique services</li>
                            </ul>
                        </div>
                    </div>
                    
                    <input type="hidden" name="pricing_type" id="pricingType" value="{{ old('pricing_type', $serviceListing->pricing_type ?? 'package') }}">
                    
                    <div class="service-listing-form-group-container mt-4">
                        <label class="service-listing-form-label-text">Price Amount <span class="service-listing-required-field-indicator">*</span></label>
                        <div class="d-flex" style="display: flex;">
                            <span class="input-group-text">$</span>
                            <input type="number" class="service-listing-form-input-field @error('price_amount') is-invalid @enderror" 
                                   id="price-amount" name="price_amount" 
                                   value="{{ old('price_amount', $serviceListing->price_amount) }}" 
                                   placeholder="Enter price amount" min="0" step="1" required>
                        </div>
                        @error('price_amount')
                            <div class="service-listing-error-message-text show">{{ $message }}</div>
                        @else
                            <small class="form-text text-muted">Enter the specific price amount based on your selected pricing type</small>
                        @enderror
                    </div>
                    
                    <div class="service-listing-form-group-container">
                        <label class="service-listing-form-label-text">Pricing Description</label>
                        <textarea class="service-listing-form-textarea-field @error('pricing_description') is-invalid @enderror" 
                                  id="pricing-description" name="pricing_description" rows="3" 
                                  placeholder="Describe your pricing structure, any discounts, payment methods, cancellation policy, etc.">{{ old('pricing_description', $serviceListing->pricing_description) }}</textarea>
                        @error('pricing_description')
                            <div class="service-listing-error-message-text show">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Schedule Section -->
                <div class="service-listing-form-group-container mt-4">
                    <label class="service-listing-form-label-text">Hours of Operation / Schedules</label>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="service-listing-form-label-text">Available Days</label>
                            <div class="service-listing-checkbox-group-container">
                                @php
                                    $oldDays = old('available_days', ($serviceListing->available_days) ?? []);
                                @endphp
                                <div><input type="checkbox" name="available_days[]" value="monday" 
                                           class="form-check-input me-2 @error('available_days') is-invalid @enderror"
                                           {{ in_array('monday', $oldDays) ? 'checked' : '' }}><label> Monday</label></div>
                                <div><input type="checkbox" name="available_days[]" value="tuesday" 
                                           class="form-check-input me-2 @error('available_days') is-invalid @enderror"
                                           {{ in_array('tuesday', $oldDays) ? 'checked' : '' }}><label> Tuesday</label></div>
                                <div><input type="checkbox" name="available_days[]" value="wednesday" 
                                           class="form-check-input me-2 @error('available_days') is-invalid @enderror"
                                           {{ in_array('wednesday', $oldDays) ? 'checked' : '' }}><label> Wednesday</label></div>
                                <div><input type="checkbox" name="available_days[]" value="thursday" 
                                           class="form-check-input me-2 @error('available_days') is-invalid @enderror"
                                           {{ in_array('thursday', $oldDays) ? 'checked' : '' }}><label> Thursday</label></div>
                                <div><input type="checkbox" name="available_days[]" value="friday" 
                                           class="form-check-input me-2 @error('available_days') is-invalid @enderror"
                                           {{ in_array('friday', $oldDays) ? 'checked' : '' }}><label> Friday</label></div>
                                <div><input type="checkbox" name="available_days[]" value="saturday" 
                                           class="form-check-input me-2 @error('available_days') is-invalid @enderror"
                                           {{ in_array('saturday', $oldDays) ? 'checked' : '' }}><label> Saturday</label></div>
                                <div><input type="checkbox" name="available_days[]" value="sunday" 
                                           class="form-check-input me-2 @error('available_days') is-invalid @enderror"
                                           {{ in_array('sunday', $oldDays) ? 'checked' : '' }}><label> Sunday</label></div>
                            </div>
                            @error('available_days')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="service-listing-form-label-text">Working Hours</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="time" class="service-listing-form-input-field @error('start_time') is-invalid @enderror" 
                                       id="start-time" name="start_time" 
                                       value="{{ old('start_time', $serviceListing->start_time) }}" 
                                       placeholder="Start time">
                                <span>to</span>
                                <input type="time" class="service-listing-form-input-field @error('end_time') is-invalid @enderror" 
                                       id="end-time" name="end_time" 
                                       value="{{ old('end_time', $serviceListing->end_time) }}" 
                                       placeholder="End time">
                            </div>
                            @error('start_time')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                            @error('end_time')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Additional Availability Notes</label>
                    <textarea class="service-listing-form-textarea-field @error('availability_notes') is-invalid @enderror" 
                              id="availability-notes" name="availability_notes" rows="2" 
                              placeholder="Any special availability? (e.g., weekends only, holidays, flexible hours)">{{ old('availability_notes', $serviceListing->availability_notes) }}</textarea>
                    @error('availability_notes')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Step 4: Credentials -->
            <div class="service-listing-step-content-panel" id="step4Content" style="display: none;">
                <div class="service-listing-step-title-text">
                    <div class="service-listing-step-title-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    Credentials
                </div>
                <p class="service-listing-step-description-text">Share your credentials to build trust with families</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">License/Certification Number</label>
                            <input type="text" class="service-listing-form-input-field @error('license_number') is-invalid @enderror" 
                                   id="licenseNumber" name="license_number" 
                                   value="{{ old('license_number', $serviceListing->license_number) }}" 
                                   placeholder="License number">
                            @error('license_number')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">Years in Operation</label>
                            <input type="text" class="service-listing-form-input-field @error('years_operation') is-invalid @enderror" 
                                   id="yearsOperation" name="years_operation" 
                                   value="{{ old('years_operation', $serviceListing->years_operation) }}" 
                                   placeholder="Example: Since 2015">
                            @error('years_operation')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Insurance Coverage</label>
                    <input type="text" class="service-listing-form-input-field @error('insurance_coverage') is-invalid @enderror" 
                           id="insuranceCoverage" name="insurance_coverage" 
                           value="{{ old('insurance_coverage', $serviceListing->insurance_coverage) }}" 
                           placeholder="General liability, professional liability, etc.">
                    @error('insurance_coverage')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                </div>

                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Diversity & Ownership Badges</label>
                    <div class="service-listing-checkbox-group-container">
                        @php
                            $oldBadges = old('diversity_badges', $serviceListing->diversity_badges ?? []);
                        @endphp
                        <div><input type="checkbox" class="form-check-input me-2 @error('diversity_badges') is-invalid @enderror" 
                                   id="badge-women" name="diversity_badges[]" value="women"
                                   {{ in_array('women', $oldBadges) ? 'checked' : '' }}><label for="badge-women"> Women-Owned</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('diversity_badges') is-invalid @enderror" 
                                   id="badge-minority" name="diversity_badges[]" value="minority"
                                   {{ in_array('minority', $oldBadges) ? 'checked' : '' }}><label for="badge-minority"> Minority-Owned</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('diversity_badges') is-invalid @enderror" 
                                   id="badge-veteran" name="diversity_badges[]" value="veteran"
                                   {{ in_array('veteran', $oldBadges) ? 'checked' : '' }}><label for="badge-veteran"> Veteran-Owned</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('diversity_badges') is-invalid @enderror" 
                                   id="badge-family" name="diversity_badges[]" value="family"
                                   {{ in_array('family', $oldBadges) ? 'checked' : '' }}><label for="badge-family"> Family-Owned</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('diversity_badges') is-invalid @enderror" 
                                   id="badge-lgbtq" name="diversity_badges[]" value="lgbtq"
                                   {{ in_array('lgbtq', $oldBadges) ? 'checked' : '' }}><label for="badge-lgbtq"> LGBTQ+ Owned</label></div>
                    </div>
                    @error('diversity_badges')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                </div>

                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Special Features</label>
                    <div class="service-listing-checkbox-group-container">
                        @php
                            $oldFeatures = old('special_features', $serviceListing->special_features ?? []);
                        @endphp
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-stem" name="special_features[]" value="stem"
                                   {{ in_array('stem', $oldFeatures) ? 'checked' : '' }}><label for="feature-stem"> STEM Focus</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-arts" name="special_features[]" value="arts"
                                   {{ in_array('arts', $oldFeatures) ? 'checked' : '' }}><label for="feature-arts"> Arts & Music</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-special" name="special_features[]" value="special"
                                   {{ in_array('special', $oldFeatures) ? 'checked' : '' }}><label for="feature-special"> Special Needs Support</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-outdoor" name="special_features[]" value="outdoor"
                                   {{ in_array('outdoor', $oldFeatures) ? 'checked' : '' }}><label for="feature-outdoor"> Outdoor Activities</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-language" name="special_features[]" value="language"
                                   {{ in_array('language', $oldFeatures) ? 'checked' : '' }}><label for="feature-language"> Language Immersion</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-sports" name="special_features[]" value="sports"
                                   {{ in_array('sports', $oldFeatures) ? 'checked' : '' }}><label for="feature-sports"> Sports Programs</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-organic" name="special_features[]" value="organic"
                                   {{ in_array('organic', $oldFeatures) ? 'checked' : '' }}><label for="feature-organic"> Organic/Healthy Meals</label></div>
                        <div><input type="checkbox" class="form-check-input me-2 @error('special_features') is-invalid @enderror" 
                                   id="feature-technology" name="special_features[]" value="technology"
                                   {{ in_array('technology', $oldFeatures) ? 'checked' : '' }}><label for="feature-technology"> Technology Integration</label></div>
                    </div>
                    @error('special_features')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">Website</label>
                            <input type="url" class="service-listing-form-input-field @error('website') is-invalid @enderror" 
                                   id="website" name="website" 
                                   value="{{ old('website', $serviceListing->website) }}" 
                                   placeholder="https://www.yourwebsite.com">
                            @error('website')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">Facebook Page</label>
                            <input type="url" class="service-listing-form-input-field @error('facebook') is-invalid @enderror" 
                                   id="facebook" name="facebook" 
                                   value="{{ old('facebook', $serviceListing->facebook) }}" 
                                   placeholder="Facebook page URL">
                            @error('facebook')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-listing-form-group-container">
                            <label class="service-listing-form-label-text">Instagram</label>
                            <input type="url" class="service-listing-form-input-field @error('instagram') is-invalid @enderror" 
                                   id="instagram" name="instagram" 
                                   value="{{ old('instagram', $serviceListing->instagram) }}" 
                                   placeholder="Instagram profile URL">
                            @error('instagram')
                                <div class="service-listing-error-message-text show">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5: Media -->
            <div class="service-listing-step-content-panel" id="step5Content" style="display: block;">
                <div class="service-listing-step-title-text">
                    <div class="service-listing-step-title-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    Media & Photos
                </div>
                
                <!-- Existing Files Display -->
                @if($serviceListing->logo_path || $serviceListing->facility_photos_paths || $serviceListing->license_docs_paths)
                <div class="existing-files-section mb-4">
                    <h6 class="text-primary">Current Files</h6>
                    
                    @if($serviceListing->logo_path)
                    <div class="existing-file-item mb-3">
                        <label class="service-listing-form-label-text">Current Logo:</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset( $serviceListing->logo_path) }}" alt="Current Logo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            <div>
                                <small class="text-muted">Upload new logo to replace</small>
                                <br>
                                <input type="checkbox" name="remove_logo" id="removeLogo" class="form-check-input">
                                <label for="removeLogo" class="form-check-label text-danger">Remove logo</label>
                            </div>
                        </div>
                    </div>
                    @endif


                    @if($serviceListing->facility_photos_paths && count($serviceListing->facility_photos_paths) > 0)
                    <div class="existing-file-item mb-3">
                        <label class="service-listing-form-label-text">Current Facility Photos:</label>
                        <div class="row">
                            @foreach($serviceListing->facility_photos_paths as $index => $photo)
                            <div class="col-md-3 mb-2">
                                <div class="position-relative">
                                    <img src="{{ asset( $photo) }}" alt="Facility Photo {{ $index + 1 }}" 
                                         style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px;">
                                    <input type="checkbox" name="remove_facility_photos[]" value="{{ $photo }}" 
                                           class="position-absolute top-0 end-0 m-1">
                                </div>
                                <small class="text-muted">Photo {{ $index + 1 }}</small>
                            </div>
                            @endforeach
                        </div>
                        <small class="text-danger">Check photos you want to remove</small>
                    </div>
                    @endif

                    @if($serviceListing->license_docs_paths && count($serviceListing->license_docs_paths) > 0)
                    <div class="existing-file-item mb-3">
                        <label class="service-listing-form-label-text">Current License Documents:</label>
                        <div class="row">
                            @foreach($serviceListing->license_docs_paths as $index => $doc)
                            <div class="col-md-4 mb-2">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    <div class="flex-grow-1">
                                        <small>Document {{ $index + 1 }}</small>
                                        <br>
                                        <small class="text-muted">{{ basename($doc) }}</small>
                                    </div>
                                    <input type="checkbox" name="remove_license_docs[]" value="{{ $doc }}" 
                                           class="form-check-input">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <small class="text-danger">Check documents you want to remove</small>
                    </div>
                    @endif
                </div>
                @endif

                <h6 class="mt-3">Business Logo</h6>
                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Upload your business logo (recommended: square format, 500x500px minimum)</label>
                    <div class="service-listing-file-upload-area @error('logo') is-invalid @enderror" id="logoUploadArea">
                        <div class="service-listing-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="service-listing-upload-text">
                            <strong>Drag & drop files here</strong><br>
                            or click to browse<br>
                            <small>Supports JPG, PNG files up to 10MB</small>
                        </div>
                        <input type="file" id="logo" name="logo" accept="image/*" style="display: none;">
                         <div class="service-listing-uploaded-files-list" id="logoFilesList"></div>
                    </div>
                    @error('logo')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                   
                </div>

                <h6>Facility Photos</h6>
                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Share photos of your space, activities, and services (up to 10 photos)</label>
                    <div class="service-listing-file-upload-area @error('facility_photos') is-invalid @enderror" id="facilityPhotosUploadArea">
                        <div class="service-listing-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="service-listing-upload-text">
                            <strong>Drag & drop files here</strong><br>
                            or click to browse<br>
                            <small>Supports JPG, PNG files up to 10MB</small>
                        </div>
                        <input type="file" id="facility_photos" name="facility_photos[]" multiple accept="image/*" style="display: none;">
                        <div class="service-listing-uploaded-files-list" id="facilityPhotosList"></div>
                    </div>
                    @error('facility_photos')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                    @error('facility_photos.*')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                    
                </div>

                <h6>License Documentation</h6>
                <div class="service-listing-form-group-container">
                    <label class="service-listing-form-label-text">Upload copies of your licenses and certifications (optional but recommended)</label>
                    <div class="service-listing-file-upload-area @error('license_docs') is-invalid @enderror" id="licenseDocsUploadArea">
                        <div class="service-listing-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="service-listing-upload-text">
                            <strong>Drag & drop files here</strong><br>
                            or click to browse<br>
                            <small>Supports JPG, PNG, PDF files up to 10MB</small>
                        </div>
                        <input type="file" id="license_docs" name="license_docs[]" multiple accept="image/*,.pdf" style="display: none;">
                         <div class="service-listing-uploaded-files-list" id="licenseDocsList"></div>
                    </div>
                    @error('license_docs')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                    @error('license_docs.*')
                        <div class="service-listing-error-message-text show">{{ $message }}</div>
                    @enderror
                   
                </div>
            </div>

            <!-- Step 6: Review -->
            <div class="service-listing-step-content-panel" id="step6Content" style="display: none;">
                <div class="service-listing-step-title-text">
                    <div class="service-listing-step-title-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    Review & Submit
                </div>
                <p class="service-listing-step-description-text">Please review all information before updating your service listing</p>

                <div class="service-listing-review-section-container">
                    <h4 class="service-listing-review-section-title">
                        <i class="fas fa-info-circle text-primary me-2"></i>Basic Information
                    </h4>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Business Name:</span>
                        <span class="service-listing-review-field-value" id="reviewBusinessName">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Contact Person:</span>
                        <span class="service-listing-review-field-value" id="reviewContactPerson">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Phone:</span>
                        <span class="service-listing-review-field-value" id="reviewPhone">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Email:</span>
                        <span class="service-listing-review-field-value" id="reviewEmail">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Address:</span>
                        <span class="service-listing-review-field-value" id="reviewAddress">-</span>
                    </div>
                </div>

                <div class="service-listing-review-section-container">
                    <h4 class="service-listing-review-section-title">
                        <i class="fas fa-users text-success me-2"></i>Services
                    </h4>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Selected Services:</span>
                        <span class="service-listing-review-field-value" id="reviewServices">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Description:</span>
                        <span class="service-listing-review-field-value" id="reviewDescription">-</span>
                    </div>
                </div>

                <div class="service-listing-review-section-container">
                    <h4 class="service-listing-review-section-title">
                        <i class="fas fa-dollar-sign text-warning me-2"></i>Pricing & Schedule
                    </h4>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Pricing Type:</span>
                        <span class="service-listing-review-field-value" id="reviewPricingType">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Price Amount:</span>
                        <span class="service-listing-review-field-value" id="reviewPriceAmount">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Available Days:</span>
                        <span class="service-listing-review-field-value" id="reviewAvailableDays">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Working Hours:</span>
                        <span class="service-listing-review-field-value" id="reviewWorkingHours">-</span>
                    </div>
                </div>

                <div class="service-listing-review-section-container">
                    <h4 class="service-listing-review-section-title">
                        <i class="fas fa-certificate text-warning me-2"></i>Credentials
                    </h4>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">License Number:</span>
                        <span class="service-listing-review-field-value" id="reviewLicenseNumber">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Years in Operation:</span>
                        <span class="service-listing-review-field-value" id="reviewYearsOperation">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Insurance Coverage:</span>
                        <span class="service-listing-review-field-value" id="reviewInsurance">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Diversity Badges:</span>
                        <span class="service-listing-review-field-value" id="reviewDiversityBadges">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Special Features:</span>
                        <span class="service-listing-review-field-value" id="reviewSpecialFeatures">-</span>
                    </div>
                </div>

                <div class="service-listing-review-section-container">
                    <h4 class="service-listing-review-section-title">
                        <i class="fas fa-camera text-info me-2"></i>Media & Links
                    </h4>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Website:</span>
                        <span class="service-listing-review-field-value" id="reviewWebsite">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Facebook:</span>
                        <span class="service-listing-review-field-value" id="reviewFacebook">-</span>
                    </div>
                    <div class="service-listing-review-field-row">
                        <span class="service-listing-review-field-label">Instagram:</span>
                        <span class="service-listing-review-field-value" id="reviewInstagram">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="service-listing-modal-footer-actions">
            <button type="button" class="service-listing-navigation-button service-listing-prev-button" id="prevStepBtn" disabled>
                <i class="fas fa-arrow-left me-2"></i>Previous
            </button>
            <button type="button" class="service-listing-navigation-button service-listing-next-button" id="nextStepBtn">
                Next<i class="fas fa-arrow-right ms-2"></i>
            </button>
            <button type="submit" class="service-listing-navigation-button service-listing-submit-button" id="submitFormBtn" style="display: none;">
                <i class="fas fa-save me-2"></i>Update Listing
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 6;
    
    // Navigation elements
    const prevBtn = document.getElementById('prevStepBtn');
    const nextBtn = document.getElementById('nextStepBtn');
    const submitBtn = document.getElementById('submitFormBtn');
    
    // Step content panels
    const stepPanels = document.querySelectorAll('.service-listing-step-content-panel');
    
    // Step indicators
    const stepIndicators = document.querySelectorAll('.service-listing-step-indicator-item');
    const stepConnectors = document.querySelectorAll('.service-listing-step-connector');
    
    // Form data for file handling
    const formData = new FormData();
    
    // Pricing options functionality
    const pricingOptions = document.querySelectorAll('.pricing-option');
    const pricingTypeInput = document.getElementById('pricingType');
    let selectedPricingType = '{{ old('pricing_type', $serviceListing->pricing_type ?? 'package') }}';
    
    // Check if there are validation errors and jump to the first step with errors
    const hasErrors = document.querySelector('.alert-danger') !== null;
    if (hasErrors) {
        // Find the first step that has errors
        const errorSteps = new Set();
        document.querySelectorAll('.is-invalid').forEach(element => {
            const stepPanel = element.closest('.service-listing-step-content-panel');
            if (stepPanel) {
                const stepId = stepPanel.id;
                const stepNumber = stepId.replace('step', '').replace('stepContent', '');
                errorSteps.add(parseInt(stepNumber));
            }
        });
        
        if (errorSteps.size > 0) {
            const firstErrorStep = Math.min(...Array.from(errorSteps));
            currentStep = firstErrorStep;
        }
    }
    
    // Initialize pricing options
    pricingOptions.forEach(option => {
        if (option.dataset.type === selectedPricingType) {
            option.classList.add('selected');
        }
        
        option.addEventListener('click', function() {
            // Remove selected class from all options
            pricingOptions.forEach(opt => opt.classList.remove('selected'));
            // Add selected class to clicked option
            this.classList.add('selected');
            // Update selected pricing type
            selectedPricingType = this.dataset.type;
            pricingTypeInput.value = selectedPricingType;
            
            // Update price amount placeholder based on selection
            const priceAmount = document.getElementById('price-amount');
            const priceSpan = this.querySelector('.pricing-option-price span');
            if (priceSpan) {
                priceAmount.placeholder = `e.g., ${priceSpan.textContent}`;
            }
        });
    });
    
    // Update navigation buttons
    function updateNavigation() {
        // Previous button
        prevBtn.disabled = currentStep === 1;
        
        // Next/Submit button
        if (currentStep === totalSteps) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'block';
            updateReviewData();
        } else {
            nextBtn.style.display = 'block';
            submitBtn.style.display = 'none';
        }
        
        // Update step indicators
        stepIndicators.forEach((indicator, index) => {
            const stepNumber = index + 1;
            if (stepNumber < currentStep) {
                indicator.classList.add('service-listing-step-completed');
                indicator.classList.remove('service-listing-step-active');
            } else if (stepNumber === currentStep) {
                indicator.classList.add('service-listing-step-active');
                indicator.classList.remove('service-listing-step-completed');
            } else {
                indicator.classList.remove('service-listing-step-active', 'service-listing-step-completed');
            }
        });
        
        // Update step connectors
        stepConnectors.forEach((connector, index) => {
            if (index + 1 < currentStep) {
                connector.classList.add('service-listing-step-connector-active');
            } else {
                connector.classList.remove('service-listing-step-connector-active');
            }
        });
    }
    
    // Show current step content
    function showStep(stepNumber) {
        stepPanels.forEach(panel => {
            panel.style.display = 'none';
        });
        
        const currentStepPanel = document.getElementById(`step${stepNumber}Content`);
        if (currentStepPanel) {
            currentStepPanel.style.display = 'block';
            
            // Scroll to top of the form
            currentStepPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    
    // Validate current step
    function validateStep(step) {
        let isValid = true;
        const errorFields = [];

        errorFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.remove('is-invalid');
            }
        });
        
        switch(step) {
            case 1:
                // Validate basic info
                const businessName = document.getElementById('businessName');
                const contactPerson = document.getElementById('contactPerson');
                const phoneNumber = document.getElementById('phoneNumber');
                const emailAddress = document.getElementById('emailAddress');
                const physicalAddress = document.getElementById('physicalAddress');
                const cityinfo = document.getElementById('cityinfo');
                const zipCode = document.getElementById('zipCode');
                
                if (!businessName.value.trim()) {
                    isValid = false;
                    errorFields.push('businessName');
                }
                if (!contactPerson.value.trim()) {
                    isValid = false;
                    errorFields.push('contactPerson');
                }
                if (!phoneNumber.value.trim()) {
                    isValid = false;
                    errorFields.push('phoneNumber');
                }
                if (!emailAddress.value.trim() || !isValidEmail(emailAddress.value)) {
                    isValid = false;
                    errorFields.push('emailAddress');
                }
                if (!physicalAddress.value.trim()) {
                    isValid = false;
                    errorFields.push('physicalAddress');
                }
                if (!cityinfo.value.trim()) {
                    isValid = false;
                    errorFields.push('cityinfo');
                }
                if (!zipCode.value.trim() || zipCode.value.length !== 5) {
                    isValid = false;
                    errorFields.push('zipCode');
                }
                break;
                
            case 2:
                // Validate services
                const serviceCheckboxes = document.querySelectorAll('input[name="sub_categories[]"]:checked');
                if (serviceCheckboxes.length === 0) {
                    isValid = false;
                    // Highlight service categories container
                    const serviceContainer = document.querySelector('.service-listing-checkbox-group-container');
                    serviceContainer.classList.add('border', 'border-danger', 'rounded', 'p-2');
                } else {
                    const serviceContainer = document.querySelector('.service-listing-checkbox-group-container');
                    serviceContainer.classList.remove('border', 'border-danger', 'rounded', 'p-2');
                }
                break;
                
            case 3:
                // Validate pricing
                const priceAmount = document.getElementById('price-amount');
                if (!priceAmount.value.trim() || parseFloat(priceAmount.value) <= 0) {
                    isValid = false;
                    errorFields.push('price-amount');
                }
                break;
                
            // Add validation for other steps as needed
        }
        
        // Highlight error fields
        errorFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.add('is-invalid');
            }
        });
        
        return isValid;
    }
    
    // Email validation helper
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // File type icon helper
    function getFileIcon(fileType) {
        if (fileType.startsWith('image/')) return 'fa-file-image text-primary';
        if (fileType === 'application/pdf') return 'fa-file-pdf text-danger';
        if (fileType.startsWith('text/')) return 'fa-file-text text-info';
        if (fileType.includes('spreadsheet') || fileType.includes('excel')) return 'fa-file-excel text-success';
        if (fileType.includes('word')) return 'fa-file-word text-primary';
        return 'fa-file text-secondary';
    }

    // File size formatting helper
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Remove file from input and formData
    function removeFile(input, fileName) {
        // Create a new DataTransfer to remove the file
        const dt = new DataTransfer();
        const files = Array.from(input.files);
        const updatedFiles = files.filter(file => file.name !== fileName);
        
        updatedFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;

        // Also remove from formData
        rebuildFormData();
    }

    // Rebuild formData from all file inputs
    function rebuildFormData() {
        // Clear existing form data for files
        for (let key of formData.keys()) {
            if (key.startsWith('license_files') || key.startsWith('portfolio_images') || key.startsWith('additional_docs')) {
                formData.delete(key);
            }
        }

        // Rebuild formData from all file inputs
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            if (input.files.length > 0) {
                if (input.multiple) {
                    Array.from(input.files).forEach(file => {
                        formData.append(input.name, file);
                    });
                } else {
                    formData.set(input.name, input.files[0]);
                }
            }
        });
    }
    
    // Update review data
    function updateReviewData() {
        // Basic Info
        document.getElementById('reviewBusinessName').textContent = document.getElementById('businessName').value || '-';
        document.getElementById('reviewContactPerson').textContent = document.getElementById('contactPerson').value || '-';
        document.getElementById('reviewPhone').textContent = document.getElementById('phoneNumber').value || '-';
        document.getElementById('reviewEmail').textContent = document.getElementById('emailAddress').value || '-';
        
        const address = [
            document.getElementById('physicalAddress').value,
            document.getElementById('cityinfo').value,
            document.getElementById('state').value,
            document.getElementById('zipCode').value
        ].filter(Boolean).join(', ');
        document.getElementById('reviewAddress').textContent = address || '-';
        
        // Services
        const selectedServices = Array.from(document.querySelectorAll('input[name="service_categories[]"]:checked'))
            .map(cb => cb.nextElementSibling.textContent).join(', ');
        document.getElementById('reviewServices').textContent = selectedServices || '-';
        document.getElementById('reviewDescription').textContent = document.getElementById('serviceDescription').value || '-';
        
        // Pricing & Schedule
        document.getElementById('reviewPricingType').textContent = selectedPricingType.charAt(0).toUpperCase() + selectedPricingType.slice(1);
        document.getElementById('reviewPriceAmount').textContent = '$' + (document.getElementById('price-amount').value || '0');
        
        const availableDays = Array.from(document.querySelectorAll('input[name="available_days[]"]:checked'))
            .map(cb => cb.value.charAt(0).toUpperCase() + cb.value.slice(1)).join(', ');
        document.getElementById('reviewAvailableDays').textContent = availableDays || '-';
        
        const startTime = document.getElementById('start-time').value;
        const endTime = document.getElementById('end-time').value;
        document.getElementById('reviewWorkingHours').textContent = (startTime && endTime) ? `${startTime} to ${endTime}` : '-';
        
        // Credentials
        document.getElementById('reviewLicenseNumber').textContent = document.getElementById('licenseNumber').value || '-';
        document.getElementById('reviewYearsOperation').textContent = document.getElementById('yearsOperation').value || '-';
        document.getElementById('reviewInsurance').textContent = document.getElementById('insuranceCoverage').value || '-';
        
        const diversityBadges = Array.from(document.querySelectorAll('input[name="diversity_badges[]"]:checked'))
            .map(cb => cb.nextElementSibling.textContent.trim()).join(', ');
        document.getElementById('reviewDiversityBadges').textContent = diversityBadges || '-';
        
        const specialFeatures = Array.from(document.querySelectorAll('input[name="special_features[]"]:checked'))
            .map(cb => cb.nextElementSibling.textContent.trim()).join(', ');
        document.getElementById('reviewSpecialFeatures').textContent = specialFeatures || '-';
        
        // Media & Links
        document.getElementById('reviewWebsite').textContent = document.getElementById('website').value || '-';
        document.getElementById('reviewFacebook').textContent = document.getElementById('facebook').value || '-';
        document.getElementById('reviewInstagram').textContent = document.getElementById('instagram').value || '-';

        // Files review
        updateFilesReview();
    }

    // Update files section in review
    function updateFilesReview() {
        const fileInputs = document.querySelectorAll('input[type="file"]');
        const filesSummary = {};

        fileInputs.forEach(input => {
            if (input.files.length > 0) {
                const fileType = input.name.replace('_files', '').replace('_images', '').replace('_docs', '');
                filesSummary[fileType] = input.files.length;
            }
        });

        let filesText = '';
        Object.keys(filesSummary).forEach(type => {
            const count = filesSummary[type];
            filesText += `${count} ${type} file${count > 1 ? 's' : ''}, `;
        });

        document.getElementById('reviewFiles').textContent = filesText ? filesText.slice(0, -2) : 'No files uploaded';
    }
    
    // Event listeners
    nextBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
            updateNavigation();
        } else {
            // Scroll to first error field
            const firstErrorField = document.querySelector('.is-invalid');
            if (firstErrorField) {
                firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstErrorField.focus();
            }
        }
    });
    
    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
            updateNavigation();
        }
    });
    
    // Enhanced File upload functionality
    const uploadAreas = document.querySelectorAll('.service-listing-file-upload-area');
    uploadAreas.forEach(area => {
        const fileInput = area.querySelector('input[type="file"]');
        const filesList = area.querySelector('.service-listing-uploaded-files-list');
        
        area.addEventListener('click', function() {
            fileInput.click();
        });
        
        area.addEventListener('dragover', function(e) {
            e.preventDefault();
            area.style.backgroundColor = 'rgba(0, 123, 255, 0.1)';
        });
        
        area.addEventListener('dragleave', function() {
            area.style.backgroundColor = '';
        });
        
        area.addEventListener('drop', function(e) {
            e.preventDefault();
            area.style.backgroundColor = '';
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                updateFileList(fileInput, filesList);
            }
        });
        
        fileInput.addEventListener('change', function() {
            updateFileList(fileInput, filesList);
        });
    });
    
    function updateFileList(fileInput, filesList) {
        filesList.innerHTML = '';
        
        if (fileInput.files.length > 0) {
            Array.from(fileInput.files).forEach(file => {
                // Add to FormData for submission
                if (fileInput.multiple) {
                    formData.append(fileInput.name, file);
                } else {
                    formData.set(fileInput.name, file);
                }
                
                const fileItem = document.createElement('div');
                fileItem.className = 'service-listing-uploaded-file-item';
                fileItem.innerHTML = `
                    <i class="fas ${getFileIcon(file.type)} me-2"></i>
                    <span>${file.name}</span>
                    <small>(${formatFileSize(file.size)})</small>
                    <button type="button" class="service-listing-remove-file-btn" data-filename="${file.name}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                // Add remove functionality
                const removeBtn = fileItem.querySelector('.service-listing-remove-file-btn');
                removeBtn.addEventListener('click', function() {
                    removeFile(fileInput, file.name);
                    fileItem.remove();
                    
                    // If no files left, clear the list
                    if (filesList.children.length === 0) {
                        filesList.innerHTML = '';
                    }
                });
                
                filesList.appendChild(fileItem);
            });
        }
    }

    // Form submission with file handling
    
    function showSuccessMessage(message) {
        // You can use SweetAlert or your preferred notification method
        alert('Success: ' + message);
    }

    function showErrorMessage(message) {
        alert('Error: ' + message);
    }
    
    // Real-time validation for email
    const emailField = document.getElementById('emailAddress');
    if (emailField) {
        emailField.addEventListener('blur', function() {
            if (this.value && !isValidEmail(this.value)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Real-time validation for ZIP code
    const zipField = document.getElementById('zipCode');
    if (zipField) {
        zipField.addEventListener('blur', function() {
            if (this.value && this.value.length !== 5) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Initialize
    showStep(currentStep);
    updateNavigation();
});
</script>

<style>
.service-listing-step-content-panel {
    transition: all 0.3s ease;
}

.service-listing-step-indicator-item.service-listing-step-completed .service-listing-step-indicator-circle {
    background-color: #28a745;
    color: white;
}

.service-listing-step-connector.service-listing-step-connector-active {
    background-color: #28a745;
}

.service-listing-uploaded-file-item {
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 4px;
    margin: 5px 0;
    border: 1px solid #dee2e6;
}

.service-listing-submit-button {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.service-listing-submit-button:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

/* Pricing Options Styles */
.pricing-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin: 1rem 0;
}

.pricing-option {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.pricing-option:hover {
    border-color: #007bff;
    transform: translateY(-2px);
}

.pricing-option.selected {
    border-color: #007bff;
    background-color: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
}

.pricing-option-name {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.pricing-option-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 1rem;
}

.pricing-option-features {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
}

.pricing-option-features li {
    padding: 0.25rem 0;
    font-size: 0.9rem;
    color: #666;
}

.pricing-option-features li:before {
    content: "✓";
    color: #28a745;
    font-weight: bold;
    margin-right: 0.5rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
}

/* Error styling */
.is-invalid {
    border-color: #dc3545 !important;
}

.service-listing-error-message-text {
    display: none;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.service-listing-error-message-text.show {
    display: block;
}

.alert-danger {
    border-left: 4px solid #dc3545;
}

.alert-success {
    border-left: 4px solid #28a745;
}

/* Existing files styling */
.existing-files-section {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.existing-file-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #dee2e6;
}

.existing-file-item:last-child {
    border-bottom: none;
}
</style>

@endsection