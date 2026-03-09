<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    /**
     * Handle chatbot messages and provide automated responses
     */
    public function handleMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = strtolower(trim($request->message));
        $isAuthenticated = Auth::check();

        // Get bot response based on user input and auth state
        $response = $this->getBotResponse($userMessage, $isAuthenticated);
        
        // Log the interaction for analytics
        Log::info('Chatbot interaction', [
            'user_message' => $userMessage,
            'bot_response' => $response['response']
        ]);

        return response()->json($response);
    }

    /**
     * Generate bot response based on user input
     */
    private function getBotResponse($message, $isAuthenticated = false)
    {
        // Quick reply options
        $findCleanerReplies = [
            ['text' => 'Browse All Services', 'value' => 'browse_services'],
            ['text' => 'Find Cleaners Near Me', 'value' => 'find_cleaners'],
            ['text' => 'View Pricing', 'value' => 'pricing'],
            ['text' => 'Back to Menu', 'value' => 'main_menu']
        ];

        $supportReplies = [
            ['text' => 'Email Us', 'value' => 'email_support'],
            ['text' => 'Visit Support Center', 'value' => 'support_center'],
            ['text' => 'Back to Menu', 'value' => 'main_menu']
        ];

        $mainMenuReplies = [
            ['text' => 'Find Cleaners', 'value' => 'find_cleaners'],
            ['text' => 'Our Services', 'value' => 'browse_services'],
            ['text' => 'For Cleaners', 'value' => 'for_cleaners'],
            ['text' => 'Contact Support', 'value' => 'contact_support']
        ];

        $serviceTypeReplies = [
            ['text' => 'Regular Home Clean', 'value' => 'regular_clean'],
            ['text' => 'Deep Clean', 'value' => 'deep_clean'],
            ['text' => 'End-of-Tenancy', 'value' => 'tenancy_clean'],
            ['text' => 'See All Services', 'value' => 'browse_services']
        ];

        // Pattern matching for responses
        switch (true) {
            // Greetings
            case $this->matchesPattern($message, ['hello', 'hi', 'hey', 'greetings', 'good morning', 'good afternoon', 'good evening']):
                $options = [
                    "Hello! 👋 Welcome to luxGold — Ireland's trusted marketplace for premium cleaning services. How can I help today?",
                    "Hi there! I'm the luxGold Assistant. I can help you find vetted cleaners, check pricing, or connect you with support. What would you like to do?",
                    "Hey! Need help finding a cleaner or wanting a quick quote? I'm here to help."
                ];
                return [
                    'response' => $this->pick($options),
                    'quickReplies' => $mainMenuReplies
                ];

            // Find cleaners
            case $this->matchesPattern($message, ['find_cleaners', 'find cleaner', 'find service', 'looking for', 'need a cleaner', 'search cleaner', 'hire cleaner']):
                return [
                    'response' => "Perfect! luxGold connects you with vetted cleaning professionals across Ireland. You can browse by service type, search by your location, or view pricing. What would you like to do? <br><br><a href='/find-cleaner' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>🔍 Search Cleaners Now</a>",
                    'quickReplies' => $findCleanerReplies
                ];

            // Browse services
            case $this->matchesPattern($message, ['browse_services', 'browse all', 'see all services', 'all services', 'what services', 'services offered']):
                return [
                    'response' => "luxGold offers comprehensive cleaning services:<br><br>🏠 <strong>Regular Home Clean</strong> - Starting from €35/hour<br>✨ <strong>Deep Clean</strong> - Starting from €70<br>🔑 <strong>End-of-Tenancy Clean</strong> - Starting from €120<br>🏢 <strong>Office Cleaning</strong> - Custom quotes<br><br><a href='/services' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>View All Services & Pricing</a>",
                    'quickReplies' => $serviceTypeReplies
                ];

            // Search by location
            case $this->matchesPattern($message, ['near me', 'my area', 'location', 'eircode', 'local cleaners', 'in my city']):
                return [
                    'response' => "Finding cleaners in your area is easy! Simply enter your Eircode or location on our search page and we'll show you all available vetted cleaners nearby with verified reviews and transparent pricing.<br><br><a href='/find-cleaner' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>🔍 Find Cleaners Near You</a>",
                    'quickReplies' => $mainMenuReplies
                ];

            // Pricing questions
            case $this->matchesPattern($message, ['price', 'cost', 'how much', 'pricing', 'fee', 'payment', 'rates']):
                return [
                    'response' => "Here are our typical starting prices:<br><br>💰 <strong>Regular Home Clean:</strong> From €35/hour<br>💰 <strong>Deep Clean:</strong> From €70 (fixed)<br>💰 <strong>End-of-Tenancy:</strong> From €120<br><br>Exact pricing varies by cleaner location and specific requirements. All cleaners display transparent pricing on their profiles. <strong>luxGold is 100% free for customers!</strong><br><br><a href='/services' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>View Detailed Pricing</a>",
                    'quickReplies' => $findCleanerReplies
                ];

            // How it works
            case $this->matchesPattern($message, ['how does it work', 'how it works', 'how to', 'process', 'get started', 'sign up', 'steps']):
                return [
                    'response' => "Getting started with luxGold is simple:<br><br>1️⃣ <strong>Search:</strong> Enter your Eircode or browse cleaners in your area<br>2️⃣ <strong>Review:</strong> View provider profiles, read verified reviews, and check pricing<br>3️⃣ <strong>Choose:</strong> Select your preferred cleaner and request a quote<br>4️⃣ <strong>Book:</strong> Schedule your cleaning and enjoy a spotless space!<br><br>🎉 <strong>It's 100% free for customers to use!</strong><br><br><a href='/find-cleaner' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>Start Your Search Now</a>",
                    'quickReplies' => $findCleanerReplies
                ];

            // Contact support
            case $this->matchesPattern($message, ['contact_support', 'support', 'help', 'customer service', 'speak to human', 'talk to someone']):
                // Require login to submit support tickets or view private requests
                if (! $isAuthenticated) {
                    return [
                        'response' => "I can connect you with our support team, but first you'll need to be logged in. Would you like to log in now?",
                        'quickReplies' => [
                            ['text' => 'Log in', 'value' => 'login'],
                            ['text' => 'Tell me contact info', 'value' => 'contact_info'],
                            ['text' => 'Back to Menu', 'value' => 'main_menu']
                        ],
                        'requireLogin' => true
                    ];
                }

                return [
                    'response' => "Thanks — since you're logged in I can help you open a support ticket. You can also email us directly:<br><br>📧 <a href='mailto:info@luxgold.com'>info@luxgold.com</a><br><br>Or visit the Support Center to submit a ticket.",
                    'quickReplies' => $supportReplies
                ];

            // Email support
            case $this->matchesPattern($message, ['email_support', 'email', 'send email', 'contact email']):
                return [
                    'response' => "You can email our support team at:<br><br>📧 <a href='mailto:info@luxgold.com' style='color: var(--brand-gold-200); font-weight: 600;'>info@luxgold.com</a><br><br>We typically respond within 24 hours during business days. For urgent matters, please visit our <a href='/support' target='_blank'>Support Center</a>.",
                    'quickReplies' => $mainMenuReplies
                ];

            // Support center
            case $this->matchesPattern($message, ['support_center', 'support center', 'help center', 'ticket']):
                return [
                    'response' => "Our Support Center is available for detailed inquiries and assistance. You can submit a ticket and track your request status.<br><br><a href='/support' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>🎫 Visit Support Center</a>",
                    'quickReplies' => $mainMenuReplies
                ];

            // About luxgold
            case $this->matchesPattern($message, ['about', 'what is luxgold', 'what is this', 'who are you', 'tell me about']):
                return [
                    'response' => "<strong>luxGold</strong> is Ireland's trusted marketplace for premium cleaning services. We connect homeowners and businesses with vetted cleaning professionals.<br><br>✅ <strong>Verified cleaners you can trust</strong><br>✅ <strong>Transparent pricing & verified reviews</strong><br>✅ <strong>Easy booking & secure payments</strong><br>✅ <strong>Quality service guaranteed</strong><br><br>Our mission is to make professional cleaning accessible, reliable, and straightforward for everyone in Ireland.<br><br><a href='/about' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>Learn More About Us</a>",
                    'quickReplies' => $mainMenuReplies
                ];

            // Reviews/Ratings
            case $this->matchesPattern($message, ['review', 'rating', 'feedback', 'testimonial', 'trust', 'verified']):
                return [
                    'response' => "All cleaners on luxGold are vetted and reviewed by real customers! ⭐<br><br>✅ Read authentic reviews from verified customers<br>✅ See detailed ratings for quality, reliability & value<br>✅ Make informed decisions with transparency<br><br>You can view reviews and ratings on each cleaner's profile page.<br><br><a href='/find-cleaner' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>Browse Reviewed Cleaners</a>",
                    'quickReplies' => $findCleanerReplies
                ];

            // For cleaners (providers)
            case $this->matchesPattern($message, ['for_cleaners', 'for cleaner', 'join', 'list my service', 'become a cleaner', 'register cleaner', 'cleaner signup']):
                return [
                    'response' => "Are you a cleaning professional looking to grow your business? Join luxGold! 🌟<br><br>💼 <strong>Benefits for Cleaners:</strong><br>• No upfront listing fees<br>• Get quality leads in your area<br>• Flexible scheduling - you're in control<br>• Fast, secure payments<br>• Build your reputation with reviews<br><br><a href='/for-cleaner' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>🚀 List Your Cleaning Service</a>",
                    'quickReplies' => $mainMenuReplies
                ];

            // Regular clean service
            case $this->matchesPattern($message, ['regular_clean', 'regular clean', 'regular cleaning', 'weekly clean', 'maintenance clean']):
                return [
                    'response' => "🏠 <strong>Regular Home Clean</strong><br><br>Our most popular service! A routine clean covering:<br>• Dusting and vacuuming<br>• Kitchen surface cleaning<br>• Bathroom sanitation<br>• Light tidying<br><br>💰 <strong>Starting from €35/hour</strong><br><br><a href='/services' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>Learn More & Book</a>",
                    'quickReplies' => $serviceTypeReplies
                ];

            // Deep clean service
            case $this->matchesPattern($message, ['deep_clean', 'deep clean', 'deep cleaning', 'intensive clean', 'thorough clean']):
                return [
                    'response' => "✨ <strong>Deep Clean Service</strong><br><br>Intensive cleaning for neglected areas:<br>• Full kitchen & bathroom deep clean<br>• Baseboards & window sills<br>• Appliance exterior cleaning<br>• Behind furniture access<br>• Descaling & heavy-duty surfaces<br><br>💰 <strong>Starting from €70</strong><br><br><a href='/services' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>Get a Deep Clean Quote</a>",
                    'quickReplies' => $serviceTypeReplies
                ];

            // End of tenancy clean
            case $this->matchesPattern($message, ['tenancy_clean', 'end of tenancy', 'end-of-tenancy', 'move out', 'move in', 'deposit clean']):
                return [
                    'response' => "🔑 <strong>End-of-Tenancy Clean</strong><br><br>Designed to meet landlord expectations:<br>• Full deep clean of all rooms<br>• Oven & appliance cleaning<br>• Carpet spot cleaning<br>• Deposit-ready guarantee<br><br>💰 <strong>Starting from €120</strong><br><br>Perfect for securing your deposit back!<br><br><a href='/services' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>Book Tenancy Clean</a>",
                    'quickReplies' => $serviceTypeReplies
                ];

            // FAQs
            case $this->matchesPattern($message, ['faq', 'faqs', 'frequently asked', 'common questions', 'questions']):
                return [
                    'response' => "I can answer common questions, or you can visit our comprehensive FAQ page for detailed information about:<br><br>• How luxGold works<br>• Pricing & payments<br>• Trust & safety<br>• Booking process<br>• For cleaners information<br><br><a href='/faqs' target='_blank' style='color: var(--brand-gold-200); font-weight: 600;'>📜 View All FAQs</a>",
                    'quickReplies' => $mainMenuReplies
                ];

            // (compare feature removed from responses)

            // Main menu
            case $this->matchesPattern($message, ['main_menu', 'menu', 'start over', 'back', 'options', 'main']):
                return [
                    'response' => "Sure! Here are the main things I can help you with. What would you like to do?",
                    'quickReplies' => $mainMenuReplies
                ];

            // Ask a question
            case $this->matchesPattern($message, ['ask_question', 'question', 'ask', 'inquiry', 'query']):
                return [
                    'response' => "I'm here to answer your questions about luxGold! What would you like to know?",
                    'quickReplies' => [
                        ['text' => 'How does it work?', 'value' => 'how does it work'],
                        ['text' => 'View Pricing', 'value' => 'pricing'],
                        ['text' => 'See FAQs', 'value' => 'faq'],
                        ['text' => 'Contact support', 'value' => 'contact_support']
                    ]
                ];

            // Thank you
            case $this->matchesPattern($message, ['thank', 'thanks', 'appreciate', 'helpful']):
                return [
                    'response' => "You're very welcome! 😊 I'm glad I could help. Is there anything else you'd like to know about luxGold?",
                    'quickReplies' => $mainMenuReplies
                ];

            // Goodbye
            case $this->matchesPattern($message, ['bye', 'goodbye', 'see you', 'later', 'no thanks']):
                return [
                    'response' => "Thank you for chatting with luxGold! Have a wonderful day, and feel free to return anytime you need help finding premium cleaning services. 👋✨",
                    'quickReplies' => []
                ];

            // Default response
            default:
                return [
                    'response' => "I'm not quite sure about that, but I'm here to help! 🤔<br><br>I can assist you with:<br>• Finding vetted cleaners in your area<br>• Information about our services & pricing<br>• How luxGold works<br>• Connecting you with support<br><br>What would you like to know?",
                    'quickReplies' => $mainMenuReplies
                ];
        }
    }

    /**
     * Pick a random element from an array
     */
    private function pick(array $options)
    {
        if (empty($options)) return '';
        return $options[array_rand($options)];
    }

    /**
     * Check if message matches any of the patterns
     */
    private function matchesPattern($message, $patterns)
    {
        foreach ($patterns as $pattern) {
            if (strpos($message, $pattern) !== false) {
                return true;
            }
        }
        return false;
    }
}
