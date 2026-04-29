<?php

namespace App\Notifications;

use App\Models\Keluhan;
use Illuminate\Notifications\Notification;

class StatusKeluhanNotification extends Notification
{
    public function __construct(public Keluhan $keluhan) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $label = match($this->keluhan->status) {
            'diproses' => 'sedang diproses',
            'selesai'  => 'telah selesai',
            'ditolak'  => 'ditolak',
            default    => $this->keluhan->status,
        };

        return [
            'judul' => 'Status Keluhan Diperbarui',
            'pesan' => "Keluhan \"{$this->keluhan->judul}\" {$label}.",
            'ref_id'   => route('warga.keluhan.show', $this->keluhan->id),
            'tipe'  => 'keluhan',
            'icon'  => 'info',
        ];
    }
}