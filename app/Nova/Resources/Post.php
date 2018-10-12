<?php

namespace App\Nova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Illuminate\Support\HtmlString;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\MorphToMany;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

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
        return '<i class="far fa-newspaper sidebar-icon"></i>';
    }

    /**
     * Returns the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Posts';
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

            BelongsTo::make('User', 'user')->display('name')->rules('required'),

            Text::make('Title', 'title')->sortable()->rules('required'),
            Boolean::make('Active', 'active'),
            Textarea::make('Body', 'body')->rules('required'),

            MorphMany::make('Comments', 'comments'),

            // MorphToMany::make('Tags', 'tags')
            //         ->display('name')
            //         ->fields(function () {
            //             return [
            //                 Text::make('Notes', 'notes')->rules('max:20'),
            //             ];
            //         })->searchable(file_exists(base_path('.searchable'))),
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
        return [
            new \App\Nova\Actions\MarkAsActive,
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
            new \App\Nova\Filters\Active
        ];
    }
}