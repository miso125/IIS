<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

// TODO continue to english
class User extends Model
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
        'isActive',
        'date_of_registration',
    ];

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
        return $query->where('isActive', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}
