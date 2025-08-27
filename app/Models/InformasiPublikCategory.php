<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\HasColoredBadge;
use App\Models\Traits\HasFrontendBadge;

/**
 * @property int $id
 * @property string $nama
 * @property string $slug
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read mixed $badge_class
 * @property-read mixed $frontend_badge_class
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InformasiPublik> $informasiPublik
 * @property-read int|null $informasi_publik_count
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InformasiPublikCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InformasiPublikCategory extends Model
{
    use HasFactory, LogsActivity, HasColoredBadge, HasFrontendBadge;

    protected $table = 'informasi_publik_categories';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
    ];

    // Definisi relasi: Satu kategori bisa memiliki banyak informasi publik
    public function informasiPublik()
    {
        return $this->hasMany(InformasiPublik::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'deskripsi'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori Info Publik \"{$this->nama}\" telah di-{$eventName}");
    }
}