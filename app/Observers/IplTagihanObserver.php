<?php

namespace App\Observers;

use App\Models\IplTagihan;
use App\Notifications\TagihanIplNotification;

class IplTagihanObserver
{
    public function created(IplTagihan $tagihan): void
    {
        // Notif ke kepala keluarga
        $kepala = $tagihan->kartuKeluarga->kepalaKeluarga;
        if ($kepala?->user) {
            $kepala->user->notify(new TagihanIplNotification($tagihan));
        }
    }
}