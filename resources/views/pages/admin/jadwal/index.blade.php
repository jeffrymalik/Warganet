@extends('layouts.main')

@section('title', 'Jadwal Kegiatan')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div id="calendar" class="min-h-screen p-4"></div>
</div>

@include('partials.calendar-event-modal')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/id.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Elemen DOM ──────────────────────────────────────────────────────
    const modal          = document.getElementById('eventModal');
    const modalJudul     = document.getElementById('modalJudul');
    const inputJudul     = document.getElementById('input-judul');
    const inputDeskripsi = document.getElementById('input-deskripsi');
    const inputMulai     = document.getElementById('input-tanggal-mulai');
    const inputSelesai   = document.getElementById('input-tanggal-selesai');
    const btnSimpan      = document.getElementById('btn-simpan-jadwal');
    const btnHapus       = document.getElementById('btn-hapus-jadwal');
    const elError        = document.getElementById('modal-error');

    let idAktif = null;

    // ── Buka / Tutup Modal ──────────────────────────────────────────────
    function bukaModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        sembunyikanError();
    }

    function tutupModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.querySelectorAll('.modal-close-btn').forEach(btn => {
        btn.addEventListener('click', tutupModal);
    });

    // ── Warna ───────────────────────────────────────────────────────────
    function getWarna() {
        return document.querySelector('input[name="event-color"]:checked')?.value ?? 'primary';
    }

    function setWarna(warna) {
        const radio = document.querySelector(`input[name="event-color"][value="${warna}"]`);
        if (radio) radio.checked = true;
    }

    // ── Error ───────────────────────────────────────────────────────────
    function tampilkanError(pesan) {
        elError.textContent = pesan;
        elError.classList.remove('hidden');
    }

    function sembunyikanError() {
        elError.textContent = '';
        elError.classList.add('hidden');
    }

    // ── Toast Notifikasi ────────────────────────────────────────────────
    function tampilkanToast(pesan, tipe = 'success') {
        const toast = document.createElement('div');
        toast.className = [
            'fixed bottom-6 right-6 z-[99999] px-5 py-3 rounded-xl',
            'text-white text-sm shadow-lg transition-all duration-300',
            tipe === 'success' ? 'bg-green-500' : 'bg-red-500'
        ].join(' ');
        toast.textContent = pesan;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ── Reset Form Modal ────────────────────────────────────────────────
    function resetModal(modeTambah = true) {
        idAktif              = null;
        inputJudul.value     = '';
        inputDeskripsi.value = '';
        inputMulai.value     = '';
        inputSelesai.value   = '';
        inputSelesai.min     = '';
        setWarna('primary');

        if (modeTambah) {
            modalJudul.textContent = 'Tambah Jadwal';
            btnHapus.classList.add('hidden');
        } else {
            modalJudul.textContent = 'Edit Jadwal';
            btnHapus.classList.remove('hidden');
        }
    }

    // ── Tanggal selesai tidak boleh sebelum tanggal mulai ──────────────
    inputMulai.addEventListener('change', function () {
        inputSelesai.min = inputMulai.value;
        if (inputSelesai.value && inputSelesai.value < inputMulai.value) {
            inputSelesai.value = inputMulai.value;
        }
    });

    // ── Helper Fetch ────────────────────────────────────────────────────
    function kirimRequest(method, url, body) {
        return fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(body),
        }).then(res => {
            if (!res.ok) return res.json().then(err => Promise.reject(err));
            return res.json();
        });
    }

    // ── FullCalendar ────────────────────────────────────────────────────
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listMonth'
        },

        events: '{{ route("admin.jadwal.ambil") }}',

        // Klik tanggal kosong → tambah jadwal
        dateClick(info) {
            resetModal(true);
            inputMulai.value   = info.dateStr;
            inputSelesai.value = info.dateStr;
            inputSelesai.min   = info.dateStr;
            bukaModal();
        },

        // Klik event → edit jadwal
        eventClick(info) {
            const ev = info.event;
            resetModal(false);
            idAktif              = ev.id;
            inputJudul.value     = ev.title;
            inputDeskripsi.value = ev.extendedProps.deskripsi ?? '';
            inputMulai.value     = ev.startStr.slice(0, 10);

            if (ev.end) {
                const tglSelesai = new Date(ev.end);
                tglSelesai.setDate(tglSelesai.getDate() - 1);
                inputSelesai.value = tglSelesai.toISOString().slice(0, 10);
            } else {
                inputSelesai.value = ev.startStr.slice(0, 10);
            }

            inputSelesai.min = inputMulai.value;
            setWarna(ev.extendedProps.color ?? 'primary');
            bukaModal();
        },

        // Drag & drop → perbarui tanggal langsung
        editable: true,
        eventDrop(info) {
            const ev       = info.event;
            const tglMulai = ev.startStr.slice(0, 10);
            let tglSelesai = tglMulai;

            if (ev.end) {
                const endBefore = new Date(ev.end);
                endBefore.setDate(endBefore.getDate() - 1);
                tglSelesai = endBefore.toISOString().slice(0, 10);
            }

            kirimRequest('PUT', `/admin/jadwal/${ev.id}`, {
                judul:           ev.title,
                deskripsi:       ev.extendedProps.deskripsi,
                tanggal_mulai:   tglMulai,
                tanggal_selesai: tglSelesai,
                color:           ev.extendedProps.color,
            })
            .then(() => {
                tampilkanToast('Jadwal berhasil dipindahkan');
                calendar.refetchEvents();
            })
            .catch(() => {
                info.revert();
                tampilkanToast('Gagal memindahkan jadwal', 'danger');
            });
        },
    });

    calendar.render();

    // ── Simpan (Tambah / Edit) ──────────────────────────────────────────
    btnSimpan.addEventListener('click', function () {
        sembunyikanError();

        const payload = {
            judul:           inputJudul.value.trim(),
            deskripsi:       inputDeskripsi.value.trim(),
            tanggal_mulai:   inputMulai.value,
            tanggal_selesai: inputSelesai.value,
            color:           getWarna(),
        };

        // Validasi sisi JS
        if (!payload.judul) {
            tampilkanError('Judul kegiatan wajib diisi.');
            return;
        }
        if (!payload.tanggal_mulai || !payload.tanggal_selesai) {
            tampilkanError('Tanggal mulai dan selesai wajib diisi.');
            return;
        }
        if (payload.tanggal_selesai < payload.tanggal_mulai) {
            tampilkanError('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
            return;
        }

        const isEdit = idAktif !== null;
        const method = isEdit ? 'PUT' : 'POST';
        const url    = isEdit ? `/admin/jadwal/${idAktif}` : '{{ route("admin.jadwal.store") }}';

        kirimRequest(method, url, payload)
            .then(data => {
                tutupModal();
                tampilkanToast(data.pesan);
                calendar.refetchEvents();
            })
            .catch(err => {
                console.error('Error:', err);
                let pesanError = 'Terjadi kesalahan, coba lagi.';

                if (err && err.errors) {
                    pesanError = Object.values(err.errors).flat().join(' ');
                } else if (err && err.message) {
                    pesanError = err.message;
                }

                tampilkanError(pesanError);
            });
    });

    // ── Hapus ───────────────────────────────────────────────────────────
    btnHapus.addEventListener('click', function () {
        if (!idAktif) return;
        if (!confirm('Yakin ingin menghapus jadwal ini?')) return;

        kirimRequest('DELETE', `/admin/jadwal/${idAktif}`, {})
            .then(data => {
                tutupModal();
                tampilkanToast(data.pesan);
                calendar.refetchEvents();
            })
            .catch(() => {
                tampilkanToast('Gagal menghapus jadwal', 'danger');
            });
    });

});
</script>
@endpush