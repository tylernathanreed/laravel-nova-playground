<?php

namespace App\Nova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsToMany;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'System Settings';

    /**
     * Returns the displayable icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return '<i class="fas fa-user sidebar-icon"></i>';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),

            Boolean::make('Active', 'active')->onlyOnDetail(),

            // ResourceTool::make()->canSee(function ($request) {
            //     return ! $request->user()->isBlockedFrom('resourceTool');
            // }),

            HasMany::make('Posts', 'posts', Post::class),

            \App\Nova\Pivots\UserRole::make('Roles', 'roles', Role::class)
                ->display('display_name')
                ->referToPivotAs('Role Assignment'),

            HasMany::make('Comments', 'comments'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            (new \App\Nova\Metrics\PostCount)->onlyOnDetail(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new \App\Nova\Filters\SelectFirst,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new \App\Nova\Lenses\PassthroughLens,
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new \App\Nova\Actions\MarkAsActive,
            new \App\Nova\Actions\Sleep,
        ];
    }
}
