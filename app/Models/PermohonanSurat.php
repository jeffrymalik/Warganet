<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermohonanSurat extends Model
{
    protected $table = 'permohonan_surat';

    protected $fillable = [
        'warga_id',
        'jenis_surat',
        'keperluan',
        'status',
        'catatan_admin',
        'file_surat',
        // Pengantar KTP
        'ktp_keperluan',
        // Domisili
        'domisili_lama_tinggal',
        // Pengantar KK
        'kk_keperluan',
        // SKTM
        'sktm_penghasilan',
        'sktm_jumlah_tanggungan',
        // SKCK
        'skck_keperluan',
    ];

    protected $casts = [
        'sktm_penghasilan'        => 'integer',
        'sktm_jumlah_tanggungan'  => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(PermohonanSuratDokumen::class, 'permohonan_surat_id');
    }

    // ─── Accessor ─────────────────────────────────────────

    public function getLabelJenisSuratAttribute(): string
    {
        return match ($this->jenis_surat) {
            'pengantar_ktp' => 'Surat Pengantar KTP',
            'domisili'      => 'Surat Keterangan Domisili',
            'pengantar_kk'  => 'Surat Pengantar KK',
            'sktm'          => 'Surat Keterangan Tidak Mampu',
            'skck'          => 'Surat Pengantar SKCK',
            default         => '-',
        };
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
            default    => '-',
        };
    }

    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'bg-yellow-100 text-yellow-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'selesai'  => 'bg-green-100 text-green-700',
            'ditolak'  => 'bg-red-100 text-red-700',
            default    => 'bg-gray-100 text-gray-700',
        };
    }

    public function getBadgeJenisSuratAttribute(): string
    {
        return match ($this->jenis_surat) {
            'pengantar_ktp' => 'bg-blue-100 text-blue-700',
            'domisili'      => 'bg-green-100 text-green-700',
            'pengantar_kk'  => 'bg-purple-100 text-purple-700',
            'sktm'          => 'bg-orange-100 text-orange-700',
            'skck'          => 'bg-red-100 text-red-700',
            default         => 'bg-gray-100 text-gray-700',
        };
    }

    public function getLabelKtpKeperluanAttribute(): string
    {
        return match ($this->ktp_keperluan) {
            'buat_baru' => 'Buat Baru',
            'hilang'    => 'Hilang',
            'rusak'     => 'Rusak',
            default     => '-',
        };
    }

    public function getLabelKkKeperluanAttribute(): string
    {
        return match ($this->kk_keperluan) {
            'baru'           => 'Buat Baru',
            'tambah_anggota' => 'Tambah Anggota',
            'pindah'         => 'Pindah',
            default          => '-',
        };
    }

    public function getSktmPenghasilanFormatAttribute(): string
    {
        return $this->sktm_penghasilan
            ? 'Rp ' . number_format($this->sktm_penghasilan, 0, ',', '.')
            : '-';
    }

    // ─── Helper ───────────────────────────────────────────

    public static function persyaratanWajib(string $jenis): array
    {
        return match ($jenis) {
            'pengantar_ktp' => ['fotokopi_kk'],
            'domisili'      => ['fotokopi_kk'],
            'pengantar_kk'  => ['buku_nikah_akta_nikah', 'kk_lama'],
            'sktm'          => ['fotokopi_kk'],
            'skck'          => ['fotokopi_ktp', 'fotokopi_kk', 'pas_foto'],
            default         => [],
        };
    }

    public static function persyaratanOpsional(string $jenis): array
    {
        return match ($jenis) {
            'pengantar_ktp' => ['ktp_lama', 'surat_kehilangan'],
            'domisili'      => ['bukti_tinggal'],
            'pengantar_kk'  => ['surat_kelahiran'],
            'sktm'          => ['foto_rumah'],
            'skck'          => [],
            default         => [],
        };
    }

    public static function labelDokumen(string $key): string
    {
        return match ($key) {
            'fotokopi_kk'           => 'Fotokopi KK',
            'fotokopi_ktp'          => 'Fotokopi KTP',
            'ktp_lama'              => 'KTP Lama',
            'surat_kehilangan'      => 'Surat Kehilangan (dari Polisi)',
            'bukti_tinggal'         => 'Bukti Tinggal (Kontrak/Surat Rumah)',
            'buku_nikah_akta_nikah' => 'Buku Nikah / Akta Nikah',
            'kk_lama'               => 'KK Lama',
            'surat_kelahiran'       => 'Surat Kelahiran',
            'foto_rumah'            => 'Foto Rumah',
            'pas_foto'              => 'Pas Foto',
            default                 => $key,
        };
    }
}