<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnosis';

    protected $fillable = [
        'nama_diagnosis',
        'deskripsi_diagnosis',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function operasi()
    {
        return $this->hasMany(Operasi::class, 'diagnosis_id');
    }
}
