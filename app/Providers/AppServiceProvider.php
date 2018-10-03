<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register the dusk service provider in appropriate environments
        $this->registerDuskServiceProvider();
    }

    /**
     * Registers the dusk service provider in appropriate environments.
     *
     * @return void
     */
    protected function registerDuskServiceProvider()
    {
        // Make sure the environment is appropriate
        if(!$this->app->environment('local', 'testing')) {
            return;
        }

        // Register the dusk service provider
        $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
    }
}
