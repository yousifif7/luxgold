<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceListingController;
use App\Http\Controllers\EircodeController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SavedProviderController;
use App\Http\Controllers\FollowedProviderController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\HireRequestController;
use App\Http\Controllers\ParentPanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProviderPanelController;
use App\Http\Controllers\EventRegistrationController;

//Website Routes

Route::get('/', [HomeController::class,'index']);
Route::get('/about', fn() => view('website.about'))->name('website.about');
Route::get('compare', [HomeController::class,'compare'])->name('website.compare');
Route::get('/find-cleaner', [HomeController::class,'findProvider'])->name('website.find-cleaner');
Route::get('/for-cleaner', fn() => view('website.for-provider'))->name('website.for-cleaner');
Route::get('/terms-of-services', fn() => view('website.term-of-services'))->name('website.services');
Route::get('/cleaner-detail/{id}', [HomeController::class,'providerDetail'])->name('website.cleaner-detail');
Route::get('/event-detail/{id}', [HomeController::class,'eventDetail'])->name('website.event-detail');
Route::get('/find-event', [HomeController::class,'findEvents'])->name('website.find-event');
Route::get('/resource/{slug}', [HomeController::class,'resourceDetails'])->name('website.resource');


Route::get('/privacy-policy', fn() => view('website.privacy-policy'))->name('website.privacy-policy');
Route::get('/cookies-policy', fn() => view('website.cookies-policy'))->name('website.cookies-policy');
Route::get('/faqs', fn() => view('website.faqs'))->name('website.faqs');

