<?php

namespace App\Policies;

use App\Models\kategoriPermohonan;
use Illuminate\Auth\Access\Response;

class KategoriPermohonanPolicy
{
    public function viewAny(kategoriPermohonan $kategori_permohonan): Response
    {
        return $kategori_permohonan->can('kagori-permohonan-list')
        ? Response::allow()
        : Response::deny('You do not have permission to view any endpoint kagori  permohonan list');
    }
    public function view(kategoriPermohonan $kategori_permohonan): Response
    {
        return $kategori_permohonan->can('kagori-permohonan-show')
        ? Response::allow()
        : Response::deny('You do not have permission to view this endpoint kagori permohonan');
    }
    public function create(kategoriPermohonan $kategori_permohonan): Response
    {
        return $kategori_permohonan->can('kagori-permohonan-create')
        ? Response::allow()
        : Response::deny('You do not have permission to create endpoint kagori permohonan');
    }
    public function update(kategoriPermohonan $kategori_permohonan): Response
    {
        return $kategori_permohonan->can('kagori-permohonan-edit')
        ? Response::allow()
        : Response::deny('You do not have permission to update this endpoint kagori permohonan');
    }
    public function delete(kategoriPermohonan $kategori_permohonan): Response
    {
        return $kategori_permohonan->can('kagori-permohonan-delete')
        ? Response::allow()
        : Response::deny('You do not have permission to delete this endpoint kagori permohonan');
    }
}
