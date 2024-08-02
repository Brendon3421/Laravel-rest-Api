<?php

namespace App\Providers;

use App\Http\Controllers\Api\AbilityUserService;
use App\Services\AbilityUserServices;
use Illuminate\Support\ServiceProvider;

class AbilityUserProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AbilityUserServices::class,function ($app){
            return new AbilityUserServices;
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
