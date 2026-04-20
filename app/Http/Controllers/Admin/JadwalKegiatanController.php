<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;

class JadwalKegiatanController extends Controller
{
    public function index()
    {
        return view('pages.admin.jadwal.index');
    }

    /**
     * Dipanggil FullCalendar via AJAX untuk mengambil semua event
     */
    public function ambilJadwal()
    {
        $colorMap = [
            'primary' => '#465fff',
            'success' => '#17a34a',
            'danger'  => '#ef4444',
            'warning' => '#f59e0b',
        ];

        $jadwal = JadwalKegiatan::all()->map(function ($item) use ($colorMap) {
            return [
                'id'    => $item->id,
                'title' => $item->judul,
                'start' => $item->tanggal_mulai->toDateString(),
                // FullCalendar: end date bersifat exclusive, jadi +1 hari
                'end'   => $item->tanggal_selesai->addDay()->toDateString(),
                'color' => $colorMap[$item->color] ?? '#465fff',
                'extendedProps' => [
                    'color'     => $item->color,
                    'deskripsi' => $item->deskripsi,
                ],
            ];
        });

        return response()->json($jadwal);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'color'           => 'required|in:primary,success,danger,warning',
        ]);

        $jadwal = JadwalKegiatan::create([
            'judul'           => $request->judul,
            'deskripsi'       => $request->deskripsi,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'color'           => $request->color,
            'created_by'      => auth()->id(),
        ]);

        return response()->json([
            'pesan'  => 'Jadwal berhasil ditambahkan',
            'jadwal' => $jadwal,
        ]);
    }

    public function update(Request $request, JadwalKegiatan $jadwal)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'color'           => 'required|in:primary,success,danger,warning',
        ]);

        $jadwal->update([
            'judul'           => $request->judul,
            'deskripsi'       => $request->deskripsi,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'color'           => $request->color,
        ]);

        return response()->json([
            'pesan'  => 'Jadwal berhasil diperbarui',
            'jadwal' => $jadwal,
        ]);
    }

    public function destroy(JadwalKegiatan $jadwal)
    {
        $jadwal->delete();

        return response()->json([
            'pesan' => 'Jadwal berhasil dihapus',
        ]);
    }
}