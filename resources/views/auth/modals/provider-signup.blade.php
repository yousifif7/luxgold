<div class="serviceflow-modal-overlay" id="providerSignUpModal" style="display: none;">
    <div class="serviceflow-modal-dialog">
        <div class="serviceflow-modal-content">
            <button class="serviceflow-btn-close" onclick="closeModal('providerSignUpModal')">&times;</button>
            <div class="serviceflow-modal-header">
                <div class="serviceflow-avatar-box">
                        <div class="serviceflow-avatar">
                        <img src="{{ asset('assets/images/updated-logo.jpeg') }}" alt="luxGold Logo">
                    </div>
                </div>
                <h2 class="serviceflow-modal-title">Join as Cleaner</h2>
                <p class="serviceflow-modal-subtitle">Connect with customers and grow your cleaning business</p>
                <p class="serviceflow-modal-subnote" style="font-size:13px; color:#6b7280; margin-top:6px;">We currently operate in Ireland — please provide an Irish address. Serving Dublin, Cork, Galway, Limerick, and surrounding areas.</p>
            </div>
            <div class="serviceflow-modal-body">
                <!-- Step Indicator -->
                <div class="serviceflow-step-indicator">
                    <div class="serviceflow-step active" id="step0Indicator">
                        <i class="bi bi-1-circle"></i>
                        Eircode
                    </div>
                    <div class="serviceflow-step" id="step1Indicator">
                        <i class="bi bi-2-circle"></i>
                        Category
                    </div>
                    <div class="serviceflow-step" id="step2Indicator">
                        <i class="bi bi-3-circle"></i>
                        Pricing
                    </div>
                    <div class="serviceflow-step" id="step3Indicator">
                        <i class="bi bi-4-circle"></i>
                        Details
                    </div>
                </div>
                
                <!-- Step 0: Eircode check -->
                <div class="serviceflow-step-content active" id="step0">
                    <h3 style="text-align: center; margin-bottom: 24px; color: #1e293b; font-size: 20px;">Enter your Eircode</h3>
                    <p style="text-align:center; color:#6b7280; margin-bottom:16px;">Please enter your Eircode to confirm you operate in Ireland.</p>
                    <div style="max-width:420px; margin:0 auto;">
                        <div class="serviceflow-form-group">
                            <label class="serviceflow-form-label">Eircode</label>
                            <input type="text" id="eircodeInput" class="serviceflow-form-control" placeholder="Eircode (e.g. D02 X285)" required>
                            <div id="eircodeFeedback" class="invalid-feedback" style="display:none; margin-top:6px;"></div>
                        </div>
                        <div style="text-align:center; margin-top:12px;">
                            <button type="button" class="serviceflow-btn-next" id="checkEircodeBtn">Check Eircode →</button>
                        </div>
                    </div>
                    <div class="serviceflow-btn-navigation" style="margin-top:20px; text-align:center;">
                        <button type="button" class="serviceflow-btn-back" onclick="closeModal('providerSignUpModal'),backToSignUpOptions()">
                            ← Back to options
                        </button>
                    </div>
                </div>

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
                
                <!-- Step 2: Pricing Selection -->
                <div class="serviceflow-step-content" id="step2">
                    <h3 style="text-align: center; margin-bottom: 32px; color: #1e293b; font-size: 24px;" id="pricingTitle">Choose Your Plan</h3>
                    
                    <!-- Billing Toggle -->
                    <div class="serviceflow-billing-toggle" style="text-align: center; margin-bottom: 24px;">
                        <div class="serviceflow-toggle-group" style="display: inline-flex; background: #f8fafc; padding: 4px; border-radius: 8px;">
                            <button type="button" class="serviceflow-toggle-option active" data-billing="monthly">
                                Monthly Billing
                            </button>
                            <button type="button" class="serviceflow-toggle-option" data-billing="yearly">
                                Yearly Billing (Save 20%)
                            </button>
                        </div>
                    </div>
                    
                    <div class="serviceflow-pricing-grid" id="pricingGrid">
                        @foreach(\App\Models\Plan::get() as $plan)
                        <div class="serviceflow-pricing-card" data-plan="{{ strtolower($plan->id) }}">
                            
                            <div class="serviceflow-plan-header">
                                <h4 class="serviceflow-plan-name">{{ $plan->name }}</h4>
                                @if($plan->description)
                                    <p class="serviceflow-plan-tagline">{{ $plan->description }}</p>
                                @endif
                            </div>

                            <div class="serviceflow-plan-price">
                                @if($plan->monthly_fee == 0)
                                    <div class="serviceflow-price-amount">Free</div>
                                @else
                                    <!-- Monthly Price -->
                                    <div class="serviceflow-price-option active" data-billing="monthly">
                                        <div class="serviceflow-price-amount">€{{ $plan->monthly_fee }}</div>
                                        <div class="serviceflow-price-period">/month</div>
                                    </div>
                                    <!-- Yearly Price -->
                                    <div class="serviceflow-price-option" data-billing="yearly" style="display: none;">
                                        <div class="serviceflow-price-amount">€{{ $plan->annual_fee }}</div>
                                        <div class="serviceflow-price-period">/year</div>
                                        <div class="serviceflow-price-savings">Save €{{ $plan->monthly_fee * 12- (float)$plan->annual_fee  }}</div>
                                    </div>
                                @endif
                            </div>

                            <div class="serviceflow-plan-features">
                                @foreach($plan->features as $feature => $enabled)
                                    @if($enabled)
                                        <div class="serviceflow-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>{{ $feature }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <button class="serviceflow-btn-plan" type="button" data-plan="{{ strtolower($plan->id) }}">
                                @if($plan->monthly_fee == 0)
                                    Start Free
                                @elseif(strtolower($plan->type) == 'featured')
                                    Go Featured
                                @else
                                    Get {{ $plan->name }}
                                @endif
                            </button>

                        </div>
                        @endforeach
                    </div>

                    <div class="serviceflow-btn-navigation">
                        <button type="button" class="serviceflow-btn-back" onclick="goToStep1()">
                            ← Back to Category
                        </button>
                        <button type="button" class="serviceflow-btn-next" id="pricingNextBtn" disabled onclick="goToStep3()">
                            Continue to Setup →
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Profile Setup -->
                <div class="serviceflow-step-content" id="step3">
                    <h3 style="text-align: center; margin-bottom: 32px; color: #1e293b; font-size: 24px;">Complete Your Profile</h3>
                    <form id="providerCompleteForm">
                        <input type="hidden" name="zip_code" id="zip_code_hidden">
                        @csrf
                        <input type="hidden" name="role" value="cleaner">
                        <input type="hidden" name="category" id="providerCategory">
                        <input type="hidden" name="pricing_plan" id="providerPricingPlan">
                        <input type="hidden" name="billing_period" id="providerBillingPeriod" value="monthly">
                        
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
                            <div class="serviceflow-form-group">
                                <label class="serviceflow-form-label">Business Name</label>
                                <input type="text" name="business_name" class="serviceflow-form-control" placeholder="Your business or service name" required>
                                <div class="invalid-feedback"></div>
                            </div>
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
                            <button type="button" class="serviceflow-btn-back" onclick="goToStep2()">
                                ← Back to Pricing
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
</style>

