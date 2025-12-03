<!-- Eircode dialog: opens first when user clicks 'Sign up as Cleaner' -->
<div class="serviceflow-modal-overlay" id="providerEircodeModal" style="display: none;">
    <div class="serviceflow-modal-dialog">
        <div class="serviceflow-modal-content">
            <button class="serviceflow-btn-close" onclick="closeEircodeDialog()">&times;</button>
            <div class="serviceflow-modal-header">
                <div class="serviceflow-avatar-box">
                    <div class="serviceflow-avatar">
                        <img src="{{ asset('assets/images/luxgold-trans.png') }}" alt="luxGold Logo">
                    </div>
                </div>
                <h2 class="serviceflow-modal-title">Enter your Eircode</h2>
                <p class="serviceflow-modal-subtitle">Please enter your Eircode to confirm you operate in Ireland.</p>
            </div>
            <div class="serviceflow-modal-body">
                <div style="max-width:420px; margin:0 auto; text-align:center;">
                    <div class="serviceflow-form-group">
                        <label class="serviceflow-form-label">Eircode</label>
                        <input type="text" id="eircodeInputStandalone" class="serviceflow-form-control" placeholder="Eircode (e.g. D02 X285)">
                        <div id="eircodeFeedbackStandalone" class="invalid-feedback" style="display:none; margin-top:6px;"></div>
                    </div>
                    <div style="margin-top:12px;">
                        <button type="button" class="serviceflow-btn-next" id="checkEircodeStandaloneBtn">Check Eircode →</button>
                    </div>
                    <div style="margin-top:18px;">
                        <button type="button" class="serviceflow-btn-back" onclick="closeEircodeDialog()">← Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="serviceflow-modal-overlay" id="providerSignUpModal" style="display: none;">
    <div class="serviceflow-modal-dialog">
        <div class="serviceflow-modal-content">
            <button class="serviceflow-btn-close" onclick="closeModal('providerSignUpModal')">&times;</button>
            <div class="serviceflow-modal-header">
                <div class="serviceflow-avatar-box">
                        <div class="serviceflow-avatar">
                        <img src="{{ asset('assets/images/luxgold-trans.png') }}" alt="luxGold Logo">
                    </div>
                </div>
                <h2 class="serviceflow-modal-title">Join as Cleaner</h2>
                <p class="serviceflow-modal-subtitle">Connect with customers and grow your cleaning business</p>
                <p class="serviceflow-modal-subnote" style="font-size:13px; color:#6b7280; margin-top:6px;">We currently operate in Ireland — please provide an Irish address. Serving Dublin, Cork, Galway, Limerick, and surrounding areas.</p>
            </div>
            <div class="serviceflow-modal-body">
                <!-- Step Indicator -->
                <div class="serviceflow-step-indicator">
                    <div class="serviceflow-step active" id="step1Indicator">
                        <i class="bi bi-1-circle"></i>
                        Category
                    </div>
                    <div class="serviceflow-step" id="step2Indicator">
                        <i class="bi bi-2-circle"></i>
                        Details
                    </div>
                </div>
                
                <!-- NOTE: Eircode step removed. Eircode will be collected in a separate dialog before opening this signup modal. -->

                <!-- Step 1: Category Selection -->
                <div class="serviceflow-step-content" id="step1">
                    <h3 style="text-align: center; margin-bottom: 32px; color: #1e293b; font-size: 24px;">Choose Your Category</h3>
                    <div class="serviceflow-category-grid">
                        @foreach(\App\Models\Category::whereNull('customer_id')->get() as $category => $data)
                        <div class="serviceflow-category-card" data-category="{{ $data->id }}">
                            <div class="serviceflow-category-icon">
                                <i class="fa {{ $data->icon }}"></i>
                            </div>
                            <h4 class="serviceflow-category-title">{{ $data->name }}</h4>
                            <p class="serviceflow-category-desc">{{ $data->description }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="serviceflow-btn-navigation">
                        <button type="button" class="serviceflow-btn-back" onclick="closeModal('providerSignUpModal'),backToSignUpOptions()">
                            ← Back to options
                        </button>
                        <button type="button" class="serviceflow-btn-next" id="categoryNextBtn" disabled onclick="goToStep2()">
                            Continue to Pricing →
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Profile Setup will be shown next -->
                
                <!-- Profile Setup -->
                <div class="serviceflow-step-content" id="step2">
                    <h3 style="text-align: center; margin-bottom: 32px; color: #1e293b; font-size: 24px;">Complete Your Profile</h3>
                    <form id="providerCompleteForm">
                        <input type="hidden" name="zip_code" id="zip_code_hidden">
                        @csrf
                        <input type="hidden" name="role" value="cleaner">
                        <input type="hidden" name="category" id="providerCategory">
                        
                        <div class="serviceflow-form-section">
                            <h4 class="serviceflow-form-section-title">Basic Information</h4>
                            <div class="serviceflow-form-row">
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">First Name</label>
                                    <input type="text" name="first_name" class="serviceflow-form-control" placeholder="First name" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">Last Name</label>
                                    <input type="text" name="last_name" class="serviceflow-form-control" placeholder="Last name" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="serviceflow-form-group">
                                <label class="serviceflow-form-label">Email Address</label>
                                <div class="serviceflow-input-icon-wrapper">
                                    <i class="bi bi-envelope serviceflow-input-icon"></i>
                                    <input type="email" name="email" class="serviceflow-form-control" placeholder="your@email.com" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="serviceflow-form-row">
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">Password</label>
                                    <div class="serviceflow-input-icon-wrapper">
                                        <i class="bi bi-lock serviceflow-input-icon"></i>
                                        <input type="password" name="password" class="serviceflow-form-control" placeholder="Create a password" required minlength="8">
                                        <button type="button" class="serviceflow-btn-password-toggle" onclick="togglePassword(this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">Confirm Password</label>
                                    <div class="serviceflow-input-icon-wrapper">
                                        <i class="bi bi-lock serviceflow-input-icon"></i>
                                        <input type="password" name="password_confirmation" class="serviceflow-form-control" placeholder="Confirm your password" required>
                                        <button type="button" class="serviceflow-btn-password-toggle" onclick="togglePassword(this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="serviceflow-form-section">
                            <h4 class="serviceflow-form-section-title">Business Information</h4>
                            <div class="serviceflow-form-row">
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">Phone Number</label>
                                    <div class="serviceflow-input-icon-wrapper">
                                        <i class="bi bi-telephone serviceflow-input-icon"></i>
                                        <input type="tel" name="phone" class="serviceflow-form-control" placeholder="e.g. +353851234567" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">Years of Experience</label>
                                    <select name="years_experience" class="serviceflow-form-control" required>
                                        <option value="">Select experience</option>
                                        <option value="0-2">0-2 years</option>
                                        <option value="3-5">3-5 years</option>
                                        <option value="6-10">6-10 years</option>
                                        <option value="10+">10+ years</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="serviceflow-form-group">
                                <label class="serviceflow-form-label">Business Address</label>
                                <input type="text" name="address" class="serviceflow-form-control" placeholder="Street address" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="serviceflow-form-row">
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">City</label>
                                    <select class="serviceflow-form-control" name="city">
                                        @foreach(App\Models\City::active()->ordered()->get() as $city)

                                        <option value="{{ $city->id }}">{{ $city->name }}</option>

                                        @endforeach
                                        
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="serviceflow-form-group">
                                    <label class="serviceflow-form-label">County</label>
                                    <input type="text" name="state" class="serviceflow-form-control" placeholder="County (e.g. Dublin)" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <!-- Eircode is collected in the initial step and stored in a hidden field -->
                            </div>
                            <div class="serviceflow-form-group">
                                <label class="serviceflow-form-label">Service Description</label>
                                <textarea name="service_description" class="serviceflow-form-control" rows="4" placeholder="Describe your services, specialties, and what makes you unique..." required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="serviceflow-btn-navigation">
                                <button type="button" class="serviceflow-btn-back" onclick="goToStep1()">
                                    ← Back to Category
                                </button>
                                <button type="submit" class="serviceflow-btn-next" id="providerSubmitBtn">
                                <span class="btn-text">Create Provider Account →</span>
                                <span class="btn-loading" style="display: none;">
                                    <i class="bi bi-arrow-repeat spin"></i> Creating Account...
                                </span>
                            </button>
                        </div>
                    </form>
                    
                    <div class="serviceflow-text-center" style="margin-top: 24px;">
                        <span class="serviceflow-text-muted">Already have an account? </span>
                        <a href="#" class="serviceflow-link" onclick="openLoginModal(); closeModal('providerSignUpModal')">Log in.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.serviceflow-billing-toggle .serviceflow-toggle-option {
    padding: 8px 16px;
    border: none;
    background: transparent;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.serviceflow-billing-toggle .serviceflow-toggle-option.active {
    background: #3b82f6;
    color: white;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

.serviceflow-price-option {
    display: none;
}
.serviceflow-step-content {
    display: none;
}
.serviceflow-step-content.active {
    display: block !important;
}

.serviceflow-price-option.active {
    display: block;
}

.serviceflow-price-savings {
    font-size: 12px;
    color: #10b981;
    font-weight: 600;
    margin-top: 4px;
}

.serviceflow-pricing-card.selected {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.serviceflow-btn-plan.selected {
    background: #3b82f6;
    color: white;
}

/* Center these modals and make dialog scrollable when tall */
#providerEircodeModal,
#providerSignUpModal {
    position: fixed;
    inset: 0;
    display: none; /* toggled by JS */
    background: rgba(17,24,39,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 24px;
}

#providerEircodeModal .serviceflow-modal-dialog,
#providerSignUpModal .serviceflow-modal-dialog {
    max-height: calc(100vh - 64px);
    overflow: auto;
}

/* Ensure other modal dialog variants also center */
.serviceflow-modal-overlay {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Also center the askroro modal overlay (used on main signup dialog) */
.askroro-modal-overlay {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: rgba(17,24,39,0.6);
    z-index: 9998;
}
</style>

<script>
let selectedBillingPeriod = 'monthly';

// Simple step navigation handlers scoped to this modal
function showStep(stepId){
    // Remove active from all steps and add to the target only
    // Remove active class and explicitly hide all step content containers.
    document.querySelectorAll('.serviceflow-step-content').forEach(el=>{
        el.classList.remove('active');
        try{ el.style.display = 'none'; }catch(e){}
    });
    const target = document.getElementById(stepId);
    if(target){
        // Ensure the target is visible and marked active. Inline style wins over any conflicting CSS rules.
        try{ target.style.display = 'block'; }catch(e){}
        target.classList.add('active');
    }

    // Update indicators
    // Clear active class from any step indicator and set the new one
    document.querySelectorAll('.serviceflow-step').forEach(ind => ind.classList.remove('active'));
    const activeIndicator = document.getElementById(stepId + 'Indicator');
    if(activeIndicator) activeIndicator.classList.add('active');

    // No need to toggle inline visibility — CSS rules handle showing the active step.
}

// Generic step navigation: call with the step index (0..3)
function goToStep(index){
    showStep('step' + index);
}

function goToStep0(){ goToStep(0); }
function goToStep1(){ goToStep(1); }
function goToStep2(){ goToStep(2); }
function goToStep3(){ goToStep(3); }

// CSRF token for AJAX
const CSRF_TOKEN = '{{ csrf_token() }}';

// Eircode is handled in a separate dialog before opening this modal.
// The standalone dialog code below opens first, validates the Eircode via AJAX,
// and on success populates `#zip_code_hidden` then opens the signup modal.

// Open / close helpers for the Eircode dialog
function openEircodeDialog(){
    const dlg = document.getElementById('providerEircodeModal');
    if(!dlg) return;
    dlg.style.display = 'flex';
    const input = document.getElementById('eircodeInputStandalone');
    if(input){ input.value = ''; input.focus(); }
    const fb = document.getElementById('eircodeFeedbackStandalone'); if(fb) fb.style.display='none';
}
function closeEircodeDialog(){
    const dlg = document.getElementById('providerEircodeModal');
    if(!dlg) return;
    dlg.style.display = 'none';
}

// Start the provider signup flow (can be called from any button click)
function startProviderSignupFlow(){
    openEircodeDialog();
}

// Attach click listeners to any elements that want to trigger this flow
document.addEventListener('DOMContentLoaded', function(){
    // Buttons/links with class `signup-as-cleaner` will open the Eircode dialog
    document.querySelectorAll('.signup-as-cleaner').forEach(el => {
        el.addEventListener('click', function(e){ e.preventDefault(); startProviderSignupFlow(); });
    });

    // Handle the Eircode check from the standalone dialog
    const checkBtn = document.getElementById('checkEircodeStandaloneBtn');
    if(checkBtn){
        checkBtn.addEventListener('click', async function(){
            const input = document.getElementById('eircodeInputStandalone');
            const feedback = document.getElementById('eircodeFeedbackStandalone');
            if(feedback) feedback.style.display = 'none';
            const value = input ? input.value.trim() : '';
            if(!value){
                if(feedback){ feedback.innerText = 'Please enter your Eircode.'; feedback.style.display='block'; }
                return;
            }

            checkBtn.disabled = true; checkBtn.innerText = 'Checking...';
            try{
                const res = await fetch('{{ route('check.eircode') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ eircode: value })
                });

                if(!res.ok){
                    let message = 'Eircode not recognized.';
                    try{ const err = await res.json(); if(err && err.message) message = err.message; }catch(e){}
                    if(feedback){ feedback.innerText = message; feedback.style.display='block'; }
                    checkBtn.disabled = false; checkBtn.innerText = 'Check Eircode →';
                    showAlert('error', 'Eircode Check Failed', message);
                    return;
                }

                const data = await res.json();
                // Populate the hidden zip code for the signup form
                const hidden = document.getElementById('zip_code_hidden');
                if(hidden) hidden.value = data.eircode;

                // Close the eircode dialog and open the signup modal
                closeEircodeDialog();
                const signupModal = document.getElementById('providerSignUpModal');
                if(signupModal) signupModal.style.display = 'flex';
                // Ensure signup modal shows the Category step
                try{ showStep('step1'); }catch(e){}
                showAlert('success', 'Eircode validated', 'Proceeding to signup');
            }catch(err){
                const msg = 'Unable to validate Eircode at this time.';
                if(feedback){ feedback.innerText = msg; feedback.style.display='block'; }
                showAlert('error', 'Eircode Error', msg);
            }finally{
                checkBtn.disabled = false; checkBtn.innerText = 'Check Eircode →';
            }
        });
    }
});

// Observe the modal overlay so we can reset/show step0 only when the modal actually opens
const providerModalOverlay = document.getElementById('providerSignUpModal');
if(providerModalOverlay){
    let prevVisible = window.getComputedStyle(providerModalOverlay).display !== 'none';
    const observer = new MutationObserver(() => {
        try{
            const visible = window.getComputedStyle(providerModalOverlay).display !== 'none';
            // Only act when visibility changes from hidden -> visible
            if(visible && !prevVisible){
                    // When modal opens, show the first step (Category)
                        showStep('step1');
                    // Ensure category next button initially disabled
                    const categoryNextBtn = document.getElementById('categoryNextBtn');
                    if(categoryNextBtn) categoryNextBtn.disabled = true;
            }
            prevVisible = visible;
        }catch(e){ /* ignore */ }
    });

    observer.observe(providerModalOverlay, { attributes: true, attributeFilter: ['style', 'class'] });
}

    // Category selection: allow clicking a card to choose a category and enable the next button
    document.querySelectorAll('.serviceflow-category-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.serviceflow-category-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            const catId = this.dataset.category;
            const hidden = document.getElementById('providerCategory');
            if(hidden) hidden.value = catId;
            const categoryNextBtn = document.getElementById('categoryNextBtn');
            if(categoryNextBtn) categoryNextBtn.disabled = false;
        });
    });

// Update the goToStep3 function to include billing period

</script>