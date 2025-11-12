<!-- Footer Section -->
<footer class="askroro-footer-section bg-white pt-5 pb-4">
  <div class="container">
    <div class="row gy-4">

      <!-- Logo & About -->
      <div class="col-lg-3 col-md-6">
        <div class="askroro-footer-brand">
          <div class="d-flex align-items-center mb-3">
            <img src="{{ asset('assets/images/updated-logo.jpeg') }}" alt="ASKRORO Logo" class="askroro-footer-logo me-2">
            <h5 class="askroro-footer-title mb-0 fw-bold">AskRoro</h5>
          </div>
          <p class="askroro-footer-description">
            Your trusted guide to childcare, learning, activities & wellness in North Texas.
          </p>
          <div class="askroro-footer-social d-flex gap-3 mt-3">
            <a href="#" class="text-dark"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/askroroofficial?igsh=bnk3djBza2lscHNp" target="_blank" class="text-dark"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>

      <!-- For Families -->
      <div class="col-lg-3 col-md-6">
        <h6 class="askroro-footer-heading text-teal fw-bold mb-3">For Families</h6>
        <ul class="list-unstyled askroro-footer-links">
          <li><a href="{{ route('website.find-provider') }}" class="text-decoration-none">Find Providers</a></li>
          <li><a href="{{ route('website.compare') }}" class="text-decoration-none">Write Reviews</a></li>
        </ul>
      </div>

      <!-- For Providers -->
      <div class="col-lg-3 col-md-6">
        <h6 class="askroro-footer-heading text-teal fw-bold mb-3">For Providers</h6>
        <ul class="list-unstyled askroro-footer-links">
          <li><a href="{{ route('website.for-provider') }}" class="text-decoration-none">List Your Service</a></li>
          <li><a href="#" class="text-decoration-none">Provider Dashboard</a></li>
        </ul>
      </div>

      <!-- Support -->
      <div class="col-lg-3 col-md-6">
        <h6 class="askroro-footer-heading text-teal fw-bold mb-3">Support</h6>
        <ul class="list-unstyled askroro-footer-links">
          <li><a href="{{ route('website.about') }}" class="text-decoration-none">About Us</a></li>
          <li><a href="{{ route('website.privacy-policy') }}" class="text-decoration-none">Privacy Policy</a></li>
          <li><a href="{{ route('website.services') }}" class="text-decoration-none">Terms of Service</a></li>
          <li><a href="{{ route('website.cookies-policy') }}" class="text-decoration-none">Cookies Information</a></li>
          <li><a href="{{ route('website.faqs') }}" class="text-decoration-none">FAQs</a></li>
        </ul>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="askroro-footer-bottom text-center mt-4 pt-3 border-top border-secondary">
      <p class="mb-1">© {{ date('Y') }} ASKRORO. All rights reserved.</p>
      <p class="mb-0">Powered by Privy Consulting LLC</p>
    </div>
  </div>
</footer>
