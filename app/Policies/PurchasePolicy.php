<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Purchase;

/**
 * Policy class for handling authorization of Purchase model actions.
 */
class PurchasePolicy
{
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any purchase entries.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole(['admin', 'winemaker'])) {
            return true;
        }
        return $user->hasPermissionTo('view purchase');
    }

    public function view(User $user, Purchase $purchase): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return $user->login === $purchase->user;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create purchase');
    }

    public function update(User $user, Purchase $purchase): bool
    {
        return $user->hasPermissionTo('edit purchase') &&
               $user->login === $purchase->user;
    }

    public function delete(User $user, Purchase $purchase): bool
    {
        return $user->hasPermissionTo('delete purchase') &&
               $user->login === $purchase->user();
    }

    public function restore(User $user, Purchase $purchase): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Purchase $purchase): bool
    {
        return $user->hasRole('admin');
    }
}
