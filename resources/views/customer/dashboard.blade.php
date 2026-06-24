@extends('layouts.customer')

@section('title', 'Dashboard')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position:  200% center; }
    }

    .dash-wrap {
        max-width: 960px;
        margin: 0 auto;
        padding: 6rem 1.5rem 4rem;
    }

    /* ── HERO BANNER ── */
    .dash-hero {
        position: relative;
        background: linear-gradient(135deg, rgba(30,20,5,0.95) 0%, rgba(15,10,3,0.98) 100%);
        border: 1px solid rgba(212,175,55,0.2);
        border-radius: 28px;
        padding: 2.5rem 3rem;
        margin-bottom: 2rem;
        overflow: hidden;
        animation: fadeInUp 0.7s cubic-bezier(0.23,1,0.32,1) both;
    }
    .dash-hero::before {
        content: '';
        position: absolute; top:-80px; right:-80px;
        width: 320px; height: 320px;
        background: radial-gradient(circle, rgba(212,175,55,0.12) 0%, transparent 70%);
        pointer-events: none;
    }
    .dash-hero::after {
        content: '';
        position: absolute; bottom:-40px; left:-40px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(212,175,55,0.06) 0%, transparent 70%);
        pointer-events: none;
    }
    .dash-hero-inner { position: relative; z-index: 2; }
    .dash-hero h1 {
        font-family: 'Crimson Pro', serif;
        font-size: 2.4rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }
    .dash-hero-gold {
        background: linear-gradient(90deg, #D4AF37, #F4D03F, #D4AF37);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }

    /* ── STAT CARDS ── */
    .dash-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.7s 0.1s cubic-bezier(0.23,1,0.32,1) both;
    }
    .dash-stat-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        overflow: hidden;
    }
    .dash-stat-card::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.015) 100%);
        pointer-events: none;
    }
    .dash-stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(212,175,55,0.25);
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }
    .dash-stat-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .dash-stat-label {
        font-size: 0.62rem; font-weight: 700;
        letter-spacing: 0.18em; text-transform: uppercase;
        margin-bottom: 0.6rem; opacity: 0.5;
    }
    .dash-stat-value {
        font-size: 2.2rem;
        font-family: 'Crimson Pro', serif;
        font-weight: 700; line-height: 1;
        margin-bottom: 0.35rem;
    }
    .dash-stat-sub {
        font-size: 0.67rem;
        color: rgba(245,235,224,0.35);
        margin-top: 0.25rem;
    }

    /* ── QUICK LINKS ── */
    .dash-quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 0.75rem;
        margin-bottom: 2rem;
        animation: fadeInUp 0.7s 0.15s cubic-bezier(0.23,1,0.32,1) both;
    }
    .dash-quick-link {
        display: flex; align-items: center; gap: 0.7rem;
        padding: 0.9rem 1.1rem;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        color: rgba(245,235,224,0.75);
        text-decoration: none;
        font-size: 0.82rem; font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    }
    .dash-quick-link:hover {
        background: rgba(212,175,55,0.07);
        border-color: rgba(212,175,55,0.3);
        color: #D4AF37;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .dash-quick-link svg { flex-shrink: 0; }

    /* ── ACCORDION ── */
    .dash-section-title {
        font-family: 'Crimson Pro', serif;
        font-size: 1.1rem; font-weight: 600;
        color: rgba(245,235,224,0.4);
        text-transform: uppercase; letter-spacing: 0.15em;
        font-size: 0.7rem;
        margin-bottom: 0.75rem;
        padding-left: 0.25rem;
        animation: fadeInUp 0.7s 0.2s cubic-bezier(0.23,1,0.32,1) both;
    }
    .dash-accordion {
        margin-bottom: 0.75rem;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 18px;
        overflow: hidden;
        transition: border-color 0.3s;
        animation: fadeInUp 0.7s 0.25s cubic-bezier(0.23,1,0.32,1) both;
    }
    .dash-accordion:hover { border-color: rgba(212,175,55,0.15); }
    .dash-accordion-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1.1rem 1.5rem;
        background: rgba(255,255,255,0.025);
        cursor: pointer; user-select: none;
        transition: background 0.2s;
    }
    .dash-accordion-header:hover { background: rgba(255,255,255,0.04); }
    .dash-accordion-title {
        font-family: 'Crimson Pro', serif;
        font-size: 1.2rem; font-weight: 600;
        display: flex; align-items: center; gap: 0.65rem;
    }
    .dash-accordion-badge {
        font-size: 0.6rem; font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.05em;
    }
    .dash-accordion-arrow {
        width: 20px; height: 20px;
        transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        color: rgba(245,235,224,0.3);
        flex-shrink: 0;
    }
    .dash-accordion.open .dash-accordion-arrow { transform: rotate(180deg); }
    .dash-accordion-body { max-height: 0; overflow: hidden; transition: max-height 0.45s ease; }
    .dash-accordion.open .dash-accordion-body { max-height: 3000px; }
    .dash-accordion-content { padding: 0 1.5rem 1.5rem; }

    /* ── EVENT CARD ── */
    .dash-event-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.055);
        border-radius: 14px;
        padding: 1.25rem 1.35rem;
        margin-bottom: 0.65rem;
        transition: all 0.25s;
    }
    .dash-event-card:hover {
        background: rgba(255,255,255,0.035);
        border-color: rgba(212,175,55,0.15);
    }

    /* ── VOUCHER CARD ── */
    .dash-voucher-card {
        background: linear-gradient(135deg, rgba(139,92,246,0.06), rgba(99,60,200,0.02));
        border: 1px solid rgba(139,92,246,0.18);
        border-radius: 14px;
        padding: 1.2rem;
        transition: all 0.25s;
    }
    .dash-voucher-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(139,92,246,0.1);
    }

    /* ── REWARD CARD ── */
    .dash-reward-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.055);
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        transition: all 0.25s;
        margin-bottom: 0.5rem;
    }
    .dash-reward-card:hover { border-color: rgba(212,175,55,0.2); }

    .btn-redeem {
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: #000; padding: 0.5rem 1.2rem;
        border-radius: 8px; font-size: 0.73rem; font-weight: 700;
        border: none; cursor: pointer; white-space: nowrap;
        letter-spacing: 0.05em; transition: all 0.2s;
        display: inline-block; text-decoration: none;
    }
    .btn-redeem:hover { transform: scale(1.04); box-shadow: 0 4px 15px rgba(212,175,55,0.3); }
    .btn-disabled {
        background: rgba(255,255,255,0.03);
        color: rgba(245,235,224,0.25);
        padding: 0.5rem 1.2rem; border-radius: 8px;
        font-size: 0.73rem; font-weight: 600;
        border: 1px solid rgba(255,255,255,0.06);
        cursor: not-allowed; white-space: nowrap;
    }

    @media (max-width: 768px) {
        .dash-wrap { padding: 5rem 1rem 3rem; }
        .dash-hero { padding: 1.75rem 1.5rem; }
        .dash-hero h1 { font-size: 1.8rem; }
        .dash-stats { grid-template-columns: 1fr; }
        .dash-quick-links { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dash-wrap">

    {{-- ── HERO BANNER ── --}}
    <div class="dash-hero">
        <div class="dash-hero-inner">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1rem;">
                <div>
                    <h1>
                        Selamat Datang,<br>
                        <em class="dash-hero-gold" style="font-style:normal;">{{ auth()->user()->name }}</em>
                    </h1>
                    <p style="color:rgba(245,235,224,0.45); font-size:0.9rem; margin-top:0.75rem; max-width:420px;">
                        Kelola keanggotaan premium, pantau poin reward, dan akses keuntungan eksklusif Anda.
                    </p>
                </div>
                <div style="text-align:right; flex-shrink:0;">
                    <div style="font-size:0.6rem; color:rgba(212,175,55,0.5); text-transform:uppercase; letter-spacing:0.15em; font-weight:700; margin-bottom:0.3rem;">Saldo Poin</div>
                
                    <div style="font-size:0.65rem; color:rgba(212,175,55,0.4); font-weight:600; letter-spacing:0.1em;">PTS REWARD</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="dash-stats">
        <div class="dash-stat-card">
            <div class="dash-stat-icon" style="background:rgba(212,175,55,0.08); border-color:rgba(212,175,55,0.15);">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#D4AF37"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26" stroke-width="2"/></svg>
            </div>
            <div class="dash-stat-label" style="color:rgba(212,175,55,0.6);">Total Poin</div>
            <div class="dash-stat-value" style="color:#D4AF37;">{{ number_format($stats['total_points']) }}</div>
            <div class="dash-stat-sub">Siap untuk ditukarkan</div>
        </div>
        <div class="dash-stat-card">
            <div class="dash-stat-icon" style="background:rgba(16,185,129,0.08); border-color:rgba(16,185,129,0.15);">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#10B981"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke-width="2"/><line x1="8" y1="2" x2="8" y2="6" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke-width="2"/></svg>
            </div>
            <div class="dash-stat-label" style="color:rgba(16,185,129,0.6);">Event Diikuti</div>
            <div class="dash-stat-value" style="color:#10B981;">{{ $stats['total_events'] }}</div>
            <div class="dash-stat-sub">Pengalaman luar biasa</div>
        </div>
        <div class="dash-stat-card">
            <div class="dash-stat-icon" style="background:rgba(139,92,246,0.08); border-color:rgba(139,92,246,0.15);">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#8B5CF6"><path d="M2 9a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v0a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3z" stroke-width="2"/></svg>
            </div>
            <div class="dash-stat-label" style="color:rgba(139,92,246,0.6);">Voucher Aktif</div>
            <div class="dash-stat-value" style="color:#8B5CF6;">{{ $stats['active_vouchers'] }}</div>
            <div class="dash-stat-sub">Keuntungan menanti</div>
        </div>
    </div>

    {{-- ── QUICK LINKS ── --}}
    <div class="dash-quick-links">
        <a href="{{ route('events.index') }}" class="dash-quick-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Jelajahi Event
        </a>
        <a href="{{ route('customer.transactions.index') }}" class="dash-quick-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Riwayat Transaksi
        </a>
        <a href="{{ route('customer.points.history') }}" class="dash-quick-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26"/></svg>
            Riwayat Poin
        </a>
        <a href="{{ route('profile.manage') }}" class="dash-quick-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Kelola Profil
        </a>
    </div>

    {{-- ── SECTION LABEL ── --}}
    <div class="dash-section-title">Aktivitas & Manfaat</div>

    {{-- ── RIWAYAT EVENT ── --}}
    <div class="dash-accordion open" data-accordion style="animation-delay:0.2s;">
        <div class="dash-accordion-header" onclick="toggleAccordion(this)">
            <div class="dash-accordion-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#10B981;"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke-width="2"/><line x1="8" y1="2" x2="8" y2="6" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke-width="2"/></svg>
                Riwayat Event
                <span class="dash-accordion-badge" style="background:rgba(16,185,129,0.12);color:#10B981;border:1px solid rgba(16,185,129,0.2);">{{ $recentEvents->count() }} terbaru</span>
            </div>
            <svg class="dash-accordion-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="dash-accordion-body">
            <div class="dash-accordion-content">
                @forelse($recentEvents as $reg)
                <div class="dash-event-card">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.9rem;flex-wrap:wrap;gap:0.5rem;">
                        <div>
                            <h3 style="font-weight:700;font-size:0.975rem;margin-bottom:0.2rem;color:rgba(245,235,224,0.9);">{{ $reg->event?->title ?? 'Event' }}</h3>
                            <div style="font-size:0.72rem;color:rgba(245,235,224,0.35);display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                                <span style="display:flex;align-items:center;gap:3px;">
                                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke-width="2"/></svg>
                                    {{ $reg->event?->date?->format('d M Y') ?? '-' }}
                                </span>
                                <span>{{ Str::limit($reg->event?->location ?? '-', 30) }}</span>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:0.88rem;font-weight:700;color:#D4AF37;margin-bottom:4px;">
                                {{ $reg->total_amount > 0 ? 'Rp '.number_format($reg->total_amount,0,',','.') : 'FREE' }}
                            </div>
                            <span style="padding:0.15rem 0.5rem;border-radius:999px;font-size:0.6rem;font-weight:700;background:rgba(16,185,129,0.1);color:#10B981;border:1px solid rgba(16,185,129,0.2);">PAID</span>
                        </div>
                    </div>
                    <div style="border-top:1px solid rgba(255,255,255,0.05);padding-top:0.75rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
                        <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
                            @foreach($reg->generatedTickets as $idx => $ticket)
                            <a href="{{ route('customer.ticket.pdf', $ticket->id) }}" target="_blank"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.65rem;font-size:0.68rem;font-weight:600;border-radius:6px;background:rgba(212,175,55,0.08);color:#D4AF37;border:1px solid rgba(212,175,55,0.18);text-decoration:none;transition:all 0.2s;"
                               onmouseover="this.style.background='rgba(212,175,55,0.15)'" onmouseout="this.style.background='rgba(212,175,55,0.08)'">
                                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Tiket {{ $idx + 1 }}
                            </a>
                            @endforeach
                        </div>
                        @php
                            $checkedTickets = $reg->generatedTickets->filter(fn($t)=>$t->checkin)->count();
                            $totalTickets   = $reg->generatedTickets->count();
                            $feedbackData   = $userFeedbacks[$reg->event_id] ?? null;
                        @endphp
                        @if($checkedTickets === $totalTickets && $totalTickets > 0 && !$feedbackData)
                            <a href="{{ route('customer.event.feedback.create', $reg->event->id) }}"
                               style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.3rem 0.85rem;font-size:0.68rem;font-weight:700;border-radius:8px;background:linear-gradient(135deg,#D4AF37,#B8860B);color:#000;text-decoration:none;">
                                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                FEEDBACK (+{{ $totalTickets * 15 }} PTS)
                            </a>
                        @elseif($feedbackData)
                            <span style="font-size:0.68rem;color:#10B981;font-weight:600;display:flex;align-items:center;gap:4px;">
                                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Feedback Terkirim
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:2.5rem;color:rgba(245,235,224,0.35);">
                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin:0 auto 1rem; opacity:0.3;"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5"/><line x1="16" y1="2" x2="16" y2="6" stroke-width="1.5"/><line x1="8" y1="2" x2="8" y2="6" stroke-width="1.5"/><line x1="3" y1="10" x2="21" y2="10" stroke-width="1.5"/></svg>
                    <p style="margin-bottom:1.25rem;font-size:0.9rem;">Anda belum mengikuti event apapun.</p>
                    <a href="{{ route('events.index') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#D4AF37,#B8860B);color:#000;padding:0.6rem 1.5rem;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;">
                        Jelajahi Event
                    </a>
                </div>
                @endforelse
                @if($recentEvents->count())
                <div style="text-align:center;margin-top:0.75rem;">
                    <a href="{{ route('customer.transactions.index') }}" style="font-size:0.78rem;color:var(--gold);text-decoration:none;font-weight:700;display:inline-flex;align-items:center;gap:0.4rem;">
                        Lihat Semua Transaksi
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── KOLEKSI VOUCHER & REWARD ── --}}
    <div class="dash-accordion {{ ($myVouchers->count() || $myRewards->count()) ? 'open' : '' }}" data-accordion style="animation-delay:0.3s;">
        <div class="dash-accordion-header" onclick="toggleAccordion(this)">
            <div class="dash-accordion-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#8B5CF6"><path d="M2 9a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v0a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3z" stroke-width="2"/></svg>
                Koleksi Voucher & Reward
                @if($myVouchers->count() || $myRewards->count())
                    <span class="dash-accordion-badge" style="background:rgba(139,92,246,0.12);color:#8B5CF6;border:1px solid rgba(139,92,246,0.2);">{{ $myVouchers->count() + $myRewards->count() }} aktif</span>
                @endif
            </div>
            <svg class="dash-accordion-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="dash-accordion-body">
            <div class="dash-accordion-content">
                @if($myVouchers->count() || $myRewards->count())
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:0.75rem;">
                    @foreach($myVouchers as $voucher)
                    <div class="dash-voucher-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.75rem;">
                            <div style="width:38px;height:38px;border-radius:10px;background:rgba(139,92,246,0.1);color:#8B5CF6;display:flex;align-items:center;justify-content:center;border:1px solid rgba(139,92,246,0.15);">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v0a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3z"/></svg>
                            </div>
                            <span style="font-size:0.58rem;font-weight:800;padding:2px 7px;border-radius:5px;background:rgba(16,185,129,0.1);color:#10B981;border:1px solid rgba(16,185,129,0.2);">AKTIF</span>
                        </div>
                        <h4 style="font-weight:700;font-size:0.9rem;margin-bottom:4px;color:rgba(245,235,224,0.9);">{{ $voucher->voucher->title }}</h4>
                        <div style="font-family:monospace;font-size:0.78rem;color:#8B5CF6;letter-spacing:0.06em;margin-bottom:8px;">{{ $voucher->voucher_code }}</div>
                        <div style="font-size:0.68rem;color:rgba(245,235,224,0.35);">Berlaku hingga: <span style="color:rgba(245,235,224,0.6);">{{ $voucher->expired_at?->format('d M Y') ?? 'Selamanya' }}</span></div>
                    </div>
                    @endforeach

                    @foreach($myRewards as $redemption)
                    <div class="dash-voucher-card" style="background: linear-gradient(135deg, rgba(212,175,55,0.06), rgba(150,120,30,0.02)); border: 1px solid rgba(212,175,55,0.25);">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.75rem;">
                            <div style="width:38px;height:38px;border-radius:10px;background:rgba(212,175,55,0.1);color:#D4AF37;display:flex;align-items:center;justify-content:center;border:1px solid rgba(212,175,55,0.15);">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 12v10H4V12M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/></svg>
                            </div>
                            <span style="font-size:0.58rem;font-weight:800;padding:2px 7px;border-radius:5px;background:rgba(212,175,55,0.1);color:#D4AF37;border:1px solid rgba(212,175,55,0.2);">{{ strtoupper($redemption->status) }}</span>
                        </div>
                        <h4 style="font-weight:700;font-size:0.9rem;margin-bottom:4px;color:rgba(245,235,224,0.9);">{{ $redemption->reward->title }}</h4>
                        <div style="font-size:0.78rem;color:rgba(245,235,224,0.5);margin-bottom:8px;">Merchandise Reward</div>
                        <div style="font-size:0.68rem;color:rgba(245,235,224,0.35);">Ditukar pada: <span style="color:rgba(245,235,224,0.6);">{{ $redemption->created_at->format('d M Y') }}</span></div>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="text-align:center;padding:1.5rem;color:rgba(245,235,224,0.35);font-size:0.85rem;">
                    Anda belum memiliki voucher atau reward. Tukarkan poin Anda untuk mendapatkan voucher/reward!
                </p>
                @endif
            </div>
        </div>
    </div>

    {{-- ── TUKAR POIN REWARD ── --}}
    <div class="dash-accordion" data-accordion style="animation-delay:0.35s;">
        <div class="dash-accordion-header" onclick="toggleAccordion(this)">
            <div class="dash-accordion-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#D4AF37"><path d="M20 12v10H4V12M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z" stroke-width="2"/></svg>
                Tukar Poin Reward
                <span class="dash-accordion-badge" style="background:rgba(212,175,55,0.12);color:#D4AF37;border:1px solid rgba(212,175,55,0.2);">{{ number_format($stats['total_points']) }} PTS</span>
            </div>
            <svg class="dash-accordion-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="dash-accordion-body">
            <div class="dash-accordion-content">
                <div style="display:flex;flex-direction:column;gap:0.5rem;">
                    @forelse($availableVouchers as $voucher)
                    <div class="dash-reward-card">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
                            <div style="flex:1;min-width:130px;">
                                <h4 style="font-weight:700;color:#D4AF37;margin-bottom:3px;font-size:0.9rem;">{{ $voucher->title }}</h4>
                                <div style="font-size:0.72rem;color:rgba(245,235,224,0.35);">
                                    Potongan {{ $voucher->discount_type === 'percentage' ? $voucher->discount_value.'%' : 'Rp '.number_format($voucher->discount_value,0,',','.') }}
                                </div>
                            </div>
                            <div style="text-align:center;min-width:55px;">
                                <div style="font-size:1.05rem;font-weight:700;color:rgba(245,235,224,0.9);">{{ number_format($voucher->points_required) }}</div>
                                <div style="font-size:0.52rem;color:rgba(245,235,224,0.3);text-transform:uppercase;letter-spacing:0.1em;">PTS</div>
                            </div>
                            @if(in_array($voucher->id, $userRedeemedVoucherIds))
                            <button disabled class="btn-disabled">SUDAH DITUKAR</button>
                            @elseif(($stats['total_points']) >= $voucher->points_required && $voucher->isValid())
                            <form method="POST" action="{{ route('customer.voucher.redeem', $voucher) }}">
                                @csrf
                                <button type="submit" class="btn-redeem">TUKAR</button>
                            </form>
                            @else
                            <button disabled class="btn-disabled">KURANG</button>
                            @endif
                        </div>
                    </div>
                    @empty
                    @if($availableRewards->isEmpty())
                    <p style="text-align:center;padding:1.5rem;color:rgba(245,235,224,0.35);font-size:0.85rem;">Belum ada voucher atau reward tersedia saat ini.</p>
                    @endif
                    @endforelse

                    @foreach($availableRewards as $reward)
                    <div class="dash-reward-card">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
                            <div style="flex:1;min-width:130px;display:flex;align-items:center;gap:0.85rem;">
                                @if($reward->image)
                                <img src="{{ asset('storage/'.$reward->image) }}" style="width:44px;height:44px;border-radius:10px;object-fit:cover;flex-shrink:0;">
                                @else
                                <div style="width:44px;height:44px;border-radius:10px;background:rgba(212,175,55,.05);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(212,175,55,.1);">
                                    <svg width="20" height="20" fill="none" stroke="rgba(212,175,55,.4)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 12v10H4V12M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                                </div>
                                @endif
                                <div>
                                    <h4 style="font-weight:700;color:#D4AF37;margin-bottom:3px;font-size:0.9rem;">{{ $reward->title }}</h4>
                                    <div style="font-size:0.72rem;color:rgba(245,235,224,0.35);">Merchandise / Reward</div>
                                </div>
                            </div>
                            <div style="text-align:center;min-width:55px;">
                                <div style="font-size:1.05rem;font-weight:700;color:rgba(245,235,224,0.9);">{{ number_format($reward->points_required) }}</div>
                                <div style="font-size:0.52rem;color:rgba(245,235,224,0.3);text-transform:uppercase;letter-spacing:0.1em;">PTS</div>
                            </div>
                            @if(in_array($reward->id, $userRedeemedRewardIds))
                            <button disabled class="btn-disabled">SUDAH DITUKAR</button>
                            @elseif(($stats['total_points']) >= $reward->points_required && $reward->stock > 0)
                            <form method="POST" action="{{ route('customer.reward.redeem', $reward) }}">
                                @csrf
                                <button type="submit" class="btn-redeem" onclick="return confirm('Tukar {{ number_format($reward->points_required) }} poin Anda dengan {{ $reward->title }}?')">TUKAR</button>
                            </form>
                            @else
                            <button disabled class="btn-disabled">{{ $reward->stock <= 0 ? 'HABIS' : 'KURANG' }}</button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($voucherHistories->count())
                <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,0.05);">
                    <h3 style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(245,235,224,0.25);margin-bottom:0.65rem;">Riwayat Penukaran</h3>
                    <div style="display:flex;flex-direction:column;gap:0.35rem;">
                        @foreach($voucherHistories->take(5) as $history)
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:0.6rem 0.85rem;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);border-radius:10px;">
                            <div style="font-size:0.8rem;color:rgba(245,235,224,0.7);">{{ Str::limit($history->voucher->title, 28) }}</div>
                            <div style="font-size:0.62rem;font-weight:700;color:{{ $history->status === 'unused' ? '#10B981' : 'rgba(245,235,224,0.25)' }}">{{ strtoupper($history->status) }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div style="height:2rem;"></div>

</div>
@endsection

@push('scripts')
<script>
function toggleAccordion(header) {
    header.closest('.dash-accordion').classList.toggle('open');
}
</script>
@endpush