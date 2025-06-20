<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTerampil extends Model
{
    protected $table = 'jenis_terapi';

    protected $fillable = [
        'nama_terapi',
        'deskripsi_terapi',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function operasi()
    {
        return $this->hasMany(Operasi::class, 'jenis_terapi_id');
    }
}
