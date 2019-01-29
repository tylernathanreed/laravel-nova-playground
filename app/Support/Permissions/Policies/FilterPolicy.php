<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\Filters\Filter;
use Illuminate\Foundation\Auth\User;

abstract class FilterPolicy extends Policy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Filters\Filter      $filter
     *
     * @return mixed
     */
    public function canSee(User $user, Filter $filter)
    {
        //
    }
}