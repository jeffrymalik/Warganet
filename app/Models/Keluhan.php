<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keluhan extends Model
{
    protected $table = 'keluhan';

    protected $fillable = [
        'warga_id',
        'judul',
        'deskripsi',
        'kategori',
        'status',
        'foto',
    ];

    // ─── Relasi ───────────────────────────────────────────

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    // ─── Accessor ─────────────────────────────────────────

    public function getLabelKategoriAttribute(): string
    {
        return match ($this->kategori) {
            'infrastruktur' => 'Infrastruktur',
            'keamanan'      => 'Keamanan',
            'kebersihan'    => 'Kebersihan',
            'sosial'        => 'Sosial',
            'lainnya'       => 'Lainnya',
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

    public function getBadgeKategoriAttribute(): string
    {
        return match ($this->kategori) {
            'infrastruktur' => 'bg-orange-100 text-orange-700',
            'keamanan'      => 'bg-red-100 text-red-700',
            'kebersihan'    => 'bg-green-100 text-green-700',
            'sosial'        => 'bg-blue-100 text-blue-700',
            'lainnya'       => 'bg-gray-100 text-gray-700',
            default         => 'bg-gray-100 text-gray-700',
        };
    }
    // Tambah relasi
    public function pesans()
    {
        return $this->hasMany(KeluhanPesan::class, 'keluhan_id')->oldest();
    }
}