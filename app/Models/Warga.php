<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warga extends Model
{
    use SoftDeletes;

    protected $table = 'warga';

    protected $fillable = [
        'user_id',
        'kartu_keluarga_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'no_telepon',
        'pendapatan',
        'is_kepala_keluarga',
        'status_dalam_kk',
        'status_warga',
    ];

    protected $casts = [
        'tanggal_lahir'      => 'date',
        'is_kepala_keluarga' => 'boolean',
        'pendapatan'         => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────

    /**
     * Akun user (login) milik warga ini
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Kartu Keluarga milik warga ini
     */
    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    // ─── Accessor ─────────────────────────────────────────

    /**
     * Kategori ekonomi otomatis berdasarkan pendapatan per bulan
     *
     * < 1.000.000          → Tidak Mampu
     * 1.000.000 - 3.000.000 → Kurang Mampu
     * 3.000.001 - 7.000.000 → Mampu
     * > 7.000.000          → Sangat Mampu
     */
    public function getKategoriEkonomiAttribute(): string
    {
        return match (true) {
            $this->pendapatan < 1_000_000                                    => 'Tidak Mampu',
            $this->pendapatan >= 1_000_000 && $this->pendapatan <= 3_000_000 => 'Kurang Mampu',
            $this->pendapatan > 3_000_000 && $this->pendapatan <= 7_000_000  => 'Mampu',
            $this->pendapatan > 7_000_000                                    => 'Sangat Mampu',
            default                                                          => '-',
        };
    }

    /**
     * Warna badge untuk kategori ekonomi (Tailwind class)
     */
    public function getBadgeEkonomiAttribute(): string
    {
        return match ($this->kategori_ekonomi) {
            'Tidak Mampu'   => 'bg-red-100 text-red-700',
            'Kurang Mampu'  => 'bg-orange-100 text-orange-700',
            'Mampu'         => 'bg-blue-100 text-blue-700',
            'Sangat Mampu'  => 'bg-green-100 text-green-700',
            default         => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Umur warga dihitung dari tanggal lahir
     */
    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir->age;
    }

    /**
     * Format pendapatan ke Rupiah
     */
    public function getPendapatanFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->pendapatan, 0, ',', '.');
    }

    /**
     * Label status warga yang lebih rapi
     */
    public function getLabelStatusWargaAttribute(): string
    {
        return match ($this->status_warga) {
            'aktif'       => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'pindah'      => 'Pindah',
            'meninggal'   => 'Meninggal',
            default       => '-',
        };
    }

    /**
     * Warna badge status warga (Tailwind class)
     */
    public function getBadgeStatusWargaAttribute(): string
    {
        return match ($this->status_warga) {
            'aktif'       => 'bg-green-100 text-green-700',
            'tidak_aktif' => 'bg-gray-100 text-gray-700',
            'pindah'      => 'bg-yellow-100 text-yellow-700',
            'meninggal'   => 'bg-red-100 text-red-700',
            default       => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Label jenis kelamin
     */
    public function getLabelJenisKelaminAttribute(): string
    {
        return match ($this->jenis_kelamin) {
            'laki_laki'  => 'Laki-laki',
            'perempuan'  => 'Perempuan',
            default      => '-',
        };
    }

    /**
     * Label status dalam KK
     */
    public function getLabelStatusKkAttribute(): string
    {
        return match ($this->status_dalam_kk) {
            'kepala_keluarga' => 'Kepala Keluarga',
            'istri'           => 'Istri',
            'anak'            => 'Anak',
            'lainnya'         => 'Lainnya',
            default           => '-',
        };
    }

    // ─── Scope ────────────────────────────────────────────

    /**
     * Filter hanya warga aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_warga', 'aktif');
    }

    /**
     * Filter hanya kepala keluarga
     */
    public function scopeKepalaKeluarga($query)
    {
        return $query->where('is_kepala_keluarga', true);
    }

    /**
     * Filter berdasarkan kategori ekonomi
     */
    public function scopeKategoriEkonomi($query, string $kategori)
    {
        return match ($kategori) {
            'tidak_mampu'  => $query->where('pendapatan', '<', 1_000_000),
            'kurang_mampu' => $query->whereBetween('pendapatan', [1_000_000, 3_000_000]),
            'mampu'        => $query->whereBetween('pendapatan', [3_000_001, 7_000_000]),
            'sangat_mampu' => $query->where('pendapatan', '>', 7_000_000),
            default        => $query,
        };
    }
}