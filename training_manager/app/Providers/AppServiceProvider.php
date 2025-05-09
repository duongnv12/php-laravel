<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Progress;
use App\Observers\ProgressObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Đăng ký observer cho Progress
        Progress::observe(ProgressObserver::class);
    }
}
