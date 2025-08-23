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
use App\Models\Traits\CleansHtml;
use Laravel\Scout\Searchable;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity, CleansHtml, Searchable;

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

    /**
     * Daftar atribut yang berisi input HTML dan perlu dibersihkan.
     *
     * @var array
     */
    protected $htmlFieldsToClean = [
        'content_html',
        'excerpt', // Sebaiknya excerpt juga dibersihkan
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title ?? '', // Tambahkan null coalescing untuk keamanan
            'excerpt' => $this->excerpt ?? '',
            'content_html' => strip_tags($this->content_html ?? ''), // Berikan string kosong jika null
        ];
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

    // Konversi untuk gambar BARU yang diunggah via Spatie
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')->fit(Fit::Crop, 800, 500)->quality(85)->sharpen(10)->withResponsiveImages()->nonQueued();
        $this->addMediaConversion('thumb')->fit(Fit::Crop, 400, 250)->quality(80)->sharpen(10)->nonQueued();
        $this->addMediaConversion('webp')->format('webp')->nonQueued();
    }

    // --- ACCESSOR YANG DIPERBAIKI DENGAN LOGIKA ANTI-GAGAL ---

    protected function universalThumbUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // PERBAIKAN KUNCI: Cek apakah symlink ada. Jika tidak, langsung fallback.
                if (! file_exists(public_path('storage'))) {
                    return 'https://placehold.co/400x250/E5E7EB/6B7280?text=No+Symlink';
                }

                // Prioritas 1: Gambar BARU dari Spatie Media Library
                if ($this->hasMedia('featured_image')) {
                    $media = $this->getFirstMedia('featured_image');
                    if ($media && file_exists($media->getPath('thumb'))) {
                        return $media->getUrl('thumb');
                    }
                }

                // Prioritas 2: Gambar LAMA dari kolom featured_image_url
                $legacyImageUrl = $this->attributes['featured_image_url'] ?? null;
                if ($legacyImageUrl && Storage::disk('public')->exists($legacyImageUrl)) {
                    return asset('storage/' . $legacyImageUrl);
                }

                // Fallback jika tidak ada data sama sekali
                return 'https://placehold.co/400x250/E5E7EB/6B7280?text=No+Image';
            }
        );
    }
    
    protected function universalPreviewUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // PERBAIKAN KUNCI: Cek apakah symlink ada.
                if (! file_exists(public_path('storage'))) {
                    return null; // Di halaman detail, kita tidak tampilkan apa-apa jika symlink rusak
                }

                if ($this->hasMedia('featured_image')) {
                    $media = $this->getFirstMedia('featured_image');
                    if ($media && file_exists($media->getPath('preview'))) {
                        return $media->getUrl('preview');
                    }
                }
                
                $legacyImageUrl = $this->attributes['featured_image_url'] ?? null;
                if ($legacyImageUrl && Storage::disk('public')->exists($legacyImageUrl)) {
                    return asset('storage/' . $legacyImageUrl);
                }
                
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
            // Tambahkan featured_image_url ke logOnly
            ->logOnly(['title', 'category_id', 'status', 'featured_image_url'])
            ->logAll() // Menangkap perubahan media
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $title = $this->title ?? 'tanpa judul';
                if ($eventName === 'updated') {
                    $changes = $this->getChanges();
                    // Deskripsi kustom jika gambar diubah
                    if (isset($changes['media']) || isset($changes['featured_image_url'])) {
                        return "Gambar unggulan untuk Berita \"{$title}\" telah diperbarui";
                    }
                    unset($changes['updated_at']);
                    $changedFields = implode(', ', array_keys($changes));
                    return "Berita \"{$title}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Berita \"{$title}\" telah di-{$eventName}";
            });
    }

}