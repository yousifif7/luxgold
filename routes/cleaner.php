<?php
use App\Http\Controllers\ProviderPanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InquiryController;

Route::prefix('cleaner')->middleware(['auth', 'role:cleaner'])->group(function () {
    Route::get('/dashboard', [ProviderPanelController::class, 'index'])->name('cleaner-home');
    Route::get('/dashboard/performance-data', [DashboardController::class, 'getPerformanceData'])->name('dashboard.performance-data');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('cleaner-profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    // Other cleaner routes...
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('cleaner-inquiries');
});