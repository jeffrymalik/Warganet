<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'no_kk',
        'no_rumah',
        'blok',
        'status_hunian',
        'tanggal_mulai_tinggal',
    ];

    protected $casts = [
        'tanggal_mulai_tinggal' => 'date',
    ];

    // ─── Relasi ───────────────────────────────────────────

    /**
     * Semua anggota warga dalam KK ini
     */
    public function wargas(): HasMany
    {
        return $this->hasMany(Warga::class, 'kartu_keluarga_id');
    }

    /**
     * Kepala keluarga (hanya 1)
     */
    public function kepalaKeluarga()
    {
        return $this->hasOne(Warga::class, 'kartu_keluarga_id')
                    ->where('is_kepala_keluarga', true);
    }

    /**
     * Anggota keluarga (selain kepala keluarga)
     */
    public function anggota(): HasMany
    {
        return $this->hasMany(Warga::class, 'kartu_keluarga_id')
                    ->where('is_kepala_keluarga', false);
    }

    // ─── Accessor ─────────────────────────────────────────

    /**
     * Label status hunian yang lebih rapi
     */
    public function getLabelStatusHunianAttribute(): string
    {
        return match ($this->status_hunian) {
            'pemilik' => 'Pemilik',
            'kontrak' => 'Kontrak',
            'kost'    => 'Kost',
            default   => '-',
        };
    }

    /**
     * Alamat lengkap (No. Rumah + Blok jika ada)
     */
    public function getAlamatLengkapAttribute(): string
    {
        return $this->blok
            ? "No. {$this->no_rumah} Blok {$this->blok}"
            : "No. {$this->no_rumah}";
    }
}