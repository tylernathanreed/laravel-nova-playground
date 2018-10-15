<?php

namespace NovaComponents\ValueToggle;

use JsonSerializable;
use Laravel\Nova\Fields\Field;

class ValueToggle extends Field implements JsonSerializable
{
    /**
     * The vue component.
     *
     * @var string
     */
    public $component = 'ValueToggle';

    /**
	 * The field being toggled.
	 *
	 * @var \Laravel\Nova\Fields\Field
     */
    public $field;

    /**
     * The condition in which the field appears.
     *
     * @var string
     */
    public $condition;

    /**
     * Create a new field.
     *
     * @param  \Laravel\Nova\Fields\Field  $field
     * @param  string                      $condition
     *
     * @return void
     */
    public function __construct(Field $field, $condition)
    {
        $this->field = $field;
        $this->condition = $condition;
    }

    /**
     * Prepare the panel for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'component' => $this->component,
            'field' => $this->field,
            'condition' => $this->condition,
        ];
    }
}
