<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VonageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            $basic  = new Basic(config('services.vonage.key'), config('services.vonage.secret'));
            return new Client($basic);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
