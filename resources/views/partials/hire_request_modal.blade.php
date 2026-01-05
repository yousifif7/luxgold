<!-- Generic Hire Request Modal (used on home page) -->
<style>
/* Hire Request Modal Styling */
.hire-modal .modal-content {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.hire-modal .modal-header {
    background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
    color: white;
    padding: 2rem;
    border: none;
    position: relative;
    overflow: hidden;
}

.hire-modal .modal-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.hire-modal .modal-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    color: white;
}

.hire-modal .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
    transition: all 0.3s ease;
}

.hire-modal .btn-close:hover {
    opacity: 1;
    transform: rotate(90deg);
}

/* Step Indicators */
.hire-step-indicators {
    display: flex;
    justify-content: center;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.hr-step-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: 2px solid #dee2e6;
    background: white;
    border-radius: 50px;
    font-weight: 600;
    color: #6c757d;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.hr-step-indicator .step-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 700;
    transition: all 0.3s ease;
}

.hr-step-indicator.active {
    border-color: #D4AF37;
    background: linear-gradient(135deg, #FFF9E6 0%, #FFF5D6 100%);
    color: #B8860B;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212,175,55,0.2);
}

.hr-step-indicator.active .step-number {
    background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
    color: white;
}

/* Type Selection Cards */
.hr-type-option {
    padding: 1.5rem;
    border: 2px solid #dee2e6;
    border-radius: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    height: 100%;
}

.hr-type-option:hover {
    border-color: #D4AF37;
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(212,175,55,0.15);
}

.hr-type-option.border-primary {
    border-color: #D4AF37 !important;
    background: linear-gradient(135deg, #FFF9E6 0%, #FFF5D6 100%);
    box-shadow: 0 8px 20px rgba(212,175,55,0.25);
}

.hr-type-option i {
    font-size: 2.5rem;
    color: #D4AF37;
    margin-bottom: 1rem;
    display: block;
}

.hr-type-option h6 {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.hr-type-option p {
    color: #6c757d;
    font-size: 0.875rem;
    margin: 0;
}

/* Form Controls */
.hire-modal .form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.hire-modal .form-control,
.hire-modal .form-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.hire-modal .form-control:focus,
.hire-modal .form-select:focus {
    border-color: #D4AF37;
    box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.15);
    outline: none;
}

.hire-modal textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* Service List Items */
#hr_servicesList .border {
    border: 2px solid #e9ecef !important;
    border-radius: 10px;
    transition: all 0.3s ease;
    background: white;
}

#hr_servicesList .border:hover {
    border-color: #D4AF37 !important;
    box-shadow: 0 4px 12px rgba(212,175,55,0.1);
}

#hr_servicesList .fw-bold {
    color: #2c3e50;
    font-size: 1rem;
}

#hr_servicesList .text-muted {
    color: #6c757d;
}

#hr_servicesList .form-check-input {
    width: 1.5rem;
    height: 1.5rem;
    border: 2px solid #dee2e6;
    cursor: pointer;
}

#hr_servicesList .form-check-input:checked {
    background-color: #D4AF37;
    border-color: #D4AF37;
}

/* Order Summary */
#hr_orderSummary {
    background: linear-gradient(135deg, #FFF9E6 0%, #FFF5D6 100%);
    border: 2px solid #D4AF37 !important;
    border-radius: 15px;
}

#hr_orderSummary .fw-bold {
    color: #B8860B;
    font-size: 1.125rem;
}

/* Modal Footer */
.hire-modal .modal-footer {
    padding: 1.5rem 2rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.hire-modal .btn {
    padding: 0.75rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.hire-modal .btn-secondary {
    background: #6c757d;
    color: white;
}

.hire-modal .btn-secondary:hover {
    background: #5a6268;
    transform: translateX(-5px);
}

.hire-modal .btn-outline-secondary {
    border: 2px solid #D4AF37;
    color: #B8860B;
    background: white;
}

.hire-modal .btn-outline-secondary:hover {
    background: #D4AF37;
    color: white;
    transform: translateX(5px);
}

.hire-modal .btn-primary {
    background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(212,175,55,0.3);
}

.hire-modal .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212,175,55,0.4);
}

.hire-modal .btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Section Headers */
.hire-modal h6 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #D4AF37;
    display: inline-block;
}

