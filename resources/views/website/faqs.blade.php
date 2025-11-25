@extends('layouts.master')

@section('title', 'FAQs - luxGold')
@section('content')
    <!-- Hero Section -->
    <section class="master-section">
        <div class="container">
            <h1 class="mt-4">
              luxGold – Frequently Asked Questions
            </h1>
           
        </div>

    </section>
    <div class="container py-5">
    
    
        <!-- Parents Section -->
        <div class="faq-accordion-section-container">
          <h2 class="faq-category-title-longkeywordclass">For Customers</h2>
          <div class="accordion" id="faqAccordionParents">
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentOne">
                  Q1. What is luxGold?
                </button>
              </h2>
              <div id="collapseParentOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  luxGold is a marketplace for professional cleaning services — find, compare, and book vetted cleaners and cleaning companies for homes and businesses.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentTwo">
                  Q2. How much does it cost for customers to use luxGold?
                </button>
              </h2>
              <div id="collapseParentTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  luxGold is free for customers to browse, search, compare, and review cleaners. Some premium features for providers may be available, while core features remain available to customers.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentThree">
                  Q3. How do I know cleaners on luxGold are trustworthy?
                </button>
              </h2>
              <div id="collapseParentThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  We require providers to verify their business information; customers can leave reviews and ratings to help others choose. Look for trust indicators like verified badges and reviews.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentFour">
                  Q4. Can I compare cleaners?
                </button>
              </h2>
              <div id="collapseParentFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  Yes! You can compare up to 3 providers side by side on price, ratings, location, and services.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentFive">
                  Q5. Do I book services directly on luxGold?
                </button>
              </h2>
              <div id="collapseParentFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  In most cases, luxGold connects you directly to cleaners to book services. Booking and payment flows depend on the cleaner’s setup and listing.
                </div>
              </div>
            </div>
    
          </div>
        </div>
    
        <!-- Providers Section -->
        <div class="faq-accordion-section-container">
          <h2 class="faq-category-title-longkeywordclass">For Cleaners</h2>
          <div class="accordion" id="faqAccordionProviders">
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingProviderOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProviderOne">
                  Q6. How do I list my service on luxGold?
                </button>
              </h2>
              <div id="collapseProviderOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionProviders">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  Click “List Your Service” in the navigation bar. Create a profile, upload details (photos, pricing, descriptions), and choose a membership plan.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingProviderTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProviderTwo">
                  Q7. What types of services can be listed?
                </button>
              </h2>
              <div id="collapseProviderTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordionProviders">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  Cleaning services, home cleaning, commercial cleaning, deep cleaning, move-in/move-out cleaning, and specialty cleaning services offered by independent cleaners and agencies.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingProviderThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProviderThree">
                  Q8. Is there a cost to join as a provider?
                </button>
              </h2>
              <div id="collapseProviderThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordionProviders">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  Providers choose from membership tiers: Basic (free/low-cost), Premium (enhanced visibility), and Featured (priority placement, ads, analytics).
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingProviderFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProviderFour">
                  Q9. What are the benefits of joining luxGold?
                </button>
              </h2>
              <div id="collapseProviderFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordionProviders">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  Benefits include increased visibility, access to analytics, ability to showcase unique value (badges, reviews), and building trust within the community.
                </div>
              </div>
            </div>
    
          </div>
        </div>
    
        <!-- General Section -->
        <div class="faq-accordion-section-container">
          <h2 class="faq-category-title-longkeywordclass">General</h2>
          <div class="accordion" id="faqAccordionGeneral">
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingGeneralOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneralOne">
                  Q10. What cities does luxGold serve?
                </button>
              </h2>
              <div id="collapseGeneralOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionGeneral">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  We’re starting in North Texas (Prosper, Frisco, Little Elm, Aubrey, Celina, and nearby communities) and will expand soon.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingGeneralTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneralTwo">
                  Q11. How does luxGold make money?
                </button>
              </h2>
              <div id="collapseGeneralTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordionGeneral">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  We offer provider memberships, featured listings, and advertising options. luxGold is free for customers to browse listings.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingGeneralThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneralThree">
                  Q12. How do I contact luxGold?
                </button>
              </h2>
              <div id="collapseGeneralThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordionGeneral">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  You can reach us at <strong>info@luxgold.com</strong> or through our Contact & Support page.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingGeneralFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneralFour">
                  Q13. Does luxGold share my data?
                </button>
              </h2>
              <div id="collapseGeneralFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordionGeneral">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  We take privacy seriously. Please read our <a href="#">Privacy Policy</a> and <a href="#">Cookie Policy</a> to see how we protect your information.
                </div>
              </div>
            </div>
    
          </div>
        </div>
    
      </div>
@endsection