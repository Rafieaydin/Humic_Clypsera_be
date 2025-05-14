<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTerampil extends Model
{
    protected $table = 'jenis_terapi';

    protected $fillable = [
        'nama_terampi',
        'deskripsi_terampi',
    ];

    public function operasi()
    {
        return $this->hasMany(Operasi::class, 'jenis_terapi_id');
    }
}
