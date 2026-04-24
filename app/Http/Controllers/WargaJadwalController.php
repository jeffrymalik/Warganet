<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;

class WargaJadwalController extends Controller
{
    public function index()
    {
        return view('pages.warga.jadwal');
    }

    public function ambil()
    {
        $jadwal = JadwalKegiatan::all();

        $events = $jadwal->map(function ($j) {
            $colorMap = [
                'primary' => '#465fff',
                'success' => '#17a34a',
                'danger'  => '#e02424',
                'warning' => '#f59e0b',
            ];

            $end = \Carbon\Carbon::parse($j->tanggal_selesai)->addDay()->format('Y-m-d');

            return [
                'id'    => $j->id,
                'title' => $j->judul,
                'start' => $j->tanggal_mulai,
                'end'   => $end,
                'color' => $colorMap[$j->color] ?? '#465fff',
                'extendedProps' => [
                    'deskripsi' => $j->deskripsi,
                    'color'     => $j->color,
                ],
            ];
        });

        return response()->json($events);
    }
}