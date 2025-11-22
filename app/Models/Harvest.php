<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    public function winerow(): BelongsTo
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
