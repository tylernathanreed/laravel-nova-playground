<?php

namespace NovaComponents\ActionGearbox;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\ActionRequest;

class DeleteResourceAction extends Action
{
    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Delete';

    /**
     * Execute the action for the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\ActionRequest  $request
     *
     * @return mixed
     *
     * @throws \Laravel\Nova\Exceptions\MissingActionHandlerException
     */
    public function handleRequest(ActionRequest $request)
    {
        $response = [
            'url' => '/nova-api/' . $request->resource()::uriKey(),
            'method' => 'delete',
            'params' => [
                'resources' => $request->get('resources'),
                'search' => $request->get('search'),
                'filters' => $request->get('filters'),
                'trashed' => $request->get('trashed'),
                'viaResource' => $request->get('viaResource'),
                'viaResourceId' => $request->get('viaResourceId'),
                'viaRelationship' => $request->get('viaRelationship')
            ]
        ];

        return [
            'request' => $response
        ];
    }
}