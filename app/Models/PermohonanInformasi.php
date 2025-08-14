<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon; // <-- Tambahkan ini
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PermohonanInformasi extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'permohonan_informasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nomor_registrasi',
        'jenis_pemohon', // <-- Tambahkan kembali
        'pekerjaan_pemohon', // <-- Tambahkan kembali
        'identitas_pemohon', // <-- Tambahkan kembali
        'rincian_informasi',
        'tujuan_penggunaan_informasi',
        'cara_mendapatkan_informasi',
        'cara_mendapatkan_salinan',
        'status',
        'catatan_admin',
        'tanggal_permohonan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_permohonan' => 'datetime',
    ];

    /**
     * Get the user that owns the permohonan.
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

        // Otomatis generate nomor registrasi saat membuat data baru
        static::creating(function ($model) {
            if (empty($model->tanggal_permohonan)) {
                $model->tanggal_permohonan = now();
            }

            if (empty($model->nomor_registrasi)) {
                // --- LOGIKA PENOMORAN BARU DI SINI ---
                $today = Carbon::today();
                $prefix = $today->format('Ymd'); // Format: 20250814

                // Cari permohonan terakhir yang dibuat HARI INI
                $lastPermohonanToday = static::whereDate('tanggal_permohonan', $today)->orderBy('id', 'desc')->first();

                if ($lastPermohonanToday) {
                    // Jika ada, ambil nomor urut terakhir dan tambahkan 1
                    $lastNumber = (int)substr($lastPermohonanToday->nomor_registrasi, -3);
                    $newNumber = $lastNumber + 1;
                } else {
                    // Jika ini yang pertama hari ini, mulai dari 1
                    $newNumber = 1;
                }

                // Format nomor urut menjadi 3 digit (001, 002, dst.)
                $sequence = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

                $model->nomor_registrasi = $prefix . $sequence; // Hasil: 20250814001
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
                $regNum = $this->nomor_registrasi ?? 'N/A';
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
                    return "Permohonan #{$regNum} diperbarui: " . implode(', ', $details);
                }
                return "Permohonan #{$regNum} telah di-{$eventName}";
            });
    }
}