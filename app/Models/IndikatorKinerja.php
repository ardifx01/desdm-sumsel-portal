<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property int $sasaran_strategis_id
 * @property string $nama_indikator
 * @property string $satuan
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kinerja> $kinerja
 * @property-read int|null $kinerja_count
 * @property-read \App\Models\SasaranStrategis $sasaranStrategis
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja query()
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja whereNamaIndikator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja whereSasaranStrategisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndikatorKinerja whereUrutan($value)
 * @mixin \Eloquent
 */
class IndikatorKinerja extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'indikator_kinerja';

    protected $fillable = [
        'sasaran_strategis_id',
        'nama_indikator',
        'satuan',
        'urutan',
    ];

    // Relasi: Satu indikator milik satu sasaran
    public function sasaranStrategis()
    {
        return $this->belongsTo(SasaranStrategis::class);
    }

    // Relasi: Satu indikator memiliki banyak data kinerja
    public function kinerja()
    {
        return $this->hasMany(Kinerja::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_indikator', 'satuan', 'urutan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Indikator Kinerja \"{$this->nama_indikator}\" telah di-{$eventName}");
    }
}