{{-- create.blade.php --}}
@extends('layouts.main')

@section('title', 'Buat Keluhan')

@section('content')

<div x-data="{ pageName: `Buat Keluhan`}">
    @include('partials.breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- ERROR --}}
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

    <form action="{{ route('warga.keluhan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Buat Keluhan</h3>

            {{-- Judul --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Judul</label>
                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul') }}"
                    placeholder="Judul keluhan"
                    maxlength="100"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Kategori --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori</label>
                <select
                    name="kategori"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >
                    <option value="">Pilih Kategori</option>
                    <option value="infrastruktur" {{ old('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="keamanan"      {{ old('kategori') == 'keamanan'      ? 'selected' : '' }}>Keamanan</option>
                    <option value="kebersihan"    {{ old('kategori') == 'kebersihan'    ? 'selected' : '' }}>Kebersihan</option>
                    <option value="sosial"        {{ old('kategori') == 'sosial'        ? 'selected' : '' }}>Sosial</option>
                    <option value="lainnya"       {{ old('kategori') == 'lainnya'       ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            {{-- Deskripsi --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Deskripsi</label>
                <textarea
                    name="deskripsi"
                    rows="5"
                    placeholder="Jelaskan keluhan kamu secara detail..."
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >{{ old('deskripsi') }}</textarea>
            </div>

            {{-- Foto --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Foto <span class="text-gray-400 font-normal">(opsional, max 2MB)</span>
                </label>
                <input
                    type="file"
                    name="foto"
                    accept="image/jpg,image/jpeg,image/png"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"
                />
            </div>
        </div>

        {{-- TOMBOL --}}
        <div class="flex justify-end gap-3 mt-5">
            
            <a    href="{{ route('warga.keluhan.index') }}"
                class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]"
            >
                Batal
            </a>
            <button
                type="submit"
                class="flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
            >
                Kirim Keluhan
            </button>
        </div>

    </form>
</div>
@endsection