/* Modal Body */
.hire-modal .modal-body {
    padding: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hire-step-indicators {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .hr-step-indicator {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .hr-step-indicator .step-text {
        display: none;
    }
    
    .hire-modal .modal-title {
        font-size: 1.5rem;
    }
    
    .hire-modal .modal-body {
        padding: 1.5rem;
    }
}
</style>

<div class="modal fade hire-modal" id="hireRequestModal" tabindex="-1" aria-labelledby="hireRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hireRequestModalLabel">
                    <i class="ti ti-sparkles me-2"></i>Request a Cleaner
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Step Indicators -->
            <div class="hire-step-indicators">
                <button type="button" class="hr-step-indicator" data-step="0">
                    <span class="step-number">1</span>
                    <span class="step-text">Choose Type</span>
                </button>
                <button type="button" class="hr-step-indicator active" data-step="1">
                    <span class="step-number">2</span>
                    <span class="step-text">Services & Schedule</span>
                </button>
                <button type="button" class="hr-step-indicator" data-step="2">
                    <span class="step-number">3</span>
                    <span class="step-text">Checkout</span>
                </button>
            </div>
            <form id="hireRequestForm">
                @csrf
                <input type="hidden" name="cleaner_id" id="hr_cleaner_id" value="">
                <input type="hidden" name="zip_code" id="hr_zip_code" value="">
                <input type="hidden" name="selected_items" id="hr_selected_items" value="">
                <input type="hidden" name="frequency" id="hr_frequency_hidden" value="one_time">
                <input type="hidden" name="scheduled_at" id="hr_scheduled_at_hidden" value="">

                <div class="modal-body">
                    <div class="inquiry-steps">
                        <!-- Step 0 -->
                        <div class="hr-step" id="hr-step-0">
                            <h5 class="mb-3">Choose Cleaning Type</h5>
                            <div class="row g-3">
                                @php
                                    $hrCategories = \App\Models\Category::where('status', true)->orderBy('sort_order')->get();
                                @endphp

                                @forelse($hrCategories as $cat)
                                    <div class="col-md-6">
                                        <div class="card p-3 hr-type-option" data-type="{{ $cat->slug }}" style="cursor:pointer;">
                                            <h6>{{ $cat->name }}</h6>
                                            <p class="mb-0 text-muted">{{ $cat->subtitle ?? '' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted">No categories available.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Step 1 -->
                        <div class="hr-step" id="hr-step-1" style="display:none;">
                            <h5 class="mb-3">Select Items To Clean & Schedule</h5>
                            <div id="hr_servicesList" class="mb-3"></div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Frequency</label>
                                    <select id="hr_frequency" class="form-select">
                                        <option value="one_time">One time</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="biweekly">Every 2 weeks</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Preferred Date</label>
                                    <input type="date" id="hr_preferred_date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Preferred Time</label>
                                    <input type="time" id="hr_preferred_time" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notes (optional)</label>
                                    <textarea id="hr_serviceNotes" class="form-control" rows="3" placeholder="Any useful notes for the cleaner (access, pets, parking)..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="hr-step" id="hr-step-2" style="display:none;">
                            <h5 class="mb-3">Contact & Checkout</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Your Name *</label>
                                    <input type="text" id="hr_checkout_name" class="form-control" value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" id="hr_checkout_email" class="form-control" value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone *</label>
                                    <input type="tel" id="hr_checkout_phone" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">City *</label>
                                    @php $hrCities = \App\Models\City::orderBy('name')->get(); @endphp
                                    <select id="hr_city" name="city" class="form-select" required>
                                        <option value="">Choose city</option>
                                        @foreach($hrCities as $c)
                                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <h6>Order Summary</h6>
                                    <div id="hr_orderSummary" class="p-3 border rounded mb-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="w-100 d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-secondary" id="hr_btnBack" style="display:none;">← Back</button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-secondary" id="hr_btnNext">Continue →</button>
                            <button type="button" class="btn btn-primary" id="hr_btnSubmit" style="display:none;"><i class="ti ti-send me-1"></i> Book & Send</button>
                        </div>
                    </div>
                </div>
            </form>

            <script>
            (function(){
                const modal = document.getElementById('hireRequestModal');
                if(!modal) return;

                const steps = ['hr-step-0','hr-step-1','hr-step-2'];
                let current = 0;

                const servicesMap = {
                    'home-cleaning':[ {key:'kitchen',label:'Kitchen',duration:30,price:30}, {key:'bathroom',label:'Bathroom',duration:25,price:25}, {key:'living',label:'Living Room',duration:25,price:25} ],
                    'deep-cleaning':[ {key:'kitchen',label:'Kitchen Deep Clean',duration:90,price:80}, {key:'bathroom',label:'Bathroom Deep Clean',duration:60,price:60}, {key:'whole_home',label:'Whole Home Deep',duration:240,price:220} ],
                    'move-cleaning':[ {key:'full_property',label:'Full Property Clean',duration:180,price:150}, {key:'oven',label:'Oven Clean',duration:45,price:40} ],
                    'carpet-upholstery':[ {key:'sofa',label:'Sofa',duration:60,price:50}, {key:'carpet_small',label:'Small Carpet',duration:30,price:35}, {key:'carpet_large',label:'Large Carpet',duration:60,price:60} ],
                    'window-cleaning':[ {key:'interior',label:'Interior Windows',duration:45,price:40}, {key:'exterior',label:'Exterior Windows',duration:60,price:55} ],
                    'commercial-cleaning':[ {key:'office_space',label:'Office Space',duration:120,price:120}, {key:'retail',label:'Retail Space',duration:180,price:180} ]
                };

                const btnNext = document.getElementById('hr_btnNext');
                const btnBack = document.getElementById('hr_btnBack');
                const btnSubmit = document.getElementById('hr_btnSubmit');

                function showStep(index){
                    current = index;
                    steps.forEach((id,i)=>{
                        const el=document.getElementById(id);
                        if(!el) return;
                        el.style.display = i===index ? '' : 'none';
                    });
                    document.querySelectorAll('.hr-step-indicator').forEach(btn=> btn.classList.toggle('active', parseInt(btn.dataset.step)===index));
                    btnBack.style.display = index===0 ? 'none' : '';
                    btnNext.style.display = index===steps.length-1 ? 'none' : '';
                    btnSubmit.style.display = index===steps.length-1 ? '' : 'none';
                }

                // Type selection
                document.querySelectorAll('.hr-type-option').forEach(card=>{
                    card.addEventListener('click', function(){
                        document.querySelectorAll('.hr-type-option').forEach(c=>c.classList.remove('border-primary'));
                        this.classList.add('border-primary');
                        const type = this.dataset.type;
                        document.getElementById('hr_cleaning_type_hidden')?.remove();
                        // set hidden cleaning type by storing on element
                        modal.dataset.selectedType = type;
                        populateServices(type);
                        showStep(1);
                    });
                });

                function populateServices(type){
                    const list = document.getElementById('hr_servicesList');
                    list.innerHTML = '';
                    const items = servicesMap[type] || [];
                    items.forEach(item=>{
                        const id = `hr_service_${item.key}`;
                        const row = document.createElement('div');
                        row.className = 'd-flex align-items-center justify-content-between p-2 border mb-2';
                        row.innerHTML = `
                            <div>
                                <div class="fw-bold">${item.label}</div>
                                <div class="text-muted small">Approx ${item.duration} mins · €${item.price}</div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input hr-service-checkbox" type="checkbox" value='${JSON.stringify(item)}' id="${id}">
                            </div>
                        `;
                        list.appendChild(row);
                    });
                }

                btnNext.addEventListener('click', function(){
                    if(current === 0){ showAlert('warning', 'Please select a cleaning type'); return; }
                    if(current === 1){
                        const checked = Array.from(document.querySelectorAll('.hr-service-checkbox:checked')).map(cb=>JSON.parse(cb.value));
                        if(checked.length === 0){ showAlert('warning', 'Please select at least one item to clean'); return; }
                        document.getElementById('hr_selected_items').value = JSON.stringify(checked);
                        document.getElementById('hr_frequency_hidden').value = document.getElementById('hr_frequency').value;
                        const date = document.getElementById('hr_preferred_date').value;
                        const time = document.getElementById('hr_preferred_time').value;
                        if(!date){ showAlert('warning', 'Please choose preferred date'); return; }
                        document.getElementById('hr_scheduled_at_hidden').value = `${date} ${time || '00:00:00'}`;
                        document.getElementById('hr_serviceNotes').value && console.log('notes:', document.getElementById('hr_serviceNotes').value);
                        buildOrderSummary();
                        showStep(2);
                        return;
                    }
                });

                btnBack.addEventListener('click', function(){ showStep(Math.max(0, current-1)); });

                btnSubmit.addEventListener('click', function(){ submitHireRequest(); });

                modal.addEventListener('show.bs.modal', function(e){
                    // reset
                    document.getElementById('hr_selected_items').value = '';
                    document.getElementById('hr_frequency_hidden').value = '';
                    document.getElementById('hr_scheduled_at_hidden').value = '';
                    document.getElementById('hr_preferred_date').value = '';
                    document.getElementById('hr_preferred_time').value = '';
                    document.getElementById('hr_serviceNotes').value = '';
                    document.getElementById('hr_orderSummary').innerHTML = '';
                    document.querySelectorAll('.hr-type-option').forEach(c=>c.classList.remove('border-primary'));
                    showStep(0);
                });

                function buildOrderSummary(){
                    const items = JSON.parse(document.getElementById('hr_selected_items').value || '[]');
                    const freq = document.getElementById('hr_frequency').value;
                    const scheduled = document.getElementById('hr_scheduled_at_hidden').value;
                    const notes = document.getElementById('hr_serviceNotes').value;
                    let total = 0;
                    const container = document.getElementById('hr_orderSummary');
                    container.innerHTML = '';
                    items.forEach(it=>{ total += parseFloat(it.price || 0); const div=document.createElement('div'); div.className='d-flex justify-content-between'; div.innerHTML = `<div>${it.label} <small class="text-muted">(${it.duration} mins)</small></div><div>€${it.price}</div>`; container.appendChild(div); });
                    const hrEl = document.createElement('hr'); container.appendChild(hrEl);
                    const freqDiv = document.createElement('div'); freqDiv.className='d-flex justify-content-between'; freqDiv.innerHTML = `<div>Frequency</div><div>${freq}</div>`; container.appendChild(freqDiv);
                    const schedDiv = document.createElement('div'); schedDiv.className='d-flex justify-content-between'; schedDiv.innerHTML = `<div>Scheduled</div><div>${scheduled}</div>`; container.appendChild(schedDiv);
                    if(notes){ const notesDiv = document.createElement('div'); notesDiv.className='mt-2 text-muted'; notesDiv.textContent = 'Notes: '+notes; container.appendChild(notesDiv); }
                    const totalDiv = document.createElement('div'); totalDiv.className='d-flex justify-content-between fw-bold mt-3'; totalDiv.innerHTML = `<div>Total</div><div>€${total.toFixed(2)}</div>`; container.appendChild(totalDiv);
                }

                function submitHireRequest(){
                    const submitBtn = btnSubmit; const originalText = submitBtn.innerHTML; submitBtn.disabled = true; submitBtn.innerHTML = '<i class="ti ti-loader me-1"></i>Booking...';

                    // normalize cleaner_id to integer or null (avoid sending string 'null')
                    const rawCleaner = (document.getElementById('hr_cleaner_id').value || '').toString().trim();
                    let payloadCleanerId = null;
                    if (rawCleaner !== '' && rawCleaner.toLowerCase() !== 'null' && rawCleaner.toLowerCase() !== 'undefined') {
                        if (!isNaN(rawCleaner)) payloadCleanerId = parseInt(rawCleaner, 10);
                    }

                        const payload = {
                        cleaner_id: payloadCleanerId,
                        cleaning_type: modal.dataset.selectedType || null,
                        selected_items: document.getElementById('hr_selected_items').value || '[]',
                        frequency: document.getElementById('hr_frequency_hidden').value || null,
                        scheduled_at: document.getElementById('hr_scheduled_at_hidden').value || null,
                        notes: document.getElementById('hr_serviceNotes').value || '',
                        name: document.getElementById('hr_checkout_name').value,
                        email: document.getElementById('hr_checkout_email').value,
                        phone: document.getElementById('hr_checkout_phone').value,
                            zip_code: document.getElementById('hr_zip_code').value || null,
                            city: (document.getElementById('hr_city') ? document.getElementById('hr_city').value : null) || null,
                        _token: document.querySelector('input[name="_token"]').value
                    };

                    const formData = new FormData();
                    Object.keys(payload).forEach(k=> formData.append(k, payload[k]));

                    fetch('{{ route("hire-requests.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            // success — use site toast
                            showAlert('success', 'Booking request sent', 'The provider will contact you soon.');
                            const bsModal = bootstrap.Modal.getInstance(modal); if(bsModal) bsModal.hide();
                        } else { throw new Error(data.message || 'Failed to send booking request'); }
                    })
                    .catch(err=>{ console.error(err); showAlert('error', 'Error sending request', err.message || 'Error sending request'); })
                    .finally(()=>{ submitBtn.disabled = false; submitBtn.innerHTML = originalText; });
                }

            })();
            </script>
        </div>
    </div>
</div>
