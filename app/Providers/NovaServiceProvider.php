<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;
use Laravel\Nova\Cards\Help;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::remoteScript(url('js/manifest.js'));
        Nova::remoteScript(url('js/vendor.js'));
        Nova::remoteScript(url('js/app.js'));

        Nova::provideToScript([
            'resources' => function (Request $request) {

                return collect(Nova::$resources)->map(function ($resource) use ($request) {

                    if(method_exists($resource, 'information')) {
                        return $resource::information($request);
                    }

                    return [
                        'uriKey' => $resource::uriKey(),
                        'label' => $resource::label(),
                        'singularLabel' => $resource::singularLabel(),
                        'authorizedToCreate' => $resource::authorizedToCreate($request),
                        'searchable' => $resource::searchable(),
                    ];

                })->values()->all();

            },
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Help,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {
        Nova::resourcesIn(app_path('Nova\\Resources'));
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
