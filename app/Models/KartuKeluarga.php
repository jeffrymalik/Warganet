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
        'alamat',
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

        public function anggota()
    {
        return $this->hasMany(\App\Models\Warga::class, 'kartu_keluarga_id');
    }

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

    /**
     * Total pendapatan seluruh anggota KK (termasuk kepala keluarga)
     */
    public function getTotalPendapatanAttribute(): int
    {
        return $this->wargas->sum('pendapatan');
    }

    /**
     * Format total pendapatan KK ke Rupiah
     */
    public function getTotalPendapatanFormatAttribute(): string
      {
        return 'Rp ' . number_format($this->total_pendapatan, 0, ',', '.');
    }

    /**
     * Kategori ekonomi berdasarkan total pendapatan seluruh KK
     */
    public function getKategoriEkonomiAttribute(): string
    {
         return match (true) {
            $this->total_pendapatan < 1_000_000                                          => 'Tidak Mampu',
            $this->total_pendapatan >= 1_000_000 && $this->total_pendapatan <= 3_000_000 => 'Kurang Mampu',
            $this->total_pendapatan > 3_000_000 && $this->total_pendapatan <= 7_000_000  => 'Mampu',
            $this->total_pendapatan > 7_000_000                                          => 'Sangat Mampu',
            default                                                                      => '-',
        };
    }

    /**
     * Warna badge kategori ekonomi KK (Tailwind class)
     */
    public function getBadgeEkonomiAttribute(): string
    {
        return match ($this->kategori_ekonomi) {
            'Tidak Mampu'  => 'bg-red-100 text-red-700',
            'Kurang Mampu' => 'bg-orange-100 text-orange-700',
            'Mampu'        => 'bg-blue-100 text-blue-700',
            'Sangat Mampu' => 'bg-green-100 text-green-700',
            default        => 'bg-gray-100 text-gray-700'
        }; 
    }
}  