<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\Actions\Action;
use Illuminate\Foundation\Auth\User;

abstract class ActionPolicy extends Policy
{
    /**
     * Returns whether the user can see the specified action.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Actions\Action      $action
     *
     * @return mixed
     */
    public function canSee(User $user, Action $action)
    {
        //
    }

    /**
     * Returns whether the user can run the specified action.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Actions\Action      $action
     *
     * @return mixed
     */
    public function canRun(User $user, Action $action)
    {
        //
    }
}