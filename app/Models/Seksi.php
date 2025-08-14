<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Seksi extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_seksi', 'urutan', 'pejabat_kepala_id', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->nama_seksi ?? 'tanpa nama';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Data Seksi \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Data Seksi \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}