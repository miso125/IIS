<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    protected $table = 'treatment';
    protected $primaryKey = 'id_treatment';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'wine_row',
        'user',
        'date_time',
        'type',
        'treatment_product',
        'concentration',
        'notes',
    ];

    public function winerow(): BelongsTo
    {
        return $this->belongsTo(WineyardRow::class, 'wine_row', 'id_row');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user', 'login');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('date_time', '>=', now()->subDays($days));
    }
}

