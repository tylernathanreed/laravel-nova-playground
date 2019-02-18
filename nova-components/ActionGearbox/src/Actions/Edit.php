<?php

namespace NovaComponents\ActionGearbox\Actions;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class Edit extends Action
{
    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Edit';

    /**
     * The icon associated to this action.
     *
     * @var string|null
     */
    public $icon = 'edit';

    /**
     * The url to redirect the user to.
     *
     * @var string|array|null
     */
    public $to = [
        'name' => 'edit',
        'params' => [
            'resourceName' => '{{resourceName}}',
            'resourceId' => '{{resourceId}}'
        ],
        'query' => [
            'viaResource' => '{{viaResource}}',
            'viaResourceId' => '{{viaResourceId}}',
            'viaRelationship' => '{{viaRelationship}}'
        ]
    ];

    /**
     * Determine if the action should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return boolean
     */
    public function authorizedToSee(Request $request)
    {
        // Make sure the relationship is not a pivot
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

        // Make sure the user is authorized to update the resource
        if(!$resource->authorizedToUpdate($request)) {
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

        // Make sure the user is authorized to update the resource
        if(!$resource->authorizedToUpdate($request)) {
            return false;
        }

        // Return the parent result
        return parent::authorizedToSeeIndividual($request, $model);
    }
}