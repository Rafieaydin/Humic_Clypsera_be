<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
class UserPolicy
{
    public function viewAny(User $user): Response
    {
        return $user->can('user-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any endpoint user list.');
    }

    public function view(User $user): Response
    {
        return $user->can('user-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this endpoint user.');
    }

    public function create(User $user): Response
    {
        return $user->can('user-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create endpoint user.');
    }

    public function update(User $user): Response
    {
        return $user->can('user-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this endpoint user.');
    }

    public function delete(User $user): Response
    {
        return $user->can('user-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this endpoint user.');
    }
}
