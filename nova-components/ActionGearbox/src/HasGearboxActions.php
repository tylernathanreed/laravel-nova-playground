<?php

namespace NovaComponents\ActionGearbox;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaComponents\ActionGearbox\Actions\PivotActionGroup;
use NovaComponents\ActionGearbox\Actions\ResourceActionGroup;

trait HasGearboxActions
{
    /**
     * Prepare the resource for JSON serialization.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Support\Collection|null      $fields
     *
     * @return array
     */
    public function serializeForIndex(NovaRequest $request, $fields = null)
    {
    	// Determine the parent serialization
    	$data = parent::serializeForIndex($request, $fields);

    	// Add and return the additional information
    	return array_merge($data, $this->serializeForActionGearboxIndex($request, $fields));
    }

    /**
     * Prepare the resource for action gearbox JSON serialization.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Support\Collection|null      $fields
     *
     * @return array
     */
    public function serializeForActionGearboxIndex(NovaRequest $request, $fields = null)
    {
    	// Return the serialization
    	return [
    		'authorizedToSee' => $this->getIndividualActionAuthorizations($request)
    	];
    }

    /**
     * Returns the individual action authorizations.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return array
     */
    public function getIndividualActionAuthorizations(NovaRequest $request)
    {
        // Determine the actions that are avaialble for the request
        $actions = $this->availableActions($request);

        // Include the pivot actions that are available for the request
        $actions = $actions->merge($this->availablePivotActions($request));

        // Flatten the action groups
        $actions = $actions->flattenActionGroups();

        // Initialize the authorizations
        $authorizations = [];

        // Iterate through the actions
        foreach($actions as $action) {

            // Add the individual authorization for each action
            $authorizations[$action->uriKey()] = method_exists($action, 'authorizedToSeeIndividual')
                ? $action->authorizedToSeeIndividual($request, $this->resource)
                : true;

        }

        // Return the authorizations
        return $authorizations;
    }

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
            [(new ResourceActionGroup(static::singularLabel()))->actions($this->actions($request))]
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
}