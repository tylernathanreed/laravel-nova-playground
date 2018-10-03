<?php

namespace App\Models;

class Captain extends Model
{
    /**
     * Get all of the ships that belong to the captain.
     */
    public function ships()
    {
        return $this->belongsToMany(Ship::class, 'ship_captains', 'captain_id', 'ship_id')->withPivot('notes', 'contract');
    }
}