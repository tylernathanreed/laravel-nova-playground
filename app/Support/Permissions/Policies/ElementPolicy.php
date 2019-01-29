<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\Element;
use Illuminate\Foundation\Auth\User;

abstract class ElementPolicy extends Policy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Element             $element
     *
     * @return mixed
     */
    public function canSee(User $user, Element $element)
    {
        //
    }
}