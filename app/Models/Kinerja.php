<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kinerja extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'kinerja';

    protected $fillable = [
        'indikator_kinerja_id',
        'tahun',
        'target_tahunan',
        'realisasi_q1',
        'realisasi_q2',
        'realisasi_q3',
        'realisasi_q4',
    ];

    // Relasi: Satu data kinerja milik satu indikator
    public function indikatorKinerja()
    {
        return $this->belongsTo(IndikatorKinerja::class);
    }

    // Accessor untuk menghitung total realisasi
    public function getTotalRealisasiAttribute()
    {
        return $this->realisasi_q1 + $this->realisasi_q2 + $this->realisasi_q3 + $this->realisasi_q4;
    }

    // Accessor untuk menghitung persentase capaian
    public function getPersentaseCapaianAttribute()
    {
        if ($this->target_tahunan > 0) {
            return ($this->total_realisasi / $this->target_tahunan) * 100;
        }
        return 0;
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['target', 'realisasi'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->indikatorKinerja->nama_indikator ?? 'N/A';
                if ($eventName === 'updated') {
                    $changes = $this->getChanges();
                    $details = [];
                    if (isset($changes['target'])) {
                        $old = $this->getOriginal('target');
                        $details[] = "target diubah dari '{$old}' menjadi '{$changes['target']}'";
                    }
                    if (isset($changes['realisasi'])) {
                        $old = $this->getOriginal('realisasi');
                        $details[] = "realisasi diubah dari '{$old}' menjadi '{$changes['realisasi']}'";
                    }
                    return "Kinerja \"{$subjectName}\" (T{$this->tahun}-Q{$this->triwulan}) diperbarui: " . implode(', ', $details);
                }
                return "Kinerja \"{$subjectName}\" (T{$this->tahun}-Q{$this->triwulan}) telah di-{$eventName}";
            });
    }
}