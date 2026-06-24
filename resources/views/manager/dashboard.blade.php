@extends('layouts.dashboard')

@section('title', 'Managerial Overview')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeInUp 0.7s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }

    /* ── Welcome Banner ── */
    .mgr-banner {
        background: radial-gradient(circle at top right, rgba(212,175,55,0.13), transparent 55%),
                    linear-gradient(135deg, rgba(19,19,26,0.9) 0%, rgba(13,13,18,0.97) 100%);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .mgr-banner::after {
        content: '';
        position: absolute; top: -60px; right: -60px;
        width: 280px; height: 280px;
        background: var(--gold); filter: blur(130px); opacity: 0.1; z-index: 0;
    }

    /* ── Stat Cards ── */
    .mgr-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .mgr-stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-top: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }
    .mgr-stat-card::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(255,255,255,0.02) 0%, transparent 100%);
        pointer-events: none;
    }
    .mgr-stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold-dim);
        box-shadow: 0 15px 35px rgba(212,175,55,0.1);
    }
    .mgr-stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(255,255,255,0.08);
        transition: transform 0.3s;
    }
    .mgr-stat-card:hover .mgr-stat-icon { transform: scale(1.1); }

    /* ── Charts Grid ── */
    .mgr-chart-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
        width: 100%; max-width: 100%; box-sizing: border-box;
    }
    .mgr-chart-grid > * { min-width: 0; box-sizing: border-box; }
    canvas { max-width: 100% !important; }

    .mgr-report-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        padding: 1.25rem;
    }
    .mgr-export-tile {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--card-border);
        padding: 1rem; border-radius: 14px;
        text-decoration: none; transition: all 0.3s;
        text-align: center;
    }
    .mgr-export-tile:hover {
        background: rgba(212,175,55,0.05);
        border-color: var(--gold-dim);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(212,175,55,0.08);
    }

    /* ── Table ── */
    .user-avatar-sm {
        width: 34px; height: 34px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }

    @media (max-width: 1200px) {
        .mgr-stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 1024px) {
        .mgr-chart-grid { grid-template-columns: 1fr !important; }
    }
    @media (max-width: 768px) {
        .mgr-stat-grid { grid-template-columns: 1fr; }
        .mgr-banner { padding: 1.5rem; }
        .mgr-report-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('sidebar')
  @include('manager.partials.sidebar')
@endsection

@section('content')

{{-- ── WELCOME BANNER ── --}}
<div class="mgr-banner animate-in">
    <div style="position: relative; z-index: 2;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
    <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.4rem; letter-spacing: -0.02em;">
        Manager Dashboard
    </h1>
    <p style="color: var(--text-secondary); font-size: 0.9rem;">
        Monitor event performance, partner activity, transactions, rewards, and overall website engagement.
    </p>
</div>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('manager.events.index') }}" style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(212,175,55,0.08); border:1px solid rgba(212,175,55,0.25); color:var(--gold); padding:0.55rem 1.1rem; border-radius:10px; font-size:0.78rem; font-weight:700; text-decoration:none; transition:all 0.2s;"
                   onmouseover="this.style.background='rgba(212,175,55,0.15)'" onmouseout="this.style.background='rgba(212,175,55,0.08)'">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan Event
                </a>
                <a href="{{ route('manager.transactions.index') }}" style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.25); color:var(--green); padding:0.55rem 1.1rem; border-radius:10px; font-size:0.78rem; font-weight:700; text-decoration:none; transition:all 0.2s;"
                   onmouseover="this.style.background='rgba(16,185,129,0.15)'" onmouseout="this.style.background='rgba(16,185,129,0.08)'">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/></svg>
                    Transaksi
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="mgr-stat-grid animate-in" style="animation-delay:0.1s;">
    @foreach([
        ['label'=>'Total Event',     'value'=>$stats['total_events'],       'raw'=>null, 'color'=>'#3B82F6', 'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'trend'=>'Terkelola'],
        ['label'=>'Gross Revenue',   'value'=>null, 'raw'=>$stats['total_revenue'],       'color'=>'#10B981','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'trend'=>'Revenue YTD'],
        ['label'=>'Paid Participants','value'=>$stats['total_participants'], 'raw'=>null, 'color'=>'#D4AF37','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'trend'=>'Peserta Aktif'],
        ['label'=>'Total Users',     'value'=>$stats['total_users'],        'raw'=>null, 'color'=>'#8B5CF6','icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'trend'=>'Wismilak Universe'],
    ] as $s)
    <div class="mgr-stat-card">
        <div class="mgr-stat-icon" style="background: {{ $s['color'] }}15;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="{{ $s['color'] }}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/>
            </svg>
        </div>
        <div style="font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 0.5rem;">{{ $s['label'] }}</div>
        <div style="font-size: 1.55rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.02em; line-height: 1.1;">
            {{ $s['raw'] !== null ? 'Rp '.number_format($s['raw'],0,',','.') : number_format($s['value']) }}
        </div>
        <div style="font-size: 0.72rem; color: var(--text-secondary); margin-top: 0.85rem; font-weight: 600;">{{ $s['trend'] }}</div>
    </div>
    @endforeach
</div>

{{-- ── CHARTS + REPORTS ── --}}
<div class="mgr-chart-grid animate-in" style="animation-delay: 0.2s;">
    {{-- Revenue Chart --}}
    <div class="premium-card" style="min-width:0; overflow:hidden; box-sizing:border-box;">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border); display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h3 style="font-family:'Crimson Pro',serif; font-size:1.3rem; font-weight:700; color:var(--gold); margin-bottom:2px;">Revenue Performance</h3>
                <div style="font-size:0.7rem; color:var(--text-secondary); text-transform:uppercase; letter-spacing:0.1em; font-weight:600;">YTD 2026 Audit</div>
            </div>
            <div style="font-size:0.72rem; color:var(--text-secondary); background:rgba(255,255,255,0.03); border:1px solid var(--card-border); padding:0.4rem 0.85rem; border-radius:8px; font-weight:600;">
                {{ now()->format('Y') }}
            </div>
        </div>
        <div style="padding: 1.5rem 2rem; position:relative; width:100%; min-width:0; max-width:100%; overflow:hidden; box-sizing:border-box;">
            <div style="position:relative; height:260px; width:100%; min-width:0; max-width:100%;">
                <canvas id="revenueChart" style="max-width:100% !important;"></canvas>
            </div>
        </div>
    </div>

    {{-- Report Center --}}
    <div class="premium-card" style="min-width:0; overflow:hidden; box-sizing:border-box;">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border);">
            <h3 style="font-family:'Crimson Pro',serif; font-size:1.3rem; font-weight:700; color:var(--gold);">Report Center</h3>
            <div style="font-size:0.7rem; color:var(--text-secondary); text-transform:uppercase; letter-spacing:0.1em; font-weight:600; margin-top:2px;">Generate Reports</div>
        </div>
        <div class="mgr-report-grid">
            @foreach([
                ['label'=>'Events PDF',   'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',   'route'=>'manager.events.export.pdf'],
                ['label'=>'Users PDF',    'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'route'=>'manager.users.export.pdf'],
                ['label'=>'Finance PDF',  'icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route'=>'manager.transactions.export.pdf'],
                ['label'=>'Feedback CSV', 'icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'route'=>'manager.feedback.export.csv'],
            ] as $r)
            <a href="{{ route($r['route']) }}" class="mgr-export-tile">
                <div style="width:36px; height:36px; border-radius:10px; background:rgba(212,175,55,0.08); display:flex; align-items:center; justify-content:center; border:1px solid rgba(212,175,55,0.15); margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--gold)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $r['icon'] }}"/></svg>
                </div>
                <span style="font-size:0.62rem; font-weight:700; color:var(--text-secondary); letter-spacing:0.08em; text-transform:uppercase;">{{ $r['label'] }}</span>
            </a>
            @endforeach
        </div>
        <div style="padding: 0.75rem 1.25rem; border-top: 1px solid var(--card-border); text-align:center;">
            <p style="font-size:0.7rem; color:var(--text-secondary);">Generate encrypted reports for stakeholders.</p>
        </div>
    </div>
</div>

{{-- ── TRANSACTIONS TABLE ── --}}
<div class="premium-card animate-in" style="animation-delay: 0.4s;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
        <h3 style="font-family:'Crimson Pro',serif; font-size:1.3rem; font-weight:700; color:var(--gold);">Critical Transactions Log</h3>
        <a href="{{ route('manager.transactions.index') }}" class="btn-premium" style="font-size:0.72rem; padding:0.55rem 1.25rem;">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            VIEW LEDGER
        </a>
    </div>
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="data-table" style="min-width: 600px;">
            <thead>
                <tr>
                    <th style="padding-left: 2rem;">Source Identity</th>
                    <th>Event Context</th>
                    <th style="text-align: right;">Amount</th>
                    <th>Status</th>
                    <th style="padding-right: 2rem;">Timestamp</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentTransactions as $t)
            @php
                $name = $t->user->name ?? 'Anonymous';
                $initials = strtoupper(substr($name, 0, 1));
                $colors = ['#D4AF37', '#E74C4C', '#3B82F6', '#10B981', '#8B5CF6'];
                $bgColor = $colors[ord($initials) % count($colors)];
            @endphp
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div class="user-avatar-sm" style="background: {{ $bgColor }}">{{ $initials }}</div>
                        <div>
                            <div style="font-weight: 600; color: var(--text-primary); font-size:0.875rem;">{{ $name }}</div>
                            <div style="font-size: 0.68rem; font-family: monospace; color: var(--text-secondary);">{{ $t->transaction_code }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:0.85rem; color:var(--text-primary);">{{ Str::limit($t->registration->event->title ?? '-', 35) }}</td>
                <td style="text-align: right; color: var(--gold); font-weight: 700; font-size: 0.95rem;">Rp {{ number_format($t->amount,0,',','.') }}</td>
                <td><span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border:1px solid rgba(16,185,129,0.2);">SETTLED</span></td>
                <td style="padding-right: 2rem; color: var(--text-secondary); font-size: 0.78rem;">{{ $t->paid_at?->format('d M Y, H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:var(--text-secondary); padding:4rem;">No records available for the current period.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(212, 175, 55, 0.18)');
    gradient.addColorStop(1, 'rgba(212, 175, 55, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Gross Revenue',
                data: @json($monthlyRevenue),
                borderColor: '#D4AF37',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#D4AF37',
                pointBorderColor: '#1A1A25',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1A1A25',
                    titleColor: '#D4AF37',
                    bodyColor: '#E8E8ED',
                    borderColor: 'rgba(255,255,255,0.08)',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: { ticks: { color: '#8A8A9A', font: { size: 10 } }, grid: { display: false } },
                y: {
                    ticks: {
                        color: '#8A8A9A', font: { size: 10 },
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000) + 'M';
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: { color: 'rgba(255,255,255,0.03)' }
                }
            }
        }
    });
});
</script>
@endpush
