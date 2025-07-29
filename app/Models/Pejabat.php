<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel (plural dari nama model)
    protected $table = 'pejabat';

    // Kolom-kolom yang boleh diisi secara massal (mass assignable)
    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'deskripsi_singkat',
        'foto',
        'urutan',
        'is_active',
    ];

    // Kolom-kolom yang harus di-cast ke tipe data tertentu
    protected $casts = [
        'is_active' => 'boolean',
    ];
}