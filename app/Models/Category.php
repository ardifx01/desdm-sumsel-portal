<?php

namespace App\Models;

use App\Models\Traits\HasColoredBadge;
use App\Models\Traits\HasFrontendBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read mixed $badge_class
 * @property-read mixed $frontend_badge_class
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory, LogsActivity, HasColoredBadge, HasFrontendBadge;
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['badge_class'];
    protected $table = 'categories';
    public $timestamps = false;
    protected $fillable = ['name', 'slug', 'type'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori Berita \"{$this->name}\" telah di-{$eventName}");
    }
}