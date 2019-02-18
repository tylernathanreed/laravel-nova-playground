<?php

namespace NovaComponents\ActionGearbox\Actions;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class View extends Action
{
    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Details';

    /**
     * The dusk name of the action.
     *
     * @var string|null
     */
    public $dusk = 'view';

    /**
     * The icon associated to this action.
     *
     * @var string|null
     */
    public $icon = 'view';

    /**
     * The size of the icon.
     *
     * @var array|null
     */
    public $iconSize = [22, 16];

    /**
     * The url to redirect the user to.
     *
     * @var string|array|null
     */
    public $to = [
        'name' => 'detail',
        'params' => [
            'resourceName' => '{{resourceName}}',
            'resourceId' => '{{resourceId}}'
        ]
    ];

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

        // Make sure the user is authorized to view the resource
        if(!$resource->authorizedToView($request)) {
            return false;
        }

        // Return the parent result
        return parent::authorizedToSeeIndividual($request, $model);
    }
}