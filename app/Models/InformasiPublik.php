<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use HasFactory;

    protected $table = 'informasi_publik';

    protected $fillable = [
        'category_id',
        'judul',
        'slug',
        'konten',
        'file_path',
        'file_nama',
        'file_tipe',
        'thumbnail',
        'tanggal_publikasi',
        'hits',
        'is_active',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Definisi relasi: Setiap informasi publik termasuk dalam satu kategori
    public function category()
    {
        return $this->belongsTo(InformasiPublikCategory::class, 'category_id');
    }
}