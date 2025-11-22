<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $table = 'purchase';
    protected $primaryKey = 'id_purchase';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user',
        'date_time',
        'total_price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user', 'login');
    }


    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'purchase', 'id_purchase');
    }


    public function scopeByUser($query, $login)
    {
        return $query->where('user', $login);
    }

    public function scopeAboveAmount($query, $amount)
    {
        return $query->where('total_price', '>=', $amount);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('date_time', '>=', now()->subDays($days));
    }
}
