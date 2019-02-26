<?php

namespace NovaComponents\ActionGearbox\Lenses;

use Laravel\Nova\Resource;
use Illuminate\Support\Arr;

trait GuessesResource
{
    /**
     * Create a new lens instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $resource
     *
     * @return void
     */
    public function __construct($resource = null)
    {
    	// If a resource wasn't provided, try to guess it
    	if(is_null($resource)) {
    		$resource = $this->guessResource();
    	}

    	// Call the parent constructor
    	parent::__construct($resource);
    }

    /**
     * Guesses the resource that created this lens.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function guessResource()
	{
		// Determine the backtrace
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS);

		// Find the call to Resource::lenses()
		$call = Arr::first($backtrace, function($trace) {
			return ($trace['function'] ?? null) == 'lenses' && ($trace['object'] ?? null) instanceof Resource;
		});

		// Make sure the call was made
		if(is_null($call)) {
			return null;
		}

		// Return the resource
		return $call['object']->resource;
	}
}