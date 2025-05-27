<?php

namespace App\Policies;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PasienPolicy
{
    public function viewAny(User $user): Response
    {
        return $user->can('pasien-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any endpoint pasien list.');
    }

    public function view(User $user): Response
    {
        return $user->can('pasien-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this endpoint pasien.');
    }

    public function create(User $user): Response
    {
        return $user->can('pasien-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create endpoint pasien.');
    }

    public function update(User $user): Response
    {
        return $user->can('pasien-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this endpoint pasien.');
    }

    public function delete(User $user): Response
    {
        return $user->can('pasien-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this endpoint pasien.');
    }
}
