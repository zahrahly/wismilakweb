@php $roleName = auth()->user()->role?->name; @endphp
@extends($roleName === 'admin' ? 'layouts.admin' : ($roleName === 'partner' || $roleName === 'manager' ? 'layouts.dashboard' : 'layouts.customer'))

@section('title', 'Notifikasi')

@if(in_array($roleName, ['partner', 'manager']))
    @section('sidebar')
        @include($roleName.'.partials.sidebar')
    @endsection
@endif

@section('content')
<div class="{{ $roleName === 'customer' || !$roleName ? 'max-w-4xl mx-auto px-4 py-32' : 'max-w-5xl' }}">
    <div class="flex items-center justify-between mb-8 animate-in" style="animation-delay: 0.1s">
        <div>
            <h1 class="text-2xl font-bold font-serif text-[var(--gold)]">Notifikasi Anda</h1>
            <p class="text-sm text-gray-400 mt-1">Daftar aktivitas penting dan pembaruan akun Anda.</p>
        </div>
        @if($notifications->where('is_read', false)->count() > 0)
            <button onclick="markAllRead()" id="mark-all-btn" class="px-4 py-2 bg-amber-500/10 border border-amber-500/30 text-[var(--gold)] text-xs font-semibold rounded hover:bg-amber-500/20 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tandai Semua Dibaca
            </button>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="bg-[var(--tobacco)]/30 border border-amber-500/10 rounded-xl p-12 text-center animate-in" style="animation-delay: 0.2s">
            <div class="w-16 h-16 bg-amber-500/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-500/10">
                <svg class="w-8 h-8 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white">Tidak Ada Notifikasi</h3>
            <p class="text-sm text-gray-400 mt-2">Anda belum menerima notifikasi apa pun saat ini.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $index => $notif)
                <div class="bg-[var(--tobacco)]/25 border {{ $notif->is_read ? 'border-amber-500/5 opacity-75' : 'border-amber-500/25' }} rounded-xl p-5 hover:border-amber-500/40 transition-all animate-in" style="animation-delay: {{ 0.1 + ($index * 0.05) }}s">
                    <div class="flex items-start gap-4">
                        <!-- Icon based on type -->
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 {{ $notif->is_read ? 'bg-gray-800/50 text-gray-400 border border-gray-700/30' : 'bg-amber-500/10 text-[var(--gold)] border border-amber-500/25' }}">
                            @switch($notif->type)
                                @case('transaction')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    @break
                                @case('event')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @break
                                @case('feedback')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.969 0 1.371 1.24.588 1.81l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.883a1 1 0 00-1.178 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.97-2.883c-.783-.57-.38-1.81.588-1.81h4.906a1 1 0 00.95-.69l1.519-4.674z"/></svg>
                                    @break
                                @case('chat')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    @break
                                @case('point')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @break
                                @case('verification')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    @break
                                @case('reward')
                                @case('voucher')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                                    @break
                                @default
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endswitch
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-[var(--gold)] opacity-75">{{ $notif->type }}</span>
                                <span class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-white mt-1">{{ $notif->title }}</h4>
                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">{{ $notif->message }}</p>
                        </div>
                        @if(!$notif->is_read)
                            <div class="w-2.5 h-2.5 bg-amber-500 rounded-full flex-shrink-0 mt-2 shadow-lg shadow-amber-500/50"></div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<script>
function markAllRead() {
    const btn = document.getElementById('mark-all-btn');
    if (btn) btn.disabled = true;
    
    fetch('{{ route("notifications.mark-read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking notifications as read:', error);
        if (btn) btn.disabled = false;
    });
}
</script>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-in {
    animation: fadeInUp 0.4s cubic-bezier(0.23, 1, 0.32, 1) forwards;
    opacity: 0;
}
</style>
@endsection
