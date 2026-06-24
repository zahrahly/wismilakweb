@extends('layouts.dashboard')

@section('title', 'Website Engagement Analytics')

@section('sidebar')
  @include('manager.partials.sidebar')
@endsection

@push('styles')
<style>
    .eng-stat { padding: 1.25rem; border-left: 3px solid var(--gold); }
    .eng-stat .label { font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 4px; }
    .eng-stat .value { font-size: 1.3rem; font-weight: 800; color: var(--text-primary); }
    .eng-stat .sub { font-size: 0.7rem; color: var(--text-secondary); margin-top: 2px; }
    .chart-container { background: rgba(26, 26, 37, 0.5); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.5rem; }
    .chart-container h3 { font-family: 'Crimson Pro', serif; font-size: 1rem; color: var(--gold); margin-bottom: 1rem; }
    .top-event-row { display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.03); }
    .top-event-row:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem;">Website Engagement Analytics</h1>
        <p style="color: var(--text-secondary); font-size: 0.8rem;">Analisis lengkap interaksi pengguna dan performa platform Wismilak {{ now()->year }}.</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('manager.engagement.export.pdf') }}" target="_blank" class="btn-premium" style="padding: 0.45rem 1rem; font-size: 0.65rem; background: rgba(231,76,76,0.08); color: var(--red); border: 1px solid rgba(231,76,76,0.15);">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            PDF
        </a>
        <a href="{{ route('manager.engagement.export.csv') }}" class="btn-premium" style="padding: 0.45rem 1rem; font-size: 0.65rem; background: rgba(139,92,246,0.08); color: #8B5CF6; border: 1px solid rgba(139,92,246,0.15);">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            CSV
        </a>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="stat-grid" style="margin-bottom: 1.5rem;">
    @foreach([
        ['label' => 'Total Users', 'value' => number_format($stats['total_users']), 'sub' => $stats['active_users'] . ' active members', 'border' => '#3B82F6'],
        ['label' => 'Registrations', 'value' => number_format($stats['paid_registrations']), 'sub' => number_format($stats['total_registrations']) . ' total attempts', 'border' => '#10B981'],
        ['label' => 'Feedback Collected', 'value' => number_format($stats['total_feedbacks']), 'sub' => 'Avg rating: ' . $stats['avg_rating'] . ' / 5.0', 'border' => '#F59E0B'],
        ['label' => 'Total Revenue', 'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'), 'sub' => $stats['published_events'] . ' active, ' . $stats['completed_events'] . ' completed', 'border' => '#D4AF37'],
    ] as $s)
    <div class="premium-card eng-stat" style="border-left-color: {{ $s['border'] }};">
        <div class="label">{{ $s['label'] }}</div>
        <div class="value">{{ $s['value'] }}</div>
        <div class="sub">{{ $s['sub'] }}</div>
    </div>
    @endforeach
</div>

{{-- CHARTS ROW 1: Registrations + Feedbacks --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
    <div class="chart-container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Pendaftaran Event (Bulanan)</h3>
            <span style="font-size: 0.65rem; color: var(--gold); font-weight: 600;">{{ now()->year }}</span>
        </div>
        <canvas id="registrationChart" style="max-height: 250px;"></canvas>
    </div>
    <div class="chart-container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Feedback Masuk (Bulanan)</h3>
            <span style="font-size: 0.65rem; color: var(--gold); font-weight: 600;">{{ now()->year }}</span>
        </div>
        <canvas id="feedbackChart" style="max-height: 250px;"></canvas>
    </div>
</div>

{{-- CHARTS ROW 2: User Growth + Rating Distribution --}}
<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
    <div class="chart-container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Pertumbuhan User Baru</h3>
            <span style="font-size: 0.65rem; color: var(--gold); font-weight: 600;">{{ now()->year }}</span>
        </div>
        <canvas id="userGrowthChart" style="max-height: 250px;"></canvas>
    </div>
    <div class="chart-container">
        <h3>Distribusi Rating Feedback</h3>
        <canvas id="ratingChart" style="max-height: 250px;"></canvas>
    </div>
</div>

{{-- TOP EVENTS --}}
<div class="premium-card" style="padding: 1.5rem;">
    <h3 style="font-family: 'Crimson Pro', serif; font-size: 1rem; color: var(--gold); margin-bottom: 1rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">Top 5 Event Berdasarkan Peserta</h3>
    @forelse($topEvents as $i => $event)
    <div class="top-event-row">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(212,175,55,0.1); color: var(--gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; border: 1px solid rgba(212,175,55,0.2);">
                {{ $i + 1 }}
            </div>
            <div>
                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.85rem;">{{ $event->title }}</div>
                <div style="font-size: 0.7rem; color: var(--text-secondary);">{{ $event->date ? $event->date->format('d M Y') : '-' }} &bull; {{ $event->location ?? '-' }}</div>
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-weight: 700; color: var(--gold); font-size: 0.9rem;">{{ $event->registrations_count }}</div>
            <div style="font-size: 0.65rem; color: var(--text-secondary);">peserta</div>
        </div>
    </div>
    @empty
    <p style="text-align: center; color: var(--text-secondary); padding: 2rem; font-size: 0.85rem;">Belum ada data event.</p>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: '#8A8A9A', font: { size: 10 } }, grid: { display: false } },
            y: { ticks: { color: '#8A8A9A', font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.03)' }, beginAtZero: true }
        }
    };
    const months = @json($months);

    // Registration Chart
    new Chart(document.getElementById('registrationChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Pendaftaran',
                data: @json($registrationsChart),
                backgroundColor: 'rgba(59,130,246,0.6)',
                borderColor: '#3B82F6',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: chartDefaults
    });

    // Feedback Chart
    new Chart(document.getElementById('feedbackChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Feedback',
                data: @json($feedbacksChart),
                borderColor: '#F59E0B',
                backgroundColor: 'rgba(245,158,11,0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointBackgroundColor: '#F59E0B'
            }]
        },
        options: chartDefaults
    });

    // User Growth Chart
    new Chart(document.getElementById('userGrowthChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'User Baru',
                data: @json($userGrowthChart),
                backgroundColor: 'rgba(212,175,55,0.5)',
                borderColor: '#D4AF37',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: chartDefaults
    });

    // Rating Distribution (Doughnut)
    new Chart(document.getElementById('ratingChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
            datasets: [{
                data: @json($ratingDistribution),
                backgroundColor: ['#E74C4C', '#F59E0B', '#8B5CF6', '#3B82F6', '#10B981'],
                borderColor: '#1A1A25',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#8A8A9A', font: { size: 10 }, padding: 12, usePointStyle: true }
                }
            }
        }
    });
});
</script>
@endpush
