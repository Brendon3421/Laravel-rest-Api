<?php

namespace App\Providers;

use App\Services\ContatoEmpresaServices;
use App\Services\EmpresasServices;
use App\Services\EnderecoServices;
use Illuminate\Support\ServiceProvider;

class EmpresasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EmpresasServices::class,function ($app){

           $enderecoServices = $app->make(EnderecoServices::class);
           $ContatoEmpresaServices = $app->make(ContatoEmpresaServices::class);

            return new EmpresasServices($enderecoServices,$ContatoEmpresaServices);
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
