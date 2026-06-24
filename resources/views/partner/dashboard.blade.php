@extends('layouts.dashboard')

@section('title', 'Partner Dashboard')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@push('styles')
<style>
    .welcome-banner {
        background: radial-gradient(circle at top right, rgba(212, 175, 55, 0.15), transparent 55%), linear-gradient(135deg, rgba(19, 19, 26, 0.85) 0%, rgba(15, 15, 20, 0.95) 100%);
        border: 1px solid var(--card-border);
        border-top: 1px solid rgba(255,255,255,0.15);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 0 30px rgba(255,255,255,0.02), 0 15px 35px rgba(0,0,0,0.4);
    }

    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position:  200% center; }
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: var(--gold);
        filter: blur(120px);
        opacity: 0.12;
        z-index: 0;
    }

    .welcome-title {
        font-family: 'Crimson Pro', serif;
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        position: relative;
        z-index: 1;
    }

    .welcome-text {
        color: var(--text-secondary);
        font-size: 1rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .stat-card-premium {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-top: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .stat-card-premium::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(180deg, rgba(255,255,255,0.02) 0%, transparent 100%);
        pointer-events: none;
    }

    .stat-card-premium:hover {
        transform: translateY(-6px);
        border-color: var(--gold-dim);
        box-shadow: 0 15px 35px rgba(212, 175, 55, 0.1), 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .stat-card-premium .icon-box {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
    }
    .stat-card-premium:hover .icon-box {
        transform: scale(1.1);
    }

    .stat-card-premium .label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .stat-card-premium .value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.03em;
    }

    .stat-card-premium .trend {
        font-size: 0.75rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .grid-dashboard {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .grid-analytics {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* CRITICAL: prevent grid children from expanding beyond viewport */
    .grid-analytics > * {
        min-width: 0;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .grid-dashboard > * {
        min-width: 0;
    }

    canvas {
        max-width: 100% !important;
    }

    .chart-container-padding {
        padding: 2rem 2.25rem;
        box-sizing: border-box;
        width: 100%;
        overflow: hidden;
    }

    /* Dashboard simple table — no min-width needed */
    .grid-analytics .data-table {
        min-width: 0 !important;
        width: 100% !important;
    }

    @media (max-width: 1024px) {
        .grid-analytics {
            grid-template-columns: 1fr !important;
        }
    }

    @media (max-width: 1200px) {
        .grid-dashboard {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .grid-dashboard {
            grid-template-columns: 1fr;
        }
        .action-grid {
            grid-template-columns: 1fr;
        }
        .chart-container-padding {
            padding: 1rem;
        }
        .welcome-banner {
            padding: 1.75rem 1.5rem;
        }
        .welcome-title {
            font-size: 1.85rem;
        }
        .revenue-header-block {
            text-align: left !important;
            margin-top: 1rem;
            width: 100%;
        }
    }

    .card-luxury-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--card-border);
        background: rgba(255,255,255,0.01);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-luxury-title {
        font-family: 'Crimson Pro', serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--gold);
        letter-spacing: -0.01em;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        padding: 1.75rem 2rem;
    }

    .action-item {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 1.5rem 1rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .action-item:hover {
        background: var(--sidebar-hover);
        border-color: var(--gold-dim);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(212,175,55,0.1);
    }

    .action-item svg {
        width: 24px;
        height: 24px;
        color: var(--gold);
        margin-bottom: 0.75rem;
        transition: transform 0.3s ease;
    }
    .action-item:hover svg {
        transform: scale(1.15);
    }

    .action-item span {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeInUp 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        opacity: 0;
    }
</style>
@endpush

@section('content')

    <!-- Welcome Banner -->
    <div class="welcome-banner animate-in">
        <div style="position: relative; z-index: 2;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
                <div>
                    <div style="font-size:0.65rem; color:rgba(212,175,55,0.5); text-transform:uppercase; letter-spacing:0.18em; font-weight:700; margin-bottom:0.5rem;">Partner Dashboard</div>
                    <h1 class="welcome-title"
                        style="background: linear-gradient(90deg, #D4AF37, #F4D03F, #D4AF37); background-size:200% auto; -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; animation: shimmer 3s linear infinite;">
                        Selamat Datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="welcome-text">Monitor dan kelola event Wismilak Anda dengan lebih efisien.</p>
                    <div style="margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <div style="background: rgba(212,175,55,0.07); backdrop-filter: blur(12px); padding: 0.75rem 1.25rem; border-radius: 12px; border: 1px solid rgba(212,175,55,0.18);">
                            <div style="font-size: 0.6rem; color: var(--gold); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 2px;">Event Aktif</div>
                            <div style="font-size: 1.05rem; font-weight: 800; color: var(--text-primary);">{{ $stats['published'] }} Published</div>
                        </div>
                        <div style="background: rgba(245,158,11,0.07); backdrop-filter: blur(12px); padding: 0.75rem 1.25rem; border-radius: 12px; border: 1px solid rgba(245,158,11,0.18);">
                            <div style="font-size: 0.6rem; color: #F59E0B; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 2px;">Pending Review</div>
                            <div style="font-size: 1.05rem; font-weight: 800; color: var(--text-primary);">{{ $stats['pending'] }} Event</div>
                        </div>
                        <a href="{{ route('partner.events.create') }}" style="background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.08)); backdrop-filter: blur(12px); padding: 0.75rem 1.25rem; border-radius: 12px; border: 1px solid rgba(212,175,55,0.25); text-decoration:none; display:flex; align-items:center; gap:0.5rem; font-size:0.8rem; font-weight:700; color:var(--gold); transition:all 0.2s;"
                           onmouseover="this.style.background='rgba(212,175,55,0.2)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.08))'">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Event Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Stats -->
    <div class="grid-dashboard animate-in" style="animation-delay: 0.1s;">
        <div class="stat-card-premium">
            <div>
                <div class="icon-box" style="background: rgba(59,130,246,0.06); border-color: rgba(59,130,246,0.15);">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="var(--blue)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="label">Total Events</div>
                <div class="value">{{ $stats['total_events'] }}</div>
            </div>
            <div class="trend" style="color: var(--text-secondary); font-size: 0.75rem; font-weight: 600;">
                <span>Event Terdaftar</span>
            </div>
        </div>

        <div class="stat-card-premium">
            <div>
                <div class="icon-box" style="background: rgba(16,185,129,0.06); border-color: rgba(16,185,129,0.15);">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="var(--green)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="label">Published</div>
                <div class="value" style="color: var(--green);">{{ $stats['published'] }}</div>
            </div>
            <div class="trend" style="color: var(--green); font-weight: 700;">
                <span>Live & Active</span>
            </div>
        </div>

        <div class="stat-card-premium">
            <div>
                <div class="icon-box" style="background: rgba(245,158,11,0.06); border-color: rgba(245,158,11,0.15);">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#F59E0B">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="label">Pending</div>
                <div class="value" style="color: #F59E0B;">{{ $stats['pending'] }}</div>
            </div>
            <div class="trend" style="color: #F59E0B; font-weight: 700;">
                <span>Butuh Persetujuan</span>
            </div>
        </div>

        <div class="stat-card-premium" style="border-color: var(--gold-dim);">
            <div>
                <div class="icon-box" style="background: rgba(212, 175, 55, 0.06); border-color: rgba(212, 175, 55, 0.15);">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="var(--gold)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="label">Total Revenue</div>
                <div class="value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            </div>
            <div class="trend" style="color: var(--gold); font-weight: 700; letter-spacing: 0.03em;">
                <span>Premium Tier</span>
            </div>
        </div>
    </div>

    <div class="grid-analytics animate-in" style="animation-delay: 0.2s;">
        <!-- Main Analytics: Charts -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; width: 100%; box-sizing: border-box;">
            <!-- Revenue Chart Card -->
            <div class="premium-card" style="min-width: 0; overflow: hidden; box-sizing: border-box;">
                <div class="card-luxury-header">
                    <h2 class="card-luxury-title">Analisis Pendapatan</h2>
                    <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.12em; font-weight: 700;">Laporan Bulanan</div>
                </div>
                <div class="chart-container-padding" style="position: relative; width: 100%; min-width: 0; max-width: 100%; overflow: hidden; box-sizing: border-box;">
                    <div style="position: relative; height: 280px; width: 100%; min-width: 0; max-width: 100%;">
                        <canvas id="revenueChart" style="max-width: 100% !important;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tickets & Attendance Chart Card -->
            <div class="premium-card" style="min-width: 0; overflow: hidden; box-sizing: border-box;">
                <div class="card-luxury-header">
                    <h2 class="card-luxury-title">Tiket & Kehadiran</h2>
                    <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.12em; font-weight: 700;">Konversi Tiket</div>
                </div>
                <div class="chart-container-padding" style="position: relative; width: 100%; min-width: 0; max-width: 100%; overflow: hidden; box-sizing: border-box;">
                    <div style="position: relative; height: 280px; width: 100%; min-width: 0; max-width: 100%;">
                        <canvas id="ticketsChart" style="max-width: 100% !important;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Events -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem; min-width: 0; width: 100%; box-sizing: border-box;">
            <!-- Quick Actions Card -->
            <div class="premium-card">
                <div class="card-luxury-header">
                    <h2 class="card-luxury-title">Akses Cepat Partner</h2>
                </div>
                <div class="action-grid">
                    <a href="{{ route('partner.events.create') }}" class="action-item">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Buat Event</span>
                    </a>
                    <a href="{{ route('partner.checkin.scan') }}" class="action-item">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m0 11v1m5-6h-1m-11 0h1m8-5a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Scan QR</span>
                    </a>
                    <a href="{{ route('partner.events.index') }}" class="action-item">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span>Kelola Event</span>
                    </a>
                </div>
            </div>

            <!-- Recent Events Card -->
            <div class="premium-card">
                <div class="card-luxury-header">
                    <h2 class="card-luxury-title">Event Terbaru</h2>
                    <a href="{{ route('partner.events.index') }}"
                        style="font-size: 0.75rem; color: var(--gold); text-decoration: none; font-weight: 700; transition: color 0.2s;"
                        onmouseover="this.style.color='var(--text-primary)'"
                        onmouseout="this.style.color='var(--gold)'">Lihat Semua</a>
                </div>
                <div style="padding: 0; overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
                    <table class="data-table">
                        <tbody>
                            @forelse($recentEvents as $event)
                                <tr>
                                    <td style="padding: 1.25rem 1.5rem;">
                                        <div style="font-weight: 600; color: var(--text-primary); font-size: 0.9rem;">
                                            {{ Str::limit($event->title, 28) }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;">
                                            {{ $event->date ? $event->date->format('d M Y') : 'Jadwal TBD' }}</div>
                                    </td>
                                    <td style="text-align: right; padding-right: 1.5rem;">
                                        @php
                                            $badgeColor = $event->status === 'published' ? 'var(--green)' : ($event->status === 'pending' ? '#F59E0B' : 'var(--gold)');
                                            $badgeBg = $event->status === 'published' ? 'rgba(16,185,129,0.1)' : ($event->status === 'pending' ? 'rgba(245,158,11,0.1)' : 'rgba(212,175,55,0.1)');
                                        @endphp
                                        <span class="badge-premium"
                                            style="color: {{ $badgeColor }}; background: {{ $badgeBg }}; border: 1px solid {{ $badgeBg }}; font-size: 0.65rem; padding: 4px 8px;">
                                            {{ strtoupper($event->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="padding: 3rem; text-align: center; color: var(--text-secondary);">Tidak ada event aktif</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    
    // Revenue Chart
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    const gradient = ctxRevenue.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(212, 175, 55, 0.2)');
    gradient.addColorStop(1, 'rgba(212, 175, 55, 0)');

    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Revenue',
                data: chartData.revenue,
                borderColor: '#D4AF37',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#D4AF37',
                pointBorderColor: '#13131A',
                pointBorderWidth: 2,
                pointRadius: 4,
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
                    titleColor: '#E8E8ED',
                    bodyColor: '#8A8A9A',
                    borderColor: 'rgba(255,255,255,0.05)',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function (context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    grid: { color: 'rgba(255, 255, 255, 0.03)' },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.6)',
                        font: { size: 10 },
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'M';
                            if (value >= 1000) return 'Rp ' + (value / 1000) + 'K';
                            return 'Rp ' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: 'rgba(255, 255, 255, 0.6)', font: { size: 10 } }
                }
            }
        }
    });

    // Tickets Chart
    const ctxTickets = document.getElementById('ticketsChart').getContext('2d');
    new Chart(ctxTickets, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Tiket Terjual',
                    data: chartData.tickets,
                    backgroundColor: '#10B981',
                    borderRadius: 4
                },
                {
                    label: 'Hadir/Check-in',
                    data: chartData.checkins,
                    backgroundColor: '#3B82F6',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: 'rgba(255, 255, 255, 0.7)', font: { size: 10 } }
                }
            },
            scales: {
                y: {
                    grid: { color: 'rgba(255, 255, 255, 0.03)' },
                    ticks: { color: 'rgba(255, 255, 255, 0.6)', font: { size: 10 }, stepSize: 1 }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: 'rgba(255, 255, 255, 0.6)', font: { size: 10 } }
                }
            }
        }
    });
});
</script>
@endpush