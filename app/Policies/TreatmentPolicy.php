<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Treatment;

/**
 * Policy class for handling authorization of Treatment model actions.
 */
class TreatmentPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }
    /**
     * Determine whether the user can view any treatment entries.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('worker') || $user->hasRole('winemaker');
    }

    public function view(User $user, Treatment $treatment)
    {
        return $user->hasRole('worker') || $user->hasRole('winemaker');
    }



    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create treatment');
    }


    public function update(User $user, Treatment $treatment): bool
    {
        return $user->hasRole('worker') || $user->hasRole('winemaker') || $user->hasRole('admin');
    }


    public function delete(User $user, Treatment $treatment): bool
    {
        return $user->hasRole('worker') || $user->hasRole('winemaker') || $user->hasRole('admin');
    }

    public function restore(User $user, Treatment $treatment): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Treatment $treatment): bool
    {
        return $user->hasRole('admin');
    }
}
