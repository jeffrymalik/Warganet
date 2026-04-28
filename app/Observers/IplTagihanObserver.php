<?php

namespace App\Observers;

use App\Models\IplTagihan;
use App\Notifications\TagihanIplNotification;

class IplTagihanObserver
{
    public function created(IplTagihan $tagihan): void
    {
        $tagihan->load('kk.kepalaKeluarga.user');

        $kepala = $tagihan->kk?->kepalaKeluarga;

        if ($kepala?->user) {
            $kepala->user->notify(new TagihanIplNotification($tagihan));
        }
    }
}