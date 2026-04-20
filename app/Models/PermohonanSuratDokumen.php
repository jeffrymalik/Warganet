<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanSuratDokumen extends Model
{
    protected $table = 'permohonan_surat_dokumen';

    protected $fillable = [
        'permohonan_surat_id',
        'nama_dokumen',
        'file',
    ];

    public function permohonanSurat(): BelongsTo
    {
        return $this->belongsTo(PermohonanSurat::class, 'permohonan_surat_id');
    }
}