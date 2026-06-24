@extends('layouts.admin')

@section('title', 'Penukaran Reward')

@section('content')
<div class="header-section-premium">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Riwayat Penukaran Reward</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Daftar transaksi penukaran poin loyalty menjadi reward produk oleh customer.</p>
    </div>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Customer</th>
                <th>Reward yang Ditukar</th>
                <th style="text-align: center;">Poin Digunakan</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Tanggal Penukaran</th>
            </tr>
        </thead>

        <tbody>
            @forelse($redemptions as $item)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="font-weight: 600; color: var(--text-primary);">{{ $item->user->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $item->user->email }}</div>
                </td>
                <td style="font-weight: 600; color: var(--text-primary);">
                    {{ $item->reward->title }}
                </td>
                <td style="text-align: center; color: var(--gold); font-weight: 700; font-family: 'Inter', sans-serif;">
                    {{ number_format($item->points_used) }}
                </td>
                <td style="text-align: center;">
                    <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">
                        {{ strtoupper($item->status) }}
                    </span>
                </td>
                <td style="padding-right: 2rem; text-align: right; color: var(--text-secondary); font-size: 0.85rem;">
                    {{ $item->created_at->format('d M Y, H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-secondary);">
                    Belum ada riwayat penukaran reward
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
