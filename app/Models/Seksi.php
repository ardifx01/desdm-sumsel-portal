<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini (Laravel secara otomatis mengasumsikan 'seksis')
    protected $table = 'seksis';

    // Kolom-kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'bidang_id',
        'nama_seksi',
        'tugas',
        'urutan',
        'pejabat_kepala_id',
        'is_active',
    ];

    // Casting atribut ke tipe data tertentu
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi: Satu Seksi adalah milik satu Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    // Relasi: Satu Seksi memiliki satu Pejabat (sebagai kepala seksi)
    public function kepala()
    {
        return $this->belongsTo(Pejabat::class, 'pejabat_kepala_id');
    }
}