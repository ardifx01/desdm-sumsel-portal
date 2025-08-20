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

    protected function thumbnailUrl(): Attribute
        {
            return Attribute::make(
                get: function () {
                    // PERBAIKAN KUNCI: Cek apakah symlink ada.
                    if (! file_exists(public_path('storage'))) {
                        return null;
                    }

                    $thumbnailPath = $this->attributes['thumbnail'] ?? null;
                    if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                        return asset('storage/' . $thumbnailPath);
                    }
                    
                    return null;
                }
            );
        }    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Tambahkan thumbnail ke logOnly
            ->logOnly(['nama', 'deskripsi', 'is_active', 'thumbnail'])
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