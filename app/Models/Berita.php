<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'content',
        'sumber',
        'status',
        'user_id',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
