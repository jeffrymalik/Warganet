@extends('layouts.main')

@section('title', 'Data Keluarga Saya')

@section('content')

<div x-data="{ pageName: 'Data Keluarga Saya' }">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- BOX INFO KK --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Data Kartu Keluarga</h3>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">No. KK</p>
                <p class="text-sm font-medium font-mono text-gray-800 dark:text-white">{{ $kartuKeluarga->no_kk }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Alamat</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->alamat }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">No. Rumah</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->alamat_lengkap ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Status Hunian</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->status_hunian }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Tanggal Mulai Tinggal</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">
                    {{ optional($kartuKeluarga->tanggal_mulai_tinggal)->format('d M Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- BOX ANGGOTA --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            Anggota Keluarga
            <span class="ml-2 text-sm font-normal text-gray-400">({{ $anggota->count() }} orang)</span>
        </h3>

        @if($anggota->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="pb-3 px-3 text-left text-xs font-medium text-gray-400">Nama</th>
                        <th class="pb-3 px-3 text-left text-xs font-medium text-gray-400">NIK</th>
                        <th class="pb-3 px-3 text-left text-xs font-medium text-gray-400">Status dalam KK</th>
                        <th class="pb-3 px-3 text-left text-xs font-medium text-gray-400">Jenis Kelamin</th>
                        <th class="pb-3 px-3 text-left text-xs font-medium text-gray-400">Status Warga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($anggota as $a)
                    <tr>
                        <td class="py-3 px-3 font-medium text-gray-800 dark:text-white whitespace-nowrap">
                            {{ $a->nama_lengkap }}
                            @if($a->id === $warga->id)
                                <span class="ml-1 text-xs text-brand-500">(Anda)</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 font-mono text-gray-500 dark:text-gray-400">{{ $a->nik }}</td>
                        <td class="py-3 px-3 text-gray-500 dark:text-gray-400 capitalize">
                            {{ str_replace('_', ' ', $a->status_dalam_kk) }}
                        </td>
                        <td class="py-3 px-3 text-gray-500 dark:text-gray-400">{{ $a->label_jenis_kelamin }}</td>
                        <td class="py-3 px-3">
                            @php
                                $color = match($a->status_warga) {
                                    'aktif'      => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400',
                                    'tidak_aktif'=> 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                    'pindah'     => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
                                    'meninggal'  => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400',
                                    default      => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }} capitalize">
                                {{ str_replace('_', ' ', $a->status_warga) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-sm text-gray-400 text-center py-6">Belum ada anggota keluarga.</p>
        @endif
    </div>

    {{-- Tombol Kembali --}}
    <div class="flex justify-start mb-6">
        <a href="{{ route('profile') }}"
            class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
            ← Kembali ke Profil
        </a>
    </div>

</div>

@endsection