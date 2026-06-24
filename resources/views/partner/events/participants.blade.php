@extends('layouts.dashboard')

@section('title', 'Peserta Event')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('partner.events.show', $event) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        KEMBALI KE DETAIL EVENT
    </a>
</div>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Daftar Peserta</h1>
        <p style="color: var(--text-secondary); font-size: 0.95rem;">Memantau kehadiran dan pendaftaran untuk event <strong>{{ $event->title }}</strong></p>
    </div>
    <div style="display: flex; gap: 1rem; align-items: center;">
        <div style="text-align: right;">
            <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Sisa Kuota</div>
            <div style="font-size: 1.25rem; font-weight: 700; color: var(--gold);">{{ $event->computed_remaining_quota }} / {{ $event->quota }}</div>
        </div>
        <div style="height: 40px; width: 1px; background: var(--card-border);"></div>
        <div style="text-align: right;">
            <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Total Terdaftar</div>
            <div style="font-size: 1.25rem; font-weight: 700; color: var(--green);">{{ $totalParticipants }}</div>
        </div>
    </div>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem; width: 80px;">#</th>
                <th>Peserta (Registrasi)</th>
                <th>Pembeli (Akun)</th>
                <th style="text-align: center;">Kode Tiket</th>
                <th style="text-align: center;">Waktu Terdaftar</th>
                <th style="text-align: right; padding-right: 2rem;">Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $i => $ticket)
            <tr>
                <td style="padding-left: 2rem; color: var(--text-secondary); font-size: 0.8rem;">
                    {{ str_pad($tickets->firstItem() + $i, 3, '0', STR_PAD_LEFT) }}
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
                    {{ $ticket->created_at->format('d M Y') }}
                    <div style="font-size: 0.7rem; color: rgba(255,255,255,0.2);">{{ $ticket->created_at->format('H:i') }}</div>
                </td>
                <td style="text-align: right; padding-right: 2rem;">
                    @if($ticket->status === 'checked_in' || $ticket->checkin()->exists())
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">
                            HADIR
                        </span>
                    @else
                        <span class="badge-premium" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border: 1px solid rgba(255, 255, 255, 0.1);">
                            BELUM HADIR
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1.5rem; opacity: 0.1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p>Belum ada peserta yang mendaftar untuk event ini.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($tickets->hasPages())
<div style="margin-top: 2rem;">
    {{ $tickets->links() }}
</div>
@endif
@endsection
