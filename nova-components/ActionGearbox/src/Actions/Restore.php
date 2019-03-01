<?php

namespace NovaComponents\ActionGearbox\Actions;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class Restore extends Action
{
    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Restore';

    /**
     * The icon associated to this action.
     *
     * @var string|null
     */
    public $icon = 'restore';

    /**
     * The size of the icon.
     *
     * @var array|null
     */
    public $iconSize = [20, 21];

    /**
     * The endpoint for the form submission.
     *
     * @var string|null
     */
    public $endpoint = '/nova-api/{{resourceName}}/restore';

    /**
     * The http request method used to submit the form.
     *
     * @var string|null
     */
    public $method = 'put';

    /**
     * The heading for the action form.
     *
     * @var string|null
     */
    public $heading = 'Restore Resource';

    /**
     * The prompt for the action form.
     *
     * @var string|null
     */
    public $prompt = 'Are you sure you want to restore this resource?';

    /**
     * The submit button text for the action form.
     *
     * @var string|null
     */
    public $submitButtonText = 'Restore';

    /**
     * Determine if the action should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return boolean
     */
    public function authorizedToSee(Request $request)
    {
        // Inject the required request parameters
        $this->injectRelationshipType($request);
        $this->injectViaManyToMany($request);

        // Make sure the relationship is not a pivot
        if($request->viaManyToMany) {
            return false;
        }

        // Check if the request is for a single resource
        if($this->authorizedToSeeIndividualUsingRequest($request) === false) {
            return false;
        }

        // Return the parent result
        return parent::authorizedToSee($request);
    }

    /**
     * Determine if the action is executable for the given request.
     *
     * @param  \Illuminate\Http\Request             $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return boolean
     */
    public function authorizedToRun(Request $request, $model)
    {
        // Determine the resource from the model
        $resource = Nova::newResourceFromModel($model);

        // Make sure the user is authorized to restore the resource
        if(!$resource->authorizedToRestore($request)) {
            return false;
        }

        // Make sure the resource has been soft deleted
        if(!$resource->isSoftDeleted()) {
            return false;
        }

        // Return the parent result
        return parent::authorizedToRun($request, $model);
    }

    /**
     * Returns whether or not the action is available for the specified model on the given request.
     *
     * @param  \Illuminate\Http\Request             $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return boolean
     */
    public function authorizedToSeeIndividual(Request $request, $model)
    {
        // Determine the resource from the model
        $resource = Nova::newResourceFromModel($model);

        // Make sure the user is authorized to restore the resource
        if(!$resource->authorizedToRestore($request)) {
            return false;
        }

        // Make sure the resource has been soft deleted
        if(!$resource->isSoftDeleted()) {
            return false;
        }

        // Return the parent result
        return parent::authorizedToSeeIndividual($request, $model);
    }
}