<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeluhanPesan extends Model
{
    protected $table = 'keluhan_pesan';

    protected $fillable = [
        'keluhan_id',
        'user_id',
        'pesan',
    ];

    // ─── Relasi ───────────────────────────────────────────

    public function keluhan(): BelongsTo
    {
        return $this->belongsTo(Keluhan::class, 'keluhan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ─── Accessor ─────────────────────────────────────────

    public function getIsAdminAttribute(): bool
    {
        return $this->user->role === 'admin';
    }
}