<?php

namespace App\Notifications;

use App\Models\PermohonanSurat;
use Illuminate\Notifications\Notification;

class SuratBaruNotification extends Notification
{
    public function __construct(public PermohonanSurat $surat) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'judul' => 'Permohonan Surat Baru',
            'pesan' => "Permohonan surat ".str_replace('_', ' ', $this->surat->jenis_surat)." dari {$this->surat->warga->nama_lengkap}.",
            'url'   => route('admin.surat.show', $this->surat->id),
            'tipe'  => 'surat',
            'icon'  => 'info',
        ];
    }
}