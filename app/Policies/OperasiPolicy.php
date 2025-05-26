<?php

namespace App\Policies;

use App\Models\Operasi;
use Illuminate\Auth\Access\Response;
class OperasiPolicy
{
    public function viewAny(Operasi $operasi): Response
    {
        return $operasi->can('operasi-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any endpoint operasi list.');
    }

    public function view(Operasi $operasi): Response
    {
        return $operasi->can('operasi-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this endpoint operasi.');
    }

    public function create(Operasi $operasi): Response
    {
        return $operasi->can('operasi-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create endpoint operasi.');
    }

    public function update(Operasi $operasi): Response
    {
        return $operasi->can('operasi-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this endpoint operasi.');
    }

    public function delete(Operasi $operasi): Response
    {
        return $operasi->can('operasi-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this endpoint operasi.');
    }
}
