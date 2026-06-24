@extends('layouts.admin')

@section('title', 'Poin Pengguna')

@section('content')
<div class="header-section-premium">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Poin Pengguna</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola saldo poin loyalty dan riwayat transaksi poin untuk seluruh pengguna.</p>
    </div>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Nama Pengguna</th>
                <th>Email</th>
                <th style="text-align: center;">Role</th>
                <th style="text-align: center;">Total Poin</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="font-weight: 600; color: var(--text-primary);">{{ $user->name }}</div>
                </td>
                <td>
                    <div style="color: var(--text-secondary); font-size: 0.85rem;">{{ $user->email }}</div>
                </td>
                <td style="text-align: center;">
                    <span class="badge-premium" style="background: rgba(139,92,246,0.1); color: #818CF8; border: 1px solid rgba(99,102,241,0.2);">
                        {{ strtoupper($user->role?->name ?? 'customer') }}
                    </span>
                </td>
                <td style="text-align: center;">
                    <span style="font-size: 1.1rem; font-weight: 700; color: var(--gold); font-family: 'Inter', sans-serif;">{{ $user->point?->total_points ?? 0 }}</span>
                </td>
                <td style="padding-right: 2rem; text-align: right;">
                    <a href="{{ route('admin.points.users.detail', $user) }}" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: rgba(59,130,246,0.05); color: #3B82F6 !important; border: 1px solid rgba(59,130,246,0.2);">
                        Riwayat Poin
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 3rem; text-align: center; color: var(--text-secondary);">
                    Belum ada pengguna dengan poin
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
