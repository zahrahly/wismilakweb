@extends('layouts.admin')

@section('title', 'Peserta Event')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Peserta Event</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Monitoring kehadiran dan data registrasi peserta secara real-time.</p>
    </div>
    <a href="{{ route('admin.checkin.scan') }}" class="btn-premium">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
        QR CHECK-IN
    </a>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Info Event</th>
                <th style="text-align: center;">Jadwal</th>
                <th style="text-align: center;">Lokasi</th>
                <th style="text-align: center;">Okupansi</th>
                <th style="text-align: center;">Kehadiran</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td style="padding: 1.25rem 2rem;">
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">{{ $event->title }}</div>
                    <div style="font-size: 0.75rem; color: var(--gold); margin-top: 4px; font-weight: 500;">
                        {{ $event->price_type === 'free' ? 'Complementary' : 'IDR ' . number_format($event->price, 0, ',', '.') }}
                    </div>
                </td>
                <td style="text-align: center;">
                    <div style="font-size: 0.85rem; color: var(--text-primary);">{{ $event->date ? $event->date->format('d M Y') : '-' }}</div>
                </td>
                <td style="text-align: center;">
                    <div style="font-size: 0.85rem; color: var(--text-secondary);">{{ Str::limit($event->location, 20) }}</div>
                </td>
                <td style="text-align: center;">
                    <div style="font-size: 0.9rem; font-weight: 700; color: var(--text-primary);">{{ $event->computed_remaining_quota }} / {{ $event->quota }}</div>
                </td>
                <td style="text-align: center;">
                    @php
                        $checked = $event->checked_in_tickets_count ?? 0;
                        $total = $event->total_tickets_count ?? 0;
                        
                        if ($total === 0) {
                            $badgeStyle = 'background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);';
                            $dotColor = 'var(--text-secondary)';
                        } elseif ($checked === $total) {
                            $badgeStyle = 'background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);';
                            $dotColor = 'var(--green)';
                        } elseif ($checked > 0) {
                            $badgeStyle = 'background: rgba(245,158,11,0.1); color: var(--gold); border: 1px solid rgba(245,158,11,0.2);';
                            $dotColor = 'var(--gold)';
                        } else {
                            $badgeStyle = 'background: rgba(99,102,241,0.08); color: #818CF8; border: 1px solid rgba(99,102,241,0.15);';
                            $dotColor = '#6366F1';
                        }
                    @endphp
                    <div style="display: inline-flex; flex-direction: column; align-items: center; gap: 6px;">
                        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; border-radius: 20px; {{ $badgeStyle }} font-weight: 700;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $dotColor }}; box-shadow: 0 0 6px {{ $dotColor }}, 0 0 12px {{ $dotColor }};"></span>
                            <span style="font-size: 0.8rem; font-weight: 700; letter-spacing: 0.02em;">{{ $checked }} / {{ $total }} Hadir</span>
                        </div>
                        @if($total > 0)
                            @php
                                $pct = ($checked / $total) * 100;
                            @endphp
                            <div style="width: 80px; height: 4px; background: rgba(255,255,255,0.05); border-radius: 99px; overflow: hidden; border: 1px solid var(--card-border);">
                                <div style="width: {{ $pct }}%; height: 100%; background: {{ $dotColor }}; border-radius: 99px; box-shadow: 0 0 8px {{ $dotColor }};"></div>
                            </div>
                        @endif
                    </div>
                </td>
                <td style="padding: 1.25rem 1rem; text-align: center; white-space: nowrap;">
                    <a href="{{ route('admin.event.participants.detail', $event) }}" class="btn-premium" style="padding: 0.5rem 1.25rem; font-size: 0.75rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; white-space: nowrap; text-decoration: none; margin: 0 auto;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="stroke-width: 2.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Data
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1rem; opacity: 0.2;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <p>Belum ada data peserta yang tersedia.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
