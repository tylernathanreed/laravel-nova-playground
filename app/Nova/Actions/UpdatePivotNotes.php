<?php

namespace App\Nova\Actions;

use Laravel\Nova\Fields\Text;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;

class UpdatePivotNotes extends Action
{
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->forceFill(['notes' => $fields->notes ?? 'Pivot Action Notes'])->save();
        }
    }

    /**
     * Returns the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            \App\Nova\Pivots\UserRole::makeNotesField()
        ];
    }
}