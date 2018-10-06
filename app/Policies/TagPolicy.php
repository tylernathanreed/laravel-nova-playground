<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;

class TagPolicy extends ResourcePolicy
{
    /**
     * Determine whether the user can view any tags.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return ! $user->isBlockedFrom('tag.viewAny');
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function view(User $user, $tag)
    {
        return ! $user->isBlockedFrom('tag.view.'.$tag->id);
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ! $user->isBlockedFrom('tag.create');
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function update(User $user, $tag)
    {
        return ! $user->isBlockedFrom('tag.update.'.$tag->id);
    }

    /**
     * Determine whether the user can add a comment to the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function addComment(User $user, Tag $tag)
    {
        return ! $user->isBlockedFrom('tag.addComment.'.$tag->id);
    }

    /**
     * Determine whether the user can attach any post to the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function attachAnyPost(User $user, Tag $tag)
    {
        return ! $user->isBlockedFrom('tag.attachAnyPost.'.$tag->id);
    }

    /**
     * Determine whether the user can attach a post to the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @param  \App\Post  $post
     * @return mixed
     */
    public function attachPost(User $user, Tag $tag, Post $post)
    {
        return ! $user->isBlockedFrom('tag.attachPost.'.$tag->id);
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function delete(User $user, $tag)
    {
        return ! $user->isBlockedFrom('tag.delete.'.$tag->id);
    }

    /**
     * Determine whether the user can restore the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function restore(User $user, $tag)
    {
        return ! $user->isBlockedFrom('tag.restore.'.$tag->id);
    }

    /**
     * Determine whether the user can force delete the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function forceDelete(User $user, $tag)
    {
        return ! $user->isBlockedFrom('tag.forceDelete.'.$tag->id);
    }
}