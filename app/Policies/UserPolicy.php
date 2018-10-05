<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends ResourcePolicy
{
    /**
     * Determine whether the user can add a post to the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function addPost(User $user, User $model)
    {
        return ! $user->isBlockedFrom('user.addPost.'.$model->id);
    }
}