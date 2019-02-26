<?php

namespace NovaComponents\ActionGearbox\Lenses;

use Laravel\Nova\Lenses\Lens as NovaLens;
use NovaComponents\ActionGearbox\ResolvesGearboxActions;

abstract class Lens extends NovaLens
{
    use ResolvesGearboxActions, GuessesResource;
}