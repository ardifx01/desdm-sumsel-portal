<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Support\ModulePathGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Spatie\Image\Enums\Fit;

use App\Models\Traits\CleansHtml;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $nama
 * @property string $jabatan
 * @property string|null $nip
 * @property string|null $deskripsi_singkat
 * @property string|null $foto
 * @property int $urutan
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read mixed $foto_alt_text
 * @property-read mixed $foto_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereDeskripsiSingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pejabat whereUrutan($value)
 * @mixin \Eloquent
 */
class Pejabat extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity, CleansHtml, Searchable;

    protected $table = 'pejabat';

    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'deskripsi_singkat',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function toSearchableArray(): array {
        return ['nama' => $this->nama, 'nip' => $this->nip, 'jabatan' => $this->jabatan, 'deskripsi_singkat' => strip_tags($this->deskripsi_singkat ?? '')];
    }

    /**
     * Daftar atribut yang berisi input HTML dan perlu dibersihkan.
     *
     * @var array
     */
    protected $htmlFieldsToClean = [
        'deskripsi_singkat',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Crop, 400, 500) // <-- Gunakan Enum Fit::Crop
            ->quality(80)
            ->sharpen(10);
        
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Crop, 150, 150) // <-- Gunakan Enum Fit::Crop
            ->sharpen(10);

        $this
           ->addMediaConversion('webp-responsive')
           ->format('webp')
           ->withResponsiveImages();
    }

    public function getPathGenerator(): ModulePathGenerator
    {
        return new ModulePathGenerator();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'jabatan', 'nip', 'urutan', 'is_active'])
            ->logAll() // <-- Gunakan logAll() untuk menangkap perubahan media
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->nama ?? 'tanpa nama';
                if ($eventName === 'updated') {
                    $changes = $this->getChanges();
                    // Deskripsi kustom jika foto berubah
                    if (isset($changes['media'])) {
                        return "Foto untuk Pejabat \"{$subjectName}\" telah diperbarui";
                    }
                    $changedFields = implode(', ', array_keys($changes));
                    return "Data Pejabat \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Data Pejabat \"{$subjectName}\" telah di-{$eventName}";
            });
    }

        /**
     * Accessor untuk mendapatkan URL foto thumbnail dengan fallback.
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // PERBAIKAN KUNCI: Cek apakah symlink ada.
                if (! file_exists(public_path('storage'))) {
                    return 'https://placehold.co/400x500/E5E7EB/6B7280?text=No+Symlink';
                }

                $media = $this->getFirstMedia('foto_pejabat');

                if ($media && file_exists($media->getPath('preview'))) {
                    return $media->getUrl('preview');
                }
                
                // Fallback jika tidak ada data sama sekali
                return 'https://placehold.co/400x500/E5E7EB/6B7280?text=No+Photo';
            },
        );
    }

    /**
     * Accessor untuk nama file foto.
     * Berguna untuk alt text pada gambar.
     */
    protected function fotoAltText(): Attribute
    {
        return Attribute::make(
            get: fn () => "Foto " . $this->nama,
        );
    }
}