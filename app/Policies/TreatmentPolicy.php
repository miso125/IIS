<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Treatment;

class TreatmentPolicy
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
        return $user->hasPermissionTo('view treatment');
    }

    public function view(User $user, Treatment $treatment): bool
    {
        return $user->hasPermissionTo('view treatment');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create treatment');
    }

    /**
     * Len ten, kto vykonál ošetrenie, môže editovať
     */
    public function update(User $user, Treatment $treatment): bool
    {
        return $user->hasPermissionTo('edit treatment') &&
               $user->login === $treatment->user;
    }

    public function delete(User $user, Treatment $treatment): bool
    {
        return $user->hasPermissionTo('delete treatment') &&
               $user->login === $treatment->user;
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
