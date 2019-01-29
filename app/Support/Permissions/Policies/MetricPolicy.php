<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\Metrics\Metric;
use Illuminate\Foundation\Auth\User;

abstract class MetricPolicy extends ElementPolicy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Metrics\Metric      $metric
     *
     * @return mixed
     */
    public function canSee(User $user, Metric $metric)
    {
        //
    }
}