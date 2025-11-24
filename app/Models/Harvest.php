<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Harvest
 *
 * Represents a single harvest entry in the winery system.
 *
*/
class Harvest extends Model
{
    use HasFactory;
    protected $table = 'harvest';
    protected $primaryKey = 'id_harvest';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'wine_row',
        'user',
        'weight_grapes',
        'variety',
        'sugariness',
        'date_time',
        'status',
        'notes',
    ];
    protected $casts = [
        'date_time' => 'datetime', // Converts string to Carbon object
    ];
    /**
     * Definitions of relationships
     */

    public function wineyardrow(): BelongsTo
    {
        return $this->belongsTo(WineyardRow::class, 'wine_row', 'id_row');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user', 'login');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(WineBatch::class, 'harvest', 'id_harvest');
    }

    public function scopeFromYear($query, $year)
    {
        return $query->whereYear('date_time', $year);
    }
}
