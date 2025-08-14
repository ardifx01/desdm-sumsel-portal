<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Dokumen extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'category_id', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->judul ?? 'tanpa judul';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Dokumen \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Dokumen \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}