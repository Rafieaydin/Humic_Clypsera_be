<?php

namespace App\Policies;

use App\Models\Pasien;
use Illuminate\Auth\Access\Response;

class PasienPolicy
{
    public function viewAny(Pasien $pasien): Response
    {
        return $pasien->can('pasien-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any endpoint pasien list.');
    }

    public function view(Pasien $pasien): Response
    {
        return $pasien->can('pasien-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this endpoint pasien.');
    }

    public function create(Pasien $pasien): Response
    {
        return $pasien->can('pasien-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create endpoint pasien.');
    }

    public function update(Pasien $pasien): Response
    {
        return $pasien->can('pasien-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this endpoint pasien.');
    }

    public function delete(Pasien $pasien): Response
    {
        return $pasien->can('pasien-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this endpoint pasien.');
    }
}
