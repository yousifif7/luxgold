

            <!-- Form -->
            <form action="{{ route('admin.pricing.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Plan Name -->
                        <div class="col-md-6">
                            <label class="form-label">Plan Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" placeholder="Plan name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Plan Type -->
                        <div class="col-md-6">
                            <label class="form-label">Plan Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                <option value="">Select Plan Type</option>
                                <option value="Basic" {{ old('type') == 'Basic' ? 'selected' : '' }}>Basic</option>
                                <option value="Standard" {{ old('type') == 'Standard' ? 'selected' : '' }}>Standard</option>
                                <option value="Premium" {{ old('type') == 'Premium' ? 'selected' : '' }}>Premium</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Monthly Fee -->
                        <div class="col-md-6">
                            <label class="form-label">Monthly Fee ($)</label>
                            <input type="number" step="0.01" class="form-control @error('monthly_fee') is-invalid @enderror" 
                                   name="monthly_fee" value="{{ old('monthly_fee', 0) }}" min="0" required>
                            @error('monthly_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Annual Fee -->
                        <div class="col-md-6">
                            <label class="form-label">Annual Fee ($)</label>
                            <input type="number" step="0.01" class="form-control @error('annual_fee') is-invalid @enderror" 
                                   name="annual_fee" value="{{ old('annual_fee', 0) }}" min="0" required>
                            @error('annual_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="2" placeholder="Plan description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Features -->
                       <!-- Features -->
<div class="col-12">
    <label class="form-label">Features</label>
    <div id="features-wrapper">
        @foreach($allFeatures as $feature)
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="features[{{ $feature }}]" id="feature_{{ \Str::slug($feature) }}"
                    value="1"
                    {{ old("features.$feature", $planDefaults[old('type', 'Basic')][$feature] ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="feature_{{ \Str::slug($feature) }}">
                    {{ $feature }}
                </label>
            </div>
        @endforeach
    </div>
</div>


                        <!-- Active Toggle -->
                        <div class="col-12 d-flex align-items-center mt-3">
                            <div class="form-check form-switch">
                              <input type="hidden" name="is_active" value="0">
<input class="form-check-input" type="checkbox" value="1" name="is_active" 
       id="planActive" {{ old('is_active', true) ? 'checked' : '' }}>

                                <label class="form-check-label" for="planActive">Plan is active</label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Plan</button>
                </div>
            </form>
        
<!-- JavaScript for Dynamic Features -->
<script>
$(document).ready(function() {

    // Add new feature
    $(document).on('click', '#addFeature', function() {
        let featureItem = `
            <div class="d-flex align-items-center mb-2 feature-item">
                <input type="text" class="form-control" name="features[]" placeholder="Feature description">
                <button type="button" class="btn btn-sm btn-link text-danger ms-2 remove-feature">
                    <i class="ti ti-x"></i>
                </button>
            </div>`;
        $('#features-wrapper').append(featureItem);
    });

    // Remove a feature
    $(document).on('click', '.remove-feature', function() {
        if ($('.feature-item').length > 1) {
            $(this).closest('.feature-item').remove();
        } else {
            $(this).closest('.feature-item').find('input').val('');
        }
    });

});

</script>