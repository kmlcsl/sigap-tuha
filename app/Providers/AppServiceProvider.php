<?php

namespace App\Providers;

use App\Models\PendataanLansia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // Route model binding: {lansia} di URL merujuk ke PendataanLansia
        Route::model('lansia', PendataanLansia::class);
    }
}
