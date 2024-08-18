<?php

namespace App\Providers;

use App\Services\ContatosServices;
use Illuminate\Support\ServiceProvider;

class ContatosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ContatosServices::class,function ($app){
            return new ContatosServices;
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
