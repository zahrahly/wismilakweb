@extends('layouts.dashboard')

@section('title', 'Riwayat Check-in')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('partner.events.show', $event) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        KEMBALI KE DETAIL EVENT
    </a>
</div>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem;">Riwayat Check-in</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Event: <strong>{{ $event->title }}</strong></p>
    </div>
    <div style="display: flex; gap: 1.5rem; align-items: center;">
        <div style="text-align: right;">
            <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Check-in Rate</div>
            <div style="font-size: 1.25rem; font-weight: 700; color: var(--blue);">{{ $checkedIn }} / {{ $totalTickets }}</div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Persentase</div>
            <div style="font-size: 1.25rem; font-weight: 700; color: var(--green);">
                {{ $totalTickets > 0 ? round(($checkedIn / $totalTickets) * 100) : 0 }}%
            </div>
        </div>
    </div>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem; width: 80px;">#</th>
                <th>Pemegang Tiket (Registrasi)</th>
                <th>Pembeli (Akun)</th>
                <th style="text-align: center;">Kode Tiket</th>
                <th style="text-align: center;">Waktu Check-in</th>
                <th style="text-align: right; padding-right: 2rem;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($checkins as $i => $ticket)
            <tr>
                <td style="padding-left: 2rem; color: var(--text-secondary); font-size: 0.8rem;">
                    {{ str_pad($checkins->firstItem() + $i, 3, '0', STR_PAD_LEFT) }}
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(212, 175, 55, 0.1); color: var(--gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; border: 1px solid var(--gold-dim);">
                            {{ strtoupper(substr($ticket->full_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--text-primary);">{{ $ticket->full_name ?? '-' }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); display: flex; flex-direction: column; gap: 1px; margin-top: 2px;">
                                <span>Email: {{ $ticket->email ?? '-' }}</span>
                                <span>Telp: {{ $ticket->phone ?? '-' }}</span>
                                <span>KTP: {{ $ticket->ktp_number ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(59,130,246,0.1); color: var(--blue); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; border: 1px solid rgba(59,130,246,0.2);">
                            {{ strtoupper(substr($ticket->user->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 500; color: var(--text-primary); font-size: 0.85rem;">{{ $ticket->user->name ?? 'Unknown' }}</div>
                            <div style="font-size: 0.7rem; color: var(--text-secondary);">{{ $ticket->user->email ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td style="text-align: center; font-family: monospace; font-size: 0.85rem; font-weight: 600; color: var(--gold);">
                    {{ $ticket->ticket_number }}
                </td>
                <td style="text-align: center; font-size: 0.85rem; color: var(--text-secondary);">
                    {{ $ticket->checkin->checked_in_at ? \Carbon\Carbon::parse($ticket->checkin->checked_in_at)->format('d M Y, H:i') : '-' }}
                </td>
                <td style="text-align: right; padding-right: 2rem;">
                    <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">
                        CHECKED IN
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1.5rem; opacity: 0.1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Belum ada peserta yang melakukan check-in untuk event ini.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($checkins->hasPages())
<div style="margin-top: 2rem;">
    {{ $checkins->links() }}
</div>
@endif
@endsection
