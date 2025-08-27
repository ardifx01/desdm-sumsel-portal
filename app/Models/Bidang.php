<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Tambahkan ini untuk helper string
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\CleansHtml;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $nama
 * @property string $slug
 * @property string $tipe
 * @property string|null $tupoksi
 * @property int|null $pejabat_kepala_id
 * @property string|null $wilayah_kerja
 * @property string|null $alamat
 * @property string|null $map
 * @property string|null $grafik_kinerja
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Pejabat|null $kepala
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Seksi> $seksis
 * @property-read int|null $seksis_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereGrafikKinerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang wherePejabatKepalaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereTupoksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bidang whereWilayahKerja($value)
 * @mixin \Eloquent
 */
class Bidang extends Model
{
    use HasFactory, LogsActivity, CleansHtml, Searchable;

    // Nama tabel yang terkait dengan model ini (Laravel secara otomatis mengasumsikan 'bidangs')
    protected $table = 'bidangs';

    // Kolom-kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'nama',
        'slug',
        'tipe',
        'tupoksi',
        'pejabat_kepala_id',
        'wilayah_kerja',
        'alamat',
        'map',
        'grafik_kinerja',
        'is_active',
    ];

public function toSearchableArray(): array {
    return ['nama' => $this->nama, 'tupoksi' => strip_tags($this->tupoksi ?? '')];
}
    
    // Casting atribut ke tipe data tertentu
    protected $casts = [
        'is_active' => 'boolean',
    ];

        /**
     * Daftar atribut yang berisi input HTML dan perlu dibersihkan.
     *
     * @var array
     */
    protected $htmlFieldsToClean = [
        'tupoksi',
        'map',
        'grafik_kinerja',
    ];

    // Relasi: Satu Bidang memiliki banyak Seksi
    public function seksis()
    {
        return $this->hasMany(Seksi::class, 'bidang_id');
    }

    // Relasi: Satu Bidang memiliki satu Pejabat (sebagai kepala bidang)
    public function kepala()
    {
        return $this->belongsTo(Pejabat::class, 'pejabat_kepala_id');
    }

    // Mutator untuk otomatis membuat slug sebelum disimpan
    // Ini akan memastikan slug unik dan bersih
    public static function boot()
    {
        parent::boot();

        static::creating(function ($bidang) {
            $bidang->slug = $bidang->generateUniqueSlug($bidang->nama);
        });

        static::updating(function ($bidang) {
            if ($bidang->isDirty('nama')) { // Hanya update slug jika 'nama' berubah
                $bidang->slug = $bidang->generateUniqueSlug($bidang->nama);
            }
        });
    }

    // Helper function untuk generate slug unik
    protected function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'tipe', 'pejabat_kepala_id', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                $subjectName = $this->nama ?? 'tanpa nama';
                if ($eventName === 'updated') {
                    $changedFields = implode(', ', array_keys($this->getChanges()));
                    return "Data Bidang/Unit \"{$subjectName}\" telah diperbarui (kolom: {$changedFields})";
                }
                return "Data Bidang/Unit \"{$subjectName}\" telah di-{$eventName}";
            });
    }
}