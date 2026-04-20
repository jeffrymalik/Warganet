<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermohonanSuratController extends Controller
{
    public function index(Request $request)
    {
        $query = PermohonanSurat::with(['warga.kartuKeluarga']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('warga', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $permohonanList = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'menunggu' => PermohonanSurat::where('status', 'menunggu')->count(),
            'diproses' => PermohonanSurat::where('status', 'diproses')->count(),
            'selesai'  => PermohonanSurat::where('status', 'selesai')->count(),
            'ditolak'  => PermohonanSurat::where('status', 'ditolak')->count(),
        ];

        return view('pages.admin.surat.index', compact('permohonanList', 'stats'));
    }

    public function show(PermohonanSurat $permohonanSurat)
    {
        $permohonanSurat->load(['warga.kartuKeluarga', 'dokumens']);
        return view('pages.admin.surat.show', compact('permohonanSurat'));
    }

    public function update(Request $request, PermohonanSurat $permohonanSurat)
    {
        $request->validate([
            'status'        => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
            'file_surat'    => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = [
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        if ($request->hasFile('file_surat')) {
            if ($permohonanSurat->file_surat) {
                Storage::disk('public')->delete($permohonanSurat->file_surat);
            }
            $data['file_surat'] = $request->file('file_surat')->store('surat', 'public');
        }

        $permohonanSurat->update($data);

        return back()->with('success', 'Permohonan berhasil diperbarui.');
    }
}