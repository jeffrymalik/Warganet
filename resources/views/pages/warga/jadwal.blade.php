@extends('layouts.main')

@section('title', 'Jadwal Kegiatan')

@section('content')

<div x-data="{ pageName: 'Jadwal Kegiatan' }">
    @include('../../../partials/breadcrumb')
</div>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mt-6">
    <div id="calendar" class="min-h-screen p-4"></div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/id.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,listMonth'
        },
        events: '{{ route("warga.jadwal.ambil") }}',
        editable: false,
        selectable: false,
        eventClick(info) {
            const ev = info.event;

            const formatTanggal = (dateStr) => {
                const date = new Date(dateStr + 'T00:00:00');
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
            };

            const mulai = ev.startStr.slice(0, 10);
            let selesai = null;

            if (ev.end) {
                const endStr = ev.end.toISOString().slice(0, 10);
                if (endStr !== mulai) {
                    selesai = endStr;
                }
            }

            const tanggalHtml = selesai
                ? `📅 ${formatTanggal(mulai)} — ${formatTanggal(selesai)}`
                : `📅 ${formatTanggal(mulai)}`;

            Swal.fire({
                title: ev.title,
                html: `
                    <p class="text-sm text-gray-500">${ev.extendedProps.deskripsi ?? 'Tidak ada deskripsi'}</p>
                    <p class="text-xs text-gray-400 mt-2">${tanggalHtml}</p>
                `,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#465fff',
            });
        },
    });

    calendar.render();
});
</script>
@endpush