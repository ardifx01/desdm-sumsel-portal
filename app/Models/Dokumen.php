<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property int $category_id
 * @property string $judul
 * @property string $slug
 * @property string|null $deskripsi
 * @property string $file_path
 * @property string $file_nama
 * @property string|null $file_tipe
 * @property \Illuminate\Support\Carbon|null $tanggal_publikasi
 * @property int $hits
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\DokumenCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereFileNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereFileTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereTanggalPublikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dokumen whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dokumen extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $table = 'dokumen';

    protected $fillable = [
        'category_id',
        'judul',
        'slug',
        'deskripsi',
        'file_path',
        'file_nama',
        'file_tipe',
        'tanggal_publikasi',
        'hits',
        'is_active',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function toSearchableArray(): array {
        return ['judul' => $this->judul, 'deskripsi' => strip_tags($this->deskripsi ?? '')];
    }
    
    // Definisi relasi: Setiap dokumen termasuk dalam satu kategori
    public function category()
    {
        return $this->belongsTo(DokumenCategory::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'category_id', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->judul ?? 'tanpa judul';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Dokumen \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Dokumen \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}