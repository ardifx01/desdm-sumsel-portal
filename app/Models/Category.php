<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'categories';
    public $timestamps = false;
    protected $fillable = ['name', 'slug', 'type'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function scopeOfTypePost($query)
    {
        return $query->where('type', 'post');
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