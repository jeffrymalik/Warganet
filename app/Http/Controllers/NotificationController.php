<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(20);

        Auth::user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    public function show(string $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $tipe   = $notification->data['tipe'] ?? null;
        $ref_id = $notification->data['ref_id'] ?? null;
        $role   = Auth::user()->role; // atau hasRole() kalau pakai Spatie

        $url = match(true) {
            $tipe === 'ipl'     && $role === 'admin'  => route('admin.ipl.index'),
            $tipe === 'ipl'     && $role === 'warga'  => route('warga.tagihan.index'),
            $tipe === 'iuran'   && $role === 'admin'  => route('admin.iuran.index'),
            $tipe === 'iuran'   && $role === 'warga'  => route('warga.tagihan.index'),
            $tipe === 'keluhan' && $role === 'admin'  => route('admin.keluhan.show', $ref_id),
            $tipe === 'keluhan' && $role === 'warga'  => route('warga.keluhan.show', $ref_id),
            $tipe === 'surat'   && $role === 'admin'  => route('admin.surat.show', $ref_id),
            $tipe === 'surat'   && $role === 'warga'  => route('warga.surat.show', $ref_id),
            default => route('notifications.index'),
        };

        return redirect($url);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
}