<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\CleansHtml;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StaticPage extends Model
{
    use HasFactory, LogsActivity, CleansHtml;

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    /**
     * Daftar atribut yang berisi input HTML dan perlu dibersihkan.
     *
     * @var array
     */
    protected $htmlFieldsToClean = [
        'content',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'content'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Halaman Statis \"{$this->title}\" telah di-{$eventName}");
    }
}