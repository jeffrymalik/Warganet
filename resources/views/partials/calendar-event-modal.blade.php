<div
    class="fixed inset-0 items-center justify-center hidden p-5 overflow-y-auto modal z-99999"
    id="eventModal"
>
    <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>
    <div class="relative flex w-full max-w-[700px] flex-col overflow-y-auto rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-11">

        {{-- Tombol Tutup --}}
        <button class="modal-close-btn transition-color absolute right-5 top-5 z-999 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-white/[0.05] dark:text-gray-400 sm:h-11 sm:w-11">
            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/>
            </svg>
        </button>

        <div class="flex flex-col px-2 overflow-y-auto custom-scrollbar">
            {{-- Header --}}
            <div>
                <h5 class="mb-2 font-semibold text-gray-800 text-theme-xl dark:text-white/90 lg:text-2xl" id="modalJudul">
                    Tambah Jadwal
                </h5>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Isi detail jadwal kegiatan warga
                </p>
            </div>

            {{-- Body --}}
            <div class="mt-8">

                {{-- Judul --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Judul Kegiatan
                    </label>
                    <input
                        id="input-judul"
                        type="text"
                        placeholder="Contoh: Rapat RT Bulanan"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>

                {{-- Deskripsi --}}
                <div class="mt-6">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Deskripsi <span class="text-gray-400">(opsional)</span>
                    </label>
                    <textarea
                        id="input-deskripsi"
                        rows="3"
                        placeholder="Keterangan tambahan..."
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    ></textarea>
                </div>

                {{-- Warna --}}
                <div class="mt-6">
                    <label class="block mb-4 text-sm font-medium text-gray-700 dark:text-gray-400">
                        Warna Kegiatan
                    </label>
                    <div class="flex flex-wrap items-center gap-4">
                        @foreach ([
                            'primary' => ['label' => 'Utama',   'class' => 'form-check-primary', 'hex' => '#465fff'],
                            'success' => ['label' => 'Sukses',  'class' => 'form-check-success', 'hex' => '#17a34a'],
                            'danger'  => ['label' => 'Bahaya',  'class' => 'form-check-danger',  'hex' => '#ef4444'],
                            'warning' => ['label' => 'Peringatan', 'class' => 'form-check-warning', 'hex' => '#f59e0b'],
                        ] as $value => $opt)
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                            <input
                                class="sr-only"
                                type="radio"
                                name="event-color"
                                value="{{ $value }}"
                                {{ $value === 'primary' ? 'checked' : '' }}
                            />
                            <span class="flex items-center justify-center w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 color-dot" style="--dot-color: {{ $opt['hex'] }}">
                                <span class="w-2.5 h-2.5 rounded-full hidden check-mark" style="background-color: {{ $opt['hex'] }}"></span>
                            </span>
                            {{ $opt['label'] }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Tanggal Mulai --}}
                <div class="mt-6">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Mulai
                    </label>
                    <div class="relative">
                        <input
                            id="input-tanggal-mulai"
                            type="date"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            onclick="this.showPicker()"
                        />
                    </div>
                </div>

                {{-- Tanggal Selesai --}}
                <div class="mt-6">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Selesai
                    </label>
                    <div class="relative">
                        <input
                            id="input-tanggal-selesai"
                            type="date"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            onclick="this.showPicker()"
                        />
                    </div>
                </div>

                {{-- Pesan Error --}}
                <div id="modal-error" class="hidden mt-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600 dark:bg-red-500/10 dark:text-red-400">
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center gap-3 mt-6 sm:justify-end">
                <button type="button" class="modal-close-btn flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                    Batal
                </button>
                <button type="button" id="btn-hapus-jadwal" class="hidden flex w-full justify-center rounded-lg bg-red-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-600 sm:w-auto">
                    Hapus
                </button>
                <button type="button" id="btn-simpan-jadwal" class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    input[name="event-color"]:checked + span {
        border-color: var(--dot-color);
    }
    input[name="event-color"]:checked + span .check-mark {
        display: block;
    }
</style>