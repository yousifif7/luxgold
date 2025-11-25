<div class="askroro-modal-overlay" id="parentSignUpModal" style="display: none;">
    <div class="askroro-modal-dialog">
        <div class="askroro-modal-content">
            <button class="askroro-btn-close" onclick="closeModal('parentSignUpModal')">&times;</button>
                <div class="askroro-modal-header">
                <div class="askroro-avatar-box">
                    <div class="askroro-avatar"><img src="{{ asset('assets/images/updated-logo.jpeg') }}" alt=""></div>
                </div>
                <h2 class="askroro-modal-title">Customer Sign Up</h2>
                <p class="askroro-modal-subtitle">Find trusted cleaning services for your home</p>
            </div>
            <div class="askroro-modal-body">
                <form id="parentSignUpForm">
                    @csrf
                    <input type="hidden" name="role" value="customer">
                    
                    <div class="askroro-name-row">
                        <div class="askroro-form-group">
                            <label class="askroro-form-label">First Name</label>
                            <input type="text" name="first_name" class="askroro-form-control" placeholder="First name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="askroro-form-group">
                            <label class="askroro-form-label">Last Name</label>
                            <input type="text" name="last_name" class="askroro-form-control" placeholder="Last name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="askroro-form-group">
                        <label class="askroro-form-label">Email Address</label>
                        <div class="askroro-input-icon-wrapper">
                            <i class="bi bi-envelope askroro-input-icon"></i>
                            <input type="email" name="email" class="askroro-form-control" placeholder="your@email.com" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="askroro-form-group">
                        <label class="askroro-form-label">Password</label>
                        <div class="askroro-input-icon-wrapper">
                            <i class="bi bi-lock askroro-input-icon"></i>
                            <input type="password" name="password" class="askroro-form-control" placeholder="Create a password" required minlength="8">
                            <button type="button" class="askroro-btn-password-toggle" onclick="togglePassword(this)">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="askroro-form-group">
                        <label class="askroro-form-label">Confirm Password</label>
                        <div class="askroro-input-icon-wrapper">
                            <i class="bi bi-lock askroro-input-icon"></i>
                            <input type="password" name="password_confirmation" class="askroro-form-control" placeholder="Confirm your password" required>
                            <button type="button" class="askroro-btn-password-toggle" onclick="togglePassword(this)">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <button type="submit" class="askroro-btn-primary" id="parentSubmitBtn">
                        <span class="btn-text">Create Account</span>
                        <span class="btn-loading" style="display: none;">
                            <i class="bi bi-arrow-repeat spin"></i> Creating Account...
                        </span>
                    </button>
                </form>
                
                <div class="askroro-text-center" style="margin-top:20px;">
                    <a href="#" class="askroro-link-back" onclick="backToSignUpOptions()">← Back to options</a>
                </div>
                <div class="askroro-text-center">
                    <span class="askroro-text-muted">Already have an account? </span>
                    <a href="#" class="askroro-link" onclick="openLoginModal()">Log in.</a>
                </div>
            </div>
        </div>
    </div>
</div>