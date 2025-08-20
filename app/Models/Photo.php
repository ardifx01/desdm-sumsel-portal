<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- TAMBAHKAN BARIS INI
use Illuminate\Support\Facades\Storage; 

class Photo extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['album_id', 'judul', 'deskripsi', 'file_path', 'file_name', 'is_active'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * Accessor untuk thumbnail di Dasbor Admin, dengan logika fallback.
     */
    protected function adminThumbUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Pengecekan symlink
                if (! file_exists(public_path('storage'))) {
                    return null;
                }

                $filePath = $this->attributes['file_path'] ?? null;
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    return asset('storage/' . $filePath);
                }
                
                return null;
            }
        );
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