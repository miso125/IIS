<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WineyardRow;

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
     * Každý môže vidieť vinohradové riadky
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view winerow');
    }

    public function view(User $user, WineyardRow $winerow): bool
    {
        return $user->hasRole('worker') || $user->hasPermissionTo('view winerow');
    }

    /**
     * Len vinári a pracovníci môžu vytvárať
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create winerow');
    }

    /**
     * Môže editovať len vinár-vlastník alebo admin
     */
    public function update(User $user, WineyardRow $winerow): bool
    {
        return $user->hasPermissionTo('edit winerow') &&
               $user->login === $winerow->user;  // Len vlastník
    }

    /**
     * Len vlastník alebo admin môžu zmazať
     */
    public function delete(User $user, WineyardRow $winerow): bool
    {
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
