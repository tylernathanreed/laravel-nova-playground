<?php

namespace NovaComponents\ActionGearbox\Actions;

use Laravel\Nova\Resource;

class ResourceActionGroup extends ActionGroup
{
	/**
	 * The resource providing the actions.
	 *
	 * @var \Laravel\Nova\Resource
	 */
	public $resource;

    /**
     * Creates a new resource action group.
     *
     * @param  \Laravel\Nova\Resource  $resource
     *
     * @return $this
     */
	public function __construct(Resource $resource)
	{
		$this->resource = $resource;

		parent::__construct($resource::singularLabel());
	}
}
