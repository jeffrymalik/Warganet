<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSurat;
use App\Models\PermohonanSuratDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermohonanSuratController extends Controller
{
    public function index()
    {
        $warga = Auth::user()->warga;
        $permohonanList = PermohonanSurat::where('warga_id', $warga->id)
                                         ->latest()
                                         ->paginate(10);
        return view('pages.warga.surat.index', compact('permohonanList'));
    }

    public function create()
    {
        return view('pages.warga.surat.create');
    }

    public function store(Request $request)
    {
        $jenis = $request->jenis_surat;

        $rules = [
            'jenis_surat' => 'required|in:pengantar_ktp,domisili,pengantar_kk,sktm,skck',
            'keperluan'   => 'required|string|min:10|max:500',

            // Dokumen wajib
            'dokumen_wajib.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Dokumen opsional
            'dokumen_opsional.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        // Validasi field tambahan per jenis surat
        if ($jenis === 'pengantar_ktp') {
            $rules['ktp_keperluan'] = 'required|in:buat_baru,hilang,rusak';
        }

        if ($jenis === 'domisili') {
            $rules['domisili_lama_tinggal'] = 'required|string|max:100';
        }

        if ($jenis === 'pengantar_kk') {
            $rules['kk_keperluan'] = 'required|in:baru,tambah_anggota,pindah';
        }

        if ($jenis === 'sktm') {
            $rules['sktm_penghasilan']        = 'required|integer|min:0';
            $rules['sktm_jumlah_tanggungan']  = 'required|integer|min:0';
        }

        if ($jenis === 'skck') {
            $rules['skck_keperluan'] = 'required|string|max:200';
        }

        $request->validate($rules);

        $warga = Auth::user()->warga;

        DB::transaction(function () use ($request, $warga, $jenis) {
            $permohonan = PermohonanSurat::create([
                'warga_id'               => $warga->id,
                'jenis_surat'            => $jenis,
                'keperluan'              => $request->keperluan,
                'status'                 => 'menunggu',
                'ktp_keperluan'          => $request->ktp_keperluan,
                'domisili_lama_tinggal'  => $request->domisili_lama_tinggal,
                'kk_keperluan'           => $request->kk_keperluan,
                'sktm_penghasilan'       => $request->sktm_penghasilan,
                'sktm_jumlah_tanggungan' => $request->sktm_jumlah_tanggungan,
                'skck_keperluan'         => $request->skck_keperluan,
            ]);

            // Simpan dokumen wajib
            if ($request->hasFile('dokumen_wajib')) {
                foreach ($request->file('dokumen_wajib') as $key => $file) {
                    $path = $file->store('surat/dokumen', 'public');
                    PermohonanSuratDokumen::create([
                        'permohonan_surat_id' => $permohonan->id,
                        'nama_dokumen'        => PermohonanSurat::labelDokumen($key),
                        'file'                => $path,
                    ]);
                }
            }

            // Simpan dokumen opsional (kalau diupload)
            if ($request->hasFile('dokumen_opsional')) {
                foreach ($request->file('dokumen_opsional') as $key => $file) {
                    if ($file) {
                        $path = $file->store('surat/dokumen', 'public');
                        PermohonanSuratDokumen::create([
                            'permohonan_surat_id' => $permohonan->id,
                            'nama_dokumen'        => PermohonanSurat::labelDokumen($key),
                            'file'                => $path,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('warga.surat.index')
                         ->with('success', 'Permohonan surat berhasil diajukan.');
    }

    public function show(PermohonanSurat $permohonanSurat)
    {
        $warga = Auth::user()->warga;
        if ($permohonanSurat->warga_id !== $warga->id) {
            abort(403);
        }
        $permohonanSurat->load(['dokumens']);
        return view('pages.warga.surat.show', compact('permohonanSurat'));
    }
}