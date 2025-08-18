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

class Pejabat extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

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
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->nama ?? 'tanpa nama';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
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
                $media = $this->getFirstMedia('foto_pejabat');

                // PERBAIKAN: Gunakan 'preview' untuk kualitas lebih tinggi
                if ($media && file_exists($media->getPath('preview'))) {
                    return $media->getUrl('preview');
                }
                
                // Fallback tetap sama
                return 'https://placehold.co/400x400/E5E7EB/6B7280?text=No+Photo';
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