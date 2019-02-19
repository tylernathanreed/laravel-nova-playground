<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;

class ActiveUsers extends Filter
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
        // Check for only active users
        if($value == 'only-active') {
            return $query->where('active', '=', 1);
        }

        // Use inactive users
        return $query->where(function($query) {
            $query->where('active', '=', 0)->orWhereNull('active');
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return array_flip([
            'only-active' => 'Only Active Users',
            'only-inactive' => 'Only Inactive Users'
        ]);
    }
}