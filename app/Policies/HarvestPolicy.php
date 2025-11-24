<?php

namespace App\Policies;

use App\Models\Harvest;
use App\Models\User;

/**
 * Policy class for handling authorization of Harvest model actions.
 */
class HarvestPolicy
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
        return $user->hasPermissionTo('view harvest');
    }

    public function view(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('view harvest') ||
               $user->login === $harvest->user;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('worker') || $user->hasPermissionTo('create harvest');
    }

    public function update(User $user, Harvest $harvest)
    {
        return $user->hasRole(['worker','winemaker']);
    }

    public function delete(User $user, Harvest $harvest): bool
    {
        if ($user->hasRole('worker') || $user->hasRole('winemaker')) {
            return true;
        }

        if ($harvest->winerow && $user->login === $harvest->winerow->user) {
            return true;
        }

        return false;
    }


    public function restore(User $user, Harvest $harvest): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Harvest $harvest): bool
    {
        return $user->hasRole('admin');
    }
}
