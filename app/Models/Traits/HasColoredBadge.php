<?php // app/Models/Traits/HasColoredBadge.php
namespace App\Models\Traits;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasColoredBadge
{
    protected function badgeClass(): Attribute
    {
        return Attribute::make(
            get: function () {
                $baseClasses = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full';
                $categoryName = $this->name ?? $this->nama ?? 'default';
                $color = getUniqueBadgeColor($categoryName); // Panggil helper baru kita
                return "{$baseClasses} bg-{$color}-100 text-{$color}-800";
            }
        );
    }
}