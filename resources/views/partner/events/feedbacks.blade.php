@extends('layouts.dashboard')

@section('title', 'Feedback Event - ' . Str::limit($event->title, 20))

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('partner.events.show', $event) }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; transition: color 0.2s;">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Detail Event
    </a>
</div>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Feedback: {{ $event->title }}</h1>
        <div style="display: flex; align-items: center; gap: 1rem; color: var(--text-secondary); font-size: 0.9rem;">
            <span>{{ $event->date ? $event->date->format('d M Y') : '-' }}</span>
            <span style="width: 4px; height: 4px; background: var(--card-border); border-radius: 50%;"></span>
            <span>{{ $event->location }}</span>
        </div>
    </div>
</div>

<div class="stat-grid" style="margin-bottom: 2.5rem;">
    <div class="premium-card" style="padding: 1.5rem; border-left: 4px solid var(--gold);">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px;">Total Feedback</div>
        <div style="font-size: 1.75rem; font-weight: 700;">{{ $stats['total'] }}</div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; border-left: 4px solid var(--gold);">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px;">Rata-rata Rating</div>
        <div style="display: flex; align-items: baseline; gap: 4px;">
            <span style="font-size: 1.75rem; font-weight: 700; color: var(--gold);">{{ $stats['avg_rating'] }}</span>
            <span style="font-size: 1rem; color: var(--text-secondary);">/ 5.0</span>
        </div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; border-left: 4px solid var(--green);">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px;">Puas (5 Bintang)</div>
        <div style="font-size: 1.75rem; font-weight: 700; color: var(--green);">{{ $stats['five_star'] }}</div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; border-left: 4px solid var(--red);">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px;">Kecewa (1 Bintang)</div>
        <div style="font-size: 1.75rem; font-weight: 700; color: var(--red);">{{ $stats['one_star'] }}</div>
    </div>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Cigar Member</th>
                <th style="text-align: center;">Rating</th>
                <th>Komentar / Masukan</th>
                <th style="text-align: right; padding-right: 2rem;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feedbacks as $feedback)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="font-weight: 600; color: var(--text-primary);">{{ $feedback->user->name ?? 'Anonim' }}</div>
                    <div style="font-size: 0.7rem; color: var(--text-secondary);">Verified Member</div>
                </td>
                <td style="text-align: center;">
                    <div style="display: flex; justify-content: center; gap: 2px; color: var(--gold);">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="14" height="14" fill="{{ $i <= $feedback->rating ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        @endfor
                    </div>
                </td>
                <td>
                    <div style="font-size: 0.9rem; line-height: 1.6; color: var(--text-secondary); max-width: 400px; font-style: italic;">
                        "{{ $feedback->comment ?? 'Tidak ada komentar.' }}"
                    </div>
                </td>
                <td style="padding-right: 2rem; text-align: right; color: var(--text-secondary); font-size: 0.8rem;">
                    {{ $feedback->created_at->format('d M Y, H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <p>Belum ada feedback yang masuk untuk event ini.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($feedbacks->hasPages())
<div style="margin-top: 2rem;">
    {{ $feedbacks->links() }}
</div>
@endif
@endsection
