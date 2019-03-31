<?php

namespace Betalectic\Car;

use Illuminate\Support\ServiceProvider;

class CarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // $this->app->singleton(RegistrableObserver::class, function($app) {
        //     return new RegistrableObserver(new Permiso);
        // });
    }
}
