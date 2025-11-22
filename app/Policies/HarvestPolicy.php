<?php

namespace App\Policies;

use App\Models\Harvest;
use App\Models\User;

class HarvestPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view harvest');
    }

    public function view(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('view harvest') ||
               $user->login === $harvest->user;
    }

    /**
     * Len vinári a pracovníci môžu nahlasovať sklizeň
     */
    public function create(User $user): bool
    {
        return $user->hasRole('worker') || $user->hasPermissionTo('create harvest');
    }




    /**
     * Len vinár-vlastník môže editovať
     */
    public function update(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('edit harvest') &&
               $user->login === $harvest->winerow->user;
    }

    public function delete(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('delete harvest') &&
               $user->login === $harvest->winerow->user;
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
