<?php

namespace NovaComponents\ActionGearbox\Actions;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action as NovaAction;

class Action extends NovaAction
{
    /**
     * The dusk name of the action.
     *
     * @var string|null
     */
    public $dusk = null;

    /**
     * The icon associated to this action.
     *
     * @var string|null
     */
    public $icon = null;

    /**
     * The size of the icon.
     *
     * @var array|null
     */
    public $iconSize = null;

    /**
     * The size of the box.
     *
     * @var array|null
     */
    public $iconBox = null;

    /**
     * The whether or not this action is destructive.
     *
     * @var boolean|null
     */
    public $destructive = null;

    /**
     * The endpoint for the form submission.
     *
     * @var string|null
     */
    public $endpoint = null;

    /**
     * The http request method used to submit the form.
     *
     * @var string|null
     */
    public $method = null;

    /**
     * The url to redirect the user to.
     *
     * @var string|array|null
     */
    public $to = null;

    /**
     * The heading for the action form.
     *
     * @var string|null
     */
    public $heading = null;

    /**
     * The prompt for the action form.
     *
     * @var string|null
     */
    public $prompt = null;

    /**
     * The cancel button text for the action form.
     *
     * @var string|null
     */
    public $cancelButtonText = null;

    /**
     * The submit button text for the action form.
     *
     * @var string|null
     */
    public $submitButtonText = null;

    /**
     * Whether or not this action can be performed without selecting a resource.
     *
     * @var boolean
     */
    public $availableWithoutResourceSelection = false;

    /**
     * Whether or not this action is available for an individual resource.
     *
     * @var boolean
     */
    public $availableForIndividualResource = true;

    /**
     * Whether or not this action is available for a selection of multiple resources.
     *
     * @var boolean
     */
    public $availableForMultipleResources = true;

    /**
     * The callback used to authorize viewing the action for an individual resource.
     *
     * @var \Closure|null
     */
    public $seeIndividualCallback = null;

    /**
     * Sets the icon associated to this action.
     *
     * @param  string|null  $icon
     *
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Sets whether or not this action is destructive.
     *
     * @param  boolean|null  $destructive
     *
     * @return $this
     */
    public function destructive($destructive)
    {
        $this->destructive = $destructive;

        return $this;
    }

    /**
     * Sets the endpoint for the form submission.
     *
     * @param  string|null  $endpoint
     *
     * @return $this
     */
    public function endpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Sets the http request method used to submit the form.
     *
     * @param  string|null  $method
     *
     * @return $this
     */
    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Returns whether or not the action is available for the specified model on the given request.
     *
     * @param  \Illuminate\Http\Request             $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return boolean
     */
    public function authorizedToSeeIndividual(Request $request, $model)
    {
        return $this->seeIndividualCallback ? call_user_func($this->seeIndividualCallback, $request, $model) : true;
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
            'class' => static::class,
            'dusk' => $this->dusk,
            'icon' => $this->icon,
            'iconSize' => $this->iconSize,
            'iconBox' => $this->iconBox,
            'destructive' => !is_null($this->destructive) ? $this->destructive : $data['destructive'],
            'endpoint' => $this->endpoint,
            'method' => $this->method,
            'to' => $this->to,
            'heading' => $this->heading,
            'prompt' => $this->prompt,
            'cancelButtonText' => $this->cancelButtonText,
            'submitButtonText' => $this->submitButtonText,
            'availableForMultipleResources' => $this->availableForMultipleResources,
            'availableForIndividualResource' => $this->availableForIndividualResource
        ]);
    }
}
