<?php

namespace NovaComponents\ActionGearbox;

use Laravel\Nova\Http\Requests\ActionRequest as NovaActionRequest;

class ActionRequest extends NovaActionRequest
{
    /**
     * Get the action instance specified by the request.
     *
     * @return \Laravel\Nova\Actions\Action
     */
    public function action()
    {
        return once(function () {
            return $this->availableActions()->flattenActionGroups()->first(function ($action) {
                return $action->uriKey() == $this->query('action');
            }) ?: abort($this->actionExists() ? 403 : 404);
        });
    }

    /**
     * Determine if the specified action exists at all.
     *
     * @return bool
     */
    protected function actionExists()
    {
        $actions = $this->isPivotAction()
                    ? $this->newResource()->resolvePivotActions($this)
                    : $this->newResource()->resolveActions($this);

        return $actions->flattenActionGroups()->contains(function ($action) {
            return $action->uriKey() == $this->query('action');
        });
    }
}