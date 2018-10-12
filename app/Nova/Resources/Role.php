<?php

namespace App\Nova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsToMany;

class Role extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Role::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'display_name', 'system_name'
    ];

    /**
     * The relationship counts that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $withCount = [
        'users'
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
        return '<i class="fas fa-lock sidebar-icon"></i>';
    }

    /**
     * Returns the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id')->sortable(),
            Text::make('Display Name', 'display_name')->sortable(),
            Text::make('System Name', 'system_name')->sortable(),

            Number::make('Users', function() {
                return $this->users_count;
            }),

            \App\Nova\Pivots\UserRole::make('Users', 'users', User::class)->display('name')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }
}