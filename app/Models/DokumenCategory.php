<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenCategory extends Model
{
    use HasFactory;

    protected $table = 'dokumen_categories';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
    ];

    // Definisi relasi: Satu kategori bisa memiliki banyak dokumen
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'category_id');
    }
}