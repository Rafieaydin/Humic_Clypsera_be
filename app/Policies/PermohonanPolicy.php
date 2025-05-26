<?php

namespace App\Policies;

use App\Models\permohonan;
use Illuminate\Auth\Access\Response;

class PermohonanPolicy
{
    public function viewAny(permohonan $permohonan): Response
    {
        return $permohonan->can('permohonan-list')
            ? Response::allow()
            : Response::deny('You do not have permission to view any endpoint permohonan list.');
    }

    public function view(permohonan $permohonan): Response
    {
        return $permohonan->can('permohonan-show')
            ? Response::allow()
            : Response::deny('You do not have permission to view this endpoint permohonan.');
    }

    public function create(permohonan $permohonan): Response
    {
        return $permohonan->can('permohonan-create')
            ? Response::allow()
            : Response::deny('You do not have permission to create endpoint permohonan.');
    }

    public function update(permohonan $permohonan): Response
    {
        return $permohonan->can('permohonan-edit')
            ? Response::allow()
            : Response::deny('You do not have permission to update this endpoint permohonan.');
    }

    public function delete(permohonan $permohonan): Response
    {
        return $permohonan->can('permohonan-delete')
            ? Response::allow()
            : Response::deny('You do not have permission to delete this endpoint permohonan.');
    }
}
