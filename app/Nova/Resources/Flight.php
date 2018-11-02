<?php

namespace App\Nova\Resources;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Otwell\CustomField\CustomField;
use Reedware\NovaValueToggle\ValueToggle;

class Flight extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Flight::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Returns the displayable icon of the resource.
     *
     * @return string
     */
    public static function icon()
    {
        return '<i class="fas fa-plane-departure sidebar-icon"></i>';
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
            ID::make('ID', 'id')->sortable(),
            CustomField::make('Name', 'name')->sortable()->rules('required'),
            Select::make('Lands On', 'lands_on')->options([
                'land' => 'Land',
                'water' => 'Water'
            ]),
            // Number::make('Wheel Count', 'wheel_count')->min(1)->max(1000)->step(1)
            ValueToggle::make(Number::make('Wheel Count', 'wheel_count')->min(1)->max(1000)->step(1), function($toggle) {
                return $toggle->where('lands_on', '=', 'land');
            }),
            // Number::make('Wheel Count', 'wheel_count')->min(1)->max(1000)->step(1)
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