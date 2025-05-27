<?php

namespace App\Policies;

use App\Models\Operasi;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class OperasiPolicy
{
    public function viewAny(User $user): Response
    {
        return $user->can('operasi-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any endpoint operasi list.');
    }

    public function view(User $user): Response
    {
        return $user->can('operasi-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this endpoint operasi.');
    }

    public function create(User $user): Response
    {
        return $user->can('operasi-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create endpoint operasi.');
    }

    public function update(User $user): Response
    {
        return $user->can('operasi-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this endpoint operasi.');
    }

    public function delete(User $user): Response
    {
        return $user->can('operasi-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this endpoint operasi.');
    }
}
