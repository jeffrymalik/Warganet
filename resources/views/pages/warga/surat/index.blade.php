@extends('layouts.main')

@section('title', 'Permohonan Surat Saya')

@section('content')

<div x-data="{ pageName: `Permohonan Surat`}">
    @include('partials.breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15">
        <p class="text-sm font-medium text-success-700 dark:text-success-400">✅ {{ session('success') }}</p>
    </div>
    @endif

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Permohonan Surat Saya</h3>
        <a
            href="{{ route('warga.surat.create') }}"
            class="flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600"
        >
            + Ajukan Surat
        </a>
    </div>

    {{-- TABEL --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        @if($permohonanList->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Jenis Surat</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Status</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Tanggal</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($permohonanList as $permohonan)
                    <tr>
                        <td class="py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $permohonan->badge_jenis_surat }}">
                                {{ $permohonan->label_jenis_surat }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $permohonan->badge_status }}">
                                {{ $permohonan->label_status }}
                            </span>
                        </td>
                        <td class="py-3 text-xs text-gray-400">
                            {{ $permohonan->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3">
                            <a href="{{ route('warga.surat.show', $permohonan->id) }}"
                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $permohonanList->links() }}
        </div>

        @else
            <div class="text-center py-12">
                <p class="text-sm text-gray-400 mb-3">Belum ada permohonan surat.</p>
                <a href="{{ route('warga.surat.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                    + Ajukan Surat Pertama
                </a>
            </div>
        @endif

    </div>
</div>
@endsection