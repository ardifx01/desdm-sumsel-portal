<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Support\ModulePathGenerator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'slug',
        'excerpt',
        'content_html',
        'category_id',
        'author_id',
        'status',
        'hits',
        'share_count',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'category_id', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $title = $this->title ?? 'tanpa judul';
                if ($eventName === 'updated') {
                    $changes = $this->getChanges();
                    // Hapus updated_at dari daftar perubahan
                    unset($changes['updated_at']);
                    $changedFields = implode(', ', array_keys($changes));
                    return "Berita \"{$title}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Berita \"{$title}\" telah di-{$eventName}";
            });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function comments(): HasMany
        {
            return $this->hasMany(Comment::class);
        }
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);

        $this
            ->addMediaConversion('webp-responsive')
            ->format('webp')
            ->nonQueued()
            ->withResponsiveImages();
    }
    public static function getPathGenerator(): ModulePathGenerator
    {
        return new ModulePathGenerator();
    }
}