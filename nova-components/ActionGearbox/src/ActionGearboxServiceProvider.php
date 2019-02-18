<?php

namespace NovaComponents\ActionGearbox;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use NovaComponents\ActionGearbox\Http\Middleware\Authorize;
use Laravel\Nova\Http\Requests\ActionRequest as NovaActionRequest;

class ActionGearboxServiceProvider extends ServiceProvider
{
    /**
     * The priority-sorted list of actions.
     *
     * @var array
     */
    public static $actionPriority = [
        \NovaComponents\ActionGearbox\Actions\View::class,
        \NovaComponents\ActionGearbox\Actions\Edit::class,
        \NovaComponents\ActionGearbox\Actions\EditAttached::class,
        \NovaComponents\ActionGearbox\Actions\ResourceActionGroup::class,
        \NovaComponents\ActionGearbox\Actions\PivotActionGroup::class,
        \NovaComponents\ActionGearbox\Actions\Delete::class,
        \NovaComponents\ActionGearbox\Actions\Detach::class,
        \NovaComponents\ActionGearbox\Actions\Restore::class,
        \NovaComponents\ActionGearbox\Actions\ForceDelete::class,
    ];

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

        Nova::provideToScript(['actionPriority' => static::$actionPriority]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->aliasActionRequest();   
    }

    /**
     * Aliases the nova action request to our own action request.
     *
     * @return void
     */
    protected function aliasActionRequest()
    {
        $this->app->alias(ActionRequest::class, NovaActionRequest::class);
    }
}
