<?php

namespace NovaComponents\ActionGearbox\Actions;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class EditAttached extends Action
{
    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Edit Attached';

    /**
     * The dusk name of the action.
     *
     * @var string|null
     */
    public $dusk = 'edit-attached';

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
        'name' => 'edit-attached',
        'params' => [
            'resourceName' => '{{viaResource}}',
            'resourceId' => '{{viaResourceId}}',
            'relatedResourceName' => '{{resourceName}}',
            'relatedResourceId' => '{{resourceId}}'
        ],
        'query' => [
            'viaRelationship' => '{{viaRelationship}}'
        ]
    ];

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