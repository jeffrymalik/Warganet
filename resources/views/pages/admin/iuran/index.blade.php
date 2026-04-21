@extends('layouts.main')

@section('title', 'Iuran Warga')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Iuran Warga</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola iuran insidental warga</p>
    </div>
    <button onclick="bukaModal()"
        class="flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1"/>
        </svg>
        Tambah Iuran
    </button>
</div>

@if(session('sukses'))
<div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
    {{ session('sukses') }}
</div>
@endif

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Nama Iuran</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Nominal</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Jatuh Tempo</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Lunas / Total</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($iuran as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white/90">{{ $item->nama }}</p>
                        <p class="mt-0.5 text-xs text-gray-400 line-clamp-1">{{ $item->deskripsi ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white/90">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $item->due_date?->format('d M Y') ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-green-600">{{ $item->lunas_count }}</span>
                            <span class="text-gray-400">/</span>
                            <span class="text-sm text-gray-500">{{ $item->tagihan_count }}</span>
                        </div>
                        {{-- Progress bar --}}
                        <div class="mt-1.5 h-1.5 w-24 rounded-full bg-gray-100 dark:bg-gray-800">
                            @php
                                $persen = $item->tagihan_count > 0
                                    ? ($item->lunas_count / $item->tagihan_count) * 100
                                    : 0;
                            @endphp
                            <div class="h-1.5 rounded-full bg-green-500" style="width: {{ $persen }}%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.iuran.detail', $item) }}"
                                class="rounded-lg p-2 text-gray-500 hover:bg-blue-50 hover:text-blue-500 dark:hover:bg-blue-500/10"
                                title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.iuran.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus iuran ini? Semua tagihan terkait akan terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="rounded-lg p-2 text-gray-500 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10"
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        Belum ada iuran. Klik "Tambah Iuran" untuk membuat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($iuran->hasPages())
    <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
        {{ $iuran->links() }}
    </div>
    @endif
</div>

{{-- Modal Tambah Iuran --}}
<div id="modalIuran" class="fixed inset-0 z-99999 hidden items-center justify-center p-5">
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px]" onclick="tutupModal()"></div>
    <div class="relative w-full max-w-[500px] rounded-3xl bg-white p-8 dark:bg-gray-900">

        <button onclick="tutupModal()" class="absolute right-5 top-5 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-white/[0.05]">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/>
            </svg>
        </button>

        <h5 class="mb-1 text-xl font-semibold text-gray-800 dark:text-white/90">Tambah Iuran Warga</h5>
        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Iuran akan otomatis ditagihkan ke semua KK</p>

        <form action="{{ route('admin.iuran.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Iuran</label>
                <input type="text" name="nama" placeholder="Contoh: Iuran Lebaran 2026"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
            </div>

            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Deskripsi <span class="text-gray-400">(opsional)</span></label>
                <textarea name="deskripsi" rows="2" placeholder="Keterangan tambahan..."
                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
            </div>

            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nominal (Rp)</label>
                <input type="number" name="nominal" placeholder="Contoh: 100000"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
            </div>

            <div class="mb-6">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jatuh Tempo <span class="text-gray-400">(opsional)</span></label>
                <input type="date" name="due_date" onclick="this.showPicker()"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="tutupModal()"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    Batal
                </button>
                <button type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    Simpan & Tagihkan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function bukaModal() {
        const modal = document.getElementById('modalIuran');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function tutupModal() {
        const modal = document.getElementById('modalIuran');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush