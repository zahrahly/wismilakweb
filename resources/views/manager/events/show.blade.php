@extends('layouts.dashboard')

@section('title', 'Detail Event')

@section('sidebar')
    @include('manager.partials.sidebar')
@endsection

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('manager.events.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        KEMBALI KE PERSETUJUAN EVENT
    </a>
</div>

<div class="premium-card animate-in" style="margin-bottom: 2rem;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border); display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin: 0;">{{ $event->title }}</h2>
        @php
            $sc = match($event->status) {
                'published' => 'background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);',
                'approved' => 'background: rgba(59,130,246,0.1); color: var(--blue); border: 1px solid rgba(59,130,246,0.2);',
                'pending' => 'background: rgba(245,158,11,0.1); color: #F59E0B; border: 1px solid rgba(245,158,11,0.2);',
                'rejected' => 'background: rgba(231,76,76,0.1); color: var(--red); border: 1px solid rgba(231,76,76,0.2);',
                default => 'background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);',
            };
        @endphp
        <span class="badge-premium" style="{{ $sc }} font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">{{ $event->status }}</span>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
            <div>
                <p style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; font-weight: 700;">Tanggal & Waktu</p>
                <p style="font-weight: 600; color: var(--text-primary);">{{ $event->date ? $event->date->format('d M Y') : '-' }} ({{ $event->start_time ?? '-' }} - {{ $event->end_time ?? 'Selesai' }})</p>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; font-weight: 700;">Lokasi Utama</p>
                <p style="font-weight: 600; color: var(--text-primary);">{{ $event->location }}</p>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; font-weight: 700;">Kuota & Kapasitas</p>
                <p style="font-weight: 600; color: var(--text-primary);">{{ $event->quota }} Peserta</p>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; font-weight: 700;">Harga Tiket</p>
                <p style="font-weight: 600; color: var(--gold);">{{ $event->price_type === 'free' ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</p>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; font-weight: 700;">Pembuat Event</p>
                <p style="font-weight: 600; color: var(--text-primary);">{{ $event->creator?->name ?? '-' }} <span style="font-size: 0.75rem; color: var(--text-secondary);">({{ ucfirst($event->created_by_role ?? 'admin') }})</span></p>
            </div>
        </div>

        <div style="margin-top: 1.5rem; border-top: 1px solid var(--card-border); padding-top: 1.5rem;">
            <p style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; font-weight: 700;">Deskripsi Acara</p>
            <p style="line-height: 1.8; color: var(--text-secondary); font-size: 0.95rem;">{{ $event->description }}</p>
        </div>

        @if($event->status === 'pending')
        <div style="margin-top: 2.5rem; border-top: 1px solid var(--card-border); padding-top: 2rem; display: flex; gap: 1.5rem; flex-wrap: wrap;">
            <form method="POST" action="{{ route('manager.events.approve', $event) }}">
                @csrf
                <button class="btn-premium" onclick="return confirm('Setujui event ini?')" style="background: var(--gold); color: #000; border: none; font-weight: 700; padding: 0.75rem 2rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Approve Event
                </button>
            </form>
            <form method="POST" action="{{ route('manager.events.reject', $event) }}" style="flex:1; max-width: 500px;">
                @csrf
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" name="rejection_reason" class="form-input" placeholder="Alasan penolakan secara jelas..." required style="margin-bottom: 0;">
                    <button class="btn-premium" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239,68,68,0.3); font-weight: 700; white-space: nowrap; padding: 0.75rem 1.5rem;">
                        Reject Event
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection

