<?php

namespace App\Notifications;

use App\Models\IuranWarga;
use Illuminate\Notifications\Notification;

class IuranBaruNotification extends Notification
{
    public function __construct(public IuranWarga $iuran) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'judul' => 'Iuran Baru',
            'pesan' => "Iuran \"{$this->iuran->nama}\" telah diterbitkan.",
            'ref_id' => $this->iuran->id,
            'tipe'  => 'iuran',
            'icon'  => 'warning',
        ];
    }
}