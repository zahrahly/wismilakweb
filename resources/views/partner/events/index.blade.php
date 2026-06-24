@extends('layouts.dashboard')

@section('title', 'Event Saya')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem;">Manajemen Event</h1>
        <p style="color: var(--text-secondary); font-size: 0.8rem;">Kelola, publikasi, dan pantau performa event Anda secara real-time.</p>
    </div>
    <a href="{{ route('partner.events.create') }}" class="btn-premium" style="padding: 0.5rem 1.2rem; font-size: 0.7rem;">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        BUAT EVENT BARU
    </a>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Detail Event</th>
                <th style="text-align: center;">Tanggal</th>
                <th style="text-align: center;">Kapasitas & Peserta</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--card-border);">
                        @else
                            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div>
                            <div style="font-weight: 700; color: var(--text-primary); font-family: 'Crimson Pro', serif; font-size: 1.1rem; margin-bottom: 2px;">{{ $event->title }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); display: flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ Str::limit($event->location, 30) }}
                            </div>
                        </div>
                    </div>
                </td>
                <td style="text-align: center;">
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.85rem; white-space: nowrap;">{{ $event->date ? $event->date->format('d M Y') : '-' }}</div>
                    <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 2px; white-space: nowrap;">{{ $event->start_time ? substr($event->start_time, 0, 5) : '-' }}</div>
                </td>
                <td style="text-align: center;">
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary);">{{ $event->registered_participants_count ?? 0 }} / {{ $event->quota }}</div>
                    @php
                        $qs = $event->quota_status;
                        $qsColor = match($qs) {
                            'Full' => 'var(--red)',
                            'Almost Full' => 'var(--gold)',
                            default => 'var(--green)',
                        };
                    @endphp
                    <div style="font-size: 0.65rem; color: {{ $qsColor }}; font-weight: 700; text-transform: uppercase; margin-top: 4px; letter-spacing: 0.05em;">{{ $qs }}</div>
                </td>
                <td style="text-align: center;">
                    @php
                        $sc = match($event->status) {
                            'published' => 'background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);',
                            'approved' => 'background: rgba(59,130,246,0.1); color: var(--blue); border: 1px solid rgba(59,130,246,0.2);',
                            'pending' => 'background: rgba(245,158,11,0.1); color: #F59E0B; border: 1px solid rgba(245,158,11,0.2);',
                            'rejected' => 'background: rgba(231,76,76,0.1); color: var(--red); border: 1px solid rgba(231,76,76,0.2);',
                            default => 'background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);',
                        };
                    @endphp
                    <span class="badge-premium" style="{{ $sc }}">
                        {{ strtoupper($event->status) }}
                    </span>
                    @if($event->status === 'rejected' && $event->rejection_reason)
                         <div style="margin-top: 0.4rem; font-size: 0.6rem; color: var(--red); font-style: italic;" title="{{ $event->rejection_reason }}">Pesan: {{ Str::limit($event->rejection_reason, 20) }}</div>
                    @endif
                </td>
                <td style="text-align: right; padding-right: 2rem;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.35rem; align-items: center;">
                        
                        {{-- DETAIL (always) --}}
                        <a href="{{ route('partner.events.show', $event) }}" class="btn-premium" style="padding: 0.35rem 0.7rem; font-size: 0.6rem; background: rgba(212,175,55,0.08); color: var(--gold); border: 1px solid rgba(212,175,55,0.2);">
                            DETAIL
                        </a>

                        {{-- EDIT (draft/pending/rejected only) --}}
                        @if(!in_array($event->status, ['approved', 'published', 'completed']))
                        <a href="{{ route('partner.events.edit', $event) }}" class="btn-premium" style="padding: 0.35rem 0.7rem; font-size: 0.6rem; background: rgba(59,130,246,0.08); color: var(--blue); border: 1px solid rgba(59,130,246,0.15);">
                            EDIT
                        </a>
                        @endif

                        {{-- SUBMIT / AJUKAN ULANG --}}
                        @if($event->status === 'draft' || $event->status === 'rejected')
                        <form method="POST" action="{{ route('partner.events.submit', $event) }}" style="display: inline; margin: 0;">
                            @csrf
                            <button type="submit" class="btn-premium" style="padding: 0.35rem 0.7rem; font-size: 0.6rem;">
                                {{ $event->status === 'draft' ? 'SUBMIT' : 'AJUKAN ULANG' }}
                            </button>
                        </form>
                        @endif

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1.5rem; opacity: 0.1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>Belum ada event yang terdaftar.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $events->links() }}
</div>
@endsection
