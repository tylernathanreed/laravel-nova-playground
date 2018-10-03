<?php

namespace App\Models;

class Tag extends Model
{
    /**
     * Returns the posts associated to this tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable')->withPivot('notes');
    }
}