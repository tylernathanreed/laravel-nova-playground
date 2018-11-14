<?php

namespace NovaComponents\ActionGearbox;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use NovaComponents\ActionGearbox\Http\Middleware\Authorize;

class ActionGearboxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('action-gearbox', __DIR__.'/../dist/js/action-gearbox.js');
            Nova::style('action-gearbox', __DIR__.'/../dist/css/action-gearbox.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
