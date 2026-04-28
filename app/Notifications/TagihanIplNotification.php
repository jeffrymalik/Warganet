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
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $bulan = $namaBulan[$this->tagihan->bulan] ?? '-';

        return [
            'judul' => 'Tagihan IPL Baru',
            'pesan' => "Tagihan IPL bulan {$bulan} {$this->tagihan->tahun} telah diterbitkan.",
            'url'   => route('warga.ipl.index'),
            'tipe'  => 'ipl',
            'icon'  => 'error',
        ];
    }
}