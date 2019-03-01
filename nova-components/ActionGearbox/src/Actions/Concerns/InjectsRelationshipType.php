<?php

namespace NovaComponents\ActionGearbox\Actions\Concerns;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

trait InjectsRelationshipType
{
	/**
	 * Injects the relationship type into the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 *
	 * @return \Illuminate\Http\Request
	 */
	public function injectRelationshipType(Request $request)
	{
		// Make sure the relationship type is not already present
		if($request->has('relationshipType')) {
			return $request;
		}

		// Make sure the request has the information required to inject
		if(is_null($viaResource = $request->viaResource) || is_null($viaRelationship = $request->viaRelationship)) {
			return $request;
		}

		// Inject the relationship type
        $request['relationshipType'] = lcfirst(class_basename(Nova::modelInstanceForKey($viaResource)->{$viaRelationship}()));

        // Return the request
        return $request;
    }
}