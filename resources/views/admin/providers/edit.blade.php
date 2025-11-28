<form id="providerForm" method="POST" action="{{ isset($provider) ? route('admin.cleaners.update', ['cleaner' => $provider->id]) : route('admin.cleaners.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($provider))
        @method('PUT')
    @endif

    <div class="modal-body">

        {{-- User Info --}}
        <div class="row">
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">First Name *</label>
                <input type="text" class="form-control" name="first_name" 
                       value="{{ old('first_name', $provider->user->first_name ?? '') }}" required>
            </div>
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Last Name *</label>
                <input type="text" class="form-control" name="last_name" 
                       value="{{ old('last_name', $provider->user->last_name ?? '') }}" required>
            </div>
           <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Email *</label>
                <input type="email" class="form-control" name="email" 
                       value="{{ old('email', $provider->email ?? '') }}" required>
            </div>
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Phone *</label>
                <input type="tel" class="form-control" name="phone" 
                       value="{{ old('phone', $provider->phone ?? '') }}" required>
            </div>
            <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">City *</label>
                            <select class="form-control" name="city" required>
                <option value="">Select Category</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city', $provider->city ?? '') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>

                           
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">State *</label>
                            <input type="text" class="form-control" name="state" 
                                   value="{{ old('state', $provider->state ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Zip Code *</label>
                            <input type="text" class="form-control" name="zip_code" 
                                   value="{{ old('zip_code', $provider->zip_code ?? '') }}" required>
                        </div>
                    </div>

        {{-- Provider Name (solo cleaner) --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Name *</label>
            <input type="text" class="form-control" name="name" 
                   value="{{ old('name', $provider->name ?? ($provider->user->name ?? '')) }}" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Category *</label>
            <select class="form-control" name="categories_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('categories_id', $provider->categories_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Sub Categories</label>
            <select class="form-control" name="sub_categories[]" multiple>
                @foreach($sub_categories as $sub)
                    <option value="{{ $sub->id }}" {{ in_array($sub->id, old('sub_categories', $provider->sub_categories ?? [])) ? 'selected' : '' }}>
                        {{ $sub->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Services Offered</label>
            <select class="form-control" name="services_offerd[]" multiple>
                @foreach($services_offerd as $service)
                    <option value="{{ $service->id }}" {{ in_array($service->id, old('services_offerd', $provider->services_offerd ?? [])) ? 'selected' : '' }}>
                        {{ $service->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Service Description</label>
            <textarea class="form-control" name="service_description" rows="3">{{ old('service_description', $provider->service_description ?? '') }}</textarea>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Ages Served</label>
            <select class="form-control" name="ages_served_id">
                <option value="">Select Age Group</option>
                @foreach($ages_served as $age)
                    <option value="{{ $age->id }}" {{ old('ages_served_id', $provider->ages_served_id ?? '') == $age->id ? 'selected' : '' }}>
                        {{ $age->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Programs Offered</label>
            <select class="form-control" name="programs_offered_id">
                <option value="">Select Program</option>
                @foreach($programs_offerd as $program)
                    <option value="{{ $program->id }}" {{ old('programs_offered_id', $provider->programs_offered_id ?? '') == $program->id ? 'selected' : '' }}>
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Pricing --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Price Amount</label>
            <input type="number" step="0.01" class="form-control" name="price_amount" 
                   value="{{ old('price_amount', $provider->price_amount ?? '') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Pricing Description</label>
            <textarea class="form-control" name="pricing_description" rows="2">{{ old('pricing_description', $provider->pricing_description ?? '') }}</textarea>
        </div>

        {{-- Availability --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Available Days</label>
            <select class="form-control" name="available_days[]" multiple>
                @php
                    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                @endphp
                @foreach($days as $day)
                    <option value="{{ $day }}" {{ in_array($day, old('available_days', $provider->available_days ?? [])) ? 'selected' : '' }}>{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Start Time</label>
                <input type="time" class="form-control" name="start_time" value="{{ old('start_time', $provider->start_time ?? '') }}">
            </div>
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">End Time</label>
                <input type="time" class="form-control" name="end_time" value="{{ old('end_time', $provider->end_time ?? '') }}">
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Availability Notes</label>
            <textarea class="form-control" name="availability_notes" rows="2">{{ old('availability_notes', $provider->availability_notes ?? '') }}</textarea>
        </div>

        {{-- Legal / Features removed per product decision --}}

        <div class="col-md-4 mb-3">
            <label class="form-label">Special Features</label>
            <select class="form-control" name="special_features[]" multiple>
                @foreach($special_pages as $feature)
                    <option value="{{ $feature->id }}" {{ in_array($feature->id, old('special_features', $provider->special_features ?? [])) ? 'selected' : '' }}>
                        {{ $feature->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Social / Media --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Website</label>
            <input type="url" class="form-control" name="website" value="{{ old('website', $provider->website ?? '') }}">
        </div>

        <div class="row">
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Facebook</label>
                <input type="url" class="form-control" name="facebook" value="{{ old('facebook', $provider->facebook ?? '') }}">
            </div>
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Instagram</label>
                <input type="url" class="form-control" name="instagram" value="{{ old('instagram', $provider->instagram ?? '') }}">
            </div>
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Avatar / Logo</label>
                <input type="file" class="form-control" name="avatar">
                @if(isset($provider) && $provider->logo_path)
                    <img src="{{ asset($provider->logo_path) }}" alt="Avatar" width="50" class="mt-2">
                @endif
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Facility Photos</label>
            <input type="file" class="form-control" name="facility_photos_paths[]" multiple>
            @if(isset($provider) && $provider->facility_photos_paths)
                <div class="mt-2">
                    @foreach($provider->facility_photos_paths as $photo)
                        <img src="{{ asset($photo) }}" alt="Photo" width="50" class="me-1">
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">License Documents</label>
            <input type="file" class="form-control" name="license_docs_paths[]" multiple>
            @if(isset($provider) && $provider->license_docs_paths)
                <div class="mt-2">
                    @foreach($provider->license_docs_paths as $doc)
                        <a href="{{ asset($doc) }}" target="_blank">View Document</a><br>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Subscription / Status --}}
        <div class="row">
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Subscription Plan *</label>
                <select class="form-control" name="plan_id" required>
                    <option value="">Select Plan</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('plan_id', $provider->plans_id ?? '') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} - ${{ number_format($plan->monthly_fee, 2) }}/month
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Status *</label>
                <select class="form-control" name="status" required>
                    <option value="pending" {{ old('status', $provider->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $provider->status ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('status', $provider->status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Featured *</label>
            <select class="form-control" name="is_featured" required>
                <option value="1" {{ old('is_featured', $provider->is_featured ?? '') == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('is_featured', $provider->is_featured ?? '') == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        {{-- Password for new provider --}}
        @if(!isset($provider))
        <div class="row">
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Password *</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="col-md-4 col-md-4 mb-3">
                <label class="form-label">Confirm Password *</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>
        @endif

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i>
            {{ isset($provider) ? 'Update' : 'Create' }} Provider
        </button>
    </div>
</form>
<!-- CSS -->
