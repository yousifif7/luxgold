<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <title>@yield('title', 'AskRoro - Ask. Compare. Choose. That’s Roro!')</title>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css" integrity="sha512-gzw5zNP2TRq+DKyAqZfDclaTG4dOrGJrwob2Fc8xwcJPDPVij0HowLIMZ8c1NefFM0OZZYUUUNoPfcoI5jqudw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="title" content="AskRoro - Ask. Compare. Choose. That’s Roro!">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description"
          content="AskRoro helps you ask, compare, and choose the best options with ease.">

    <meta name="keywords"
          content="AskRoro, comparison platform, ask compare choose, product comparison, decision making tool">
    <meta name="author" content="AskRoro Team">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.askroro.com/">
    <meta property="og:title" content="AskRoro - Ask. Compare. Choose. That’s Roro!">
    <meta property="og:description"
          content="AskRoro helps you ask, compare, and choose the best options with ease.">
    <meta property="og:image" content="https://www.askroro.com/assets/images/logo.png">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.askroro.com/">
    <meta property="twitter:title" content="AskRoro - Ask. Compare. Choose. That’s Roro!">
    <meta property="twitter:description"
          content="AskRoro helps you ask, compare, and choose the best options with ease.">
    <meta property="twitter:image" content="https://www.askroro.com/assets/images/logo.png">

    <meta name="theme-color" content="#ffffff">

    {{-- Page-specific meta pushed from views (meta_title, meta_description, og overrides) --}}
    @stack('meta')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    @stack('links')
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">
          <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />

</head>


<body>

    <!-- Modal -->


<!-- Include CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include JavaScript -->
    <!-- Signup Options Modal -->
  <!-- Include your modals here -->
    @include('auth.modals.signup')
    @include('auth.modals.parent-signup')
    @include('auth.modals.provider-signup')
    @include('auth.modals.login')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

   <script>

      function serviceListingModal(){
        document.getElementById('serviceModalOverlay').style.display = 'flex';
    }
    // Modal functions
    function openSignUpModal() {
        document.getElementById('signUpModal').style.display = 'flex';
    }

    function openParentSignUpModal() {
        closeModal('signUpModal');
        document.getElementById('parentSignUpModal').style.display = 'flex';
    }

    function openServiceProviderModal() {
        closeModal('signUpModal');
        document.getElementById('providerSignUpModal').style.display = 'flex';
    }

    function openLoginModal() {
        closeAllModals();
        document.getElementById('loginModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function closeAllModals() {
        const modals = document.querySelectorAll('.askroro-modal-overlay, .serviceflow-modal-overlay');
        modals.forEach(modal => modal.style.display = 'none');
    }

    function backToSignUpOptions() {
        closeAllModals();
        openSignUpModal();
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

    // Service Provider Modal Steps
    let selectedCategory = '';
    let selectedPlan = '';

    function goToStep1() {
        document.getElementById('step1').classList.add('active');
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step3').classList.remove('active');
        
        document.getElementById('step1Indicator').classList.add('active');
        document.getElementById('step2Indicator').classList.remove('active');
        document.getElementById('step3Indicator').classList.remove('active');
    }

    function goToStep2() {
        if (!selectedCategory) {
            showAlert('warning', 'Please select a service category');
            return;
        }
        
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.add('active');
        document.getElementById('step3').classList.remove('active');
        
        document.getElementById('step1Indicator').classList.remove('active');
        document.getElementById('step2Indicator').classList.add('active');
        document.getElementById('step3Indicator').classList.remove('active');
    }

    function goToStep3() {
        if (!selectedPlan) {
            showAlert('warning', 'Please select a pricing plan');
            return;
        }
        
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step3').classList.add('active');
        
        document.getElementById('step1Indicator').classList.remove('active');
        document.getElementById('step2Indicator').classList.remove('active');
        document.getElementById('step3Indicator').classList.add('active');
    }

    // Initialize category selection
    document.addEventListener('DOMContentLoaded', function() {
        // Category selection
        const categoryCards = document.querySelectorAll('.serviceflow-category-card');
        categoryCards.forEach(card => {
            card.addEventListener('click', function() {
                categoryCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedCategory = this.getAttribute('data-category');
                document.getElementById('categoryNextBtn').disabled = false;
            });
        });

        // Plan selection
        const planCards = document.querySelectorAll('.serviceflow-plan-card');
        planCards.forEach(card => {
            card.addEventListener('click', function() {
                planCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedPlan = this.getAttribute('data-plan');
                document.getElementById('planNextBtn').disabled = false;
            });
        });

        // Form submissions
        document.getElementById('parentSignUpForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            submitParentForm(this);
        });

        document.getElementById('providerCompleteForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            submitProviderForm(this);
        });

      
    });

    // SweetAlert helper function
    function showAlert(icon, title, text = '', timer = 3000) {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: timer,
            showConfirmButton: icon === 'error',
            timerProgressBar: icon !== 'error'
        });
    }

    // AJAX form submissions
    async function submitParentForm(form) {
        const formData = new FormData(form);
        formData.append('role', 'parent');
        
        try {
            const response = await fetch('/register/parent', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            
            if (response.ok) {
                showAlert('success', 'Registration successful!', 'Redirecting to dashboard...');
                setTimeout(() => {
                    window.location.href = '/parent/dashboard';
                }, 2000);
            } else {
                showAlert('error', 'Registration Failed', data.message || 'Please check your information and try again.');
            }
        } catch (error) {
            showAlert('error', 'Registration Error', 'An unexpected error occurred. Please try again.');
        }
    }

    async function submitProviderForm(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Processing...';
        submitBtn.disabled = true;

        const formData = new FormData(form);
        formData.append('role', 'provider');
        formData.append('category', selectedCategory);
        formData.append('pricing_plan', selectedPlan);
        
        try {
            const response = await fetch('/register/provider', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            
            if (response.ok) {
                showAlert('success', 'Welcome to ServiceFlow!', 'Your provider account has been created successfully.');
                setTimeout(() => {
                    window.location.href = 'provider/dashboard';
                }, 2000);
            } else {
                showAlert('error', 'Registration Failed', data.message || 'Please check your information and try again.');
            }
        } catch (error) {
            showAlert('error', 'Network Error', 'Unable to connect to server. Please check your connection.');
        } finally {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    async function submitLoginForm(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Signing in...';
        submitBtn.disabled = true;

        const formData = new FormData(form);
        
        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            
            if (response.ok) {
                showAlert('success', 'Login successful!', 'Welcome back!');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1500);
            } else {
                showAlert('error', 'Login Failed', data.message || 'Invalid credentials. Please try again.');
            }
        } catch (error) {
            showAlert('error', 'Login Error', 'Unable to connect to server. Please try again.');
        } finally {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    // Add CSS for spinner
    const style = document.createElement('style');
    style.textContent = `
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
</script>


    {{-- Fixed Header --}}
    @include('layouts.header')


    @yield('content')


    {{-- Fixed Footer --}}
    @include('layouts.footer')

@stack('scripts')



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-K1EN6K673M"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-K1EN6K673M'); </script>




<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4162913120186247"
     crossorigin="anonymous"></script>




</body>



</html>
