@extends('layouts.main')

@section('title', 'Kategori Ekonomi Warga')

@section('content')

<div x-data="{ pageName: `Kategori Ekonomi Warga`}">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- 4 CARD STATISTIK --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 dark:border-red-500/30 dark:bg-red-500/10">
            <p class="text-xs font-medium text-red-500 mb-1">Tidak Mampu</p>
            <p class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $stats['tidak_mampu'] }}</p>
            <p class="text-xs text-red-400 mt-1">KK</p>
        </div>
        <div class="rounded-2xl border border-orange-200 bg-orange-50 p-5 dark:border-orange-500/30 dark:bg-orange-500/10">
            <p class="text-xs font-medium text-orange-500 mb-1">Kurang Mampu</p>
            <p class="text-2xl font-bold text-orange-700 dark:text-orange-400">{{ $stats['kurang_mampu'] }}</p>
            <p class="text-xs text-orange-400 mt-1">KK</p>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-500/30 dark:bg-blue-500/10">
            <p class="text-xs font-medium text-blue-500 mb-1">Mampu</p>
            <p class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $stats['mampu'] }}</p>
            <p class="text-xs text-blue-400 mt-1">KK</p>
        </div>
        <div class="rounded-2xl border border-green-200 bg-green-50 p-5 dark:border-green-500/30 dark:bg-green-500/10">
            <p class="text-xs font-medium text-green-500 mb-1">Sangat Mampu</p>
            <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $stats['sangat_mampu'] }}</p>
            <p class="text-xs text-green-400 mt-1">KK</p>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="GET" action="{{ route('admin.warga.kategoriEkonomi') }}" class="flex flex-col gap-3 sm:flex-row">
            
            {{-- Search --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari No KK, nama, atau NIK..."
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />

            {{-- Filter Kategori --}}
            <select
                name="kategori"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full sm:w-56 appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >
                <option value="">Semua Kategori</option>
                <option value="tidak_mampu"  {{ request('kategori') == 'tidak_mampu'  ? 'selected' : '' }}>Tidak Mampu</option>
                <option value="kurang_mampu" {{ request('kategori') == 'kurang_mampu' ? 'selected' : '' }}>Kurang Mampu</option>
                <option value="mampu"        {{ request('kategori') == 'mampu'        ? 'selected' : '' }}>Mampu</option>
                <option value="sangat_mampu" {{ request('kategori') == 'sangat_mampu' ? 'selected' : '' }}>Sangat Mampu</option>
            </select>

            {{-- Tombol --}}
            <button type="submit"
                class="h-11 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600 shrink-0">
                Filter
            </button>

            @if(request('search') || request('kategori'))
            <a href="{{ route('admin.warga.kategoriEkonomi') }}"
                class="flex items-center justify-center h-11 rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 shrink-0">
                Reset
            </a>
            @endif

        </form>
    </div>

    {{-- TABEL --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Daftar KK
                <span class="ml-2 text-sm font-normal text-gray-400">({{ $kartus->count() }} KK)</span>
            </h3>
        </div>

        @if($kartus->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">No KK</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Kepala Keluarga</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Jumlah Anggota</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Total Pendapatan</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Kategori</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($kartus as $kk)
                    <tr>
                        <td class="py-3 text-gray-600 dark:text-gray-400">{{ $kk->no_kk }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white">
                            {{ $kk->kepalaKeluarga->nama_lengkap ?? '-' }}
                        </td>
                        <td class="py-3 text-gray-600 dark:text-gray-400">
                            {{ $kk->wargas->count() }} orang
                        </td>
                        <td class="py-3 text-gray-600 dark:text-gray-400">
                            {{ $kk->total_pendapatan_format }}
                        </td>
                        <td class="py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $kk->badge_ekonomi }}">
                                {{ $kk->kategori_ekonomi }}
                            </span>
                        </td>
                        <td class="py-3">
                            <a href="{{ route('admin.warga.show', $kk->id) }}"
                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-sm text-gray-400 text-center py-6">Tidak ada data.</p>
        @endif
    </div>

</div>
@endsection