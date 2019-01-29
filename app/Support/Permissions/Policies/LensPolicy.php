<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\Lenses\Lens;
use Illuminate\Foundation\Auth\User;

abstract class LensPolicy extends Policy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Lenses\Lens         $lens
     *
     * @return mixed
     */
    public function canSee(User $user, Lens $lens)
    {
        //
    }
}