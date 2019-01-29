<?php

namespace App\Support\Permissions\Policies;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class ResourcePolicy extends Policy
{
    /**
     * Returns whether the user can view any resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Returns whether the user can view trashed resources.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     *
     * @return mixed
     */
    public function viewTrashed(User $user)
    {
        //
    }

    /**
     * Returns whether the user can view the specified resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function view(User $user, Model $model)
    {
        //
    }

    /**
     * Returns whether the user can create a new resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Returns whether the user can update the specified resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function update(User $user, Model $model)
    {
        //
    }

    /**
     * Returns whether the user can delete the specified resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        //
    }

    /**
     * Returns whether the user can restore the specified resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function restore(User $user, Model $model)
    {
        //
    }

    /**
     * Returns whether the user can forceDelete the specified resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, Model $model)
    {
        //
    }

    /**
     * Returns whether the user can add the specified (other) resource to the given resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Illuminate\Database\Eloquent\Model  $other
     *
     * @return mixed
     */
    public function add(User $user, Model $model, Model $other)
    {
        //
    }

    /**
     * Returns whether the user can attach any (other) resource to the specified resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function attachAny(User $user, Model $model)
    {
        //
    }

    /**
     * Returns whether the user can attach the specified (other) resource to the given resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Illuminate\Database\Eloquent\Model  $other
     *
     * @return mixed
     */
    public function attach(User $user, Model $model, Model $other)
    {
        //
    }

    /**
     * Returns whether the user can detatch the specified (other) resource from the given resource.
     *
     * @param  \Illuminate\Foundation\Auth\User     $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Illuminate\Database\Eloquent\Model  $other
     *
     * @return mixed
     */
    public function detatch(User $user, Model $model, Model $other)
    {
        //
    }

    /**
     * Filters the specified index query using the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     *
     * @return mixed
     */
    public function indexQuery(NovaRequest $request, $query)
    {
        //
    }

    /**
     * Filters the specified relatable query using the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     *
     * @return mixed
     */
    public function relatableQuery(NovaRequest $request, $query)
    {
        //
    }

    /**
     * Filters the specified scout query using the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     *
     * @return mixed
     */
    public function scoutQuery(NovaRequest $request, $query)
    {
        //
    }
}