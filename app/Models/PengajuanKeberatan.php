<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property int $user_id
 * @property string $nomor_registrasi_permohonan
 * @property string $alasan_keberatan
 * @property string $jenis_keberatan
 * @property string|null $kasus_posisi
 * @property string $status
 * @property string|null $catatan_admin
 * @property \Illuminate\Support\Carbon $tanggal_pengajuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereAlasanKeberatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereCatatanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereJenisKeberatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereKasusPosisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereNomorRegistrasiPermohonan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereTanggalPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PengajuanKeberatan whereUserId($value)
 * @mixin \Eloquent
 */
class PengajuanKeberatan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pengajuan_keberatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nomor_registrasi_permohonan',
        'alasan_keberatan',
        'jenis_keberatan',
        'kasus_posisi',
        'status',
        'catatan_admin',
        'tanggal_pengajuan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
    ];

    /**
     * Get the user that owns the keberatan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Otomatis set tanggal pengajuan saat membuat data baru
        static::creating(function ($model) {
            if (empty($model->tanggal_pengajuan)) {
                $model->tanggal_pengajuan = now();
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'catatan_admin'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $regNum = $this->nomor_registrasi_permohonan ?? 'N/A';
                if ($eventName === 'updated') {
                    $changes = $this->getChanges();
                    $details = [];
                    if (isset($changes['status'])) {
                        $oldStatus = $this->getOriginal('status');
                        $details[] = "status diubah dari '{$oldStatus}' menjadi '{$changes['status']}'";
                    }
                    if (isset($changes['catatan_admin'])) {
                        $details[] = "catatan admin diperbarui";
                    }
                    return "Keberatan untuk #{$regNum} diperbarui: " . implode(', ', $details);
                }
                return "Keberatan untuk #{$regNum} telah di-{$eventName}";
            });
    }
}