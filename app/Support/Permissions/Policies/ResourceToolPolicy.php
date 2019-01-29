<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\ResourceTool;
use Illuminate\Foundation\Auth\User;

abstract class ResourceToolPolicy extends Policy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\ResourceTool        $tool
     *
     * @return mixed
     */
    public function canSee(User $user, ResourceTool $tool)
    {
        //
    }
}