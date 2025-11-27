<div class="askroro-modal-overlay" id="signUpModal" style="display: none;">
    <div class="askroro-modal-dialog">
        <div class="askroro-modal-content">
            <button class="askroro-btn-close" onclick="closeModal('signUpModal')">&times;</button>
            <div class="askroro-modal-header">
                <div class="askroro-avatar-box">
                    <div class="askroro-avatar"><img src="{{ asset('assets/images/logo.png') }}" alt="logo-image"></div>
                </div>
                <h2 class="askroro-modal-title">Sign Up</h2>
                <p class="askroro-modal-subtitle">Create your free account to get started with luxGold — find or offer professional cleaning services.</p>
            </div>
            <div class="askroro-modal-body">
                <button class="askroro-btn-option" onclick="openParentSignUpModal()">
                    <i class="bi bi-person"></i> I am a Customer
                </button>
                <button class="askroro-btn-option signup-as-cleaner" onclick="startProviderSignupFlow()">
                    <i class="bi bi-briefcase"></i> I am a Cleaner
                </button>
                <div class="askroro-text-center">
                    <span class="askroro-text-muted">Already have an account? </span>
                    <a href="#" class="askroro-link" onclick="openLoginModal()">Log in.</a>
                </div>
            </div>
        </div>
    </div>
</div>