<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WineBatch extends Model
{
    protected $table = 'winebatch';
    protected $primaryKey = 'batch_number';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'harvest',
        'vintage',
        'variety',
        'sugariness',
        'alcohol_percentage',
        'number_of_bottles',
        'price',
        'date_time',
    ];
    /**
     * Definitions of relationships
     */

    public function harvestDetail(): BelongsTo
    {
        return $this->belongsTo(Harvest::class, 'harvest', 'id_harvest');
    }

    public function purchaseitems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'wine_batch', 'batch_number');
    }

    public function scopeHighAlcohol($query, $percent = 13)
    {
        return $query->where('alcohol_percentage', '>=', $percent);
    }

    public function scopeFromYear($query, $year)
    {
        return $query->where('vintage', $year);
    }
}
