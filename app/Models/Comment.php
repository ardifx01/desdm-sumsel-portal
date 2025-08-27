<?php

// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property string $content
 * @property int $post_id
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $email_verified_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Comment|null $parent
 * @property-read \App\Models\Post $post
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @mixin \Eloquent
 */
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