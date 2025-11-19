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
                <form id="personalInfoForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="firstName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="lastName" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" id="phone">
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
                <form id="locationPreferencesForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Primary City</label>
                            <input type="text" class="form-control" name="city" id="city" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Search Radius</label>
                            <select class="form-select" name="search_radius" id="radius" required>
                                <option value="5">5 miles</option>
                                <option value="10" selected>10 miles</option>
                                <option value="15">15 miles</option>
                                <option value="20">20 miles</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" class="form-control" name="zip_code" id="zip" required>
                        </div>
                        <input type="hidden" name="state" id="state" value="WA">
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
                
                <form id="notificationPreferencesForm">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="provider-name">Email Notifications</div>
                            <div class="provider-type">Receive updates about messages, reviews, and recommendations</div>
                        </div>
                        <div class="toggle-switch" data-preference="email_notifications" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="email_notifications" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="provider-name">Provider Responses</div>
                            <div class="provider-type">Get notified when providers respond to your inquiries</div>
                        </div>
                        <div class="toggle-switch" data-preference="provider_responses" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="provider_responses" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="provider-name">New Provider Suggestions</div>
                            <div class="provider-type">Weekly recommendations based on your preferences</div>
                        </div>
                        <div class="toggle-switch" data-preference="new_provider_suggestions" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="new_provider_suggestions" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="provider-name">Event Reminders</div>
                            <div class="provider-type">Reminders about upcoming events and appointments</div>
                        </div>
                        <div class="toggle-switch" data-preference="event_reminders" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="event_reminders" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3">
                        <div>
                            <div class="provider-name">Marketing Communications</div>
                            <div class="provider-type">Updates about new features and platform news</div>
                        </div>
                        <div class="toggle-switch" data-preference="marketing_communications" onclick="toggleSwitch(this)">
                            <div class="toggle-slider"></div>
                            <input type="hidden" name="marketing_communications" value="0">
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
                <form id="passwordChangeForm">
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

// Clear field-level errors for a form
function clearFieldErrors(form) {
    // remove invalid classes and feedback nodes
    const invalids = form.querySelectorAll('.is-invalid');
    invalids.forEach(el => el.classList.remove('is-invalid'));
    const feedbacks = form.querySelectorAll('.invalid-feedback');
    feedbacks.forEach(f => f.remove());
}

// Show field-level errors (Laravel format: { field: [messages] })
function showFieldErrors(form, errors) {
    if (!errors || typeof errors !== 'object') return;
    let firstEl = null;
    Object.keys(errors).forEach(field => {
        const messages = errors[field];
        // try to find control by name
        const control = form.querySelector(`[name="${field}"]`) || form.querySelector(`#${field}`);
        if (control) {
            control.classList.add('is-invalid');
            // create feedback container
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = (Array.isArray(messages) ? messages[0] : messages);
            // Insert after the control
            if (control.parentNode) {
                // if control is inside .input-group or similar, append after parent
                if (control.parentNode.classList.contains('input-group')) {
                    control.parentNode.parentNode.insertBefore(feedback, control.parentNode.nextSibling);
                } else {
                    control.parentNode.insertBefore(feedback, control.nextSibling);
                }
            }
            if (!firstEl) firstEl = control;
        }
    });

    // focus and scroll to first invalid field
    if (firstEl) {
        firstEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        try { firstEl.focus(); } catch (e) {}
    }
}

