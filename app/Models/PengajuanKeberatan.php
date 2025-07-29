<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKeberatan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_keberatan';

    protected $fillable = [
        'nomor_registrasi_permohonan',
        'nama_pemohon',
        'email_pemohon',
        'telp_pemohon',
        'alamat_pemohon',
        'alasan_keberatan',
        'jenis_keberatan',
        'kasus_posisi',
        'identitas_pemohon',
        'status',
        'catatan_admin',
        'tanggal_pengajuan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->tanggal_pengajuan)) {
                $model->tanggal_pengajuan = now();
            }
        });
    }
}