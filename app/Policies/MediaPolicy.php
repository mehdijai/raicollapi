<?php

namespace App\Policies;

use App\Models\User;

class MediaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function create(User $user): bool
    {
        return $user->role->privileges->contains('slug', 'upload-media');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function update(User $user): bool
    {
        return $user->role->privileges->contains('slug', 'upload-media');
    }
}
