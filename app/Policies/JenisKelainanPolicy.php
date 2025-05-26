<?php

namespace App\Policies;

use App\Models\JenisKelainan;
use Illuminate\Auth\Access\Response;

class JenisKelainanPolicy
{
    public function viewAny(JenisKelainan $jenis_kelainan): Response
    {
        return $jenis_kelainan->can('jenis-kelainan-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any jenis kelainan list.');
    }

    public function view(JenisKelainan $jenis_kelainan): Response
    {
        return $jenis_kelainan->can('jenis-kelainan-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this jenis kelainan.');
    }
    public function create(JenisKelainan $jenis_kelainan): Response
    {
        return $jenis_kelainan->can('jenis-kelainan-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create jenis kelainan.');
    }
    public function update(JenisKelainan $jenis_kelainan): Response
    {
        return $jenis_kelainan->can('jenis-kelainan-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this jenis kelainan.');
    }

    public function delete(JenisKelainan $jenis_kelainan): Response
    {
        return $jenis_kelainan->can('jenis-kelainan-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this jenis kelainan.');
    }
}
