@extends('../layouts.main')

@section('title', 'Edit Profil')

@section('content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

    {{-- Breadcrumb --}}
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-200">Dashboard</a>
            <span>/</span>
            <a href="{{ route('profile') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Profil</a>
            <span>/</span>
            <span class="text-gray-800 dark:text-white/90 font-medium">Edit Profil</span>
        </nav>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
        <svg class="shrink-0 w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Alert Error --}}
    @if($errors->any())
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
        <svg class="shrink-0 w-5 h-5 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="font-medium mb-1">Terdapat kesalahan input:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <div class="flex items-center justify-between mb-7">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Profil</h3>
            <a href="{{ route('profile') }}"
               class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Profil
            </a>
        </div>

        {{-- ══════════════════════════════════════════
             FORM FOTO PROFIL
        ══════════════════════════════════════════ --}}
        <form action="{{ route('profile.update.foto') }}" method="POST" enctype="multipart/form-data" id="form-foto">
            @csrf
            @method('PATCH')

            <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90 mb-5 flex items-center gap-2">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </span>
                    Foto Profil
                </h4>

                <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-start">

                    {{-- Foto saat ini + tombol hapus --}}
                    <div class="relative shrink-0">
                        <div class="w-28 h-28 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center shadow">
                            @if(auth()->user()->avatar)
                                <img id="avatar-preview"
                                     src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                     alt="Foto Profil"
                                     class="w-full h-full object-cover">
                                <span id="avatar-initials"
                                      class="hidden text-4xl font-bold text-gray-400 dark:text-gray-500 select-none uppercase">
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </span>
                            @else
                                <img id="avatar-preview" src="" alt="Foto Profil" class="w-full h-full object-cover hidden">
                                <span id="avatar-initials"
                                      class="text-4xl font-bold text-gray-400 dark:text-gray-500 select-none uppercase">
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </span>
                            @endif
                        </div>

                        {{-- Badge kamera (klik untuk pilih foto) --}}
                        <button type="button"
                                onclick="document.getElementById('avatar').click()"
                                class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center shadow-md transition-colors"
                                title="Ganti foto">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Kanan: drop zone + info --}}
                    <div class="flex-1 w-full">

                        {{-- Drop Zone --}}
                        <div id="drop-zone"
                             class="relative flex flex-col items-center justify-center w-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-6 py-8 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/40 dark:hover:border-indigo-600 dark:hover:bg-indigo-900/10 transition-all duration-200"
                             onclick="document.getElementById('avatar').click()"
                             ondragover="handleDragOver(event)"
                             ondragleave="handleDragLeave(event)"
                             ondrop="handleDrop(event)">

                            <div class="mb-3 p-3 rounded-full bg-gray-100 dark:bg-gray-700" id="dz-icon-wrap">
                                <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                            </div>

                            <p id="dz-text" class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Klik atau seret foto ke sini
                            </p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                PNG, JPG, JPEG, WEBP — Maks. 2MB
                            </p>

                            <p id="file-name"
                               class="hidden mt-3 text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-3 py-1 rounded-full border border-indigo-200 dark:border-indigo-800">
                            </p>

                            <input type="file"
                                   id="avatar"
                                   name="avatar"
                                   accept="image/png,image/jpeg,image/webp"
                                   class="hidden"
                                   onchange="handleFileChange(this)">
                        </div>

                        @error('avatar')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <p class="mt-3 text-xs text-gray-400 dark:text-gray-500">
                            Foto akan ditampilkan sebagai lingkaran. Gunakan foto wajah yang jelas untuk tampilan terbaik.
                        </p>

                        {{-- Tombol aksi --}}
                        <div class="flex items-center gap-3 mt-4 flex-wrap">

                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                                Simpan Foto
                            </button>

                            <button type="button" id="btn-reset"
                                    onclick="resetPreview()"
                                    class="hidden items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batalkan
                            </button>

                            @if(auth()->user()->avatar)
                            <button type="button"
                                    onclick="konfirmasiHapusFoto()"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-100 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Hapus Foto
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Form Hapus Foto (hidden, di-submit via JS) --}}
        <form id="form-hapus-foto" action="{{ route('profile.hapus.foto') }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        {{-- ══════════════════════════════════════════
             FORM DATA AKUN
        ══════════════════════════════════════════ --}}
        <form action="{{ route('profile.update.akun') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90 mb-5 flex items-center gap-2">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-bold">1</span>
                    Data Akun
                </h4>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama Akun <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            placeholder="Nama akun Anda"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 @error('name') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            placeholder="email@contoh.com"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-5">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Data Akun
                    </button>
                </div>
            </div>
        </form>

        {{-- ══════════════════════════════════════════
             FORM GANTI PASSWORD
        ══════════════════════════════════════════ --}}
        <form action="{{ route('profile.update.password') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90 mb-5 flex items-center gap-2">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400 text-xs font-bold">2</span>
                    Ganti Password
                    <span class="text-xs font-normal text-gray-400">(kosongkan jika tidak ingin mengganti)</span>
                </h4>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

                    @foreach([
                        ['current_password', 'Password Saat Ini', 'Password saat ini'],
                        ['password',         'Password Baru',     'Password baru'],
                        ['password_confirmation', 'Konfirmasi Password Baru', 'Ulangi password baru'],
                    ] as [$fieldName, $label, $placeholder])
                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $label }}
                        </label>
                        <div class="relative">
                            <input type="password" name="{{ $fieldName }}" placeholder="{{ $placeholder }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 @error($fieldName) border-red-400 @enderror">
                            <button type="button" onclick="togglePassword(this)"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error($fieldName) <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    @endforeach

                </div>

                <div class="flex justify-end mt-5">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-yellow-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Ganti Password
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
// ─── Toggle password ──────────────────────────────────
function togglePassword(btn) {
    const input = btn.previousElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        btn.querySelector('svg').innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        input.type = 'password';
        btn.querySelector('svg').innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}

