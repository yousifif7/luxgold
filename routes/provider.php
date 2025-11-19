<?php
use App\Http\Controllers\ProviderPanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InquiryController;

Route::prefix('provider')->middleware(['auth', 'role:provider'])->group(function () {
    Route::get('/dashboard', [ProviderPanelController::class, 'index'])->name('provider-home');
    Route::get('/dashboard/performance-data', [DashboardController::class, 'getPerformanceData'])->name('dashboard.performance-data');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('provider-profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    // Other provider routes...
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('provider-inquiries');
});