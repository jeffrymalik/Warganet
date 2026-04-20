<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::with('pembuat')
            ->latest()
            ->paginate(10);

        return view('pages.admin.pengumuman.index', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'prioritas'=> 'required|in:low,medium,high',
        ]);

        Pengumuman::create([
            'judul'        => $request->judul,
            'isi'          => $request->isi,
            'prioritas'    => $request->prioritas,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'created_by'   => auth()->id(),
        ]);

        return back()->with('sukses', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'prioritas'=> 'required|in:low,medium,high',
        ]);

        $pengumuman->update([
            'judul'        => $request->judul,
            'isi'          => $request->isi,
            'prioritas'    => $request->prioritas,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published')
                ? ($pengumuman->published_at ?? now())
                : null,
        ]);

        return back()->with('sukses', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return back()->with('sukses', 'Pengumuman berhasil dihapus.');
    }
}