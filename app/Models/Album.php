<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- TAMBAHKAN BARIS INI
use Illuminate\Support\Facades\Storage; 

/**
 * @property int $id
 * @property string $nama
 * @property string $slug
 * @property string|null $deskripsi
 * @property string|null $thumbnail
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read mixed $admin_thumb_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Photo> $photos
 * @property-read int|null $photos_count
 * @property-read mixed $thumbnail_url
 * @method static \Illuminate\Database\Eloquent\Builder|Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album query()
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Album extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['nama', 'slug', 'deskripsi', 'thumbnail', 'is_active'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Pengecekan symlink tetap ada untuk keamanan
                if (! file_exists(public_path('storage'))) {
                    return null;
                }

                // --- LOGIKA BARU YANG LEBIH PINTAR ---

                // Prioritas 1: Cek apakah ada thumbnail yang diatur secara eksplisit.
                $explicitThumbnail = $this->attributes['thumbnail'] ?? null;
                if ($explicitThumbnail && Storage::disk('public')->exists($explicitThumbnail)) {
                    return asset('storage/' . $explicitThumbnail);
                }

                // Prioritas 2: Jika tidak ada, fallback ke FOTO PERTAMA di dalam album.
                if ($this->photos()->exists()) {
                    $firstPhoto = $this->photos()->first(); // Ambil foto pertama
                    if ($firstPhoto && $firstPhoto->file_path && Storage::disk('public')->exists($firstPhoto->file_path)) {
                        return asset('storage/' . $firstPhoto->file_path);
                    }
                }
                
                // Fallback final jika tidak ada thumbnail EKSPLISIT dan TIDAK ADA FOTO SAMA SEKALI.
                return null;
            }
        );
    }
    
    /**
     * Accessor untuk thumbnail di Dasbor Admin, dengan logika fallback.
     */
    protected function adminThumbUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Pengecekan symlink
                if (! file_exists(public_path('storage'))) {
                    return null;
                }

                // Prioritas 1: Thumbnail eksplisit
                $thumbnailPath = $this->attributes['thumbnail'] ?? null;
                if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                    return asset('storage/' . $thumbnailPath);
                }

                // Prioritas 2: Fallback ke foto pertama
                if ($this->photos()->exists()) {
                    $firstPhoto = $this->photos()->first();
                    if ($firstPhoto && $firstPhoto->file_path && Storage::disk('public')->exists($firstPhoto->file_path)) {
                        return asset('storage/' . $firstPhoto->file_path);
                    }
                }
                
                return null; // Fallback jika tidak ada gambar sama sekali
            }
        );
    }
        
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Tambahkan thumbnail ke logOnly
            ->logOnly(['nama', 'deskripsi', 'is_active', 'thumbnail'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
                ->setDescriptionForEvent(function(string $eventName) {
                    $subjectName = $this->nama ?? 'tanpa nama';
                    if ($eventName === 'updated') {
                        $changedFields = implode(', ', array_keys($this->getChanges()));
                        return "Album Foto \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                    }
                    return "Album Foto \"{$subjectName}\" telah di-{$eventName}";
                });
    }    
    
}