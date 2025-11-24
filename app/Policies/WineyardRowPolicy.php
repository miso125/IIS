<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WineyardRow;

/**
 * Policy class for handling authorization of WineyardRow model actions.
 */
class WineyardRowPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any wineyard entries.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view winerow');
    }

    public function view(User $user, WineyardRow $winerow): bool
    {
        return $user->hasRole('worker') || $user->hasPermissionTo('view winerow');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create winerow');
    }

    public function update(User $user, WineyardRow $winerow): bool
    {
        return $user->hasPermissionTo('edit winerow') &&
               $user->login === $winerow->user;
    }

    public function delete(User $user, WineyardRow $winerow): bool
    {
        if ($user->login !== $winerow->user) {
            dd([
                'User Login (Prihlásený)' => $user->login,
                'Vineyard Owner (Z DB)' => $winerow->user,
                'Permission Check' => $user->hasPermissionTo('delete winerow'),
                'Is Admin?' => $user->hasRole('admin')
            ]);
        }
        return $user->hasPermissionTo('delete winerow') &&
               $user->login === $winerow->user;
    }

    public function restore(User $user, WineyardRow $winerow): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, WineyardRow $winerow): bool
    {
        return $user->hasRole('admin');
    }
}
