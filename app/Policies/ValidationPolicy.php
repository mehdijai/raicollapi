<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Validation;
use Illuminate\Auth\Access\Response;

class ValidationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->privileges->contains('slug', 'validate-media');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Validation $validation): bool
    {
        return $user->role->privileges->contains('slug', 'validate-media');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->privileges->contains('slug', 'validate-media');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Validation $validation): bool
    {
        return $user->role->privileges->contains('slug', 'validate-media');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Validation $validation): bool
    {
        return $user->role->privileges->contains('slug', 'validate-media');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Validation $validation): bool
    {
        return $user->role->privileges->contains('slug', 'validate-media');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Validation $validation): bool
    {
        return $user->role->privileges->contains('slug', 'validate-media');
    }
}
