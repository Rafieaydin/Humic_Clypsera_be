<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permohonan extends Model
{
    protected $table = 'permohonan_data';

    protected $fillable = [
        'kategori_id',
        'nama_pemohon',
        'nik_pemohon',
        'email_pemohon',
        'no_telepon',
        'status_permohonan',
        'alasan_permohonan',
        'operasi_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategoriPermohonan::class, 'kategori_id');
    }
    public function operasi()
    {
        return $this->belongsTo(operasi::class, 'operasi_id');
    }
}
