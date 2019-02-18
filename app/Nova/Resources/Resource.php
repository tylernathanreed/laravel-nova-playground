<?php

namespace App\Nova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Resource as NovaResource;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaComponents\ActionGearbox\HasGearboxActions;

abstract class Resource extends NovaResource
{
    use HasGearboxActions;

    /**
     * The relationship counts that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $withCount = [];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount(static::$withCount);
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * Returns meta data information about this resource for client side consumption.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public static function information(Request $request)
    {
        return [
            'uriKey' => static::uriKey(),
            'label' => static::label(),
            'singularLabel' => static::singularLabel(),
            'authorizedToCreate' => static::authorizedToCreate($request),
            'searchable' => static::searchable(),
            'icon' => 'asdf'
        ];
    }
}
