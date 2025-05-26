<?php

namespace App\Policies;

use App\Models\Diagnosis;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class DiagnosisPolicy
{
    public function viewAny(Diagnosis $diagnosis): Response
    {
        return $diagnosis->can('diagnosis-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any diagnosis.');
    }

    public function view(User $user, Diagnosis $diagnosis): Response
    {
        return $user->can('diagnosis-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this diagnosis.');
    }
    public function create(User $user): Response
    {
        return $user->can('diagnosis-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create diagnosis.');
    }
    public function update(User $user): Response
    {
        return $user->can('diagnosis-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this diagnosis.');
    }
    public function delete(User $user): Response
    {
        return $user->can('diagnosis-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this diagnosis.');
    }

}
