<?php

namespace App\Providers;

use App\Services\EmpresasServices;
use Illuminate\Support\ServiceProvider;

class EmpresasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EmpresasServices::class,function ($app){
            return new EmpresasServices;
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
