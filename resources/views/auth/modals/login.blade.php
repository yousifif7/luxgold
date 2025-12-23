<div class="askroro-modal-overlay" id="loginModal" style="display: none;">
    <div class="askroro-modal-dialog">
        <div class="askroro-modal-content">
            <button class="askroro-btn-close" onclick="closeModal('loginModal')">&times;</button>
            <div class="askroro-modal-header">
                <div class="askroro-avatar-box">
                    <div class="askroro-avatar">
                        <div class="askroro-avatar-inner">
                            <img src="{{ asset('assets/images/luxgold-trans.png') }}" alt="LuxGold Logo">
                        </div>
                    </div>
                </div>
                <h2 class="askroro-modal-title">Welcome Back</h2>
                <p class="askroro-modal-subtitle">Sign in to your LuxGold account</p>
            </div>
            <div class="askroro-modal-body">
                <div id="loginAlertContainer"></div>
                
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="askroro-form-group">
                        <label class="askroro-form-label">Email Address</label>
                        <div class="askroro-input-icon-wrapper">
                            <i class="bi bi-envelope askroro-input-icon"></i>
                            <input type="email" name="email" class="askroro-form-control" placeholder="your@email.com" required value="{{ old('email') }}">
                            <div class="invalid-feedback">Please enter a valid email address</div>
                        </div>
                    </div>

                    <div class="askroro-form-group">
                        <label class="askroro-form-label">Password</label>
                        <div class="askroro-input-icon-wrapper">
                            <i class="bi bi-lock askroro-input-icon"></i>
                            <input type="password" name="password" class="askroro-form-control" placeholder="Enter your password" required>
                            <button type="button" class="askroro-btn-password-toggle" onclick="togglePassword(this)">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="invalid-feedback">Password must be at least 6 characters</div>
                        </div>
                        <div class="askroro-forgot-password">
                            <a href="{{ route('password.request') }}" class="askroro-link">Forgot password?</a>
                        </div>
                    </div>

                    <button type="submit" class="askroro-btn-primary" id="loginSubmitBtn">
                        <span class="btn-text">Sign In</span>
                        <span class="btn-loading" style="display: none;">
                            <i class="bi bi-arrow-repeat spin"></i> Signing In...
                        </span>
                    </button>
                </form>
                
                <div class="askroro-text-center" style="margin-top:20px;">
                    <a href="#" class="askroro-link-back" onclick="backToSignUpOptions()">← Back to options</a>
                </div>
                <div class="askroro-text-center">
                    <span class="askroro-text-muted">Don't have an account? </span>
                    <a href="#" class="askroro-link" onclick="openSignUpModal()">Sign up.</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showLoginAlert(type, message) {
    const alertContainer = document.getElementById('loginAlertContainer');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    
    alertContainer.innerHTML = `
        <div class="alert ${alertClass}">
            ${message}
        </div>
    `;
    
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 5000);
}

function togglePassword(button) {
    const input = button.parentElement.querySelector('input');
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}



@if($errors->has('email') || $errors->has('password'))
openLoginModal()
@endif

// If there are server-side errors, display them when modal opens
function displayServerErrors() {
    @if($errors->has('email') || $errors->has('password'))
        showLoginAlert('error', 'Invalid credentials. Please try again.');
        
        @if($errors->has('email'))
            const emailInput = document.querySelector('input[name="email"]');
            emailInput.classList.add('error');
            emailInput.nextElementSibling.style.display = 'block';
        @endif
        
        @if($errors->has('password'))
            const passwordInput = document.querySelector('input[name="password"]');
            passwordInput.classList.add('error');
            passwordInput.nextElementSibling.style.display = 'block';
        @endif
    @endif
}

// Call this when opening the modal
function openLoginModal() {
    document.getElementById('loginModal').style.display = 'flex';
    displayServerErrors();
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    // Reset form when closing
    const form = document.getElementById('loginForm');
    form.reset();
    
    // Clear errors
    const errorMessages = form.querySelectorAll('.invalid-feedback');
    errorMessages.forEach(error => error.style.display = 'none');
    
    const inputs = form.querySelectorAll('.askroro-form-control');
    inputs.forEach(input => input.classList.remove('error'));
    
    document.getElementById('loginAlertContainer').innerHTML = '';
}
</script>

<style>
.alert {
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background-color: rgba(var(--primary-rgb), 0.1);
    color: var(--primary);
    border: 1px solid rgba(var(--primary-rgb), 0.3);
}

.alert-error {
    background-color: #ffebee;
    color: #c62828;
    border: 1px solid #ffcdd2;
}

.askroro-form-control.error {
    border-color: #f44336;
}

.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>