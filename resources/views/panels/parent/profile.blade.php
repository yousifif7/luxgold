@extends('layouts.parent-layout')

@section('parent-title', 'Profile - Parent Portal')
@section('content')

<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">
        <div class="section-card">
            <div class="section-title">Profile & Settings</div>
            <div class="section-subtitle">Manage your account information and preferences</div>

            <!-- Success/Error Messages -->
            <div id="message-alert" class="alert alert-success d-none"></div>

            <div class="mb-4">
                <h6 class="mb-3"><i class="fas fa-user me-2"></i> Personal Information</h6>
                <form id="personalInfoForm" method="POST" action="{{ route('parent.profile.personal-info') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Profile Picture Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <div class="profile-picture-container me-4">
                                    <div class="profile-picture-wrapper">
                                        <img id="profilePicturePreview" 
                                             src="{{ auth()->user()->profile_picture ? asset( auth()->user()->profile_picture) : asset('images/default-avatar.png') }}" 
                                             alt="Profile Picture" 
                                             class="profile-picture">
                                        <div class="profile-picture-overlay">
                                            <i class="fas fa-camera"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-picture-info">
                                    <h6 class="mb-1">Profile Picture</h6>
                                    <p class="text-muted mb-2">Click on the image to upload a new photo</p>
                                    <input type="file" 
                                           name="profile_picture" 
                                           id="profilePictureInput" 
                                           accept="image/*" 
                                           class="d-none">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profilePictureInput').click()">
                                        <i class="fas fa-upload me-1"></i> Upload Photo
                                    </button>
                                    @if(auth()->user()->profile_picture)
                                    <button type="button" class="btn btn-outline-danger btn-sm ms-2" onclick="removeProfilePicture()">
                                        <i class="fas fa-trash me-1"></i> Remove
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="firstName" 
                                   value="{{ auth()->user()->first_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="lastName" 
                                   value="{{ auth()->user()->last_name }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" 
                                   value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" id="phone" 
                                   value="{{ auth()->user()->phone }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" id="personalInfoBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Save Changes
                    </button>
                </form>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <h6 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i> Location Preferences</h6>
                <div class="section-subtitle">Set your preferred location for provider suggestions</div>
                <form id="locationPreferencesForm" method="POST" action="{{ route('parent.profile.location-preferences') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Primary City</label>
                            <input type="text" class="form-control" name="city" id="city" 
                                   value="{{ auth()->user()->city }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Search Radius</label>
                            <select class="form-select" name="search_radius" id="radius" required>
                                <option value="5" {{ auth()->user()->search_radius == 5 ? 'selected' : '' }}>5 miles</option>
                                <option value="10" {{ auth()->user()->search_radius == 10 ? 'selected' : '' }}>10 miles</option>
                                <option value="15" {{ auth()->user()->search_radius == 15 ? 'selected' : '' }}>15 miles</option>
                                <option value="20" {{ auth()->user()->search_radius == 20 ? 'selected' : '' }}>20 miles</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" class="form-control" name="zip_code" id="zip" 
                                   value="{{ auth()->user()->zip_code }}" required>
                        </div>
                        <input type="hidden" name="state" id="state" value="{{ auth()->user()->state ?? 'WA' }}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" id="locationPreferencesBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Update Location
                    </button>
                </form>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <h6 class="mb-3"><i class="fas fa-bell me-2"></i> Notification Preferences</h6>
                <div class="section-subtitle">Choose how you'd like to receive updates</div>
                
                <form id="notificationPreferencesForm" method="POST" action="{{ route('parent.profile.notification-preferences') }}">
                    @csrf
                   
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="provider-name">Provider Responses</div>
                            <div class="provider-type">Get notified when providers respond to your inquiries</div>
                        </div>
                        <div class="toggle-switch {{ auth()->user()->notification_preferences['provider_responses'] ?? false ? 'active' : '' }}" 
                             data-preference="provider_responses" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="provider_responses" 
                                   value="{{ auth()->user()->notification_preferences['provider_responses'] ?? false ? '1' : '0' }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="provider-name">New Provider Suggestions</div>
                            <div class="provider-type">Weekly recommendations based on your preferences</div>
                        </div>
                        <div class="toggle-switch {{ auth()->user()->notification_preferences['new_provider_suggestions'] ?? false ? 'active' : '' }}" 
                             data-preference="new_provider_suggestions" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="new_provider_suggestions" 
                                   value="{{ auth()->user()->notification_preferences['new_provider_suggestions'] ?? false ? '1' : '0' }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="provider-name">Event Reminders</div>
                            <div class="provider-type">Reminders about upcoming events and appointments</div>
                        </div>
                        <div class="toggle-switch {{ auth()->user()->notification_preferences['event_reminders'] ?? false ? 'active' : '' }}" 
                             data-preference="event_reminders" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="event_reminders" 
                                   value="{{ auth()->user()->notification_preferences['event_reminders'] ?? false ? '1' : '0' }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3" id="notificationPreferencesBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Save Preferences
                    </button>
                </form>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <h6 class="mb-3"><i class="fas fa-key me-2"></i> Change Password</h6>
                <div class="section-subtitle">Update your account password</div>
                <form id="passwordChangeForm" method="POST" action="{{ route('parent.profile.password') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password" id="currentPassword" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" id="newPassword" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="confirmPassword" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" id="passwordChangeBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- End Content -->            

