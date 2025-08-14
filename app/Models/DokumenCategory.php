<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DokumenCategory extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'dokumen_categories';
    protected $fillable = ['nama', 'slug', 'deskripsi'];

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'deskripsi'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori Dokumen \"{$this->nama}\" telah di-{$eventName}");
    }
}