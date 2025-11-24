<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    protected $table = 'purchaseitem';
    protected $primaryKey = 'id_item';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'purchase',
        'wine_batch',
        'number_of_bottles',
        'stock',
        'item_price',
    ];
    /**
     * Definitions of relationships
     */
    public function purchaseDetail(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase', 'id_purchase');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(WineBatch::class, 'wine_batch', 'batch_number');
    }


    public function getTotalPriceAttribute()
    {
        return $this->number_of_bottles * $this->item_price;
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', true);
    }
}
