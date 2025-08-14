<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Album extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['nama', 'slug', 'deskripsi', 'thumbnail', 'is_active'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'deskripsi', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->nama ?? 'tanpa nama';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Album Foto \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Album Foto \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}