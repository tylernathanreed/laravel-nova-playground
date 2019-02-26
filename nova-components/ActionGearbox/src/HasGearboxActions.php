<?php

namespace NovaComponents\ActionGearbox;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

trait HasGearboxActions
{
    use ResolvesGearboxActions;

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
}