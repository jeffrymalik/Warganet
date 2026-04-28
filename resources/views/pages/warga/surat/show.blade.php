@extends('layouts.main')

@section('title', 'Detail Permohonan Surat')

@section('content')

<div x-data="{ pageName: `Detail Permohonan`}">
    @include('partials.breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- BOX INFO PERMOHONAN --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $permohonanSurat->label_jenis_surat }}</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $permohonanSurat->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
            </div>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $permohonanSurat->badge_status }}">
                {{ $permohonanSurat->label_status }}
            </span>
        </div>

        <div class="space-y-3">
            <div>
                <p class="text-xs text-gray-400 mb-1">Keperluan</p>
                <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->keperluan }}</p>
            </div>

            @if($permohonanSurat->jenis_surat === 'pengantar_ktp')
            <div>
                <p class="text-xs text-gray-400 mb-1">Keperluan KTP</p>
                <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->label_ktp_keperluan }}</p>
            </div>
            @endif

            @if($permohonanSurat->jenis_surat === 'domisili')
            <div>
                <p class="text-xs text-gray-400 mb-1">Lama Tinggal</p>
                <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->domisili_lama_tinggal }}</p>
            </div>
            @endif

            @if($permohonanSurat->jenis_surat === 'pengantar_kk')
            <div>
                <p class="text-xs text-gray-400 mb-1">Keperluan KK</p>
                <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->label_kk_keperluan }}</p>
            </div>
            @endif

            @if($permohonanSurat->jenis_surat === 'sktm')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Penghasilan</p>
                    <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->sktm_penghasilan_format }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Jumlah Tanggungan</p>
                    <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->sktm_jumlah_tanggungan }} orang</p>
                </div>
            </div>
            @endif

            @if($permohonanSurat->jenis_surat === 'skck')
            <div>
                <p class="text-xs text-gray-400 mb-1">Keperluan SKCK</p>
                <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->skck_keperluan }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- BOX CATATAN ADMIN --}}
    @if($permohonanSurat->catatan_admin)
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-3">Catatan Admin</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $permohonanSurat->catatan_admin }}</p>
    </div>
    @endif

    {{-- BOX DOWNLOAD SURAT --}}
    @if($permohonanSurat->file_surat)
    <div class="rounded-2xl border border-green-200 bg-green-50 p-5 dark:border-green-500/30 dark:bg-green-500/10">
        <h3 class="text-base font-semibold text-green-800 dark:text-green-400 mb-3">✅ Surat Sudah Siap</h3>
        <a href="{{ asset('storage/' . $permohonanSurat->file_surat) }}" target="_blank"
            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-green-700">
            ⬇️ Download Surat
        </a>
    </div>
    @endif

    {{-- BOX DOKUMEN --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Dokumen yang Diupload</h3>

        @if($permohonanSurat->dokumens->count() > 0)
        <div class="space-y-3">
            @foreach($permohonanSurat->dokumens as $dokumen)
            <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-brand-50 dark:bg-brand-500/10 text-base">📄</div>
                    <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $dokumen->nama_dokumen }}</p>
                </div>
                <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank"
                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                    Lihat
                </a>
            </div>
            @endforeach
        </div>
        @else
            <p class="text-sm text-gray-400">Tidak ada dokumen.</p>
        @endif
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="flex justify-start">
        <a href="{{ route('warga.surat.index') }}"
            class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
            ← Kembali
        </a>
    </div>

</div>
@endsection