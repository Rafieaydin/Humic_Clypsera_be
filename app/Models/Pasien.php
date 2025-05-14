<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'foto_profil',
        'pasien_anak_ke_berapa',
        'kelainan_kotigental',
        'riwayat_kehamilan',
        'riwayat_keluarga_pasien',
        'riwayat_kawin_berabat',
        'riwayat_terdahulu',
        'operator_id',
    ];

    public function operasi()
    {
        return $this->hasMany(Operasi::class, 'pasien_id');
    }
}
