<?php

namespace App\Policies;

use App\Models\JenisTerampil;
use Illuminate\Auth\Access\Response;

class JenisTerapiPolicy
{
    public function viewAny(JenisTerampil $jenis_terampil): Response
    {
        return $jenis_terampil->can('jenis-terapi-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any jenis terapi list.');
    }

    public function view(JenisTerampil $jenis_terampil): Response
    {
        return $jenis_terampil->can('jenis-terapi-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this jenis terapi.');
    }

    public function create(JenisTerampil $jenis_terampil): Response
    {
        return $jenis_terampil->can('jenis-terapi-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create jenis terapi.');
    }

    public function update(JenisTerampil $jenis_terampil): Response
    {
        return $jenis_terampil->can('jenis-terapi-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this jenis terapi.');
    }

    public function delete(JenisTerampil $jenis_terampil): Response
    {
        return $jenis_terampil->can('jenis-terapi-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this jenis terapi.');
    }
}
