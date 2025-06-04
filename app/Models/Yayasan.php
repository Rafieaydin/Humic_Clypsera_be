<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yayasan extends Model
{
    protected $table = 'yayasan';

    protected $fillable = [
        'nama_yayasan',
        'domisili_yayasan',
        'alamat_yayasan',
        'no_telepon',
        'email_yayasan',
        'website_yayasan',
        'deskripsi_yayasan',
        'logo_yayasan',
        'visi_yayasan',
        'misi_yayasan',
        'status_verifikasi',
    ];

    public function ratings()
    {
        return $this->hasMany(RatingYayasan::class, 'yayasan_id');
    }
}
