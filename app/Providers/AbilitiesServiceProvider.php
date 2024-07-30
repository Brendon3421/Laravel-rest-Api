<?php

namespace App\Providers;

use App\Services\AbilitiesServices;
use Illuminate\Support\ServiceProvider;

class AbilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AbilitiesServices::class, function ($app) {
            return new AbilitiesServices();
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
