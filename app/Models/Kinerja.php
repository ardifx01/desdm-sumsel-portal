<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property int $indikator_kinerja_id
 * @property string $tahun
 * @property string|null $target_tahunan
 * @property string|null $realisasi_q1
 * @property string|null $realisasi_q2
 * @property string|null $realisasi_q3
 * @property string|null $realisasi_q4
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read mixed $persentase_capaian
 * @property-read mixed $total_realisasi
 * @property-read \App\Models\IndikatorKinerja $indikatorKinerja
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereIndikatorKinerjaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereRealisasiQ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereRealisasiQ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereRealisasiQ3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereRealisasiQ4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereTargetTahunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinerja whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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