<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WineBatch;

class WineBatchPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Všetci môžu vidieť dostupné vína
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view winebatch');
    }

    public function view(User $user, WineBatch $varka): bool
    {
        return $user->hasPermissionTo('view winebatch');
    }

    /**
     * Len vinári môžu vytvárať nové dávky vína
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create winebatch');
    }

    /**
     * Len vinár-vlastník sklizne môže editovať
     */
    public function update(User $user, WineBatch $winebatch): bool
    {
        return $user->hasPermissionTo('edit winebatch') &&
               $user->login === $winebatch->harvest->wine_row->user;
    }

    public function delete(User $user, WineBatch $winebatch): bool
    {
        return $user->hasPermissionTo('delete winebatch') &&
               $user->login === $winebatch->harvest->wine_row->user;
    }

    public function restore(User $user, WineBatch $varka): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, WineBatch $varka): bool
    {
        return $user->hasRole('admin');
    }
}
