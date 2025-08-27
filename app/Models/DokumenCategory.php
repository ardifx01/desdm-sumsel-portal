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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dokumen> $dokumen
 * @property-read int|null $dokumen_count
 * @property-read mixed $frontend_badge_class
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DokumenCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DokumenCategory extends Model
{
    use HasFactory, LogsActivity, HasColoredBadge, HasFrontendBadge;

    protected $table = 'dokumen_categories';
    protected $fillable = ['nama', 'slug', 'deskripsi'];

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'deskripsi'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori Dokumen \"{$this->nama}\" telah di-{$eventName}");
    }
}