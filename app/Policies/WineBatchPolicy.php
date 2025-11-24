<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WineBatch;

/**
 * Policy class for handling authorization of WInebatch model actions.
 */
class WineBatchPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin|winemaker')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any winebatch entries.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view winebatch');
    }

    public function view(User $user, WineBatch $varka): bool
    {
        return $user->hasPermissionTo('view winebatch');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create winebatch');
    }

    public function update(User $user, WineBatch $winebatch): bool
    {
        return $user->hasPermissionTo('edit winebatch') &&
               $user->login === $winebatch->harvestDetail->wineyardrow->user;
    }

    public function delete(User $user, WineBatch $winebatch): bool
    {
        return $user->hasPermissionTo('delete winebatch') &&
               $user->login === $winebatch->harvestDetail->wineyardrow->user;
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
