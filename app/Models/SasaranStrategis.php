<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property string $sasaran
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndikatorKinerja> $indikatorKinerja
 * @property-read int|null $indikator_kinerja_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kinerja> $kinerja
 * @property-read int|null $kinerja_count
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis query()
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis whereSasaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SasaranStrategis whereUrutan($value)
 * @mixin \Eloquent
 */
class SasaranStrategis extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'sasaran_strategis';

    protected $fillable = [
        'sasaran',
        'urutan',
    ];

    // Relasi: Satu sasaran memiliki banyak data kinerja (melalui indikator)
    public function kinerja()
    {
        return $this->hasManyThrough(Kinerja::class, IndikatorKinerja::class);
    }

    // Relasi: Satu sasaran memiliki banyak indikator
    public function indikatorKinerja()
    {
        return $this->hasMany(IndikatorKinerja::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['sasaran', 'urutan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Sasaran Strategis \"{$this->sasaran}\" telah di-{$eventName}");
    }
}