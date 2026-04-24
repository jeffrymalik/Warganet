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
            const mulai = ev.startStr.slice(0, 10);
            let selesai = mulai;
            if (ev.end) {
                const endBefore = new Date(ev.end);
                endBefore.setDate(endBefore.getDate() - 1);
                selesai = endBefore.toISOString().slice(0, 10);
            }

            Swal.fire({
                title: ev.title,
                html: `
                    <p class="text-sm text-gray-500">${ev.extendedProps.deskripsi ?? 'Tidak ada deskripsi'}</p>
                    <p class="text-xs text-gray-400 mt-2">📅 ${mulai}${selesai !== mulai ? ' — ' + selesai : ''}</p>
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