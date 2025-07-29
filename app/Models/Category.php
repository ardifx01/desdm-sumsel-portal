<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Menunjuk ke tabel 'categories'

    // Karena tabel categories Anda tidak memiliki timestamps, nonaktifkan
    public $timestamps = false; // TIDAK ADA created_at dan updated_at

    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    // Relasi: Satu kategori bisa memiliki banyak post
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    // Scope untuk hanya mengambil kategori type 'post'
    // Ini yang seharusnya dipanggil secara statis
    public function scopeOfTypePost($query) // <-- UBAH NAMA METODE INI
    {
        return $query->where('type', 'post');
    }
}