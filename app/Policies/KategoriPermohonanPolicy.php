<?php

namespace App\Policies;

use App\Models\kategoriPermohonan;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class KategoriPermohonanPolicy
{
    public function viewAny(User $user): Response
    {
        return $user->can('kagori-permohonan-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any endpoint kagori  permohonan list');
    }
    public function view(User $user): Response
    {
        return $user->can('kagori-permohonan-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this endpoint kagori permohonan');
    }
    public function create(User $user): Response
    {
        return $user->can('kagori-permohonan-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create endpoint kagori permohonan');
    }
    public function update(User $user): Response
    {
        return $user->can('kagori-permohonan-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this endpoint kagori permohonan');
    }
    public function delete(User $user): Response
    {
        return $user->can('kagori-permohonan-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this endpoint kagori permohonan');
    }
}
