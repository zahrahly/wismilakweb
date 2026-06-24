@extends('layouts.admin')

@section('title', 'Manajemen Event')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Manajemen Event</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Organisir dan publikasikan event eksklusif Wismilak.</p>
    </div>
    <a href="{{ route('admin.event.create') }}" class="btn-premium">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        BUAT EVENT BARU
    </a>
</div>

<!-- FILTER BAR -->
<form action="{{ route('admin.event.index') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; background: var(--card-bg); border: 1px solid var(--card-border); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;">
    <!-- Search Query -->
    <div style="flex: 1; min-width: 240px; position: relative;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau lokasi event..." 
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
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </div>

    <!-- Price Type -->
    <div style="min-width: 150px;">
        <select name="price_type" style="width: 100%; padding: 0.65rem 1rem; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; cursor: pointer; transition: border-color 0.2s;"
            onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
        >
            <option value="all">Semua Tipe Harga</option>
            <option value="free" {{ request('price_type') === 'free' ? 'selected' : '' }}>Complementary (Gratis)</option>
            <option value="paid" {{ request('price_type') === 'paid' ? 'selected' : '' }}>Paid (Berbayar)</option>
        </select>
    </div>

    <!-- Buttons -->
    <div style="display: flex; gap: 0.5rem; align-items: center;">
        <button type="submit" class="btn-premium" style="padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
            FILTER
        </button>
        @if(request()->anyFilled(['search', 'status', 'price_type']))
            <a href="{{ route('admin.event.index') }}" style="padding: 0.65rem 1.25rem; border-radius: 8px; border: 1px solid var(--card-border); background: rgba(255,255,255,0.03); color: var(--text-secondary); text-decoration: none; font-size: 0.8rem; font-weight: 600; text-align: center; transition: all 0.2s;"
               onmouseover="this.style.borderColor='var(--gold)'; this.style.color='var(--text-primary)'"
               onmouseout="this.style.borderColor='var(--card-border)'; this.style.color='var(--text-secondary)'"
            >
                RESET
            </a>
        @endif
    </div>
</form>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Detail Event</th>
                <th style="text-align: center;">Jadwal</th>
                <th style="text-align: center;">Okupansi</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
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
                    <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 2px;">{{ Str::limit($event->location, 20) }}</div>
                </td>
                <td style="text-align: center;">
                    @php
                        $percentage = $event->quota > 0 ? round((($event->quota - $event->computed_remaining_quota) / $event->quota) * 100) : 0;
                        $progressColor = $percentage >= 90 ? 'var(--red)' : ($percentage >= 70 ? '#F59E0B' : 'var(--gold)');
                    @endphp
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-primary);">{{ $percentage }}%</div>
                        <div style="width: 80px; height: 4px; background: rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                            <div style="width: {{ $percentage }}%; height: 100%; background: {{ $progressColor }}; box-shadow: 0 0 10px {{ $progressColor }}44;"></div>
                        </div>
                        <div style="font-size: 0.65rem; color: var(--text-secondary);">{{ $event->quota - $event->computed_remaining_quota }} / {{ $event->quota }} Slots</div>
                    </div>
                </td>
                <td style="text-align: center;">
                    @php
                        $badgeStyle = match($event->status) {
                            'published' => 'background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);',
                            'draft' => 'background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);',
                            default => 'background: rgba(212,175,55,0.1); color: var(--gold); border: 1px solid var(--gold-dim);',
                        };
                    @endphp
                    <span class="badge-premium" style="{{ $badgeStyle }}">
                        {{ strtoupper($event->status) }}
                    </span>
                </td>
                <td style="padding: 1.25rem 2rem; text-align: right;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.event.edit', $event) }}" class="table-action-btn btn-gold" title="Edit">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.event.destroy', $event) }}" method="POST" class="table-action-form" onsubmit="return confirm('Hapus event ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="table-action-btn btn-red" title="Delete">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1rem; opacity: 0.2;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                    <p>Belum ada event yang dibuat.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

