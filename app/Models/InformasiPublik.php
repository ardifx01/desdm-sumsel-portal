<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage; 
use App\Models\Traits\CleansHtml;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property int $category_id
 * @property string $judul
 * @property string $slug
 * @property string $konten
 * @property string|null $file_path
 * @property string|null $file_nama
 * @property string|null $file_tipe
 * @property string|null $thumbnail
 * @property \Illuminate\Support\Carbon|null $tanggal_publikasi
 * @property int $hits
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\InformasiPublikCategory $category
 * @property-read mixed $thumbnail_url
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik query()
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereFileNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereFileTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereTanggalPublikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublik whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InformasiPublik extends Model
{
    use HasFactory, LogsActivity, CleansHtml, Searchable;

    protected $table = 'informasi_publik';

    protected $fillable = [
        'category_id',
        'judul',
        'slug',
        'konten',
        'file_path',
        'file_nama',
        'file_tipe',
        'thumbnail',
        'tanggal_publikasi',
        'hits',
        'is_active',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function toSearchableArray(): array {
        return ['judul' => $this->judul, 'konten' => strip_tags($this->konten ?? '')];
    }
    
    /**
     * Daftar atribut yang berisi input HTML dan perlu dibersihkan.
     *
     * @var array
     */
    protected $htmlFieldsToClean = [
        'konten',
    ];

    // Definisi relasi: Setiap informasi publik termasuk dalam satu kategori
    public function category()
    {
        return $this->belongsTo(InformasiPublikCategory::class, 'category_id');
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
                if ($thumbnailPath && Storage::disk('public')->exists('thumbnails/' . $thumbnailPath)) {
                    return asset('storage/thumbnails/' . $thumbnailPath);
                }
                
                return null;
            }
        );
    }
        
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Tambahkan thumbnail dan file_path
            ->logOnly(['judul', 'category_id', 'is_active', 'thumbnail', 'file_path'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->judul ?? 'tanpa judul';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Item Info Publik \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Item Info Publik \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}