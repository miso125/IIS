<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WineyardRow extends Model
{
    protected $table = 'wineyardrow';
    protected $primaryKey = 'id_row';
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'user',
        'variety',
        'number_of_vines',
        'planting_year',
        'colour',
    ];

    protected $casts = [
        'wine_row' => 'winerow',
    ];
    /**
     * Definitions of relationships
     */

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user', 'login');
    }

    public function harvests(): HasMany
    {
        return $this->hasMany(Harvest::class, 'wine_row', 'id_row');
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class, 'wine_row', 'id_row');
    }

    public function scopeByColour($query, $colour)
    {
        return $query->where('colour', $colour);
    }

    public function scopeOlderThan($query, $years)
    {
        return $query->where('planting_year', '<=', now()->year - $years);
    }
}
