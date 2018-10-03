<?php

namespace App\Nova\Pivots;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;

class UserRole extends Pivot
{
    /**
     * The resources associated to this pivot.
     *
     * @var array
     */
    public static $resources = [
        \App\Nova\Resources\User::class,
        \App\Nova\Resources\Role::class,
    ];

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
        return parent::make($label, $attribute, $resource)->prunable();
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
        return [
            static::makeNotesField(),
        ];
    }

    /**
     * Creates and returns a new "notes" field.
     *
     * @return \Laravel\Nova\Fields\Text
     */
    public static function makeNotesField()
    {
        return Text::make('Notes', 'notes')->rules('max:20');
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
        return [
        	new \App\Nova\Actions\UpdatePivotNotes
        ];
    }
}