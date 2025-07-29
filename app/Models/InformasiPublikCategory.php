<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublikCategory extends Model
{
    use HasFactory;

    protected $table = 'informasi_publik_categories';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
    ];

    // Definisi relasi: Satu kategori bisa memiliki banyak informasi publik
    public function informasiPublik()
    {
        return $this->hasMany(InformasiPublik::class, 'category_id');
    }
}