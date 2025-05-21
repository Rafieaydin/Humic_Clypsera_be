<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategoriPermohonan extends Model
{
    protected $table = 'kategori_peromohonan';
    protected $fillable = [
        'kategori',
    ];

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'kategori_id');
    }
}
