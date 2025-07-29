<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanInformasi extends Model
{
    use HasFactory;

    protected $table = 'permohonan_informasi';

    protected $fillable = [
        'nomor_registrasi',
        'nama_pemohon',
        'email_pemohon',
        'telp_pemohon',
        'alamat_pemohon',
        'pekerjaan_pemohon',
        'identitas_pemohon',
        'jenis_pemohon',
        'tujuan_penggunaan_informasi',
        'rincian_informasi',
        'cara_mendapatkan_informasi',
        'cara_mendapatkan_salinan',
        'status',
        'catatan_admin',
        'tanggal_permohonan',
    ];

    protected $casts = [
        'tanggal_permohonan' => 'datetime',
    ];

    // Contoh: Generate nomor registrasi secara otomatis saat membuat data baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomor_registrasi)) {
                $year = date('Y');
                $lastPermohonan = static::whereYear('tanggal_permohonan', $year)->orderBy('id', 'desc')->first();
                $lastNumber = $lastPermohonan ? (int)substr($lastPermohonan->nomor_registrasi, -4) : 0;
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                $model->nomor_registrasi = 'PI/DESDM/' . $year . '/' . $newNumber;
            }
            if (empty($model->tanggal_permohonan)) {
                $model->tanggal_permohonan = now();
            }
        });
    }
}