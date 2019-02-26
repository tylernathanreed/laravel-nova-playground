<?php

namespace NovaComponents\ActionGearbox;

use Laravel\Nova\Nova;
use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaComponents\ActionGearbox\Actions\PivotActionGroup;
use NovaComponents\ActionGearbox\Actions\ResourceActionGroup;

trait ResolvesGearboxActions
{
    /**
     * Returns the actions for the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return \Illuminate\Support\Collection
     */
    public function resolveActions(NovaRequest $request)
    {
        // Determine the gearbox actions
        $actions = $this->getGearboxActions($request);

        // Return the actions
        return new ActionCollection(array_values($this->filter($actions)));
    }

    /**
     * Returns the "pivot" actions for the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return \Illuminate\Support\Collection
     */
    public function resolvePivotActions(NovaRequest $request)
    {
        // If there isn't a relationship, return an empty collection
        if(!$request->viaRelationship()) {
            return new ActionCollection();
        }

        // Determine the gearbox pivot actions
        $actions = $this->getGearboxPivotActions($request);

        // Return the actions
        return new ActionCollection(array_values($this->filter($actions)));
    }

    /**
     * Returns the gearbox actions available on this resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function getGearboxActions(Request $request)
    {
        return array_merge(
            $this->getResourceManagementActions($request),
            [(new ResourceActionGroup($this->getResourceForGearboxActions($request)))->actions($this->actions($request))]
        );
    }

    /**
     * Returns the gearbox pivot actions available on this resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function getGearboxPivotActions(Request $request)
    {
        // Determine the pivot field used for the request
        $pivot = $this->getPivotField($request);

        return array_merge(
            $this->getResourcePivotManagementActions($request),
            [(new PivotActionGroup($pivot->pivotName ?? 'Pivot'))->actions($this->getPivotActions($request))]
        );
    }

    /**
     * Returns the pivot field used for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Laravel\Nova\Fields\Field|null
     */
    public function getPivotField(Request $request)
    {
        return $this->availableFields($request)->first(function($field) use ($request) {
            return isset($field->resourceName) &&
                   $field->resourceName == $request->viaResource;
        });
    }

    /**
     * Returns the resource for the gearbox actions.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Laravel\Nova\Resource
     */
    public function getResourceForGearboxActions(Request $request)
    {
        // If this instance is a resource, return it
        if($this instanceof Resource) {
            return $this;
        }

        // Check for a resource property
        if(property_exists($this, 'resource') && !is_null($resource = $this->resource)) {

            // If the property is a resource, return it
            if($resource instanceof Resource) {
                return $resource;
            }

            // If the resource is a model, derive and return the resource
            if($resource instanceof Model) {
                return Nova::newResourceFromModel($resource);
            }

            // Unknown resource
            return null;

        }

        // Unknown resource
        return null;
    }

    /**
     * Returns the actions for resource management.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function getResourceManagementActions(Request $request)
    {
        return [
            new \NovaComponents\ActionGearbox\Actions\View,
            new \NovaComponents\ActionGearbox\Actions\Edit,
            new \NovaComponents\ActionGearbox\Actions\Delete,
            new \NovaComponents\ActionGearbox\Actions\Restore,
            new \NovaComponents\ActionGearbox\Actions\ForceDelete
        ];
    }

    /**
     * Returns the actions for resource pivot management.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function getResourcePivotManagementActions(Request $request)
    {
        return [
            new \NovaComponents\ActionGearbox\Actions\EditAttached,
            new \NovaComponents\ActionGearbox\Actions\Detach,
        ];
    }
}