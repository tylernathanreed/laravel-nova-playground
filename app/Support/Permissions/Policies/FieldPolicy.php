<?php

namespace App\Support\Permissions\Policies;

use Laravel\Nova\Fields\Field;
use Illuminate\Foundation\Auth\User;

abstract class FieldPolicy extends ElementPolicy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Laravel\Nova\Fields\Field        $field
     *
     * @return mixed
     */
    public function canSee(User $user, Field $field)
    {
        //
    }
}