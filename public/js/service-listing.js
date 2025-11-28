// public/js/service-listing.js

class ServiceListingModal {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 5;
        this.formData = new FormData();
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateStepIndicator();
    }

    bindEvents() {
        // Navigation buttons
        document.getElementById('nextStepBtn').addEventListener('click', () => this.nextStep());
        document.getElementById('prevStepBtn').addEventListener('click', () => this.prevStep());
        
        // Close modal
        document.getElementById('closeModalBtn').addEventListener('click', () => this.closeModal());
        
        // File upload
        this.setupFileUpload();
        
        // Form validation
        this.setupValidation();

        // Close modal when clicking outside
        document.getElementById('serviceModalOverlay').addEventListener('click', (e) => {
            if (e.target.id === 'serviceModalOverlay') {
                this.closeModal();
            }
        });
    }

    setupValidation() {
        // Add real-time validation for required fields
        const requiredFields = document.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('input', () => {
                if (field.value.trim()) {
                    field.classList.remove('error');
                    const errorElement = field.parentElement.querySelector('.service-listing-error-message-text');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                }
            });
        });
    }

    validateField(field) {
        const errorElement = field.parentElement.querySelector('.service-listing-error-message-text');
        
        if (!field.value.trim()) {
            field.classList.add('error');
            if (errorElement) {
                errorElement.style.display = 'block';
            }
            return false;
        } else {
            field.classList.remove('error');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            return true;
        }
    }

    validateStep(step) {
        let isValid = true;

        switch(step) {
            case 1:
                const requiredFields = document.querySelectorAll('#step1Content [required]');
                requiredFields.forEach(field => {
                    if (!this.validateField(field)) {
                        isValid = false;
                    }
                });
                break;
            
            case 2:
                const serviceCheckboxes = document.querySelectorAll('.service-listing-service-checkbox:checked');
                const serviceErrorElement = document.querySelector('#step2Content .service-listing-error-message-text');
                if (serviceCheckboxes.length === 0) {
                    if (serviceErrorElement) {
                        serviceErrorElement.style.display = 'block';
                    }
                    isValid = false;
                } else {
                    if (serviceErrorElement) {
                        serviceErrorElement.style.display = 'none';
                    }
                }
                break;
        }

        return isValid;
    }

    nextStep() {
        if (!this.validateStep(this.currentStep)) {
            return;
        }

        if (this.currentStep === this.totalSteps) {
            this.submitForm();
            return;
        }

        this.currentStep++;
        this.updateStepIndicator();
        this.updateContent();
        this.updateNavigation();
    }

    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.updateStepIndicator();
            this.updateContent();
            this.updateNavigation();
        }
    }

    updateStepIndicator() {
        // Update step indicators
        document.querySelectorAll('.service-listing-step-indicator-item').forEach((indicator, index) => {
            if (index + 1 === this.currentStep) {
                indicator.classList.add('service-listing-step-active');
            } else {
                indicator.classList.remove('service-listing-step-active');
            }
        });
    }

    updateContent() {
        // Hide all content panels
        document.querySelectorAll('.service-listing-step-content-panel').forEach(panel => {
            panel.classList.remove('service-listing-step-active-content');
        });

        // Show current content panel
        const currentContent = document.getElementById(`step${this.currentStep}Content`);
        if (currentContent) {
            currentContent.classList.add('service-listing-step-active-content');
        }

        // Update review section if we're on step 5
        if (this.currentStep === 5) {
            this.updateReviewSection();
        }
    }

    updateNavigation() {
        const prevBtn = document.getElementById('prevStepBtn');
        const nextBtn = document.getElementById('nextStepBtn');

        // Update previous button
        prevBtn.disabled = this.currentStep === 1;

        // Update next button text
        if (this.currentStep === this.totalSteps) {
            nextBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Listing';
        } else {
            nextBtn.innerHTML = 'Next<i class="fas fa-arrow-right ms-2"></i>';
        }
    }

    updateReviewSection() {
        // Basic Info
        document.getElementById('reviewBusinessName').textContent = (document.getElementById('profileName') && document.getElementById('profileName').value) ? document.getElementById('profileName').value : '-';
        document.getElementById('reviewPhone').textContent = document.getElementById('phoneNumber').value || '-';
        document.getElementById('reviewEmail').textContent = document.getElementById('emailAddress').value || '-';
        
        const address = [
            document.getElementById('physicalAddress').value,
            document.getElementById('cityinfo').value,
            document.querySelector('#state').value,
            document.getElementById('zipCode').value
        ].filter(Boolean).join(', ');
        document.getElementById('reviewAddress').textContent = address || '-';

        // Services
        const selectedServices = Array.from(document.querySelectorAll('.service-listing-service-checkbox:checked'))
            .map(cb => cb.nextElementSibling.textContent).join(', ');
        document.getElementById('reviewServices').textContent = selectedServices || '-';
        document.getElementById('reviewDescription').textContent = document.getElementById('serviceDescription').value || '-';

        // Credentials
        document.getElementById('reviewLicenseNumber').textContent = document.getElementById('licenseNumber').value || '-';
        document.getElementById('reviewYearsOperation').textContent = document.getElementById('yearsOperation').value || '-';
        document.getElementById('reviewInsurance').textContent = document.getElementById('insuranceCoverage').value || '-';
        
        const diversityBadges = Array.from(document.querySelectorAll('input[id^="badge-"]:checked'))
            .map(cb => cb.nextElementSibling.textContent).join(', ');
        document.getElementById('reviewDiversityBadges').textContent = diversityBadges || '-';
        
        const specialFeatures = Array.from(document.querySelectorAll('input[id^="feature-"]:checked'))
            .map(cb => cb.nextElementSibling.textContent).join(', ');
        document.getElementById('reviewSpecialFeatures').textContent = specialFeatures || '-';

        // Media & Links
        document.getElementById('reviewWebsite').textContent = document.getElementById('website').value || '-';
        document.getElementById('reviewFacebook').textContent = document.getElementById('facebook').value || '-';
        document.getElementById('reviewInstagram').textContent = document.getElementById('instagram').value || '-';
    }

    setupFileUpload() {
        const uploadAreas = document.querySelectorAll('.service-listing-file-upload-area');
        
        uploadAreas.forEach(area => {
            const fileInput = area.querySelector('input[type="file"]');
            
            area.addEventListener('click', () => fileInput.click());
            
            area.addEventListener('dragover', (e) => {
                e.preventDefault();
                area.classList.add('dragover');
            });
            
            area.addEventListener('dragleave', () => {
                area.classList.remove('dragover');
            });
            
            area.addEventListener('drop', (e) => {
                e.preventDefault();
                area.classList.remove('dragover');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    this.handleFileSelection(fileInput);
                }
            });
            
            fileInput.addEventListener('change', () => this.handleFileSelection(fileInput));
        });
    }

    handleFileSelection(input) {
        const files = Array.from(input.files);
        const uploadArea = input.closest('.service-listing-file-upload-area');
        const fileListId = input.id + 'List';
        const fileList = document.getElementById(fileListId);
        
        if (!fileList) {
            console.error('File list element not found for:', input.id);
            return;
        }

        files.forEach(file => {
            // Add to FormData for submission
            if (input.multiple) {
                this.formData.append(input.name, file);
            } else {
                this.formData.set(input.name, file);
            }
            
            const fileElement = document.createElement('div');
            fileElement.className = 'service-listing-uploaded-file-item';
            fileElement.innerHTML = `
                <i class="fas fa-file ${this.getFileIcon(file.type)}"></i>
                <span>${file.name} (${this.formatFileSize(file.size)})</span>
                <button type="button" class="service-listing-remove-file-btn" data-filename="${file.name}">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Add remove functionality
            const removeBtn = fileElement.querySelector('.service-listing-remove-file-btn');
            removeBtn.addEventListener('click', () => {
                this.removeFile(input, file.name);
                fileElement.remove();
            });
            
            fileList.appendChild(fileElement);
        });
    }

    getFileIcon(fileType) {
        if (fileType.startsWith('image/')) return 'fa-file-image text-primary';
        if (fileType === 'application/pdf') return 'fa-file-pdf text-danger';
        return 'fa-file text-secondary';
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    removeFile(input, fileName) {
        // Create a new DataTransfer to remove the file
        const dt = new DataTransfer();
        const files = Array.from(input.files);
        const updatedFiles = files.filter(file => file.name !== fileName);
        
        updatedFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;

        // Also remove from formData
        this.formData = new FormData(); // Reset formData and rebuild
        this.rebuildFormData();
    }

    rebuildFormData() {
        // Rebuild formData from all file inputs
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            if (input.files.length > 0) {
                if (input.multiple) {
                    Array.from(input.files).forEach(file => {
                        this.formData.append(input.name, file);
                    });
                } else {
                    this.formData.set(input.name, input.files[0]);
                }
            }
        });
    }

    async submitForm() {
        const submitBtn = document.getElementById('nextStepBtn');
        const originalText = submitBtn.innerHTML;
        
        try {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';

            // Collect form data
            const formData = new FormData();
            
            // Basic Info
            formData.append('profile_name', (document.getElementById('profileName') && document.getElementById('profileName').value) ? document.getElementById('profileName').value : (document.getElementById('businessName') ? document.getElementById('businessName').value : ''));
            formData.append('phone_number', document.getElementById('phoneNumber').value);
            formData.append('email', document.getElementById('emailAddress').value);
            formData.append('physical_address', document.getElementById('physicalAddress').value);
            formData.append('city', document.getElementById('cityinfo').value);
            formData.append('state', document.querySelector('#state').value);
            formData.append('zip_code', document.getElementById('zipCode').value);

            // Services
            const serviceCategories = Array.from(document.querySelectorAll('input[name="sub_categories[]"]:checked'))
                .map(cb => cb.value);
            formData.append('sub_categories', JSON.stringify(serviceCategories));
            formData.append('service_description', document.getElementById('serviceDescription').value);

            // Credentials removed from UI; no longer appended

            // Special features
            const specialFeatures = Array.from(document.querySelectorAll('input[id^="feature-"]:checked'))
                .map(cb => cb.value);
            formData.append('special_features', JSON.stringify(specialFeatures));

            // Social media
            formData.append('website', document.getElementById('website').value);
            formData.append('facebook', document.getElementById('facebook').value);
            formData.append('instagram', document.getElementById('instagram').value);

            // Append files
            for (let [key, value] of this.formData.entries()) {
                formData.append(key, value);
            }

            // Submit to backend - Use the web route instead of API
            const response = await fetch('/service-listing/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Non-JSON response:', text.substring(0, 200));
                throw new Error('Server returned non-JSON response');
            }

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Server error');
            }

            if (result.success) {
                this.showSuccessMessage(result.message);
                this.closeModal();
                this.resetForm();
            } else {
                this.showErrorMessage(result.message || 'Submission failed');
            }

        } catch (error) {
            console.error('Error submitting form:', error);
            this.showErrorMessage(error.message || 'An error occurred while submitting your listing. Please try again.');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }

 showSuccessMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });
}

 showErrorMessage(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        showConfirmButton: true,
        confirmButtonColor: '#d33'
    });
}


    closeModal() {
        document.getElementById('serviceModalOverlay').style.display = 'none';
    }

    resetForm() {
        this.currentStep = 1;
        this.formData = new FormData();
        
        // Reset all form fields
        document.querySelectorAll('input, textarea, select').forEach(field => {
            if (field.type !== 'button' && field.type !== 'submit') {
                field.value = '';
            }
        });
        
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        document.querySelectorAll('.service-listing-uploaded-files-list').forEach(list => {
            list.innerHTML = '';
        });
        
        this.updateStepIndicator();
        this.updateContent();
        this.updateNavigation();
    }

    // Method to open the modal
    openModal() {
        document.getElementById('serviceModalOverlay').style.display = 'flex';
    }
}

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.serviceListingModal = new ServiceListingModal();
    
    // Add global function to open modal
    window.openServiceListingModal = function() {
        window.serviceListingModal.openModal();
    };
});