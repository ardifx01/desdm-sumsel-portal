<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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