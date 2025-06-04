<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operasi extends Model
{
    protected $table = 'operasi';

    protected $fillable = [
        'pasien_id',
        'tanggal_operasi',
        'tehnik_operasi',
        'lokasi_operasi',
        'foto_sebelum_operasi',
        'foto_setelah_operasi',
        'jenis_kelainan_cleft_id',
        'jenis_terapi_id',
        'diagnosis_id',
        'follow_up',
        'operator_id',
        'operasi_id',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
    public function jenisKelainan()
    {
        return $this->belongsTo(JenisKelainan::class, 'jenis_kelainan_cleft_id');
    }
    public function jenisTerapi()
    {
        return $this->belongsTo(JenisTerampil::class, 'jenis_terapi_id');
    }
    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id');
    }
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
