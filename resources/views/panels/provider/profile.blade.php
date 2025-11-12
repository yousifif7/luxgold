@extends('layouts.provider-layout')

@section('provider-title', 'Profile - Provider Portal')
@section('content')

<div class="page-wrapper">
    <!-- Start Content -->
    <div class="content">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Profile Settings</h4>
                <p class="mb-0">Manage your account information and security.</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i>
                Please fix the following errors:
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="tab-buttons mb-4">
            <button class="tab-btn active" onclick="showProfileTab('profile')">Profile Information</button>
            <button class="tab-btn" onclick="showProfileTab('security')">Change Password</button>
        </div>

        <!-- Profile Information Tab -->
        <div id="profile-tab" class="profile-tab-content">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4"><i class="ti ti-user me-2"></i>Profile Information</h5>
                    <p class="text-muted mb-4">Update your personal and contact information</p>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" 
                                       value="{{ old('first_name', $user->first_name) }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" 
                                       value="{{ old('last_name', $user->last_name) }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" 
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" 
                                       value="{{ old('city', $user->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                       id="state" name="state" 
                                       value="{{ old('state', $user->state) }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                                       id="zip_code" name="zip_code" 
                                       value="{{ old('zip_code', $user->zip_code) }}">
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div id="security-tab" class="profile-tab-content hidden">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4"><i class="ti ti-lock me-2"></i>Change Password</h5>
                    <p class="text-muted mb-4">Update your password to keep your account secure</p>

                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label">Current Password *</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Password must be at least 8 characters long.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-key me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
</div>

<style>
.tab-buttons {
    display: flex;
    gap: 1rem;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.tab-btn {
    background: none;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
}

.tab-btn:hover {
    background: #f8f9fa;
    color: #495057;
}

.tab-btn.active {
    background: #5f7f7a;
    color: white;
}

.profile-tab-content {
    animation: fadeIn 0.3s ease;
}

.hidden {
    display: none;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.card {
    border: 1px solid #e9ecef;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.card-title {
    color: #2c3e50;
    font-weight: 600;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.btn-primary {
    background: #5f7f7a;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

.btn-primary:hover {
    background: #4a6763;
}
</style>

<script>
function showProfileTab(tab) {
    // Hide all tab contents
    document.querySelectorAll(".profile-tab-content").forEach(el => {
        el.classList.add("hidden");
    });

    // Remove active from all buttons
    document.querySelectorAll(".tab-btn").forEach(btn => {
        btn.classList.remove("active");
    });

    // Show selected tab
    document.getElementById(tab + "-tab").classList.remove("hidden");

    // Add active to clicked button
    event.target.classList.add("active");
}

// Form validation enhancement
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="ti ti-loader me-2"></i> Saving...';
            }
        });
    });

    // Clear validation errors when user starts typing
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const feedback = this.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            }
        });
    });
});
</script>

@endsection