<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

class MarketingRedirectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Listen for login events
        Event::listen(Login::class, function ($event) {
            // Check if the referer URL contains 'marketing'
            $referer = request()->headers->get('referer');
            if ($referer && str_contains($referer, 'marketing')) {
                session(['redirect_to_marketing' => true]);
            }
        });
    }
} 