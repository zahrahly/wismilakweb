@extends('layouts.admin')

@section('title', 'Riwayat Poin: ' . $user->name)

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.points.users') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Poin
    </a>
</div>

<!-- USER INFO CARD -->
<div class="premium-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
        <div style="width: 54px; height: 54px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), #B8860B); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; color: #000; box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); font-family: 'Crimson Pro', serif;">{{ $user->name }}</h1>
            <p style="color: var(--text-secondary); font-size: 0.85rem;">{{ $user->email }} &bull; <span class="badge-premium" style="background: rgba(139,92,246,0.1); color: #818CF8; border: 1px solid rgba(99,102,241,0.2); font-size: 0.65rem; padding: 2px 8px;">{{ strtoupper($user->role?->name ?? 'customer') }}</span></p>
        </div>
    </div>
</div>

<!-- STATS GRID -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="premium-card" style="padding: 1.5rem; text-align: center; border-color: var(--gold-dim);">
        <div style="font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--gold); margin-bottom: 0.5rem; font-weight: 700;">Poin Saat Ini</div>
        <div style="font-size: 2.25rem; font-weight: 800; color: var(--gold); font-family: 'Inter', sans-serif;">{{ $user->point?->total_points ?? 0 }}</div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; text-align: center;">
        <div style="font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--green); margin-bottom: 0.5rem; font-weight: 700;">Total Diperoleh</div>
        <div style="font-size: 2.25rem; font-weight: 800; color: var(--green); font-family: 'Inter', sans-serif;">+{{ number_format($totalEarned) }}</div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; text-align: center;">
        <div style="font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--red); margin-bottom: 0.5rem; font-weight: 700;">Total Digunakan</div>
        <div style="font-size: 2.25rem; font-weight: 800; color: var(--red); font-family: 'Inter', sans-serif;">-{{ number_format($totalSpent) }}</div>
    </div>
</div>

<!-- HISTORY TABLE -->
<div class="premium-card">
    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--card-border);">
        <h2 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; font-weight: 700; color: var(--gold);">Riwayat Transaksi Poin</h2>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Tanggal</th>
                <th>Aktivitas</th>
                <th>Sumber</th>
                <th style="text-align: center;">Tipe</th>
                <th style="text-align: right; padding-right: 2rem;">Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $h)
            <tr>
                <td style="padding-left: 2rem; color: var(--text-secondary); font-size: 0.8rem;">
                    {{ $h->created_at->format('d M Y, H:i') }}
                </td>
                <td style="font-weight: 600; color: var(--text-primary);">
                    {{ $h->description }}
                </td>
                <td style="color: var(--text-secondary); font-size: 0.8rem; text-transform: capitalize;">
                    {{ str_replace('_', ' ', $h->source) }}
                </td>
                <td style="text-align: center;">
                    @if($h->type === 'earn')
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">EARN</span>
                    @else
                        <span class="badge-premium" style="background: rgba(231,76,76,0.1); color: var(--red); border: 1px solid rgba(231,76,76,0.2);">SPEND</span>
                    @endif
                </td>
                <td style="padding-right: 2rem; text-align: right; font-weight: 700; font-size: 1rem; {{ $h->type === 'earn' ? 'color: var(--green);' : 'color: var(--red);' }}">
                    {{ $h->type === 'earn' ? '+' : '-' }}{{ $h->points }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 3rem; text-align: center; color: var(--text-secondary);">
                    Belum ada riwayat poin
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($histories->hasPages())
    <div style="padding: 1.25rem 2rem; border-top: 1px solid var(--card-border);">
        {{ $histories->links() }}
    </div>
    @endif
</div>
@endsection
