<?php

namespace NovaComponents\ActionGearbox\Actions;

class ActionGroup extends Action
{
    /**
     * The icon associated to this action group.
     *
     * @var string|null
     */
    public $icon = 'resource';

    /**
     * The actions within this action group.
     *
     * @var array
     */
    public $actions = [];

    /**
     * Creates a new action group.
     *
     * @param  string  $name
     *
     * @return $this
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Sets the actions for this action group.
     *
     * @var array
     *
     * @return $this
     */
    public function actions($actions = [])
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Prepare the action for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        // Determine the parent serialization data
        $data = parent::jsonSerialize();

        // Add additional information
        return array_merge($data, [
            'actions' => $this->actions,
        ]);
    }
}
