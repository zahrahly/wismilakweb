@extends('layouts.dashboard')

@section('title', 'Laporan Event & Pameran')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeInUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        opacity: 0;
    }
</style>
@endpush

@section('sidebar')
  @include('manager.partials.sidebar')
@endsection

@section('content')
<div class="animate-in" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h2 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Event Reports</h2>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Comprehensive oversight of all scheduled and historical brand events.</p>
    </div>
    <div style="display:flex; gap:1rem;">
      <a href="{{ route('manager.events.export.pdf') }}" class="btn-premium" style="background: rgba(239,68,68,0.1); color: #EF4444 !important; border: 1px solid rgba(239,68,68,0.2); padding: 0.6rem 1.2rem; font-size: 0.75rem;">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        EXPORT PDF
      </a>
      <a href="{{ route('manager.events.export.csv') }}" class="btn-premium" style="background: rgba(59,130,246,0.1); color: #60A5FA !important; border: 1px solid rgba(59,130,246,0.2); padding: 0.6rem 1.2rem; font-size: 0.75rem;">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        EXPORT CSV
      </a>
    </div>
</div>

<!-- FILTER BAR -->
<div class="premium-card animate-in" style="animation-delay: 0.05s; margin-bottom: 1.5rem; background: rgba(255,255,255,0.02); padding: 1.25rem 2rem;">
    <form method="GET" action="{{ route('manager.events.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; width: 100%;">
        <!-- Search Query -->
        <div style="flex: 1; min-width: 240px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau lokasi event..." 
                style="width: 100%; padding: 0.65rem 1rem 0.65rem 2.5rem; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
            >
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); pointer-events: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <!-- Status -->
        <div style="min-width: 160px;">
            <select name="status" style="width: 100%; padding: 0.65rem 1rem; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; cursor: pointer; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
            >
                <option value="all">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Review (Pending)</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Live (Published)</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <button type="submit" class="btn-premium" style="padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                FILTER
            </button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('manager.events.index') }}" style="padding: 0.65rem 1.25rem; border-radius: 8px; border: 1px solid var(--card-border); background: rgba(255,255,255,0.03); color: var(--text-secondary); text-decoration: none; font-size: 0.8rem; font-weight: 600; text-align: center; transition: all 0.2s;"
                   onmouseover="this.style.borderColor='var(--gold)'; this.style.color='var(--text-primary)'"
                   onmouseout="this.style.borderColor='var(--card-border)'; this.style.color='var(--text-secondary)'"
                >
                    RESET
                </a>
            @endif
        </div>
    </form>
</div>

<div class="premium-card animate-in" style="animation-delay: 0.1s;">
  <div class="card-header" style="padding: 1.5rem 2rem; background: rgba(255,255,255,0.02);">
    <span class="card-title" style="font-weight: 700; letter-spacing: 0.05em; color: var(--gold);">MASTER EVENT DATABASE ({{ $events->total() }})</span>
  </div>

  <table class="data-table">
    <thead>
        <tr>
            <th style="padding-left: 2rem;">Event Detail</th>
            <th>Creator Identity</th>
            <th>Current Status</th>
            <th>Scheduled Date</th>
            <th>Attendance</th>
            <th style="text-align: right; padding-right: 2rem;">Valuation</th>
        </tr>
    </thead>
    <tbody>
    @forelse($events as $event)
    <tr>
      <td style="padding-left: 2rem;">
        <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem; margin-bottom: 0.25rem;">{{ $event->title }}</div>
        <div style="font-size: 0.75rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            {{ $event->location }}
        </div>
      </td>
      <td>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 28px; height: 28px; border-radius: 6px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: var(--gold);">
                {{ strtoupper(substr($event->creator?->name ?? 'N', 0, 1)) }}
            </div>
            <div>
                <div style="font-size: 0.85rem; font-weight: 600;">{{ $event->creator?->name ?? 'System' }}</div>
                <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">{{ $event->created_by ? 'Partner Merchant' : 'Internal Admin' }}</div>
            </div>
        </div>
      </td>
      <td>
        @php
          $statusStyles = match($event->status) {
            'published' => ['bg' => 'rgba(16,185,129,0.1)', 'color' => 'var(--green)', 'label' => 'LIVE'],
            'pending'   => ['bg' => 'rgba(245,158,11,0.1)', 'color' => '#F59E0B', 'label' => 'REVIEW'],
            'rejected'  => ['bg' => 'rgba(231,76,76,0.1)', 'color' => 'var(--red)', 'label' => 'REJECTED'],
            default     => ['bg' => 'rgba(59,130,246,0.1)', 'color' => 'var(--blue)', 'label' => 'DRAFT'],
          };
        @endphp
        <span class="badge-premium" style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }}; border: 1px solid {{ $statusStyles['color'] }}22;">
          {{ $statusStyles['label'] }}
        </span>
      </td>
      <td style="font-size: 0.85rem; color: var(--text-secondary); font-weight: 500;">
        {{ $event->date?->format('d M, Y') ?? 'Unscheduled' }}
      </td>
      <td>
        @php $percent = $event->quota > 0 ? (($event->quota - $event->computed_remaining_quota) / $event->quota) * 100 : 0; @endphp
        <div style="width: 100px;">
            <div style="display: flex; justify-content: space-between; font-size: 0.7rem; margin-bottom: 0.4rem;">
                <span style="font-weight: 700; color: var(--text-primary);">{{ $event->quota - $event->computed_remaining_quota }} <span style="color: var(--text-secondary); font-weight: 400;">/ {{ $event->quota }}</span></span>
                <span style="color: var(--text-secondary);">{{ round($percent) }}%</span>
            </div>
            <div style="height: 4px; background: rgba(255,255,255,0.05); border-radius: 2px; overflow: hidden;">
                <div style="height: 100%; width: {{ $percent }}%; background: {{ $percent >= 100 ? 'var(--red)' : 'var(--gold)' }}; transition: width 1s ease;"></div>
            </div>
        </div>
      </td>
      <td style="text-align: right; padding-right: 2rem;">
        @if($event->price_type === 'free')
          <span style="color: var(--green); font-weight: 700; font-size: 0.8rem; letter-spacing: 0.05em;">COMPLIMENTARY</span>
        @else
          <span style="color: var(--gold); font-weight: 700; font-size: 0.95rem;">Rp {{ number_format($event->price,0,',','.') }}</span>
        @endif
      </td>
    </tr>
    @empty
    <tr><td colspan="6" style="text-align:center;color:var(--text-secondary);padding:5rem;">
        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.2; margin-bottom: 1rem;"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <div style="font-size: 0.9rem;">No brand events found in current registry.</div>
    </td></tr>
    @endforelse
    </tbody>
  </table>

  @if($events->hasPages())
    <div style="padding: 2rem; border-top: 1px solid var(--card-border); display: flex; justify-content: center;">
        {{ $events->links() }}
    </div>
  @endif
</div>
@endsection