<script>
let selectedBillingPeriod = 'monthly';

// Simple step navigation handlers scoped to this modal
function showStep(stepId){
    document.querySelectorAll('.serviceflow-step-content').forEach(el=>{
        // hide all step contents
        el.classList.remove('active');
        el.style.display = 'none';
    });

    const target = document.getElementById(stepId);
    if(target){
        target.classList.add('active');
        target.style.display = '';
    }

    // Update indicators
    ['step0Indicator','step1Indicator','step2Indicator','step3Indicator'].forEach(id=>{
        const el = document.getElementById(id);
        if(!el) return;
        el.classList.remove('active');
    });
    const activeIndicator = {
        'step0':'step0Indicator',
        'step1':'step1Indicator',
        'step2':'step2Indicator',
        'step3':'step3Indicator'
    }[stepId];
    if(activeIndicator) document.getElementById(activeIndicator).classList.add('active');

    // Ensure Eircode input/feedback are only visible on step0
    const eirInput = document.getElementById('eircodeInput');
    const eirFeedback = document.getElementById('eircodeFeedback');
    const step0 = document.getElementById('step0');
    if(stepId !== 'step0'){
        if(eirInput) eirInput.style.display = 'none';
        if(eirFeedback) eirFeedback.style.display = 'none';
        if(step0) step0.style.display = 'none';
    } else {
        if(eirInput) eirInput.style.display = '';
        if(step0) step0.style.display = '';
    }
}

function goToStep1(){ showStep('step1'); }
function goToStep2(){ showStep('step2'); }
function goToStep3(){ showStep('step3'); }

