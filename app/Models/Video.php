<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property string $judul
 * @property string $slug
 * @property string|null $deskripsi
 * @property string $embed_code
 * @property string|null $thumbnail
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read string $thumbnail_url
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereEmbedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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