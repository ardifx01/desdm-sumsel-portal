<?php

namespace App\Models;

use App\Models\Traits\HasColoredBadge;
use App\Models\Traits\HasFrontendBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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