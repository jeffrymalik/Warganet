@extends('layouts.main')

@section('title', 'Pengumuman')

@section('content')

{{-- Header --}}
<div x-data="{ pageName: `Pengumuman`}">
    @include('../../../partials/breadcrumb')
</div>
<div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            Kelola Pengumuman Untuk Warga
        </h2>
    </div>

    <button
        onclick="bukaModalTambah()"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white rounded-lg bg-brand-500 hover:bg-brand-600"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1"/>
        </svg>
        Tambah Pengumuman
    </button>
</div>
{{-- Notifikasi --}}
@if(session('sukses'))
<div class="mb-4 flex items-start justify-between rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
    <span>{{ session('sukses') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-4 text-green-500 hover:text-green-700 text-base leading-none">&times;</button>
</div>
@endif

{{-- Tabel --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    {{-- Search --}}
    <div class="px-6 pt-5 pb-4">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </span>
            <input
                type="text"
                placeholder="Cari judul pengumuman..."
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[430px] dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30"
            >
        </div>
    </div>

    {{-- Table --}}
    <div class="w-full overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-y border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Prioritas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($pengumuman as $item)
                <tr>

                    {{-- Judul + Isi --}}
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white/90 text-sm">{{ $item->judul }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 line-clamp-1 max-w-xs">{{ $item->isi }}</p>
                    </td>

                    {{-- Prioritas --}}
                    <td class="px-6 py-4">
                        @php
                            $labelPrioritas = [
                                'high'   => 'Tinggi',
                                'medium' => 'Sedang',
                                'low'    => 'Rendah',
                            ];
                        @endphp

                        <span @class([
                            'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                            'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400' => $item->prioritas === 'high',
                            'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400' => $item->prioritas === 'medium',
                            'bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400' => $item->prioritas === 'low',
                        ])>
                            {{ $labelPrioritas[$item->prioritas] }}
                        </span>
                    </td>

                    {{-- Status Published --}}
                    <td class="px-6 py-4">
                        @if($item->is_published)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-600 dark:bg-green-500/10 dark:text-green-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                Dipublikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                Draft
                            </span>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                        {{ $item->created_at->format('d M Y') }}
                    </td>

                    {{-- Aksi (titik tiga seperti tabel KK) --}}
                    <td class="px-6 py-4">
                        <div x-data="{ open: false }" class="relative">
                            <button
                                @click="open = !open"
                                class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-white/[0.05] dark:hover:text-gray-200"
                            >
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="9" cy="9" r="1.5" fill="currentColor"/>
                                    <circle cx="9" cy="3.75" r="1.5" fill="currentColor"/>
                                    <circle cx="9" cy="14.25" r="1.5" fill="currentColor"/>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-1 w-40 rounded-xl border border-gray-200 bg-white shadow-lg z-50 py-1 dark:border-gray-700 dark:bg-gray-800"
                            >
                                {{-- Edit --}}
                                <button
                                    @click="open = false; bukaModalEdit({{ $item->id }}, '{{ addslashes($item->judul) }}', {{ json_encode($item->isi) }}, '{{ $item->prioritas }}', {{ $item->is_published ? 'true' : 'false' }})"
                                    class="flex w-full items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/[0.05]"
                                >
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.854 1.146a.5.5 0 0 0-.707 0L2.5 9.793V12.5h2.707l8.647-8.646a.5.5 0 0 0 0-.708l-2-2zM3.5 11.5v-1.293l7-7 1.293 1.293-7 7H3.5z" fill="currentColor"/>
                                    </svg>
                                    Edit
                                </button>

                                <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>

                                {{-- Hapus --}}
                                <button
                                    @click="open = false; hapusPengumuman({{ $item->id }})"
                                    class="flex w-full items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10"
                                >
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 1h4v1h-4V1zM2 3h11v1H2V3zm2 1h7l-.5 9h-6L4 4zm2 2v5h1V6H6zm2 0v5h1V6H8z" fill="currentColor"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="h-10 w-10 text-gray-300 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada pengumuman</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pengumuman->hasPages())
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-gray-800">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Menampilkan {{ $pengumuman->firstItem() }} - {{ $pengumuman->lastItem() }}
            dari {{ $pengumuman->total() }} data
        </p>

        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if ($pengumuman->onFirstPage())
                <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed dark:bg-gray-800">Prev</span>
            @else
                <a href="{{ $pengumuman->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800">Prev</a>
            @endif

            {{-- Numbers --}}
            @for ($i = 1; $i <= $pengumuman->lastPage(); $i++)
                <a href="{{ $pengumuman->url($i) }}"
                   class="px-3 py-2 text-sm rounded-lg border {{ $pengumuman->currentPage() == $i ? 'bg-brand-500 text-white border-brand-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800' }}">
                    {{ $i }}
                </a>
            @endfor

            {{-- Next --}}
            @if ($pengumuman->hasMorePages())
                <a href="{{ $pengumuman->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800">Next</a>
            @else
                <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed dark:bg-gray-800">Next</span>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- MODAL --}}
<div id="modalPengumuman" class="fixed inset-0 hidden items-center justify-center p-5 overflow-y-auto" style="z-index: 99999;">
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px]" onclick="tutupModal()"></div>
    <div class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">

        <button onclick="tutupModal()" class="absolute right-5 top-5 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-white/[0.05] dark:hover:bg-white/[0.1]">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/></svg>
        </button>

        <h5 id="judulModal" class="mb-1 text-xl font-semibold text-gray-800 dark:text-white/90">Tambah Pengumuman</h5>
        <p class="mb-8 text-sm text-gray-500 dark:text-gray-400">Isi informasi pengumuman untuk warga</p>

        <form id="formPengumuman" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="inputId">

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Judul Pengumuman</label>
                <input type="text" name="judul" id="inputJudul" placeholder="Contoh: Jadwal Kerja Bakti RT 03"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"/>
                @error('judul')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Isi Pengumuman</label>
                <textarea name="isi" id="inputIsi" rows="5" placeholder="Tulis isi pengumuman di sini..."
                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                @error('isi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Prioritas</label>
                <select name="prioritas" id="inputPrioritas"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-none focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="low">Rendah</option>
                    <option value="medium" selected>Sedang</option>
                    <option value="high">Tinggi</option>
                </select>
            </div>

            <div class="mb-8">
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="is_published" id="inputPublished" value="1"
                        class="h-5 w-5 cursor-pointer rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-400">Publikasikan sekarang</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="tutupModal()"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    Batal
                </button>
                <button type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const csrfToken      = '{{ csrf_token() }}';
    const modal          = document.getElementById('modalPengumuman');
    const form           = document.getElementById('formPengumuman');
    const judulModal     = document.getElementById('judulModal');
    const inputId        = document.getElementById('inputId');
    const inputJudul     = document.getElementById('inputJudul');
    const inputIsi       = document.getElementById('inputIsi');
    const inputPrioritas = document.getElementById('inputPrioritas');
    const inputPublished = document.getElementById('inputPublished');
    const formMethod     = document.getElementById('formMethod');

    function bukaModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function tutupModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function bukaModalTambah() {
        judulModal.textContent = 'Tambah Pengumuman';
        form.action            = '{{ route("admin.pengumuman.store") }}';
        formMethod.value       = 'POST';
        inputId.value          = '';
        inputJudul.value       = '';
        inputIsi.value         = '';
        inputPrioritas.value   = 'medium';
        inputPublished.checked = false;
        bukaModal();
    }

    function bukaModalEdit(id, judul, isi, prioritas, isPublished) {
        judulModal.textContent = 'Edit Pengumuman';
        form.action            = `/admin/pengumuman/${id}`;
        formMethod.value       = 'PUT';
        inputId.value          = id;
        inputJudul.value       = judul;
        inputIsi.value         = isi;
        inputPrioritas.value   = prioritas;
        inputPublished.checked = isPublished;
        bukaModal();
    }

    function hapusPengumuman(id) {
        if (!confirm('Yakin ingin menghapus pengumuman ini?')) return;

        const formHapus = document.createElement('form');
        formHapus.method = 'POST';
        formHapus.action = `/admin/pengumuman/${id}`;
        formHapus.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(formHapus);
        formHapus.submit();
    }
</script>
@endpush