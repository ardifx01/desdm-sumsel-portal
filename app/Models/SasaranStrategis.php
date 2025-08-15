<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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