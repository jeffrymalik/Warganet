<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\KeluhanPesan;

class KeluhanController extends Controller
{
    public function index()
    {
        $warga = Auth::user()->warga;

        $keluhanList = Keluhan::where('warga_id', $warga->id)
                              ->latest()
                              ->paginate(10);

        return view('pages.warga.keluhan.index', compact('keluhanList'));
    }

    public function create()
    {
        return view('pages.warga.keluhan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:100',
            'deskripsi' => 'required|string|min:20',
            'kategori'  => 'required|in:infrastruktur,keamanan,kebersihan,sosial,lainnya',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $warga = Auth::user()->warga;

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('keluhan', 'public');
        }

        Keluhan::create([
            'warga_id'  => $warga->id,
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori'  => $request->kategori,
            'foto'      => $fotoPath,
            'status'    => 'menunggu',
        ]);

        return redirect()->route('warga.keluhan.index')
                         ->with('success', 'Keluhan berhasil dikirim.');
    }

    public function show(Keluhan $keluhan)
    {
        $warga = Auth::user()->warga;
        if ($keluhan->warga_id !== $warga->id) {
            abort(403);
        }

        $keluhan->load(['pesans.user']);

        return view('pages.warga.keluhan.show', compact('keluhan'));
    }

    public function kirimPesan(Request $request, Keluhan $keluhan)
    {
        $warga = Auth::user()->warga;
        if ($keluhan->warga_id !== $warga->id) {
            abort(403);
        }

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