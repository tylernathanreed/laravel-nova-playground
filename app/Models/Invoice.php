<?php

namespace App\Models;

class Invoice extends Model
{
    /**
     * Returns all of the items that belong to this invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}