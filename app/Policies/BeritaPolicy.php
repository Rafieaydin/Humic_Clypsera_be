<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Berita;
use App\Models\User;

class BeritaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->can('berita-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any berita.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Berita $berita): Response
    {
        return $user->can('berita-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this berita.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->can('berita-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create berita.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->can('berita-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this berita.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->can('berita-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this berita.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Berita $berita): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Berita $berita): bool
    {
        return false;
    }
}
