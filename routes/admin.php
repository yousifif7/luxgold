<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\ProvidersAdminController;



Route::prefix('admin')->middleware(RoleMiddleware::class . ':admin')->group(function () {

    // Dashboard: use dedicated controller so we can pass realtime stats

      Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-home');
    // Content management (homepage hero, resources, etc.)
    Route::get('content-management', [ContentController::class, 'index'])->name('admin.content-management');
  // Promotions (hero/banner campaigns)
  Route::resource('promotions', PromotionController::class, ['as' => 'admin']);
    Route::get('realtime-feed', [DashboardController::class, 'realtimeFeed'])->name('admin.realtime.feed');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
    // Admin quick actions: inquiries and payments
  Route::delete('inquiries/{id}', [DashboardController::class, 'deleteInquiry'])->name('admin.inquiries.delete');
  Route::post('inquiries/{id}/resolve', [DashboardController::class, 'resolveInquiry'])->name('admin.inquiries.resolve');
  // Admin: list all inquiries with stats
  Route::get('inquiries', [DashboardController::class, 'inquiriesIndex'])->name('admin.inquiries.index');
  Route::get('payments/export', [DashboardController::class, 'exportPaymentsCSV'])->name('admin.payments.export');
  // Transaction log (paginated view)
  Route::get('payments', [DashboardController::class, 'paymentsIndex'])->name('admin.payments.index');
  // Admin support tickets
  Route::get('support', [App\Http\Controllers\Admin\SupportController::class, 'index'])->name('admin.support.index');
  Route::get('support/{id}', [App\Http\Controllers\Admin\SupportController::class, 'show'])->name('admin.support.show');
  Route::get('support/{id}/messages', [App\Http\Controllers\Admin\SupportMessageController::class, 'index']);
  Route::post('support/{id}/messages', [App\Http\Controllers\Admin\SupportMessageController::class, 'store']);
  Route::post('support/{id}/status', [App\Http\Controllers\Admin\SupportController::class, 'updateStatus'])->name('admin.support.status');
  Route::delete('support/{id}', [App\Http\Controllers\Admin\SupportController::class, 'destroy'])->name('admin.support.destroy');
    // Admin settings
    Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::put('settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('settings/users', [SettingsController::class, 'storeUser'])->name('admin.settings.users.store');
    Route::put('settings/users/{id}', [SettingsController::class, 'updateUser'])->name('admin.settings.users.update');
    Route::delete('settings/users/{id}', [SettingsController::class, 'deleteUser'])->name('admin.settings.users.delete');
    Route::post('settings/templates', [SettingsController::class, 'storeTemplate'])->name('admin.settings.templates.store');
    Route::put('settings/templates/{index}', [SettingsController::class, 'updateTemplate'])->name('admin.settings.templates.update');
    Route::delete('settings/templates/{index}', [SettingsController::class, 'deleteTemplate'])->name('admin.settings.templates.delete');
    
    // Admin analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');
    Route::get('analytics/reviews', [AnalyticsController::class, 'reviews'])->name('admin.analytics.reviews');

    // Admin categories & services
    Route::resource('categories', CategoryController::class, ['as'=>'admin']);
    Route::resource('services', ServiceController::class, ['as'=>'admin']);
    // Admin providers (CRUD)
    // Public admin providers landing (uses analytics-style panel)
    Route::get('providers', [ProvidersAdminController::class, 'index'])->name('admin.providers.index');
    // Export providers CSV (analytics / reports) - keep custom routes BEFORE resource to avoid being captured by the {provider} wildcard
    Route::get('providers/export', [ProvidersAdminController::class, 'export'])->name('admin.providers.export');
    // Register resource routes but exclude the index (we provide a dedicated admin landing)
    Route::resource('providers', ProviderController::class, ['as'=>'admin'])->except(['index']);

    Route::post('providers/{provider}/status', [ProviderController::class, 'updateStatus'])->name('admin.providers.status');
    Route::post('providers/bulk-action', [ProviderController::class, 'bulkAction'])->name('admin.providers.bulk-action');
    Route::get('providers/stats', [ProviderController::class, 'getStats'])->name('admin.providers.stats');
    // Admin parents
    Route::resource('parents', ParentController::class, ['as'=>'admin']);
    // Admin pricing / plans
    Route::resource('pricing', PricingController::class, ['as'=>'admin']);
    // Admin reviews (CRUD + moderation)
    Route::resource('reviews', ReviewController::class, ['as' => 'admin']);
    Route::post('reviews/{review}/action', [ReviewController::class, 'action'])->name('admin.reviews.action');
    Route::post('reviews/bulk/approve', [ReviewController::class, 'bulkApprove'])->name('admin.reviews.bulk.approve');
    Route::get('reviews/{review}/history', [ReviewController::class, 'history'])->name('admin.reviews.history');
    // Admin: create subscription on behalf of a parent
    Route::post('parents/{parent}/subscriptions', [ParentController::class, 'storeSubscription'])->name('admin.parents.subscriptions.store');
    // Admin: delete a subscription
    Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('admin.subscriptions.destroy');
    
    // (Integrations removed — Stripe only)

   


});

Route::middleware(['role:admin,provider'])->group(function () {

 // Admin events (use existing EventController)
    Route::get('user/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('user/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::get('user/events/{id}', [EventController::class, 'show'])->name('admin.events.show');
    Route::get('user/events/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('user/events/{id}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('user/events/{id}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    Route::post('user/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('user/events/{id}/approve', [EventController::class, 'approve'])->name('admin.events.approve');
    Route::get('user/events/{id}/reject', [EventController::class, 'reject'])->name('admin.events.reject');


   


});

?>