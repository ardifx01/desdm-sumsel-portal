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
 * @property int $album_id
 * @property string|null $judul
 * @property string|null $deskripsi
 * @property string $file_path
 * @property string $file_name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read mixed $admin_thumb_url
 * @property-read \App\Models\Album $album
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Photo extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['album_id', 'judul', 'deskripsi', 'file_path', 'file_name', 'is_active'];

    public function album()
    {
        return $this->belongsTo(Album::class);
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

                $filePath = $this->attributes['file_path'] ?? null;
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    return asset('storage/' . $filePath);
                }
                
                return null;
            }
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Tambahkan file_path
            ->logOnly(['judul', 'deskripsi', 'is_active', 'file_path'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->judul ?: $this->file_name;
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Foto \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Foto \"{$subjectName}\" telah di-{$eventName}";
            });
    }
    
}