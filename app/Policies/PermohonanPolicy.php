<?php

namespace App\Policies;

use App\Models\permohonan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermohonanPolicy
{
    public function viewAny(User $User): Response
    {
        return $User->can('permohonan-list')
            ? Response::allow()
            : Response::deny('You do not have permission to view any endpoint permohonan list.');
    }

    public function view(User $User): Response
    {
        return $User->can('permohonan-show')
            ? Response::allow()
            : Response::deny('You do not have permission to view this endpoint permohonan.');
    }

    public function create(User $User): Response
    {
        return $User->can('permohonan-create')
            ? Response::allow()
            : Response::deny('You do not have permission to create endpoint permohonan.');
    }

    public function update(User $User): Response
    {
        return $User->can('permohonan-edit')
            ? Response::allow()
            : Response::deny('You do not have permission to update this endpoint permohonan.');
    }

    public function delete(User $User): Response
    {
        return $User->can('permohonan-delete')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this endpoint permohonan.');
    }
}
