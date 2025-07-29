<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts'; // Menunjuk ke tabel 'posts'

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'slug',
        'excerpt',
        'content_html',
        'featured_image_url',
        'category_id',
        'author_id',
        'status',
    ];

    // Kolom-kolom yang harus di-cast ke tipe data tertentu
    protected $casts = [
        // 'created_at' => 'datetime', // Jika di table posts Anda datetime
        // 'updated_at' => 'datetime', // Jika di table posts Anda datetime
    ];

    // Definisi relasi: Satu post termasuk dalam satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Definisi relasi: Satu post ditulis oleh satu user (author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scope untuk hanya mengambil post dengan status 'published'
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}