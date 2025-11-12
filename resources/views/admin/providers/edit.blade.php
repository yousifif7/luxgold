
        <form id="providerForm" method="POST" action="{{ isset($provider) ? route('admin.providers.update', $provider->id) : route('admin.providers.store') }}">
            @csrf
            @if(isset($provider))
                @method('PUT')
            @endif
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" class="form-control" name="first_name" 
                                   value="{{ old('first_name', $provider->user->first_name ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Last Name *</label>
                            <input type="text" class="form-control" name="last_name" 
                                   value="{{ old('last_name', $provider->user->last_name ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" 
                                   value="{{ old('email', $provider->user->email ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Phone *</label>
                            <input type="tel" class="form-control" name="phone" 
                                   value="{{ old('phone', $provider->phone ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Business Name *</label>
                            <input type="text" class="form-control" name="business_name" 
                                   value="{{ old('business_name', $provider->business_name ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Category *</label>
                            <select class="form-control" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Daycare" {{ (old('category', $provider->category ?? '') == 'Daycare') ? 'selected' : '' }}>Daycare</option>
                                <option value="Preschool" {{ (old('category', $provider->category ?? '') == 'Preschool') ? 'selected' : '' }}>Preschool</option>
                                <option value="Tutoring" {{ (old('category', $provider->category ?? '') == 'Tutoring') ? 'selected' : '' }}>Tutoring</option>
                                <option value="Activities" {{ (old('category', $provider->category ?? '') == 'Activities') ? 'selected' : '' }}>Activities</option>
                                <option value="Wellness" {{ (old('category', $provider->category ?? '') == 'Wellness') ? 'selected' : '' }}>Wellness</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Physical Address *</label>
                    <input type="text" class="form-control" name="physical_address" 
                           value="{{ old('physical_address', $provider->physical_address ?? '') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">City *</label>
                            <input type="text" class="form-control" name="city" 
                                   value="{{ old('city', $provider->city ?? '') }}" required>
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
                </div>

                <div class="mb-3">
                    <label class="form-label">Service Description *</label>
                    <textarea class="form-control" name="service_description" rows="3" required>{{ old('service_description', $provider->service_description ?? '') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Subscription Plan *</label>
                            <select class="form-control" name="plan_id" required>
                                <option value="">Select Plan</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" 
                                        {{ (old('plan_id', $provider->subscription->plan_id ?? '') == $plan->id) ? 'selected' : '' }}>
                                        {{ $plan->name }} - ${{ number_format($plan->monthly_fee, 2) }}/month
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if(isset($provider))
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-control" name="status" required>
                                <option value="pending" {{ (old('status', $provider->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ (old('status', $provider->status) == 'approved') ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ (old('status', $provider->status) == 'rejected') ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        @endif
                    </div>
                      <div class="col-md-6">
                        @if(isset($provider))
                        <div class="mb-3">
                            <label class="form-label">Featured *</label>
                            <select class="form-control" name="is_featured" required>
                                <option value="1" {{ (old('is_featured', $provider->is_featured) == 1) ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ (old('is_featured', $provider->is_featured) == 0) ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </div>

                @if(!isset($provider))
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
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
    