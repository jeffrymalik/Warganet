<?php

namespace App\Notifications;

use App\Models\IplTagihan;
use Illuminate\Notifications\Notification;

class TagihanIplNotification extends Notification
{
    public function __construct(public IplTagihan $tagihan) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $bulan = \Carbon\Carbon::create()->month($this->tagihan->bulan)->translatedFormat('F');

        return [
            'judul' => 'Tagihan IPL Baru',
            'pesan' => "Tagihan IPL bulan {$bulan} {$this->tagihan->tahun} telah diterbitkan.",
            'url'   => route('warga.ipl.index'),
            'tipe'  => 'ipl',
            'icon'  => 'error',
        ];
    }
}