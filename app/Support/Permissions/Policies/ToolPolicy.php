<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\Tool;
use Illuminate\Foundation\Auth\User;

abstract class ToolPolicy extends ElementPolicy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Tool                $tool
     *
     * @return mixed
     */
    public function canSee(User $user, Tool $tool)
    {
        //
    }
}