<?php

namespace NovaComponents\ActionGearbox;

use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
	use HasGearboxActions;
}