<?php

namespace NovaComponents\ActionGearbox\Actions\Concerns;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

trait InjectsViaManyToMany
{
	/**
	 * Injects the relationship type into the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 *
	 * @return \Illuminate\Http\Request
	 */
	public function injectViaManyToMany(Request $request)
	{
		// Make sure the relationship type is not already present
		if($request->has('viaManyToMany')) {
			return $request;
		}

		// Make sure the request has the information required to inject
		if(is_null($relationshipType = $request->relationshipType)) {
			return $request;
		}

		// Inject via many to many
        $request['viaManyToMany'] = $request->viaManyToMany == 'belongsToMany' || $request->viaManyToMany == 'morphToMany';

        // Return the request
        return $request;
    }
}