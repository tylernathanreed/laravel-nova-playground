<?php

namespace NovaComponents\ActionGearbox\Actions;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class Delete extends Action
{
    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Delete';

    /**
     * The icon associated to this action.
     *
     * @var string|null
     */
    public $icon = 'delete';

    /**
     * The whether or not this action is destructive.
     *
     * @var boolean|null
     */
    public $destructive = true;

    /**
     * The endpoint for the form submission.
     *
     * @var string|null
     */
    public $endpoint = '/nova-api/{{resourceName}}';

    /**
     * The http request method used to submit the form.
     *
     * @var string|null
     */
    public $method = 'delete';

    /**
     * The heading for the action form.
     *
     * @var string|null
     */
    public $heading = 'Delete Resource';

    /**
     * The prompt for the action form.
     *
     * @var string|null
     */
    public $prompt = 'Are you sure you want to delete this resource?';

    /**
     * The submit button text for the action form.
     *
     * @var string|null
     */
    public $submitButtonText = 'Delete';

    /**
     * Determine if the action should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return boolean
     */
    public function authorizedToSee(Request $request)
    {
        // Make sure the relationship is not many to many
        if($request->relationshipType == 'belongsToMany' || $request->relationshipType == 'morphToMany') {
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

        // Make sure the user is authorized to delete the resource
        if(!$resource->authorizedToDelete($request)) {
            return false;
        }

        // Make sure the resource has not been soft deleted
        if($resource->isSoftDeleted()) {
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

        // Make sure the user is authorized to delete the resource
        if(!$resource->authorizedToDelete($request)) {
            return false;
        }

        // Make sure the resource has not been soft deleted
        if($resource->isSoftDeleted()) {
            return false;
        }

        // Return the parent result
        return parent::authorizedToSeeIndividual($request, $model);
    }
}