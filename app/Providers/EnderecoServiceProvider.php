<?php

namespace App\Providers;

use App\Services\EnderecoServices;
use Illuminate\Support\ServiceProvider;

class EnderecoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EnderecoServices::class, function ($app) {
            return new EnderecoServices();
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
