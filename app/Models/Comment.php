<?php

// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Comment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'content',
        'post_id',
        'user_id',
        'name',      // <-- Tambahkan ini
        'email',     // <-- Tambahkan ini
        'status',    // <-- Tambahkan ini
        'email_verified_at',
        'parent_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi untuk komentar anak (balasan)
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relasi untuk komentar induk (asli)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logOnly(['status'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs()
        ->setDescriptionForEvent(function(string $eventName) {
            
            // Logika untuk event 'updated'
            if ($eventName === 'updated') {
                // PERBAIKAN KUNCI: Cek apakah 'status' benar-benar salah satu atribut yang berubah.
                if (array_key_exists('status', $this->getChanges())) {
                    $oldStatus = $this->getOriginal('status');
                    $newStatus = $this->getChanges()['status'];
                    return "Status Komentar #{$this->id} diubah dari \"{$oldStatus}\" menjadi \"{$newStatus}\"";
                }
                
                // Fallback untuk update lain (seperti verifikasi email)
                return "Komentar #{$this->id} telah diperbarui (non-status change)";
            }

            // Logika untuk event lain
            if ($eventName === 'created') {
                return "Komentar baru #{$this->id} telah dibuat oleh \"{$this->name}\"";
            }

            if ($eventName === 'deleted') {
                return "Komentar #{$this->id} telah dihapus";
            }

            // Fallback umum
            return "Komentar #{$this->id} telah di-{$eventName}";
        });
}
}