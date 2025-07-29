<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'embed_code',
        'thumbnail',
        'is_active',
    ];
}