</div>

<script>
// Toggle switch functionality
function toggleSwitch(element) {
    const toggle = element;
    const isActive = toggle.classList.contains('active');
    const hiddenInput = toggle.querySelector('input[type="hidden"]');
    
    if (isActive) {
        toggle.classList.remove('active');
        hiddenInput.value = '0';
    } else {
        toggle.classList.add('active');
        hiddenInput.value = '1';
    }
}

// Profile picture preview
document.getElementById('profilePictureInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePicturePreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Remove profile picture
function removeProfilePicture() {
    if (confirm('Are you sure you want to remove your profile picture?')) {
        document.getElementById('profilePicturePreview').src = '{{ asset("images/default-avatar.png") }}';
        document.getElementById('profilePictureInput').value = '';
        
        // You might want to add an AJAX call here to remove the profile picture from the server
        // removeProfilePictureFromServer();
    }
}

// Show message
function showMessage(message, type = 'success') {
    const alert = document.getElementById('message-alert');
    alert.textContent = message;
    alert.className = `alert alert-${type}`;
    alert.classList.remove('d-none');
    
    setTimeout(() => {
        alert.classList.add('d-none');
    }, 5000);
}

// Handle form submissions with AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Handle all form submissions
    const forms = document.querySelectorAll('form[id$="Form"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const spinner = submitBtn.querySelector('.spinner-border');
            
            // Prevent double submissions
            if (form.dataset.submitting === '1') return;
            form.dataset.submitting = '1';
            
            // Clear previous errors
            const invalidFields = form.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => field.classList.remove('is-invalid'));
            
            const errorMessages = form.querySelectorAll('.invalid-feedback');
            errorMessages.forEach(msg => msg.remove());
            
            // Show loading state
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            
            // Submit form
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(async response => {
                const data = await response.json();
                
                if (response.ok) {
                    // Success
                    showMessage(data.message || 'Settings updated successfully');
                    
                    // Clear password fields if password form
                    if (form.id === 'passwordChangeForm') {
                        form.reset();
                    }
                    
                    // Update profile picture if it was changed
                    if (form.id === 'personalInfoForm' && data.user && data.user.profile_picture) {
                        document.getElementById('profilePicturePreview').src = 
                            '{{ url("storage") }}/' + data.user.profile_picture + '?t=' + new Date().getTime();
                    }
                } else if (response.status === 422) {
                    // Validation errors
                    if (data.errors) {
                        // Show field errors
                        Object.keys(data.errors).forEach(field => {
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'invalid-feedback';
                                errorDiv.textContent = data.errors[field][0];
                                
                                input.parentNode.appendChild(errorDiv);
                            }
                        });
                        
                        // Scroll to first error
                        const firstError = form.querySelector('.is-invalid');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstError.focus();
                        }
                    }
                    
                    // Show error message
                    showMessage(data.message || 'Please fix the errors below', 'danger');
                } else {
                    // Other errors
                    throw new Error(data.message || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage(error.message || 'An error occurred while updating settings', 'danger');
            })
            .finally(() => {
                // Reset loading state
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
                delete form.dataset.submitting;
            });
        });
    });
});
</script>

<style>
.profile-picture-container {
    position: relative;
}

.profile-picture-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
}

.profile-picture-wrapper:hover {
    border-color: #007bff;
}

.profile-picture {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-picture-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.profile-picture-wrapper:hover .profile-picture-overlay {
    opacity: 1;
}

.profile-picture-overlay i {
    color: white;
    font-size: 1.5rem;
}

.profile-picture-info {
    flex: 1;
}

.toggle-switch {
    width: 50px;
    height: 25px;
    background-color: #ccc;
    border-radius: 25px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.3s;
}

.toggle-switch.active {
    background-color: #007bff;
}

.toggle-slider {
    width: 21px;
    height: 21px;
    background-color: white;
    border-radius: 50%;
    position: absolute;
    top: 2px;
    left: 2px;
    transition: transform 0.3s;
}

.toggle-switch.active .toggle-slider {
    transform: translateX(25px);
}
</style>
@endsection