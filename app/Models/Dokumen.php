<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = [
        'category_id',
        'judul',
        'slug',
        'deskripsi',
        'file_path',
        'file_nama',
        'file_tipe',
        'tanggal_publikasi',
        'hits',
        'is_active',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Definisi relasi: Setiap dokumen termasuk dalam satu kategori
    public function category()
    {
        return $this->belongsTo(DokumenCategory::class, 'category_id');
    }
}