<?php

namespace NovaComponents\ActionGearbox\Actions\Concerns;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

trait AuthorizesIndividualUsingRequest
{
	/**
	 * Returns whether or not the user is authorized to see the individual resource within the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 *
	 * @return boolean|null
	 */
	public function authorizedToSeeIndividualUsingRequest(Request $request)
	{
		// Make sure the request is for a single resource
		if(!$request->has('resourceId') || is_null($request->resource)) {
			return null;
		}

        // Determine the model
        $model = Nova::modelInstanceForKey($request->resource)->findOrFail($request->resourceId);

		// Return the result from individual authorization
		return $this->authorizedToSeeIndividual($request, $model);

    }
}