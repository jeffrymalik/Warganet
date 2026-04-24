<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Warga;
use App\Models\User;
use App\Models\Keluhan;
use App\Models\IplTagihan;
use App\Models\PermohonanSurat;
use App\Models\IuranTagihan;
use App\Models\Pengumuman;
use App\Models\JadwalKegiatan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('warga.dashboard');
    }

    public function adminIndex()
    {
        $totalKK       = KartuKeluarga::count();
        $totalWarga    = Warga::where('status_warga', 'aktif')->count();
        $totalUsers    = User::where('role', 'warga')->count();
        $keluhanBaru   = Keluhan::where('status', 'menunggu')->count();
        $iplBelumBayar = IplTagihan::where('status', 'belum_bayar')->count();
        $suratMenunggu = PermohonanSurat::where('status', 'menunggu')->count();
        $iuranMenunggu = IuranTagihan::where('status', 'belum_bayar')->count();
        $recentKeluhan = Keluhan::with('warga')->latest()->take(5)->get();
        $recentSurat   = PermohonanSurat::with('warga')->latest()->take(5)->get();
        $pengumuman    = Pengumuman::where('is_published', 1)->latest()->take(3)->get();
        $jadwal = JadwalKegiatan::orderBy('tanggal_mulai', 'desc')->take(3)->get();

        return view('pages.admin.index', compact(
            'totalKK', 'totalWarga', 'totalUsers',
            'keluhanBaru', 'iplBelumBayar', 'suratMenunggu', 'iuranMenunggu',
            'recentKeluhan', 'recentSurat', 'pengumuman', 'jadwal'
        ));
    }

    public function wargaIndex()
    {
        $user  = Auth::user();
        $warga = $user->warga()->with('kartuKeluarga')->first();
        $kk    = $warga?->kartuKeluarga;

        $tagihan         = IplTagihan::where('kk_id', $kk?->id)->where('status', 'belum_bayar')->count();
        $iuranBelumBayar = IuranTagihan::where('kk_id', $kk?->id)->where('status', 'belum_bayar')->count();
        $keluhanSaya     = Keluhan::where('warga_id', $warga?->id)->latest()->take(5)->get();
        $suratSaya       = PermohonanSurat::where('warga_id', $warga?->id)->latest()->take(5)->get();
        $pengumuman      = Pengumuman::where('is_published', 1)->latest()->take(3)->get();
        $jadwal = JadwalKegiatan::orderBy('tanggal_mulai', 'desc')->take(3)->get();

        return view('pages.warga.index', compact(
            'warga', 'kk',
            'tagihan', 'iuranBelumBayar',
            'keluhanSaya', 'suratSaya',
            'pengumuman', 'jadwal'
        ));
    }
}