<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'key',
        'value',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['value']) // Hanya peduli pada perubahan nilai
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                if ($eventName === 'updated') {
                    $oldValue = Str::limit($this->getOriginal('value'), 30);
                    $newValue = Str::limit($this->getChanges()['value'], 30);
                    return "Pengaturan \"{$this->key}\" diubah dari '{$oldValue}' menjadi '{$newValue}'";
                }
                return "Pengaturan \"{$this->key}\" telah di-{$eventName}";
            });
    }
}