// Load profile data
document.addEventListener('DOMContentLoaded', function() {
    // Fetch and populate profile data
    fetch('{{ route("parent.profile.data") }}')
        .then(response => response.json())
        .then(data => {
            const user = data.user;
            
            // Personal Information
            document.getElementById('firstName').value = user.first_name || '';
            document.getElementById('lastName').value = user.last_name || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('phone').value = user.phone || '';
            
            // Location Preferences
            document.getElementById('city').value = user.city || '';
            document.getElementById('radius').value = user.search_radius || 10;
            document.getElementById('zip').value = user.zip_code || '';
            
            // Notification Preferences
            const preferences = user.notification_preferences || {};
            Object.keys(preferences).forEach(pref => {
                const toggle = document.querySelector(`[data-preference="${pref}"]`);
                if (toggle) {
                    const hiddenInput = toggle.querySelector('input[type="hidden"]');
                    if (preferences[pref]) {
                        toggle.classList.add('active');
                        hiddenInput.value = '1';
                    } else {
                        toggle.classList.remove('active');
                        hiddenInput.value = '0';
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading profile data:', error);
        });

    // Personal Information Form
    document.getElementById('personalInfoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('personalInfoBtn');
        const spinner = btn.querySelector('.spinner-border');
    const form = this;
    // Prevent double submissions if a request is already in progress
    if (form.dataset.submitting === '1') return;
    form.dataset.submitting = '1';
    clearFieldErrors(form);
        btn.disabled = true;
        spinner.classList.remove('d-none');
        fetch('{{ route("parent.profile.personal-info") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                first_name: document.getElementById('firstName').value,
                last_name: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value
            })
        })
        .then(async response => {
            const data = await response.json().catch(() => null);
            if (response.ok) return data;
            if (response.status === 422 && data && data.errors) {
                showFieldErrors(form, data.errors);
                throw data;
            }
            throw data || new Error('Request failed');
        })
        .then(data => {
            data = data || {};
            const msg = data.message || 'Personal information updated successfully.';
            const ok = (typeof data.success !== 'undefined') ? data.success : true;
            showMessage(msg, ok ? 'success' : 'danger');
        })
        .catch(error => {
            if (error && error.errors) {
                // errors already shown
            } else {
                showMessage('An error occurred while updating personal information.', 'danger');
            }
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            delete form.dataset.submitting;
        });
    });

    // Location Preferences Form
    document.getElementById('locationPreferencesForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('locationPreferencesBtn');
        const spinner = btn.querySelector('.spinner-border');
    const form = this;
    if (form.dataset.submitting === '1') return;
    form.dataset.submitting = '1';
    clearFieldErrors(form);
        btn.disabled = true;
        spinner.classList.remove('d-none');
        fetch('{{ route("parent.profile.location-preferences") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                city: document.getElementById('city').value,
                state: document.getElementById('state').value,
                zip_code: document.getElementById('zip').value,
                search_radius: document.getElementById('radius').value
            })
        })
        .then(async response => {
            const data = await response.json().catch(() => null);
            if (response.ok) return data;
            if (response.status === 422 && data && data.errors) {
                showFieldErrors(form, data.errors);
                throw data;
            }
            throw data || new Error('Request failed');
        })
        .then(data => {
            data = data || {};
            const msg = data.message || 'Location preferences updated successfully.';
            const ok = (typeof data.success !== 'undefined') ? data.success : true;
            showMessage(msg, ok ? 'success' : 'danger');
        })
        .catch(error => {
            if (error && error.errors) {
                // shown above
            } else {
                showMessage('An error occurred while updating location preferences.', 'danger');
            }
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            delete form.dataset.submitting;
        });
    });

    // Notification Preferences Form
    document.getElementById('notificationPreferencesForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('notificationPreferencesBtn');
        const spinner = btn.querySelector('.spinner-border');
    const form = this;
    if (form.dataset.submitting === '1') return;
    form.dataset.submitting = '1';
    clearFieldErrors(form);
        btn.disabled = true;
        spinner.classList.remove('d-none');
        
        const formData = new FormData(this);
        const preferences = {};
        formData.forEach((value, key) => {
            preferences[key] = value === '1';
        });
        
        fetch('{{ route("parent.profile.notification-preferences") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(preferences)
        })
        .then(async response => {
            const data = await response.json().catch(() => null);
            if (response.ok) return data;
            if (response.status === 422 && data && data.errors) {
                showFieldErrors(form, data.errors);
                throw data;
            }
            throw data || new Error('Request failed');
        })
        .then(data => {
            data = data || {};
            const msg = data.message || 'Notification preferences updated successfully.';
            const ok = (typeof data.success !== 'undefined') ? data.success : true;
            showMessage(msg, ok ? 'success' : 'danger');
        })
        .catch(error => {
            if (error && error.errors) {
                // errors already shown
            } else {
                showMessage('An error occurred while updating notification preferences.', 'danger');
            }
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            delete form.dataset.submitting;
        });
    });

    // Password Change Form
    document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('passwordChangeBtn');
        const spinner = btn.querySelector('.spinner-border');
    const form = this;
    if (form.dataset.submitting === '1') return;
    form.dataset.submitting = '1';
    clearFieldErrors(form);
        btn.disabled = true;
        spinner.classList.remove('d-none');

        fetch('{{ route("parent.profile.password") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                current_password: document.getElementById('currentPassword').value,
                password: document.getElementById('newPassword').value,
                password_confirmation: document.getElementById('confirmPassword').value
            })
        })
        .then(async response => {
            const data = await response.json().catch(() => null);
            if (response.ok) return data;
            if (response.status === 422 && data && data.errors) {
                showFieldErrors(form, data.errors);
                throw data;
            }
            throw data || new Error('Request failed');
        })
        .then(data => {
            data = data || {};
            const msg = data.message || 'Password updated successfully.';
            const ok = (typeof data.success !== 'undefined') ? data.success : true;
            showMessage(msg, ok ? 'success' : 'danger');
            if (ok) {
                // clear fields
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmPassword').value = '';
            }
        })
        .catch(err => {
            if (err && err.errors) {
                // field errors already shown
            } else {
                const msg = (err && err.message) ? err.message : 'Failed to update password.';
                showMessage(msg, 'danger');
            }
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            delete form.dataset.submitting;
        });
    });
});
</script>

<style>
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