<?php

namespace App\Policies;

use App\Models\User;

/**
 * Policy class for handling authorization of User model actions.
 */
class UserPolicy
{
    /**
     * Admins have access everywhere
     */
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any uner entries.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view users');
    }

    public function view(User $user, User $user1): bool
    {
        return $user->hasPermissionTo('view users') ||
               $user->login === $user1->login; 
    }


    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create user');
    }


    public function update(User $user, User $user1): bool
    {
        return $user->hasPermissionTo('edit user') ||
               $user->login === $user1->login;  
    }


    public function delete(User $user, User $user1): bool
    {
        return $user->hasPermissionTo('delete user') &&
               $user->login !== $user1->login;  
    }


    public function restore(User $user, User $user1): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, User $user1): bool
    {
        return $user->hasRole('admin');
    }
}
