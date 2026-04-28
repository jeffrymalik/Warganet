@extends('layouts.main')

@section('title', 'Detail Permohonan Surat')

@section('content')

<div x-data="{ pageName: `Detail Permohonan Surat`}">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15">
        <p class="text-sm font-medium text-success-700 dark:text-success-400">✅ {{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- KIRI --}}
        <div class="lg:col-span-2 space-y-6">

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
                    {{-- Keperluan Umum --}}
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Keperluan</p>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->keperluan }}</p>
                    </div>

                    {{-- Data Tambahan Pengantar KTP --}}
                    @if($permohonanSurat->jenis_surat === 'pengantar_ktp')
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Keperluan KTP</p>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->label_ktp_keperluan }}</p>
                    </div>
                    @endif

                    {{-- Data Tambahan Domisili --}}
                    @if($permohonanSurat->jenis_surat === 'domisili')
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Lama Tinggal</p>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->domisili_lama_tinggal }}</p>
                    </div>
                    @endif

                    {{-- Data Tambahan Pengantar KK --}}
                    @if($permohonanSurat->jenis_surat === 'pengantar_kk')
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Keperluan KK</p>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->label_kk_keperluan }}</p>
                    </div>
                    @endif

                    {{-- Data Tambahan SKTM --}}
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

                    {{-- Data Tambahan SKCK --}}
                    @if($permohonanSurat->jenis_surat === 'skck')
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Keperluan SKCK</p>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $permohonanSurat->skck_keperluan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- BOX DOKUMEN --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Dokumen Persyaratan</h3>

                @if($permohonanSurat->dokumens->count() > 0)
                <div class="space-y-3">
                    @foreach($permohonanSurat->dokumens as $dokumen)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-brand-50 dark:bg-brand-500/10 text-base">
                                📄
                            </div>
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

            {{-- BOX INFO WARGA --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Data Pemohon</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Nama</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $permohonanSurat->warga->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">NIK</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $permohonanSurat->warga->nik }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">No KK</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $permohonanSurat->warga->kartuKeluarga->no_kk ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Alamat</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $permohonanSurat->warga->kartuKeluarga->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">No Telepon</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $permohonanSurat->warga->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Status dalam KK</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $permohonanSurat->warga->label_status_kk }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- KANAN --}}
        <div class="space-y-6">

            {{-- BOX UPDATE STATUS --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Update Permohonan</h3>

                <form action="{{ route('admin.surat.update', $permohonanSurat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
                        <select name="status"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <option value="menunggu" {{ $permohonanSurat->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $permohonanSurat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai"  {{ $permohonanSurat->status == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak"  {{ $permohonanSurat->status == 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Catatan <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <textarea name="catatan_admin" rows="3"
                            placeholder="Tulis catatan untuk warga..."
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        >{{ old('catatan_admin', $permohonanSurat->catatan_admin) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Upload Surat PDF <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <input type="file" name="file_surat" accept=".pdf"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"/>
                        @if($permohonanSurat->file_surat)
                        <div class="mt-2 flex items-center gap-2">
                            <p class="text-xs text-gray-400">File saat ini:</p>
                            <a href="{{ asset('storage/' . $permohonanSurat->file_surat) }}" target="_blank"
                                class="text-xs text-brand-500 hover:underline">Lihat PDF</a>
                        </div>
                        @endif
                    </div>

                    <button type="submit"
                        class="mt-4 w-full rounded-lg bg-brand-500 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        Simpan
                    </button>
                </form>
            </div>

            <a href="{{ route('admin.surat.index') }}"
                class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                ← Kembali
            </a>

        </div>
    </div>
</div>
@endsection