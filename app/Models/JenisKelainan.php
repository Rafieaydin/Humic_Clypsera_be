<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKelainan extends Model
{
    protected $table = 'jenis_kelainan';

    protected $fillable = [
        'nama_kelainan',
        'deskripsi_kelainan',
    ];

    public function operasi()
    {
        return $this->hasMany(Operasi::class, 'jenis_kelainan_id');
    }
}
