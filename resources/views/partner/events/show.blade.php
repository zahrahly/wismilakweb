@extends('layouts.dashboard')

@section('title', 'Detail Event')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('partner.events.index') }}" style="display: inline-flex; align-items: center; gap: 0.6rem; color: var(--text-secondary); text-decoration: none; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.15em; transition: all 0.3s ease;" onmouseover="this.style.color='var(--gold)'; this.style.transform='translateX(-4px)';" onmouseout="this.style.color='var(--text-secondary)'; this.style.transform='translateX(0)';">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        KEMBALI KE DAFTAR EVENT
    </a>
</div>

{{-- TOP ALERT FOR REJECTION --}}
@if($event->status === 'rejected' && $event->rejection_reason)
<div style="margin-bottom: 2rem; padding: 1.5rem 2rem; background: linear-gradient(135deg, rgba(231,76,76,0.15) 0%, rgba(231,76,76,0.03) 100%); border: 1px solid rgba(231,76,76,0.25); border-radius: 16px; display: flex; gap: 1.25rem; align-items: flex-start;">
    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(231,76,76,0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(231,76,76,0.2);">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="var(--red)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <div>
        <h4 style="font-weight: 700; color: var(--text-primary); margin: 0 0 0.25rem 0; font-size: 0.95rem; letter-spacing: 0.05em;">EVENT DITOLAK OLEH ADMIN</h4>
        <p style="color: rgba(245,235,224,0.6); font-size: 0.85rem; line-height: 1.5; margin: 0;">{{ $event->rejection_reason }}</p>
        <div style="margin-top: 0.85rem;">
            <a href="{{ route('partner.events.edit', $event) }}" class="btn-premium" style="padding: 0.5rem 1.25rem; font-size: 0.75rem; background: var(--red); color: white;">
                EDIT & RE-SUBMIT EVENT
            </a>
        </div>
    </div>
</div>
@endif

{{-- 2-COLUMN PREMIUM HERO SPLIT --}}
<div style="display: grid; grid-template-columns: {{ $event->image ? '1.4fr 1fr' : '1fr' }}; gap: 2.5rem; margin-bottom: 2.5rem; align-items: stretch;">
    
    {{-- Left Side: Title, Status, and Overview --}}
    <div style="display: flex; flex-direction: column; justify-content: space-between; gap: 2rem;">
        <div style="background: linear-gradient(135deg, rgba(26,26,37,0.8) 0%, rgba(15,15,20,0.9) 100%); border: 1px solid var(--card-border); border-radius: 20px; padding: 2.5rem; display: flex; flex-direction: column; height: 100%; justify-content: center; box-shadow: 0 15px 35px rgba(0,0,0,0.3); backdrop-filter: blur(10px); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(212,175,55,0.08) 0%, transparent 70%); pointer-events: none;"></div>
            
            <div style="margin-bottom: 1.5rem;">
                @php
                    $statusColor = match($event->status) {
                        'published' => 'background: rgba(16,185,129,0.12); color: #10B981; border: 1px solid rgba(16,185,129,0.25); text-shadow: 0 0 10px rgba(16,185,129,0.2);',
                        'approved' => 'background: rgba(59,130,246,0.12); color: #60A5FA; border: 1px solid rgba(59,130,246,0.25);',
                        'completed' => 'background: rgba(139,92,246,0.12); color: #A78BFA; border: 1px solid rgba(139,92,246,0.25);',
                        'pending' => 'background: rgba(245,158,11,0.12); color: #F59E0B; border: 1px solid rgba(245,158,11,0.25);',
                        'rejected' => 'background: rgba(231,76,76,0.12); color: #F87171; border: 1px solid rgba(231,76,76,0.25);',
                        default => 'background: rgba(255,255,255,0.06); color: var(--text-secondary); border: 1px solid var(--card-border);',
                    };
                @endphp
                <span style="display: inline-block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.2em; padding: 6px 16px; border-radius: 50px; text-transform: uppercase; margin-bottom: 1.25rem; {{ $statusColor }}">{{ $event->status }}</span>
                
                <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.6rem; font-weight: 700; color: var(--text-primary); line-height: 1.25; margin: 0 0 1rem 0; letter-spacing: -0.02em;">
                    {{ $event->title }}
                </h1>
                
                <p style="color: rgba(245,235,224,0.55); font-size: 1rem; line-height: 1.7; margin: 0 0 2rem 0; font-family: 'Inter', sans-serif; font-weight: 300;">
                    {{ Str::limit($event->description, 280) }}
                </p>
            </div>

            {{-- Short Highlights Grid --}}
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; border-top: 1px solid rgba(212,175,55,0.1); padding-top: 1.5rem;">
                <div>
                    <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 700; margin-bottom: 0.35rem;">TANGGAL</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 0.4rem;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--gold)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $event->date ? $event->date->format('d M Y') : '-' }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 700; margin-bottom: 0.35rem;">WAKTU</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 0.4rem;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--gold)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $event->start_time ?? '--:--' }} - {{ $event->end_time ?? '--:--' }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 700; margin-bottom: 0.35rem;">LOKASI</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $event->location }}">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--gold)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ Str::limit($event->location, 18) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Right Side: The Premium Framed Poster --}}
    @if($event->image)
    <div style="display: flex; align-items: center; justify-content: center; background: rgba(26,26,37,0.4); border: 1px solid var(--card-border); border-radius: 20px; padding: 1.5rem; position: relative; box-shadow: 0 15px 35px rgba(0,0,0,0.3); backdrop-filter: blur(10px);">
        <div style="position: absolute; inset: 1.5rem; border: 1px solid rgba(212,175,55,0.18); border-radius: 12px; pointer-events: none; transform: scale(1.02); z-index: 1;"></div>
        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; max-height: 320px; object-fit: cover; border-radius: 10px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.05); position: relative; z-index: 2; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
    </div>
    @endif
    
