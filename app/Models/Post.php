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
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Fit;

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
        'featured_image_url',
    ];

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

    // Konversi untuk gambar BARU yang diunggah via Spatie
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')->fit(Fit::Crop, 800, 500)->quality(85)->sharpen(10)->withResponsiveImages()->nonQueued();
        $this->addMediaConversion('thumb')->fit(Fit::Crop, 400, 250)->quality(80)->sharpen(10)->nonQueued();
        $this->addMediaConversion('webp')->format('webp')->nonQueued();
    }

    // --- ACCESSOR YANG MENDUKUNG GAMBAR LAMA & BARU ---

    // Untuk thumbnail (Halaman daftar berita /berita dan dasbor admin)
    protected function universalThumbUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Prioritas 1: Gambar BARU dari Spatie Media Library
                if ($this->hasMedia('featured_image')) {
                    return $this->getFirstMediaUrl('featured_image', 'thumb');
                }

                // Prioritas 2: Gambar LAMA dari kolom featured_image_url
                if ($this->featured_image_url && Storage::disk('public')->exists($this->featured_image_url)) {
                    return asset('storage/' . $this->featured_image_url);
                }

                // Fallback jika tidak ada sama sekali
                return 'https://placehold.co/400x250/E5E7EB/6B7280?text=No+Image';
            }
        );
    }
    
    // Untuk gambar besar (Halaman detail berita /berita/{slug})
    protected function universalPreviewUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Prioritas 1: Gambar BARU dari Spatie Media Library
                if ($this->hasMedia('featured_image')) {
                    return $this->getFirstMediaUrl('featured_image', 'preview');
                }

                // Prioritas 2: Gambar LAMA dari kolom featured_image_url
                if ($this->featured_image_url && Storage::disk('public')->exists($this->featured_image_url)) {
                    return asset('storage/' . $this->featured_image_url);
                }
                
                // Tidak perlu placeholder di halaman detail
                return null; 
            }
        );
    }

    public static function getPathGenerator(): ModulePathGenerator
    {
        return new ModulePathGenerator();
    }

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

}