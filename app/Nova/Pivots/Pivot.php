<?php

namespace App\Nova\Pivots;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;

abstract class Pivot
{
	/**
	 * The resources associated to this pivot.
	 *
	 * @var array
	 */
	public static $resources = [];

	/**
	 * Creates and returns a new pivot instance.
	 *
	 * @param  string       $label
	 * @param  string|null  $attribute
	 * @param  string|null  $resource
	 *
	 * @return \Laravel\Nova\Fields\BelongsToMany
	 */
	public static function make($label, $attribute = null, $resource = null)
	{
		return static::newBelongsToManyField($label, $attribute, $resource)
			->fields(function($request) {
				return (new static)->fields($request);
        	})
            ->actions(function($request) {
            	return (new static)->actions($request);
            });
	}

    /**
     * Creates and returns a new belongs to many field.
     *
     * @param  string       $label
     * @param  string|null  $attribute
     * @param  string|null  $resource
     *
     * @return \Laravel\Nova\Fields\BelongsToMany
     */
	protected static function newBelongsToManyField($label, $attribute = null, $resource = null)
	{
		return new BelongsToMany($label, $attribute, $resource);
	}

    /**
     * Returns the fields displayed by the pivot.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [];
    }

    /**
     * Returns the actions available for the pivot.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}