// Support / Contact
Route::get('/support', [App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
Route::post('/support', [App\Http\Controllers\SupportController::class, 'store'])->name('support.store');
Route::get('/support/{ticket}', [App\Http\Controllers\SupportController::class, 'show'])->name('support.show');
Route::get('/support/{ticket}/messages', [App\Http\Controllers\SupportMessageController::class, 'index']);
Route::post('/support/messages', [App\Http\Controllers\SupportMessageController::class, 'store'])->name('support.messages.store');

Route::post('/events/{event}/save', [EventRegistrationController::class, 'save'])
    ->middleware('auth')
    ->name('events.save');

Route::post('/event-registration', [EventRegistrationController::class, 'store'])
    ->name('event.registration.store');

Route::get('/registration/{code}', [EventRegistrationController::class, 'show'])
    ->name('event.registration.show');

Route::post('/registration/{code}/cancel', [EventRegistrationController::class, 'cancel'])
    ->name('event.registration.cancel');

Route::get('/my-registrations', [EventRegistrationController::class, 'userRegistrations'])
    ->name('user.registrations')
    ->middleware('auth');
Route::delete('/saved-events/{savedEvent}', [EventRegistrationController::class, 'destroy'])
    ->name('saved-events.destroy');




Route::middleware(['auth'])->group(function () {
    // Parent profile routes
    Route::get('/customer/profile', [ProfileController::class, 'show'])->name('customer-profile');
    Route::post('/customer/profile/personal-info', [ProfileController::class, 'updatePersonalInfo'])->name('customer.profile.personal-info');
    Route::post('/customer/profile/location-preferences', [ProfileController::class, 'updateLocationPreferences'])->name('customer.profile.location-preferences');
    Route::post('/customer/profile/notification-preferences', [ProfileController::class, 'updateNotificationPreferences'])->name('customer.profile.notification-preferences');
    Route::get('/customer/profile/data', [ProfileController::class, 'getProfileData'])->name('customer.profile.data');
        // Parent password update
        Route::post('/customer/profile/password', [ProfileController::class, 'updatePassword'])->name('customer.profile.password');
});



// Subscription Routes
Route::middleware(['auth'])->group(function () {
    // Subscription checkout flow
    Route::get('/services/{plan}/checkout', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout');
    Route::get('/subscriptions/success/{subscription}', [SubscriptionController::class, 'success'])->name('subscriptions.success');
    Route::get('/subscriptions/cancel/{subscription}', [SubscriptionController::class, 'cancelCheckout'])->name('subscriptions.cancel-checkout');
    
    // Subscription management
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::post('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::post('/subscriptions/{subscription}/enable', [SubscriptionController::class, 'enable'])->name('subscriptions.enable');
    Route::post('/subscriptions/{subscription}/disable', [SubscriptionController::class, 'disable'])->name('subscriptions.disable');
});

// Webhook route (should be excluded from CSRF protection)
Route::post('/stripe/webhook', [SubscriptionController::class, 'webhook'])->name('stripe.webhook');
Route::middleware(RoleMiddleware::class . ':customer')->group(function () {

Route::get('/customer/dashboard', [ParentPanelController::class,'index'])->name('customer-home');


Route::get('/customer/compare', [ParentPanelController::class,'compare'])->name('customer-compare');

Route::get('/customer/reviews', [ParentPanelController::class,'reviews'])->name('customer-reviews');

Route::get('/customer/messages', [ParentPanelController::class,'messages'])->name('customer-messages');

Route::get('/customer/saved-items', [ParentPanelController::class,'saveItems'])->name('customer-saved-items');
});

// Cleaner Routes
Route::get('/cleaner/analytics', fn() => view('panels.provider.analytics'))->name('cleaner-analytics');
Route::get('/cleaner/events', fn() => view('panels.provider.events'))->name('cleaner-events');

Route::get('/cleaner/subscription', [ProviderPanelController::class,'subscription'])->name('cleaner-subscription');

    Route::post('/subscriptions/change-plan/{plan}', [App\Http\Controllers\ProviderPanelController::class, 'changePlan'])->name('subscriptions.change-plan');
    Route::post('/subscriptions/toggle-auto-renewal', [SubscriptionController::class, 'toggleAutoRenewal'])->name('subscriptions.toggle-auto-renewal');
    Route::get('/invoices/{payment}/download', [App\Http\Controllers\ProviderPanelController::class, 'downloadInvoice'])->name('invoices.download');





// Review routes
Route::post('/cleaners/{provider}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::put('/cleaners/{provider}/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update')->middleware('auth');
Route::delete('/cleaners/{provider}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');

// Save/Follow routes
Route::post('/cleaners/{provider}/save', [SavedProviderController::class, 'store'])->name('cleaners.save')->middleware('auth');
Route::post('/cleaners/{provider}/follow', [FollowedProviderController::class, 'store'])->name('cleaners.follow')->middleware('auth');
Route::get('/saved-cleaners', [SavedProviderController::class, 'index'])->name('saved-cleaners.index')->middleware('auth');

Route::delete('/saved-cleaners/{id}/delete', [SavedProviderController::class, 'destroy'])->name('saved-cleaners.destroy')->middleware('auth');

// Compare routes
Route::post('/cleaners/{provider}/compare', [CompareController::class, 'toggle'])->name('cleaners.compare.toggle');
Route::get('/compare/count', [CompareController::class, 'count'])->name('compare.count');
Route::get('/compare/list', [CompareController::class, 'list'])->name('compare.list');
Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

    Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'update'])->name('inquiries.update')->middleware('auth');

// Inquiry routes
Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
// Hire requests from the multi-step "Hire Me" flow (guest-friendly)
Route::post('/hire-requests', [HireRequestController::class, 'store'])->name('hire-requests.store');
// Customer-side views for their hire requests
Route::middleware('auth')->group(function(){
    Route::get('/my-hire-requests', [HireRequestController::class, 'index'])->name('hire-requests.index');
    Route::get('/my-hire-requests/{hireRequest}', [HireRequestController::class, 'show'])->name('hire-requests.show');
});
Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index')->middleware('auth');
Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show')->middleware('auth');
Route::put('/inquiries/{inquiry}', [InquiryController::class, 'update'])->name('inquiries.update')->middleware('auth');
Route::post('/inquiries/{inquiry}/cancel', [InquiryController::class, 'cancel'])->name('inquiries.cancel')->middleware('auth');



 Route::get('/messages', [InquiryController::class, 'index'])->name('messages.index');
    Route::get('/inquiries/{inquiryId}/messages', [InquiryController::class, 'getMessages']);
    Route::post('/inquiries/messages', [InquiryController::class, 'sendMessage']);


Route::get('logout', [HomeController::class,'logout']);


// Admin ROutes

/*Route::get('/admin/dashboard', fn() => view('panels.admin.index'))->name('admin-home');
Route::get('/admin/analytics', fn() => view('panels.admin.analytics'))->name('admin-analytics');
// Admin content-management is handled by admin routes (see routes/admin.php)
Route::get('/admin/events', fn() => view('panels.admin.events'))->name('admin-events');
Route::get('/admin/integrations', fn() => view('panels.admin.integrations'))->name('admin-integrations');
Route::get('/admin/parents', fn() => view('panels.admin.parents'))->name('admin-parents');
Route::get('/admin/pricing', fn() => view('panels.admin.pricing'))->name('admin-pricing');
use App\Http\Controllers\Admin\ProvidersAdminController;

Route::get('/admin/providers', [ProvidersAdminController::class, 'index'])->name('admin-providers');
Route::get('/admin/reviews', fn() => view('panels.admin.reviews'))->name('admin-reviews');
Route::get('/admin/settings', fn() => view('panels.admin.settings'))->name('admin-settings');*/

Auth::routes();

Route::prefix('cleaner')->middleware(RoleMiddleware::class . ':cleaner')->group(function () {
    Route::get('/listing/profile', [ServiceListingController::class, 'index'])->name('cleaner.listings.profile');
    Route::put('/listing/profile/{id}/update', [ServiceListingController::class, 'update'])->name('cleaner.listings.update');
    // Provider hire requests assigned to this cleaner
    Route::get('/hire-requests', [App\Http\Controllers\Provider\HireRequestController::class, 'index'])->name('cleaner.hire-requests');

});




Route::post('/register/parent', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.parent');
Route::post('/register/provider', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.provider');

// Eircode check used by provider signup flow (AJAX)
Route::post('/check-eircode', [EircodeController::class, 'check'])->name('check.eircode');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


require __DIR__ . '/admin.php';
require __DIR__ . '/cms.php';
require __DIR__ . '/cleaner.php';
