<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ReviewAnalysisService;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ReviewAnalysisService::class, function ($app) {
            return new ReviewAnalysisService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            Paginator::useBootstrapFive();

    }
}
