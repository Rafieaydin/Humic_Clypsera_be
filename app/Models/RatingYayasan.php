<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingYayasan extends Model
{
    protected $table = 'list_rating_yayasan';

    protected $fillable = [
        'yayasan_id',
        'user_id',
        'rating',
        'komentar',
    ];

    public function yayasan()
    {
        return $this->belongsTo(Yayasan::class, 'yayasan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
