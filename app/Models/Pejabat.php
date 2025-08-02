<?php

namespace App\Models;

use App\Support\ModulePathGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Pejabat extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'pejabat';

    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'deskripsi_singkat',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);

        $this
           ->addMediaConversion('webp-responsive')
           ->format('webp')
           ->withResponsiveImages();
    }

    public function getPathGenerator(): ModulePathGenerator
    {
        return new ModulePathGenerator();
    }
}