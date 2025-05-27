<?php

namespace App\Policies;

use App\Models\JenisTerampil;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class JenisTerapiPolicy
{
    public function viewAny(User $User): Response
    {
        return $User->can('jenis-terapi-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any jenis terapi list.');
    }

    public function view(User $User): Response
    {
        return $User->can('jenis-terapi-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this jenis terapi.');
    }

    public function create(User $User): Response
    {
        return $User->can('jenis-terapi-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create jenis terapi.');
    }

    public function update(User $User): Response
    {
        return $User->can('jenis-terapi-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this jenis terapi.');
    }

    public function delete(User $User): Response
    {
        return $User->can('jenis-terapi-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this jenis terapi.');
    }
}
