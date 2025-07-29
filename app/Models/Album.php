<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'thumbnail',
        'is_active',
    ];

    // Relasi: Satu album memiliki banyak foto
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}