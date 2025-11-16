<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Dokumen;

class DokumenPolicy
{
    /**
     * Determine whether the user can view any dokumen
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the dokumen
     */
    public function view(User $user, Dokumen $dokumen): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create dokumen (only admin)
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the dokumen (only admin)
     */
    public function update(User $user, Dokumen $dokumen): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can delete the dokumen (only admin)
     */
    public function delete(User $user, Dokumen $dokumen): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the dokumen
     */
    public function restore(User $user, Dokumen $dokumen): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can permanently delete the dokumen
     */
    public function forceDelete(User $user, Dokumen $dokumen): bool
    {
        return $user->hasRole('Admin');
    }
}
