<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailUser extends Model
{
    protected $table = 'detail_user';
    protected $fillable = [
        'user_id',
        'nik',
        'pekerjaan',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'umur',
        'no_telepon',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
