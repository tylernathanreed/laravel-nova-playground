<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	use SoftDeletes;

    /**
     * Returns the users associated to this role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id')->withPivot('notes');
    }
}