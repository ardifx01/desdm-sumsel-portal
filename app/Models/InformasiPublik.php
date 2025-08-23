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