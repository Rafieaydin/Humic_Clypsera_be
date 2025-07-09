<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanToken extends Model
{
    protected $table = 'permohonan_data_token';

    protected $fillable = [
        'permohonan_data_id',
        'token',
    ];

    public function permohonanData()
    {
        return $this->belongsTo(permohonan::class, 'permnohonan_data_id');
    }
}
