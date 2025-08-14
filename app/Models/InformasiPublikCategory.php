<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InformasiPublikCategory extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'deskripsi'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori Info Publik \"{$this->nama}\" telah di-{$eventName}");
    }
}