</div>

{{-- STAT CARDS (MODERN METRICS ROW) --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 2.5rem;">
    @foreach([
        [
            'label' => 'Peserta Terdaftar', 
            'value' => $stats['total_registrations'], 
            'color' => '#10B981', 
            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
            'desc' => 'Total tiket terjual'
        ],
        [
            'label' => 'Total Pendapatan', 
            'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'), 
            'color' => '#D4AF37', 
            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'desc' => 'Akumulasi transaksi lunas'
        ],
        [
            'label' => 'Persentase Check-in', 
            'value' => $stats['total_tickets'] > 0 ? round(($stats['total_checkins'] / $stats['total_tickets']) * 100, 1) . '%' : '0%', 
            'color' => '#3B82F6', 
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'desc' => $stats['total_checkins'] . ' dari ' . $stats['total_tickets'] . ' tiket'
        ],
        [
            'label' => 'Rating & Kepuasan', 
            'value' => $stats['avg_rating'] > 0 ? number_format($stats['avg_rating'], 1) . ' / 5.0' : 'No Reviews', 
            'color' => '#F59E0B', 
            'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
            'desc' => $stats['total_feedbacks'] . ' ulasan dari peserta'
        ],
    ] as $s)
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.5rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 20px rgba(0,0,0,0.15); position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='rgba(212,175,55,0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--card-border)';">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
            <span style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700;">{{ $s['label'] }}</span>
            <div style="width: 36px; height: 36px; border-radius: 10px; background: {{ $s['color'] }}18; display: flex; align-items: center; justify-content: center; border: 1px solid {{ $s['color'] }}30;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="{{ $s['color'] }}" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
            </div>
        </div>
        <div style="font-size: 1.6rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem;">{{ $s['value'] }}</div>
        <div style="font-size: 0.72rem; color: rgba(245,235,224,0.4);">{{ $s['desc'] }}</div>
    </div>
    @endforeach
</div>

{{-- DETAILS AND ACTION SPLIT --}}
<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem; margin-bottom: 2.5rem; align-items: start;">
    
    {{-- Left Side: Complete Event Information --}}
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 18px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.3rem; color: var(--gold); margin-bottom: 1.75rem; border-bottom: 1px solid rgba(212,175,55,0.1); padding-bottom: 0.75rem; display: flex; align-items: center; gap: 0.6rem;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Spesifikasi Detail Event
        </h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <div style="color: var(--text-secondary); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 6px; font-weight: 700;">Biaya Pendaftaran</div>
                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">
                    @if($event->price_type === 'free')
                        <span style="color: #10B981; background: rgba(16,185,129,0.1); padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; border: 1px solid rgba(16,185,129,0.2);">Gratis Entry</span>
                    @else
                        <span style="color: var(--gold);">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 6px; font-weight: 700;">Status Kuota Tiket</div>
                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem; display: flex; align-items: center; gap: 0.4rem;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    {{ $event->computed_remaining_quota }} dari {{ $event->quota }} tiket tersedia
                </div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 6px; font-weight: 700;">Nama PIC Event</div>
                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">
                    {{ $event->contact_person_name ?? 'Tidak ada' }}
                </div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 6px; font-weight: 700;">WhatsApp PIC</div>
                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem; display: flex; align-items: center; gap: 0.4rem;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#10B981" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $event->contact_person_phone ?? '-' }}
                </div>
            </div>
        </div>

        @if($event->description)
        <div style="margin-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1.5rem;">
            <div style="color: var(--text-secondary); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 8px; font-weight: 700;">Deskripsi Lengkap</div>
            <p style="color: rgba(245,235,224,0.7); line-height: 1.7; font-size: 0.88rem; margin: 0; white-space: pre-line;">{{ $event->description }}</p>
        </div>
        @endif

        {{-- Privileges / Packages --}}
        @if(count($event->packages ?? []) > 0)
        <div style="margin-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1.5rem;">
            <div style="color: var(--text-secondary); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 10px; font-weight: 700;">Privilege & Fasilitas Peserta</div>
            <div style="display: grid; grid-template-columns: 1fr; gap: 0.75rem;">
                @foreach($event->packages as $pkg)
                <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(212,175,55,0.03); border: 1px solid rgba(212,175,55,0.08); padding: 0.75rem 1.25rem; border-radius: 8px;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--gold);"></div>
                    <span style="font-size: 0.85rem; color: var(--text-primary); font-weight: 500;">{{ $pkg->title }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        {{-- Assigned Outlets --}}
        @if(count($event->outlets ?? []) > 0)
        <div style="margin-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1.5rem;">
            <div style="color: var(--text-secondary); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 10px; font-weight: 700;">Lokasi Outlet Wismilak</div>
            @foreach($event->outlets as $outlet)
            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 1rem 1.25rem; border-radius: 12px; display: flex; align-items: center; justify-content: justify; gap: 1rem;">
                <div style="width: 36px; height: 36px; background: rgba(212,175,55,0.1); border: 1px solid rgba(212,175,55,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--gold)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h5 style="font-weight: 700; color: var(--text-primary); margin: 0 0 0.25rem 0; font-size: 0.9rem;">{{ $outlet->name }}</h5>
                    <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 0;">{{ $outlet->address }} ({{ $outlet->pivot->location_detail ?? '-' }})</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Right Side: Quick Navigation & Actions --}}
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        {{-- Navigation Cards --}}
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 18px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15); display: flex; flex-direction: column; gap: 1rem;">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.3rem; color: var(--gold); margin-bottom: 0.75rem; border-bottom: 1px solid rgba(212,175,55,0.1); padding-bottom: 0.75rem;">Menu Manajemen</h3>
            
            <a href="{{ route('partner.events.participants', $event) }}" style="display: flex; align-items: center; gap: 1rem; padding: 1.1rem 1.25rem; background: rgba(16,185,129,0.03); border: 1px solid rgba(16,185,129,0.12); border-radius: 12px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.borderColor='rgba(16,185,129,0.3)'; this.style.background='rgba(16,185,129,0.06)';" onmouseout="this.style.borderColor='rgba(16,185,129,0.12)'; this.style.background='rgba(16,185,129,0.03)';">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16,185,129,0.12); display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#10B981" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 700; font-size: 0.88rem; color: var(--text-primary);">Daftar Peserta</div>
                    <div style="font-size: 0.72rem; color: var(--text-secondary); margin-top: 1px;">{{ $stats['total_registrations'] }} terdaftar</div>
                </div>
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.25)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="{{ route('partner.events.feedbacks', $event) }}" style="display: flex; align-items: center; gap: 1rem; padding: 1.1rem 1.25rem; background: rgba(245,158,11,0.03); border: 1px solid rgba(245,158,11,0.12); border-radius: 12px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.borderColor='rgba(245,158,11,0.3)'; this.style.background='rgba(245,158,11,0.06)';" onmouseout="this.style.borderColor='rgba(245,158,11,0.12)'; this.style.background='rgba(245,158,11,0.03)';">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(245,158,11,0.12); display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#F59E0B" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 700; font-size: 0.88rem; color: var(--text-primary);">Kepuasan & Ulasan</div>
                    <div style="font-size: 0.72rem; color: var(--text-secondary); margin-top: 1px;">{{ $stats['total_feedbacks'] }} feedback masuk</div>
                </div>
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.25)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="{{ route('partner.events.checkins', $event) }}" style="display: flex; align-items: center; gap: 1rem; padding: 1.1rem 1.25rem; background: rgba(59,130,246,0.03); border: 1px solid rgba(59,130,246,0.12); border-radius: 12px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.borderColor='rgba(59,130,246,0.3)'; this.style.background='rgba(59,130,246,0.06)';" onmouseout="this.style.borderColor='rgba(59,130,246,0.12)'; this.style.background='rgba(59,130,246,0.03)';">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(59,130,246,0.12); display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#3B82F6" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 700; font-size: 0.88rem; color: var(--text-primary);">Log Check-in Tiket</div>
                    <div style="font-size: 0.72rem; color: var(--text-secondary); margin-top: 1px;">{{ $stats['total_checkins'] }} / {{ $stats['total_tickets'] }} checked in</div>
                </div>
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.25)" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        {{-- Report & Actions Card --}}
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 18px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.3rem; color: var(--gold); margin-bottom: 1.25rem; border-bottom: 1px solid rgba(212,175,55,0.1); padding-bottom: 0.75rem;">Aksi Laporan & Sunting</h3>
            
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                <a href="{{ route('partner.events.export.pdf', $event) }}" target="_blank" class="btn-premium" style="width: 100%; justify-content: center; background: rgba(231,76,76,0.06); color: #F87171 !important; border: 1px solid rgba(231,76,76,0.2); font-size: 0.78rem;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    UNDUH LAPORAN PDF
                </a>
                <a href="{{ route('partner.events.export.csv', $event) }}" class="btn-premium" style="width: 100%; justify-content: center; background: rgba(139,92,246,0.06); color: #C084FC !important; border: 1px solid rgba(139,92,246,0.2); font-size: 0.78rem;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    UNDUH DATA CSV
                </a>
                
                {{-- Edit Button (Visible if draft or rejected) --}}
                @if(in_array($event->status, ['draft', 'rejected']))
                <div style="border-top: 1px solid rgba(255,255,255,0.05); margin-top: 0.75rem; padding-top: 1rem;">
                    <a href="{{ route('partner.events.edit', $event) }}" class="btn-premium" style="width: 100%; justify-content: center; font-size: 0.8rem;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        EDIT KONTEN EVENT
                    </a>
                </div>
                
                {{-- Submit for Review Button --}}
                @if($event->status === 'draft')
                <form method="POST" action="{{ route('partner.events.submit', $event) }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-premium" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; border: none; font-size: 0.8rem;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        SUBMIT KONTEN KE ADMIN
                    </button>
                </form>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
