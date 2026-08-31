<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // 1. If forwarded by Ngrok / Reverse Proxy, force full Root URL and HTTPS
        if (request()->hasHeader('X-Forwarded-Host')) {
            $forwardedHost = request()->header('X-Forwarded-Host');
            $forwardedProto = request()->header('X-Forwarded-Proto', 'https');
            
            URL::forceRootUrl("{$forwardedProto}://{$forwardedHost}");
            URL::forceScheme($forwardedProto);
        } elseif (str_contains(request()->getHost(), 'ngrok') || request()->isSecure()) {
            URL::forceScheme('https');
        }
    }
}
