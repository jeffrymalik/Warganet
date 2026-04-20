<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use App\Models\KeluhanPesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluhanController extends Controller
{
    public function index(Request $request)
    {
        $query = Keluhan::with(['warga.kartuKeluarga']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('warga', function ($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $keluhanList = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'menunggu' => Keluhan::where('status', 'menunggu')->count(),
            'diproses' => Keluhan::where('status', 'diproses')->count(),
            'selesai'  => Keluhan::where('status', 'selesai')->count(),
            'ditolak'  => Keluhan::where('status', 'ditolak')->count(),
        ];

        return view('pages.admin.keluhan.index', compact('keluhanList', 'stats'));
    }

    public function show(Keluhan $keluhan)
    {
        $keluhan->load(['warga.kartuKeluarga', 'pesans.user']);

        return view('pages.admin.keluhan.show', compact('keluhan'));
    }

    public function update(Request $request, Keluhan $keluhan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        $keluhan->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function kirimPesan(Request $request, Keluhan $keluhan)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        KeluhanPesan::create([
            'keluhan_id' => $keluhan->id,
            'user_id'    => Auth::id(),
            'pesan'      => $request->pesan,
        ]);

        return back()->with('success', 'Pesan terkirim.');
    }
}