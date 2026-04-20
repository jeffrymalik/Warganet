@extends('layouts.main')

@section('title', 'Pengumuman')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Pengumuman</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola pengumuman untuk warga</p>
    </div>
    <button
        onclick="bukaModalTambah()"
        class="flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1"/>
        </svg>
        Tambah Pengumuman
    </button>
</div>

{{-- Notifikasi --}}
@if(session('sukses'))
<div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
    {{ session('sukses') }}
</div>
@endif

{{-- Tabel --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Judul</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Prioritas</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Dibuat</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($pengumuman as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                    {{-- Judul + Isi --}}
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white/90">{{ $item->judul }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 line-clamp-1">{{ $item->isi }}</p>
                    </td>

                    {{-- Prioritas --}}
                    <td class="px-6 py-4">
                        @php
                            $badgePrioritas = [
                                'high'   => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                'medium' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400',
                                'low'    => 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400',
                            ];
                            $labelPrioritas = [
                                'high'   => 'Tinggi',
                                'medium' => 'Sedang',
                                'low'    => 'Rendah',
                            ];
                        @endphp
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgePrioritas[$item->prioritas] }}">
                            {{ $labelPrioritas[$item->prioritas] }}
                        </span>
                    </td>

                    {{-- Status Published --}}
                    <td class="px-6 py-4">
                        @if($item->is_published)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                Dipublikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                Draft
                            </span>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $item->created_at->format('d M Y') }}
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button
                                onclick="bukaModalEdit({{ $item->id }}, '{{ addslashes($item->judul) }}', {{ json_encode($item->isi) }}, '{{ $item->prioritas }}', {{ $item->is_published ? 'true' : 'false' }})"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 dark:hover:bg-white/[0.05]"
                                title="Edit"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>
                            <button
                                onclick="hapusPengumuman({{ $item->id }})"
                                class="rounded-lg p-2 text-gray-500 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10"
                                title="Hapus"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <svg class="mx-auto mb-3 h-10 w-10 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Belum ada pengumuman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pengumuman->hasPages())
    <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
        {{ $pengumuman->links() }}
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════ --}}
{{-- MODAL TAMBAH / EDIT                             --}}
{{-- ═══════════════════════════════════════════════ --}}
<div id="modalPengumuman" class="fixed inset-0 z-99999 hidden items-center justify-center p-5 overflow-y-auto">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px]" onclick="tutupModal()"></div>

    {{-- Dialog --}}
    <div class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">

        {{-- Tombol tutup --}}
        <button onclick="tutupModal()" class="absolute right-5 top-5 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-white/[0.05] dark:hover:bg-white/[0.1]">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/>
            </svg>
        </button>

        {{-- Judul Modal --}}
        <h5 id="judulModal" class="mb-1 text-xl font-semibold text-gray-800 dark:text-white/90">
            Tambah Pengumuman
        </h5>
        <p class="mb-8 text-sm text-gray-500 dark:text-gray-400">
            Isi informasi pengumuman untuk warga
        </p>

        {{-- Form --}}
        <form id="formPengumuman" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="inputId">

            {{-- Judul --}}
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Judul Pengumuman
                </label>
                <input
                    type="text"
                    name="judul"
                    id="inputJudul"
                    placeholder="Contoh: Jadwal Kerja Bakti RT 03"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                />
                @error('judul')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Isi --}}
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Isi Pengumuman
                </label>
                <textarea
                    name="isi"
                    id="inputIsi"
                    rows="5"
                    placeholder="Tulis isi pengumuman di sini..."
                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                ></textarea>
                @error('isi')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Prioritas --}}
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Prioritas
                </label>
                <select
                    name="prioritas"
                    id="inputPrioritas"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >
                    <option value="low">Rendah</option>
                    <option value="medium" selected>Sedang</option>
                    <option value="high">Tinggi</option>
                </select>
            </div>

            {{-- Publikasi --}}
            <div class="mb-8">
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        name="is_published"
                        id="inputPublished"
                        value="1"
                        class="h-5 w-5 cursor-pointer rounded border-gray-300 text-brand-500 focus:ring-brand-500"
                    >
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-400">
                        Publikasikan sekarang
                    </span>
                </label>
            </div>

            {{-- Footer Tombol --}}
            <div class="flex items-center justify-end gap-3">
                <button
                    type="button"
                    onclick="tutupModal()"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const modal        = document.getElementById('modalPengumuman');
    const form         = document.getElementById('formPengumuman');
    const judulModal   = document.getElementById('judulModal');
    const inputId      = document.getElementById('inputId');
    const inputJudul   = document.getElementById('inputJudul');
    const inputIsi     = document.getElementById('inputIsi');
    const inputPrioritas  = document.getElementById('inputPrioritas');
    const inputPublished  = document.getElementById('inputPublished');
    const formMethod   = document.getElementById('formMethod');

    function bukaModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function tutupModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function bukaModalTambah() {
        judulModal.textContent   = 'Tambah Pengumuman';
        form.action              = '{{ route("admin.pengumuman.store") }}';
        formMethod.value         = 'POST';
        inputId.value            = '';
        inputJudul.value         = '';
        inputIsi.value           = '';
        inputPrioritas.value     = 'medium';
        inputPublished.checked   = false;
        bukaModal();
    }

    function bukaModalEdit(id, judul, isi, prioritas, isPublished) {
        judulModal.textContent   = 'Edit Pengumuman';
        form.action              = `/admin/pengumuman/${id}`;
        formMethod.value         = 'PUT';
        inputId.value            = id;
        inputJudul.value         = judul;
        inputIsi.value           = isi;
        inputPrioritas.value     = prioritas;
        inputPublished.checked   = isPublished;
        bukaModal();
    }

    function hapusPengumuman(id) {
        if (!confirm('Yakin ingin menghapus pengumuman ini?')) return;

        const formHapus = document.createElement('form');
        formHapus.method = 'POST';
        formHapus.action = `/admin/pengumuman/${id}`;
        formHapus.innerHTML = `
            @csrf
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(formHapus);
        formHapus.submit();
    }
</script>
@endpush