@extends('layouts.dashboard')

@section('title', 'Katalog Voucher & Reward')

@section('sidebar')
  @include('manager.partials.sidebar')
@endsection

@section('content')
<div class="animate-in" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; letter-spacing: -0.02em;">Rewards & Voucher Collection</h1>
        <p style="color: var(--text-secondary); font-size: 1.1rem; max-width: 600px; line-height: 1.6;">Monitoring performa penukaran poin loyalitas customer, ketersediaan voucher diskon, dan katalog reward.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('manager.rewards.export.csv') }}" class="btn-premium" target="_blank" style="background: rgba(16,185,129,0.1); color: #10B981; border: 1px solid rgba(16,185,129,0.2);">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            CSV EXPORT
        </a>
        <a href="{{ route('manager.rewards.export.pdf') }}" class="btn-premium" target="_blank" style="background: rgba(239,68,68,0.1); color: #EF4444; border: 1px solid rgba(239,68,68,0.2);">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            PDF REPORT
        </a>
    </div>
</div>

{{-- STAT CARDS --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;" class="animate-in">
    <div class="premium-card" style="padding: 1.5rem; border-left: 3px solid var(--gold);">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 0.5rem;">Katalog Reward</div>
        <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-primary); font-family: 'Crimson Pro', serif;">{{ $stats['total_rewards'] }} <span style="font-size: 0.8rem; font-weight: 500; color: var(--text-secondary);">({{ $stats['active_rewards'] }} Aktif)</span></div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; border-left: 3px solid #3B82F6;">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 0.5rem;">Katalog Voucher</div>
        <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-primary); font-family: 'Crimson Pro', serif;">{{ $stats['total_vouchers'] }} <span style="font-size: 0.8rem; font-weight: 500; color: var(--text-secondary);">({{ $stats['active_vouchers'] }} Aktif)</span></div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; border-left: 3px solid var(--green);">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 0.5rem;">Total Penukaran</div>
        <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-primary); font-family: 'Crimson Pro', serif;">{{ number_format($stats['total_redemptions']) }}</div>
    </div>
    <div class="premium-card" style="padding: 1.5rem; border-left: 3px solid #8B5CF6;">
        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 0.5rem;">Penukaran Voucher</div>
        <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-primary); font-family: 'Crimson Pro', serif;">{{ number_format($stats['total_voucher_redemptions']) }}</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2.5rem;" class="animate-in" style="animation-delay: 0.2s;">
    {{-- Reward Catalog --}}
    <div class="premium-card" style="display: flex; flex-direction: column;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; font-weight: 700; color: var(--gold); margin: 0;">Catalog Reward</h3>
            <span class="badge-premium" style="background: rgba(212,175,55,0.1); color: var(--gold); font-size: 0.7rem;">REWARD</span>
        </div>
        <div class="card-body" style="padding: 0; flex: 1;">
            <table class="data-table">
                <thead><tr><th>Nama Reward</th><th style="text-align: center;">Poin</th><th style="text-align: center;">Stok</th><th style="text-align: center;">Ditukar</th></tr></thead>
                <tbody>
                @forelse($rewards as $r)
                <tr>
                    <td style="font-weight: 500; color: var(--text-primary);">{{ $r->title }}</td>
                    <td style="color:var(--gold); text-align: center; font-weight: 600;">{{ number_format($r->points_required) }}</td>
                    <td style="text-align: center; color: var(--text-secondary);">{{ $r->stock }}</td>
                    <td style="font-weight:700; text-align: center; color: var(--green);">{{ $r->redemptions_count }} kali</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-secondary);padding:3rem;">Belum ada reward terdaftar.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($rewards->hasPages())
        <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--card-border);">
            {{ $rewards->appends(request()->except('rewards_page'))->links() }}
        </div>
        @endif
    </div>

    {{-- Voucher Catalog --}}
    <div class="premium-card" style="display: flex; flex-direction: column;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; font-weight: 700; color: #3B82F6; margin: 0;">Catalog Voucher</h3>
            <span class="badge-premium" style="background: rgba(59,130,246,0.1); color: #60A5FA; font-size: 0.7rem;">VOUCHER</span>
        </div>
        <div class="card-body" style="padding: 0; flex: 1;">
            <table class="data-table">
                <thead><tr><th>Kode & Voucher</th><th style="text-align: center;">Poin</th><th style="text-align: center;">Diskon</th><th style="text-align: center;">Ditukar</th></tr></thead>
                <tbody>
                @forelse($vouchers as $v)
                <tr>
                    <td>
                        <div style="font-weight: 500; color: var(--text-primary);">{{ $v->title }}</div>
                        <div style="font-family: monospace; font-size: 0.75rem; color: var(--text-secondary);">{{ $v->code }}</div>
                    </td>
                    <td style="color:var(--gold); text-align: center; font-weight: 600;">{{ number_format($v->points_required) }}</td>
                    <td style="text-align: center; color: var(--text-primary); font-weight: 500;">
                        {{ $v->discount_type === 'percent' ? $v->discount_value . '%' : 'Rp ' . number_format($v->discount_value, 0, ',', '.') }}
                    </td>
                    <td style="font-weight:700; text-align: center; color: #60A5FA;">{{ $v->redemptions_count }} kali</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-secondary);padding:3rem;">Belum ada voucher terdaftar.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($vouchers->hasPages())
        <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--card-border);">
            {{ $vouchers->appends(request()->except('vouchers_page'))->links() }}
        </div>
        @endif
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1.5rem;" class="animate-in" style="animation-delay: 0.4s;">
    {{-- Top 10 User Poin --}}
    <div class="premium-card">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border);">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; font-weight: 700; color: var(--gold); margin: 0;">Top 10 Cigar Member Poin</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="data-table">
                <thead><tr><th style="padding-left: 1.5rem; width: 60px;">#</th><th>Member</th><th style="padding-right: 1.5rem; text-align: right;">Total Poin</th></tr></thead>
                <tbody>
                @forelse($topUsers as $i => $up)
                <tr>
                    <td style="padding-left: 1.5rem; color:var(--gold); font-weight:700;">{{ $i + 1 }}</td>
                    <td>
                        <div style="font-weight:500; color: var(--text-primary);">{{ $up->user->name ?? '-' }}</div>
                        <div style="font-size:.75rem; color:var(--text-secondary);">{{ $up->user->email ?? '' }}</div>
                    </td>
                    <td style="padding-right: 1.5rem; text-align: right;">
                        <span style="background:rgba(212,175,55,.15); color:var(--gold); padding:.25rem .75rem; border-radius:999px; font-weight:700; font-size:.8rem;">
                            {{ number_format($up->total_points) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--text-secondary);padding:3rem;">Belum ada data member.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Redemption History --}}
    <div class="premium-card">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border);">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin: 0;">Log Penukaran Terbaru (Merged)</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="data-table">
                <thead><tr><th style="padding-left: 1.5rem;">Tipe</th><th>Item</th><th>User</th><th style="text-align: center;">Poin</th><th style="padding-right: 1.5rem; text-align: right;">Tanggal</th></tr></thead>
                <tbody>
                @forelse($recentRedemptions as $item)
                <tr>
                    <td style="padding-left: 1.5rem;">
                        @if($item['type'] === 'Reward')
                        <span class="badge-premium" style="background: rgba(212,175,55,0.1); color: var(--gold); font-size: 0.65rem; font-weight: 700;">REWARD</span>
                        @else
                        <span class="badge-premium" style="background: rgba(59,130,246,0.1); color: #60A5FA; font-size: 0.65rem; font-weight: 700;">VOUCHER</span>
                        @endif
                    </td>
                    <td style="font-weight: 500; color: var(--text-primary);">{{ $item['item_name'] }}</td>
                    <td>{{ $item['user_name'] }}</td>
                    <td style="text-align: center; color: var(--gold); font-weight: 600;">{{ number_format($item['points']) }} pts</td>
                    <td style="padding-right: 1.5rem; text-align: right; font-size: 0.75rem; color: var(--text-secondary);">
                        {{ $item['date'] ? $item['date']->format('d M Y, H:i') : '-' }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--text-secondary);padding:3rem;">Belum ada riwayat penukaran poin.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