// ─── Avatar upload ────────────────────────────────────
const MAX_MB  = 2;
const ALLOWED = ['image/png', 'image/jpeg', 'image/webp'];

function applyFile(file) {
    if (!file) return;

    clearDropError();

    if (!ALLOWED.includes(file.type)) {
        showDropError('Format tidak didukung. Gunakan PNG, JPG, atau WEBP.');
        return;
    }
    if (file.size > MAX_MB * 1024 * 1024) {
        showDropError(`Ukuran terlalu besar. Maksimal ${MAX_MB}MB.`);
        return;
    }

    // Preview gambar
    const reader = new FileReader();
    reader.onload = (e) => {
        const preview  = document.getElementById('avatar-preview');
        const initials = document.getElementById('avatar-initials');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        initials.classList.add('hidden');
    };
    reader.readAsDataURL(file);

    // Nama file
    const fileNameEl = document.getElementById('file-name');
    fileNameEl.textContent = '✓ ' + file.name;
    fileNameEl.classList.remove('hidden');

    // Teks drop zone
    document.getElementById('dz-text').textContent = 'Foto siap diunggah';

    // Tampilkan tombol Batalkan
    const btnReset = document.getElementById('btn-reset');
    btnReset.classList.remove('hidden');
    btnReset.classList.add('inline-flex');
}

function handleFileChange(input) {
    applyFile(input.files[0] ?? null);
}

// Drag & Drop
function handleDragOver(e) {
    e.preventDefault();
    document.getElementById('drop-zone').classList.add('border-indigo-400', '!bg-indigo-50/40', 'dark:border-indigo-600');
}
function handleDragLeave() {
    document.getElementById('drop-zone').classList.remove('border-indigo-400', '!bg-indigo-50/40', 'dark:border-indigo-600');
}
function handleDrop(e) {
    e.preventDefault();
    handleDragLeave();
    const file = e.dataTransfer.files[0];
    if (!file) return;
    // Masukkan ke input agar ikut ter-submit
    const dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('avatar').files = dt.files;
    applyFile(file);
}

// Reset pilihan
function resetPreview() {
    const input    = document.getElementById('avatar');
    const preview  = document.getElementById('avatar-preview');
    const initials = document.getElementById('avatar-initials');

    input.value = '';

    @if(auth()->user()->avatar)
        preview.src = "{{ asset('storage/' . auth()->user()->avatar) }}";
        preview.classList.remove('hidden');
        initials.classList.add('hidden');
    @else
        preview.src = '';
        preview.classList.add('hidden');
        initials.classList.remove('hidden');
    @endif

    document.getElementById('file-name').classList.add('hidden');
    document.getElementById('dz-text').textContent = 'Klik atau seret foto ke sini';

    const btnReset = document.getElementById('btn-reset');
    btnReset.classList.add('hidden');
    btnReset.classList.remove('inline-flex');

    clearDropError();
}

// Error message di bawah drop zone
function showDropError(msg) {
    clearDropError();
    const err = document.createElement('p');
    err.id          = 'drop-error';
    err.className   = 'mt-2 text-xs text-red-500';
    err.textContent = msg;
    document.getElementById('drop-zone').after(err);
}
function clearDropError() {
    document.getElementById('drop-error')?.remove();
}

// Konfirmasi hapus foto
function konfirmasiHapusFoto() {
    if (confirm('Yakin ingin menghapus foto profil? Foto akan digantikan dengan inisial nama Anda.')) {
        document.getElementById('form-hapus-foto').submit();
    }
}
</script>
@endpush

@endsection