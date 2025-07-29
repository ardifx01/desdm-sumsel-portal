<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'judul',
        'deskripsi',
        'file_path',
        'file_name',
        'is_active',
    ];

    // Relasi: Satu foto termasuk dalam satu album
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}