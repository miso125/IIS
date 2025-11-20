<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admins majú prístup na všetko
     * Volá sa pred akoukoľvek inou metodou
     */
    public function before(User $user): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Či môže vidieť zoznam všetkých používateľov
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view users');
    }

    /**
     * Či môže vidieť konkrétneho používateľa
     */
    public function view(User $user, User $user1): bool
    {
        return $user->hasPermissionTo('view users') ||
               $user->login === $user1->login;  // Každý vidí seba
    }

    /**
     * Či môže vytvoriť nového používateľa
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create user');
    }

    /**
     * Či môže editovať používateľa
     */
    public function update(User $user, User $user1): bool
    {
        return $user->hasPermissionTo('edit user') ||
               $user->login === $user1->login;  // Môžeš editovať seba
    }

    /**
     * Či môže zmazať používateľa
     */
    public function delete(User $user, User $user1): bool
    {
        return $user->hasPermissionTo('delete user') &&
               $user->login !== $user1->login;  // Nemôžeš vymazať seba
    }

    /**
     * Či môže obnoviť vymazaného používateľa (soft delete)
     */
    public function restore(User $user, User $user1): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Trvale zmazať (force delete)
     */
    public function forceDelete(User $user, User $user1): bool
    {
        return $user->hasRole('admin');
    }
}
