<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKelainan extends Model
{
    protected $table = 'jenis_kelainan_cleft';

    protected $fillable = [
        'nama_kelainan',
        'deskripsi_kelainan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function operasi()
    {
        return $this->hasMany(Operasi::class, 'jenis_kelainan_id');
    }
}
