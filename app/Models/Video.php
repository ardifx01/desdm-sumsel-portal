<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Video extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['judul', 'slug', 'deskripsi', 'embed_code', 'thumbnail', 'is_active'];

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return $this->thumbnail;
        }
        $videoId = null;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->embed_code, $matches)) {
            $videoId = $matches[1];
        }
        if ($videoId) {
            return "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
        }
        return asset('storage/images/placeholder-video.png');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'deskripsi', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->judul ?? 'tanpa judul';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Video \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Video \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}