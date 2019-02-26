<?php

namespace App\Nova\Lenses;

use DB;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\LensRequest;

class MostValueableUsers extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->select(['users.id', 'users.name', DB::raw('sum(licenses.price) as revenue')])
                  ->join('users', 'users.id', '=', 'licenses.user_id')
                  ->orderBy('revenue', 'desc')
                  ->groupBy('users.id', 'users.name')
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id')->sortable(),
            Text::make('Name', 'name')->sortable(),
            Number::make('Revenue', 'revenue', function($value) {
                return '$' . number_format($value, 2);
            })
        ];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
        ];
    }
}