<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Active extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request               $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed                                  $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if($value === 'active') {
            return $query->where('active', '=', 1);
        }

        return $query->where(function($query) {
            $query->where('active', '=', 0)->orWhereNull('active');
        });
    }

    /**
     * Returns the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return array_flip([
            'active' => 'Active',
            'inactive' => 'Inactive'
        ]);
    }
}
