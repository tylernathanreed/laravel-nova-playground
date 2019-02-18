<?php

namespace NovaComponents\ActionGearbox;

use Illuminate\Support\Collection;
use NovaComponents\ActionGearbox\Actions\ActionGroup;

class ActionCollection extends Collection
{
	/**
	 * Flattens the action groups within this collection.
	 *
	 * @return static
	 */
	public function flattenActionGroups()
	{
        return new static($this->reduce(function($items, $action) {

            // If the action is an action group, add all of the actions to the list
            if($action instanceof ActionGroup) {
                $items = array_merge($items, (new static($action->actions))->flattenActionGroups()->all());
            }

            // Otherwise, just add the action to the list
            else {
                array_push($items, $action);
            }

            // Return the list
            return $items;

        }, []));
	}
}