<?php

use App\Http\Controllers\Admin\ContentController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    // Content Management Routes
    Route::get('/content-management', [ContentController::class, 'index'])->name('admin.content-management');
    
    // Hero Content
    Route::post('/hero/update', [ContentController::class, 'updateHero'])->name('admin.hero.update');
    
    
    // Cities
    Route::post('/cities/store', [ContentController::class, 'storeCity'])->name('admin.cities.store');
    Route::put('/cities/update/{id}', [ContentController::class, 'updateCity'])->name('admin.cities.update');
    Route::delete('/cities/{id}', [ContentController::class, 'destroyCity'])->name('admin.cities.destroy');
    
    // Testimonials
    Route::post('/testimonials/store', [ContentController::class, 'storeTestimonial'])->name('admin.testimonials.store');
    Route::put('/testimonials/update/{id}', [ContentController::class, 'updateTestimonial'])->name('admin.testimonials.update');
    Route::delete('/testimonials/{id}', [ContentController::class, 'destroyTestimonial'])->name('admin.testimonials.destroy');
    
    // Resources
    Route::post('/resources/store', [ContentController::class, 'storeResource'])->name('admin.resources.store');
    Route::put('/resources/update/{id}', [ContentController::class, 'updateResource'])->name('admin.resources.update');
    Route::delete('/resources/{id}', [ContentController::class, 'destroyResource'])->name('admin.resources.destroy');
    
    // Bulk Actions
    Route::post('/bulk-action', [ContentController::class, 'bulkAction'])->name('admin.bulk-action');
    
    // Image Upload
    Route::post('/upload-image', [ContentController::class, 'uploadImage'])->name('admin.upload-image');
    
    // Toggle Status
    Route::post('/toggle-status/{id}', [ContentController::class, 'toggleStatus'])->name('admin.toggle-status');
    
    // Search
    Route::post('/search-content', [ContentController::class, 'searchContent'])->name('admin.search-content');
});