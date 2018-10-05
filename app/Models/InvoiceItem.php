<?php

namespace App\Models;

class InvoiceItem extends Model
{
    /**
     * Returns the invoice that this item belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}