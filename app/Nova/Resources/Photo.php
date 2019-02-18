<?php

namespace App\Nova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;

class Photo extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Photo::class;

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
        return '<i class="fas fa-camera sidebar-icon"></i>';
    }

    /**
     * Returns the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Photos';
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

            Text::make('Name', 'display_name')->rules('required', 'max:100')->sortable(),

            $this->photoField(),

            Text::make('Original Name')->onlyOnDetail(),

            Text::make('Size', 'size', function($value) {
                return number_format($value / 1024, 2) . 'kb';
            })->onlyOnDetail()
        ];
    }

    /**
     * Returns the photo field.
     *
     * @return \Laravel\Nova\Fields\File
     */
    protected function photoField()
    {
        return Image::make('Photo')
            ->disk('public')
            ->storeOriginalName('original_name')
            ->storeSize('size')
            ->creationRules('required', 'max:1024')
            ->updateRules('max:1024')
            ->prunable();
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
        return [
            // new \App\Nova\Actions\MarkAsActive,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            // new \App\Nova\Filters\Active
        ];
    }
}