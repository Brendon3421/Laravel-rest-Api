<?php

namespace App\Providers;

use App\Services\abilityRoleServices;
use Illuminate\Support\ServiceProvider;

class abilityRoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(abilityRoleServices::class, function ($app) {
            return new abilityRoleServices;
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
