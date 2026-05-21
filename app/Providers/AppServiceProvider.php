<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        if (str_contains(config('app.url'), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }

        // Set session lifetime dynamically from settings in database
        if (Schema::hasTable('settings')) {
            $lifetime = \App\Models\Setting::get('masaKadaluarsaSesi', 120);
            config(['session.lifetime' => (int) $lifetime]);
        }
    }
}
