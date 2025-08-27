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

/**
 * @property int $id
 * @property string $title
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $content_html
 * @property string|null $featured_image_url
 * @property int|null $category_id
 * @property int $author_id
 * @property string $status
 * @property int $hits
 * @property int $share_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User|null $author
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read mixed $universal_preview_url
 * @property-read mixed $universal_thumb_url
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContentHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFeaturedImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereShareCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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