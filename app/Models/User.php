<?php

namespace App\Models;

use Laravel\Nova\Actions\Actionable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Actionable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'blocked_from' => 'json',
    ];

    /**
     * Store the actions the user should be blocked from.
     *
     * @param  ...string  $block
     *
     * @return void
     */
    public function shouldBlockFrom(...$block)
    {
        $this->forceFill([
            'blocked_from' => collect($block)->mapWithKeys(function ($block) {
                return [$block => true];
            })->all(),
        ])->save();
    }

    /**
     * Determine if the user is blocked from performing the given action.
     *
     * @param  string  $action
     *
     * @return boolean
     */
    public function isBlockedFrom($action)
    {
        return ! empty($this->blocked_from) &&
               array_key_exists($action, $this->blocked_from);
    }

    /**
     * Returns the roles associated to this role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->withPivot('notes');
    }
}
