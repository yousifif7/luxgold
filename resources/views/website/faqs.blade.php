@extends('layouts.master')

@section('title', 'FAQs - AskRoro')
@section('content')
    <!-- Hero Section -->
    <section class="master-section">
        <div class="container">
            <h1 class="mt-4">
                AskRoro – Frequently Asked Questions
            </h1>
           
        </div>

    </section>
    <div class="container py-5">
    
    
        <!-- Parents Section -->
        <div class="faq-accordion-section-container">
          <h2 class="faq-category-title-longkeywordclass">For Parents</h2>
          <div class="accordion" id="faqAccordionParents">
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentOne">
                  Q1. What is AskRoro?
                </button>
              </h2>
              <div id="collapseParentOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  AskRoro is your family’s trusted guide to finding and comparing local services, including childcare, preschools, afterschool programs, events, and wellness providers — all in one place.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentTwo">
                  Q2. How much does it cost for parents to use AskRoro?
                </button>
              </h2>
              <div id="collapseParentTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  AskRoro is free for parents to browse, search, compare, and review providers. Some premium features may be added in the future, but the core platform will always be free for families.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentThree">
                  Q3. How do I know providers on AskRoro are trustworthy?
                </button>
              </h2>
              <div id="collapseParentThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  We require providers to verify their business information, and parents can leave reviews and ratings. Look for diversity badges (Minority-Owned, Woman-Owned, Veteran-Owned, Family-Owned).
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingParentFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParentFour">
                  Q4. Can I compare providers?
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
                  Q5. Do I book services directly on AskRoro?
                </button>
              </h2>
              <div id="collapseParentFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordionParents">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  In most cases, AskRoro connects you directly to providers to book. For some events and activities, you may be able to RSVP or purchase tickets directly through the platform.
                </div>
              </div>
            </div>
    
          </div>
        </div>
    
        <!-- Providers Section -->
        <div class="faq-accordion-section-container">
          <h2 class="faq-category-title-longkeywordclass">For Providers</h2>
          <div class="accordion" id="faqAccordionProviders">
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingProviderOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProviderOne">
                  Q6. How do I list my service on AskRoro?
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
                  Childcare centers, preschools, private schools (K–12), afterschool programs, tutoring, camps, events, entertainment, and wellness services for families & children.
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
                  Q9. What are the benefits of joining AskRoro?
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
                  Q10. What cities does AskRoro serve?
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
                  Q11. How does AskRoro make money?
                </button>
              </h2>
              <div id="collapseGeneralTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordionGeneral">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  We offer provider memberships, featured listings, and advertising options. AskRoro is free for parents.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingGeneralThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneralThree">
                  Q12. How do I contact AskRoro?
                </button>
              </h2>
              <div id="collapseGeneralThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordionGeneral">
                <div class="accordion-body faq-accordion-body-longkeywordclass">
                  You can reach us at <strong>info@askroro.com</strong> or through our Contact & Support page.
                </div>
              </div>
            </div>
    
            <div class="accordion-item faq-accordion-item-longkeywordclass">
              <h2 class="accordion-header faq-accordion-header-longkeywordclass" id="headingGeneralFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneralFour">
                  Q13. Does AskRoro share my data?
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