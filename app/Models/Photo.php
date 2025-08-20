<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Photo extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['album_id', 'judul', 'deskripsi', 'file_path', 'file_name', 'is_active'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Tambahkan file_path
            ->logOnly(['judul', 'deskripsi', 'is_active', 'file_path'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->judul ?: $this->file_name;
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Foto \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Foto \"{$subjectName}\" telah di-{$eventName}";
            });
    }
    
}