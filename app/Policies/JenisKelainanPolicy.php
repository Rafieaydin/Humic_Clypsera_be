<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class JenisKelainanPolicy
{
    public function viewAny(User $user): Response
    {
        return $user->can('jenis-kelainan-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any jenis kelainan list.');
    }

    public function view(User $user): Response
    {
        return $user->can('jenis-kelainan-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this jenis kelainan.');
    }
    public function create(User $user): Response
    {
        return $user->can('jenis-kelainan-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create jenis kelainan.');
    }
    public function update(User $user): Response
    {
        return $user->can('jenis-kelainan-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this jenis kelainan.');
    }

    public function delete(User $jenis_kelainan): Response
    {
        return $jenis_kelainan->can('jenis-kelainan-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this jenis kelainan.');
    }
}
