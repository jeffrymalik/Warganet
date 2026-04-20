@extends('layouts.main')

@section('title', 'Ajukan Surat')

@section('content')

<div x-data="{ pageName: `Ajukan Surat`}">
    @include('partials.breadcrumb')
</div>

<div class="mt-6 space-y-6">

    @if ($errors->any())
    <div class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15">
        <div class="flex items-start gap-3">
            <div class="-mt-0.5 text-error-500">❗</div>
            <div>
                <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">Terjadi Kesalahan:</h4>
                <ul class="text-sm text-gray-500 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('warga.surat.store') }}" method="POST" enctype="multipart/form-data"
        x-data="{
            jenis: '{{ old('jenis_surat') }}',
            persyaratanWajib: {
                pengantar_ktp : ['fotokopi_kk'],
                domisili      : ['fotokopi_kk'],
                pengantar_kk  : ['buku_nikah_akta_nikah', 'kk_lama'],
                sktm          : ['fotokopi_kk'],
                skck          : ['fotokopi_ktp', 'fotokopi_kk', 'pas_foto'],
            },
            persyaratanOpsional: {
                pengantar_ktp : ['ktp_lama', 'surat_kehilangan'],
                domisili      : ['bukti_tinggal'],
                pengantar_kk  : ['surat_kelahiran'],
                sktm          : ['foto_rumah'],
                skck          : [],
            },
            labelDokumen: {
                fotokopi_kk           : 'Fotokopi KK',
                fotokopi_ktp          : 'Fotokopi KTP',
                ktp_lama              : 'KTP Lama',
                surat_kehilangan      : 'Surat Kehilangan (dari Polisi)',
                bukti_tinggal         : 'Bukti Tinggal (Kontrak/Surat Rumah)',
                buku_nikah_akta_nikah : 'Buku Nikah / Akta Nikah',
                kk_lama               : 'KK Lama',
                surat_kelahiran       : 'Surat Kelahiran',
                foto_rumah            : 'Foto Rumah',
                pas_foto              : 'Pas Foto',
            },
            get wajib() { return this.persyaratanWajib[this.jenis] ?? [] },
            get opsional() { return this.persyaratanOpsional[this.jenis] ?? [] },
        }"
    >
        @csrf

        {{-- BOX 1 — JENIS SURAT --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Jenis Surat</h3>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pilih Jenis Surat</label>
                <select name="jenis_surat" x-model="jenis"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">Pilih...</option>
                    <option value="pengantar_ktp" {{ old('jenis_surat') == 'pengantar_ktp' ? 'selected' : '' }}>Surat Pengantar KTP</option>
                    <option value="domisili"      {{ old('jenis_surat') == 'domisili'      ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                    <option value="pengantar_kk"  {{ old('jenis_surat') == 'pengantar_kk'  ? 'selected' : '' }}>Surat Pengantar KK</option>
                    <option value="sktm"          {{ old('jenis_surat') == 'sktm'          ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                    <option value="skck"          {{ old('jenis_surat') == 'skck'          ? 'selected' : '' }}>Surat Pengantar SKCK</option>
                </select>
            </div>
        </div>

        {{-- BOX 2 — KEPERLUAN UMUM --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Keperluan</h3>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Keperluan / Tujuan</label>
                <textarea name="keperluan" rows="3"
                    placeholder="Jelaskan keperluan pengajuan surat ini..."
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >{{ old('keperluan') }}</textarea>
            </div>

            {{-- Pengantar KTP --}}
            <div x-show="jenis === 'pengantar_ktp'" class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Keperluan KTP</label>
                <select name="ktp_keperluan"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">Pilih...</option>
                    <option value="buat_baru" {{ old('ktp_keperluan') == 'buat_baru' ? 'selected' : '' }}>Buat Baru</option>
                    <option value="hilang"    {{ old('ktp_keperluan') == 'hilang'    ? 'selected' : '' }}>Hilang</option>
                    <option value="rusak"     {{ old('ktp_keperluan') == 'rusak'     ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            {{-- Domisili --}}
            <div x-show="jenis === 'domisili'" class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Lama Tinggal</label>
                <input type="text" name="domisili_lama_tinggal"
                    value="{{ old('domisili_lama_tinggal') }}"
                    placeholder="Contoh: 3 tahun, sejak 2020..."
                    class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400"/>
            </div>

            {{-- Pengantar KK --}}
            <div x-show="jenis === 'pengantar_kk'" class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Keperluan KK</label>
                <select name="kk_keperluan"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">Pilih...</option>
                    <option value="baru"           {{ old('kk_keperluan') == 'baru'           ? 'selected' : '' }}>Buat Baru</option>
                    <option value="tambah_anggota" {{ old('kk_keperluan') == 'tambah_anggota' ? 'selected' : '' }}>Tambah Anggota</option>
                    <option value="pindah"         {{ old('kk_keperluan') == 'pindah'         ? 'selected' : '' }}>Pindah</option>
                </select>
            </div>

            {{-- SKTM --}}
            <div x-show="jenis === 'sktm'" class="mt-5 grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Penghasilan per Bulan</label>
                    <input type="number" name="sktm_penghasilan"
                        value="{{ old('sktm_penghasilan') }}"
                        placeholder="0"
                        min="0"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jumlah Tanggungan</label>
                    <input type="number" name="sktm_jumlah_tanggungan"
                        value="{{ old('sktm_jumlah_tanggungan') }}"
                        placeholder="0"
                        min="0"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
                </div>
            </div>

            {{-- SKCK --}}
            <div x-show="jenis === 'skck'" class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Keperluan SKCK</label>
                <input type="text" name="skck_keperluan"
                    value="{{ old('skck_keperluan') }}"
                    placeholder="Contoh: Melamar kerja, mendaftar kuliah..."
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>
        </div>

        {{-- BOX 3 — DOKUMEN WAJIB --}}
        <div x-show="jenis" class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Dokumen Wajib</h3>
            <p class="text-xs text-gray-400 mb-4">Format: JPG, PNG, atau PDF. Maks 2MB per file.</p>

            <div class="space-y-4">
                <template x-for="key in wajib" :key="key">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" x-text="labelDokumen[key]"></label>
                        <input type="file" :name="`dokumen_wajib[${key}]`"
                            accept=".jpg,.jpeg,.png,.pdf"
                            class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400"/>
                    </div>
                </template>
            </div>
        </div>

        {{-- BOX 4 — DOKUMEN OPSIONAL --}}
        <div x-show="jenis && opsional.length > 0" class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Dokumen Opsional</h3>
            <p class="text-xs text-gray-400 mb-4">Upload jika ada. Format: JPG, PNG, atau PDF. Maks 2MB per file.</p>

            <div class="space-y-4">
                <template x-for="key in opsional" :key="key">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" x-text="labelDokumen[key]"></label>
                        <input type="file" :name="`dokumen_opsional[${key}]`"
                            accept=".jpg,.jpeg,.png,.pdf"
                            class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400"/>
                    </div>
                </template>
            </div>
        </div>

        {{-- TOMBOL --}}
        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('warga.surat.index') }}"
                class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]">
                Batal
            </a>
            <button type="submit"
                class="flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                Ajukan Surat
            </button>
        </div>

    </form>
</div>
@endsection