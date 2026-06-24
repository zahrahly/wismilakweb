@extends('layouts.dashboard')

@section('title', 'Laporan Customer Feedback')

@section('sidebar')
  @include('manager.partials.sidebar')
@endsection

@push('styles')
<style>
    .stat-card-premium {
        position: relative;
        overflow: hidden;
        padding: 1.5rem 2rem;
        background: linear-gradient(145deg, rgba(26, 26, 37, 0.9), rgba(15, 15, 20, 0.9));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 16px;
    }
    .stat-card-premium:hover {
        transform: translateY(-5px);
        border-color: var(--gold-dim);
        box-shadow: 0 15px 30px rgba(0,0,0,0.4);
    }
    .stat-card-premium .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 4rem;
        opacity: 0.08;
        color: var(--gold);
        transform: rotate(-15deg);
        transition: all 0.4s ease;
    }
    .stat-card-premium:hover .icon-bg {
        transform: rotate(0deg) scale(1.1);
        opacity: 0.15;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        color: #fff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .rating-stars {
        display: flex;
        gap: 2px;
    }
    .table-row-premium {
        transition: all 0.2s ease;
    }
    .table-row-premium:hover {
        background: rgba(212, 175, 55, 0.03) !important;
        transform: scale(1.002);
    }
    .table-row-premium:hover td:first-child {
        box-shadow: inset 4px 0 0 var(--gold);
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeInUp 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        opacity: 0;
    }
    
    .chart-container {
        background: rgba(26, 26, 37, 0.5);
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid var(--card-border);
        height: 100%;
    }
</style>
@endpush

@section('content')
<div class="animate-in" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; letter-spacing: -0.02em;">Feedback Analytics</h1>
        <p style="color: var(--text-secondary); font-size: 1.1rem; max-width: 600px; line-height: 1.6;">Analisis komprehensif kepuasan partisipan dan kualitas event Wismilak.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('manager.feedback.export.pdf', request()->all()) }}" class="btn-premium" target="_blank" style="background: rgba(239,68,68,0.1); color: #EF4444; border: 1px solid rgba(239,68,68,0.2);">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            PDF
        </a>
        <a href="{{ route('manager.feedback.export.csv', request()->all()) }}" class="btn-premium" style="background: rgba(59,130,246,0.1); color: #60A5FA; border: 1px solid rgba(59,130,246,0.2);">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            CSV
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2rem; margin-bottom: 2.5rem;">
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
        <div class="stat-card-premium animate-in" style="animation-delay: 0.1s;">
            <div>
                <div class="label" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700;">Total Feedback</div>
                <div class="value" style="font-size: 2rem; font-weight: 800; font-family: 'Crimson Pro', serif; margin-top: 5px;">{{ number_format($stats['total']) }}</div>
            </div>
            <div class="trend" style="color: var(--gold); font-weight: 600; font-size: 0.85rem; margin-top: 5px;">Verified</div>
            <div class="icon-bg">
                <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
            </div>
        </div>
        <div class="stat-card-premium animate-in" style="animation-delay: 0.2s; border-left: 3px solid var(--gold);">
            <div>
                <div class="label" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700;">Avg Rating</div>
                <div class="value" style="font-size: 2rem; font-weight: 800; font-family: 'Crimson Pro', serif; color: var(--gold); margin-top: 5px;">{{ number_format($stats['avg_rating'], 1) }}</div>
            </div>
            <div style="display: flex; gap: 3px; margin-top: 0.5rem;">
                @for($i = 1; $i <= 5; $i++)
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $i <= round($stats['avg_rating']) ? 'var(--gold)' : 'rgba(255,255,255,0.1)' }}">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                @endfor
            </div>
            <div class="icon-bg">
                <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
        </div>
        <div class="stat-card-premium animate-in" style="animation-delay: 0.3s; border-left: 3px solid var(--green);">
            <div>
                <div class="label" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700;">Perfect Scores</div>
                <div class="value" style="font-size: 2rem; font-weight: 800; font-family: 'Crimson Pro', serif; color: var(--green); margin-top: 5px;">{{ number_format($stats['five_star']) }}</div>
            </div>
            <div class="trend" style="color: var(--green); font-size: 0.85rem; margin-top: 5px;">{{ round(($stats['five_star'] / max($stats['total'], 1)) * 100) }}% Success</div>
            <div class="icon-bg">
                <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="stat-card-premium animate-in" style="animation-delay: 0.4s; border-left: 3px solid var(--red);">
            <div>
                <div class="label" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700;">Critical</div>
                <div class="value" style="font-size: 2rem; font-weight: 800; font-family: 'Crimson Pro', serif; color: var(--red); margin-top: 5px;">{{ number_format($stats['one_star']) }}</div>
            </div>
            <div class="trend" style="color: var(--red); font-size: 0.85rem; margin-top: 5px;">Action Required</div>
            <div class="icon-bg">
                <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
    </div>
    
    <div class="animate-in" style="animation-delay: 0.5s;">
        <div class="chart-container">
            <h3 style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Rating Distribution
            </h3>
            <canvas id="ratingChart" style="max-height: 180px;"></canvas>
        </div>
    </div>
</div>

