<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Only admins can manage users.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, User $model): bool
    {
        // Admin cannot delete themselves
        return $user->isAdmin() && $user->id !== $model->id;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, User $model): bool
    {
        // Admin cannot force-delete themselves
        return $user->isAdmin() && $user->id !== $model->id;
    }
}