// CSRF token for AJAX
const CSRF_TOKEN = '{{ csrf_token() }}';

// Handle Eircode check
document.addEventListener('DOMContentLoaded', function(){
    const btn = document.getElementById('checkEircodeBtn');
    if(btn){
        btn.addEventListener('click', async function(){
            const input = document.getElementById('eircodeInput');
            const feedback = document.getElementById('eircodeFeedback');
            feedback.style.display = 'none';
            const value = input.value.trim();
            if(!value){
                feedback.innerText = 'Please enter your Eircode.';
                feedback.style.display = 'block';
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Checking...';

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
                    const error = await res.json();
                    feedback.innerText = error.message || 'Eircode not recognized.';
                    feedback.style.display = 'block';
                    btn.disabled = false;
                    btn.innerText = 'Check Eircode →';
                    return;
                }

                const data = await res.json();
                // Set normalized eircode into hidden field so registration will submit it
                const hidden = document.getElementById('zip_code_hidden');
                if(hidden) hidden.value = data.eircode;

                // Hide the Eircode input and feedback so they don't appear in other steps
                const step0El = document.getElementById('step0');
                const eirInputEl = document.getElementById('eircodeInput');
                const eirFeedbackEl = document.getElementById('eircodeFeedback');
                if(eirInputEl) eirInputEl.style.display = 'none';
                if(eirFeedbackEl) eirFeedbackEl.style.display = 'none';
                if(step0El) step0El.style.display = 'none';

                // Proceed to category step
                goToStep1();
            }catch(err){
                feedback.innerText = 'Unable to validate Eircode at this time.';
                feedback.style.display = 'block';
            }finally{
                btn.disabled = false;
                btn.innerText = 'Check Eircode →';
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
                // When modal opens, show step0 so Eircode input is visible first
                showStep('step0');
                const eirInput = document.getElementById('eircodeInput');
                const eirFeedback = document.getElementById('eircodeFeedback');
                const hidden = document.getElementById('zip_code_hidden');
                if(eirInput) { eirInput.style.display = ''; eirInput.value = ''; }
                if(eirFeedback) { eirFeedback.style.display = 'none'; eirFeedback.innerText = ''; }
                if(hidden) hidden.value = '';
                // Ensure pricing/category next buttons initially disabled
                const pricingNextBtn = document.getElementById('pricingNextBtn');
                if(pricingNextBtn) pricingNextBtn.disabled = true;
                const categoryNextBtn = document.getElementById('categoryNextBtn');
                if(categoryNextBtn) categoryNextBtn.disabled = true;
            }
            prevVisible = visible;
        }catch(e){ /* ignore */ }
    });

    observer.observe(providerModalOverlay, { attributes: true, attributeFilter: ['style', 'class'] });
}

// Billing period toggle
document.querySelectorAll('.serviceflow-toggle-option').forEach(option => {
    option.addEventListener('click', function() {
        const billingPeriod = this.dataset.billing;
        
        // Update toggle buttons
        document.querySelectorAll('.serviceflow-toggle-option').forEach(btn => {
            btn.classList.remove('active');
        });
        this.classList.add('active');
        console.log(billingPeriod)
        // Update price displays
        document.querySelectorAll('.serviceflow-price-option').forEach(priceOption => {
            priceOption.classList.remove('active');
        });
        document.querySelectorAll(`.serviceflow-price-option[data-billing="${billingPeriod}"]`).forEach(priceOption => {
            priceOption.classList.add('active');
        });
        
        selectedBillingPeriod = billingPeriod;
        document.getElementById('providerBillingPeriod').value = billingPeriod;
    });
});

// Plan selection
document.querySelectorAll('.serviceflow-btn-plan').forEach(button => {
    button.addEventListener('click', function() {
        const planType = this.dataset.plan;
        
        // Remove selected class from all cards and buttons
        document.querySelectorAll('.serviceflow-pricing-card').forEach(card => {
            card.classList.remove('selected');
        });
        document.querySelectorAll('.serviceflow-btn-plan').forEach(btn => {
            btn.classList.remove('selected');
        });
        
        // Add selected class to current card and button
        this.closest('.serviceflow-pricing-card').classList.add('selected');
        this.classList.add('selected');
        
        selectedPlan = planType;
        document.getElementById('providerPricingPlan').value = planType;
        
        // Enable the next button
        document.getElementById('pricingNextBtn').disabled = false;
    });
});

// Update the goToStep3 function to include billing period

</script>