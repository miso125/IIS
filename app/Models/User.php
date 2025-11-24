<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

// TODO continue to english
class User extends Authenticable
{
    use HasRoles;
    protected $table = 'user';
    protected $primaryKey = 'login';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guard_name = 'web';
    public $timestamps = false;
    protected $fillable = [
        'login',
        'password_hash',
        'email',
        'name',
        'last_name',
        'address',
        'role',
        'is_active',
        'date_of_registration',
    ];
    protected $casts = [
        'date_of_registration' => 'datetime', // Converts string to Carbon object
        'is_active' => 'boolean',              // Converts 0/1 to false/true
    ];
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }
    /**
     * Definitions of relationships
     */
    public function wineyardrows(): HasMany
    {
        return $this->hasMany(WineyardRow::class, 'user', 'login');
    }

    public function harvests(): HasMany
    {
        return $this->hasMany(Harvest::class, 'user', 'login');
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class, 'user', 'login');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'user', 'login');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}
