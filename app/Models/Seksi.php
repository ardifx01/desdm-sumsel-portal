<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\CleansHtml;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property int $bidang_id
 * @property string $nama_seksi
 * @property string|null $tugas
 * @property int $urutan
 * @property int|null $pejabat_kepala_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Bidang $bidang
 * @property-read \App\Models\Pejabat|null $kepala
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereBidangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereNamaSeksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi wherePejabatKepalaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seksi whereUrutan($value)
 * @mixin \Eloquent
 */
class Seksi extends Model
{
    use HasFactory, LogsActivity, CleansHtml, Searchable;

    // Nama tabel yang terkait dengan model ini (Laravel secara otomatis mengasumsikan 'seksis')
    protected $table = 'seksis';

    // Kolom-kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'bidang_id',
        'nama_seksi',
        'tugas',
        'urutan',
        'pejabat_kepala_id',
        'is_active',
    ];

    // Casting atribut ke tipe data tertentu
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function toSearchableArray(): array {
        return ['nama_seksi' => $this->nama_seksi, 'tugas' => strip_tags($this->tugas ?? '')];
    }
    
        /**
     * Daftar atribut yang berisi input HTML dan perlu dibersihkan.
     *
     * @var array
     */
    protected $htmlFieldsToClean = [
        'tugas',
    ];

    // Relasi: Satu Seksi adalah milik satu Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    // Relasi: Satu Seksi memiliki satu Pejabat (sebagai kepala seksi)
    public function kepala()
    {
        return $this->belongsTo(Pejabat::class, 'pejabat_kepala_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_seksi', 'urutan', 'pejabat_kepala_id', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->nama_seksi ?? 'tanpa nama';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Data Seksi \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Data Seksi \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}