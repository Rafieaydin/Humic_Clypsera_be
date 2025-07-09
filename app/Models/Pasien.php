<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama_pasien',
        'tanggal_lahir',
        'umur_pasien',
        'jenis_kelamin',
        'alamat_pasien',
        'no_telepon',
        'foto_profil',
        'pasien_anak_ke_berapa',
        'kelainan_kotigental',
        'riwayat_kehamilan',
        'riwayat_keluarga_pasien',
        'riwayat_kawin_kerabat',
        'riwayat_terdahulu',
        'operator_id',
        'suku_pasien',
    ];

    public function operasi()
    {
        return $this->hasOne(Operasi::class, 'pasien_id');
    }
}