<div class="premium-card animate-in" style="animation-delay: 0.6s; margin-bottom: 2.5rem; background: rgba(255,255,255,0.01); border-color: rgba(255,255,255,0.08);">
    <div style="padding: 1.75rem 2rem;">
        <form method="GET" action="{{ route('manager.feedback.index') }}" style="display: grid; grid-template-columns: 2fr 1.5fr 1.5fr auto; gap: 1.5rem; align-items: end;">
            <div class="form-group-premium">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 10px; display: block;">Keywords</label>
                <div style="position: relative;">
                    <input type="text" name="search" class="form-input" value="{{ request('search') }}" placeholder="Search reviews..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; background: rgba(0,0,0,0.3); border-radius: 12px !important;">
                    <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gold); opacity: 0.5;" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
            <div>
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 10px; display: block;">Event Scope</label>
                <select name="event_id" class="form-input" style="width: 100%; padding: 0.75rem 1rem; background: rgba(0,0,0,0.3); border-radius: 12px !important;">
                    <option value="">All Events</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 10px; display: block;">Filter Rating</label>
                <select name="rating" class="form-input" style="width: 100%; padding: 0.75rem 1rem; background: rgba(0,0,0,0.3); border-radius: 12px !important;">
                    <option value="">All Ratings</option>
                    @foreach([5,4,3,2,1] as $r)
                        <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>{{ $r }} Stars</option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn-premium" style="padding: 0.75rem 1.5rem; border-radius: 12px;">
                    FILTER
                </button>
                <a href="{{ route('manager.feedback.index') }}" class="btn-premium" style="background: rgba(255,255,255,0.05); color: var(--text-primary) !important; padding: 0.75rem 1.5rem; border-radius: 12px;">RESET</a>
            </div>
        </form>
    </div>
</div>

<div class="premium-card animate-in" style="animation-delay: 0.7s;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem; width: 280px;">User Information</th>
                <th style="width: 200px;">Event</th>
                <th style="text-align: center; width: 140px;">Experience</th>
                <th style="text-align: center; width: 100px;">Foto</th>
                <th>Feedback Content</th>
                <th style="text-align: right; padding-right: 2rem; width: 130px;">Timeline</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feedbacks as $feedback)
            @php
                $name = $feedback->user->name ?? 'Anonymous';
                $initials = '';
                $words = explode(' ', $name);
                foreach($words as $w) $initials .= strtoupper(substr($w, 0, 1));
                $initials = substr($initials, 0, 2);
                
                $colors = ['#D4AF37', '#E74C4C', '#3B82F6', '#10B981', '#8B5CF6', '#F59E0B'];
                $bgColor = $colors[ord(substr($name, 0, 1)) % count($colors)];
            @endphp
            <tr class="table-row-premium">
                <td style="padding-left: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1.25rem;">
                        <div class="user-avatar" style="background: {{ $bgColor }}; border: 2px solid rgba(255,255,255,0.1);">
                            {{ $initials }}
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem; margin-bottom: 2px;">{{ $name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); opacity: 0.8;">{{ $feedback->user->email ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); line-height: 1.4;">{{ Str::limit($feedback->event->title ?? '-', 40) }}</div>
                </td>
                <td style="text-align: center;">
                    <div class="rating-stars" style="justify-content: center; margin-bottom: 4px;">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $feedback->rating ? 'var(--gold)' : 'rgba(255,255,255,0.05)' }}">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        @endfor
                    </div>
                    <div style="font-size: 0.7rem; color: var(--gold); font-weight: 800; letter-spacing: 0.05em;">{{ $feedback->rating }}.0 / 5.0</div>
                </td>
                <td style="text-align: center;">
                    @if($feedback->image)
                        <a href="{{ asset('storage/' . $feedback->image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $feedback->image) }}" alt="Feedback Photo" style="width: 45px; height: 45px; border-radius: 8px; object-fit: cover; border: 1px solid var(--card-border);">
                        </a>
                    @else
                        <span style="font-size: 0.75rem; color: var(--text-secondary);">-</span>
                    @endif
                </td>
                <td>
                    <div style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.7; max-width: 450px; font-style: italic; border-left: 2px solid rgba(212, 175, 55, 0.2); padding-left: 1rem;">
                        "{{ Str::limit($feedback->comment, 150) }}"
                    </div>
                </td>
                <td style="text-align: right; padding-right: 2rem; font-size: 0.8rem; color: var(--text-secondary);">
                    <div style="font-weight: 600; color: var(--text-primary);">{{ $feedback->created_at->format('d M Y') }}</div>
                    <div style="font-size: 0.75rem; opacity: 0.6;">{{ $feedback->created_at->diffForHumans() }}</div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div style="padding: 6rem 2rem; text-align: center;">
                        <div style="background: rgba(255,255,255,0.02); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: var(--text-secondary); opacity: 0.3;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 style="color: var(--text-primary); margin-bottom: 0.5rem;">No feedback found</h4>
                        <p style="color: var(--text-secondary); font-size: 0.95rem;">Try adjusting your filters or search terms.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($feedbacks->hasPages())
    <div style="padding: 2rem; border-top: 1px solid var(--card-border);">
        {{ $feedbacks->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ratingChart');
    if(!ctx) return;
    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'],
            datasets: [{
                label: 'Count',
                data: @json($stats['distribution']),
                backgroundColor: [
                    'rgba(212, 175, 55, 0.8)',
                    'rgba(212, 175, 55, 0.6)',
                    'rgba(212, 175, 55, 0.4)',
                    'rgba(212, 175, 55, 0.2)',
                    'rgba(231, 76, 76, 0.3)'
                ],
                borderColor: [
                    '#D4AF37',
                    '#D4AF37',
                    '#D4AF37',
                    '#D4AF37',
                    '#E74C4C'
                ],
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1A1A25',
                    titleColor: '#D4AF37',
                    bodyColor: '#E8E8ED',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    display: false,
                    grid: { display: false }
                },
                y: {
                    ticks: {
                        color: '#8A8A9A',
                        font: { size: 10, weight: '600' }
                    },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush
