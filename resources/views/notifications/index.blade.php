@extends('layouts.main')

@section('title', 'Notifikasi')

@section('content')

<div x-data="{ pageName: 'Notifikasi' }">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">Semua Notifikasi</h3>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-brand-500 hover:underline">Tandai semua dibaca</button>
            </form>
            @endif
        </div>

        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($notifications as $notif)
            
            <a    href="{{ route('notifications.show', $notif->id) }}"
                class="flex gap-4 px-5 py-4 hover:bg-gray-50 dark:hover:bg-white/[0.02] transition {{ $notif->read_at ? 'opacity-60' : '' }}"
            >
                @php
                    $icon = $notif->data['icon'] ?? 'info';
                    $iconBg = match($icon) {
                        'warning' => 'bg-warning-50 dark:bg-warning-500/10',
                        'error'   => 'bg-error-50 dark:bg-error-500/10',
                        'success' => 'bg-success-50 dark:bg-success-500/10',
                        default   => 'bg-brand-50 dark:bg-brand-500/10',
                    };
                    $iconColor = match($icon) {
                        'warning' => 'text-warning-500',
                        'error'   => 'text-error-500',
                        'success' => 'text-success-500',
                        default   => 'text-brand-500',
                    };
                @endphp
                <div class="shrink-0 mt-1">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $iconBg }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="{{ $iconColor }}">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $notif->data['judul'] }}
                            @if(!$notif->read_at)
                                <span class="inline-block ml-1 h-2 w-2 rounded-full bg-brand-500"></span>
                            @endif
                        </p>
                        <span class="shrink-0 text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $notif->data['pesan'] }}</p>
                </div>
            </a>
            @empty
            <div class="text-center py-12">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto text-gray-300 dark:text-gray-600 mb-3">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <p class="text-sm text-gray-400">Belum ada notifikasi</p>
            </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $notifications->links() }}
        </div>
        @endif

    </div>
</div>

@endsection