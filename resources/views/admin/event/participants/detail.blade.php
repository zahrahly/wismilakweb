@extends('layouts.admin')

@section('title', 'Peserta: ' . $event->title)

@section('content')
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.event.participants') }}"
            style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;"
            onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Event
        </a>
    </div>

    <!-- Event Info Header Card -->
    <div class="premium-card" style="margin-bottom: 1.5rem; padding: 1.5rem 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gold); font-weight: 700; display: block; margin-bottom: 0.25rem;">Detail Event</span>
                <h1 style="font-family: 'Crimson Pro', serif; font-size: 1.8rem; font-weight: 700; color: var(--text-primary); margin: 0; line-height: 1.2;">{{ $event->title }}</h1>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.7;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $event->date ? $event->date->format('d M Y, H:i') : '-' }} 
                    <span style="color: var(--card-border);">|</span>
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.7;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $event->location }}
                </p>
            </div>
            
            <div style="display: flex; align-items: center; gap: 2rem;">
                <a href="{{ route('admin.checkin.scan', ['event_id' => $event->id]) }}" class="btn-premium"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; text-decoration: none;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    Scan QR Check-In
                </a>
                
                <div style="text-align: right; border-left: 1px solid var(--card-border); padding-left: 2rem;">
                    <div style="font-size: 0.7rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-secondary); font-weight: 700;">
                        Total Tiket
                    </div>
                    <div style="font-size: 2.2rem; font-weight: 700; color: var(--gold); line-height: 1.1; margin-top: 0.25rem;">
                        {{ 
                            $participants->sum(function ($reg) {
                                return $reg->generatedTickets->count()
                                    ?: ($reg->eventTickets->count()
                                        ?: $reg->quantity);
                            })
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Table Card -->
    <div class="premium-card" style="overflow: hidden; margin-bottom: 2rem;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0;">Daftar Peserta Terdaftar</h3>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.02);">
                        <th style="padding: 1rem 1.25rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700; width: 50px;">#</th>
                        <th style="padding: 1rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700;">Nama</th>
                        <th style="padding: 1rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700;">Email</th>
                        <th style="padding: 1rem; text-align: center; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700; width: 120px;">Pembayaran</th>
                        <th style="padding: 1rem; text-align: center; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700; width: 120px;">Check-in</th>
                        <th style="padding: 1rem; text-align: center; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700; width: 100px;">Tiket</th>
                        <th style="padding: 1rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); font-weight: 700; width: 280px;">Aksi / Tiket</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $idx => $reg)
                        <tr style="border-bottom: 1px solid var(--card-border); transition: background 0.2s;"
                            onmouseover="this.style.background='rgba(255,255,255,0.02)'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 1.25rem; color: var(--text-secondary); font-family: monospace;">{{ $idx + 1 }}</td>
                            <td style="padding: 1.25rem 1rem;">
                                <div style="font-weight: 600; color: var(--text-primary);">
                                    {{ $reg->user?->name ?? 'Guest' }}
                                </div>
                                @php
                                    $ticketNames = $reg->generatedTickets->pluck('full_name')->filter()->unique()->implode(', ');
                                @endphp
                                @if($ticketNames)
                                    <div style="font-size: 0.75rem; color: var(--gold); font-weight: 500; margin-top: 2px;">
                                        ({{ $ticketNames }})
                                    </div>
                                @elseif($reg->full_name)
                                    <div style="font-size: 0.75rem; color: var(--gold); font-weight: 500; margin-top: 2px;">
                                        ({{ $reg->full_name }})
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 1.25rem 1rem; color: var(--text-secondary);">
                                {{ $reg->user?->email ?? '-' }}
                            </td>
                            <td style="padding: 1.25rem 1rem; text-align: center;">
                                <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
                                    {{ $reg->payment_status === 'paid' ? 'background: rgba(16,185,129,0.1); color: #10B981; border: 1px solid rgba(16,185,129,0.2);' : 'background: rgba(245,158,11,0.1); color: #F59E0B; border: 1px solid rgba(245,158,11,0.2);' }}">
                                    {{ $reg->payment_status === 'paid' ? 'Paid' : ucfirst($reg->payment_status) }}
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1rem; text-align: center;">
                                @php
                                    $totalTickets = $reg->generatedTickets->count();
                                    $checkedTickets = $reg->generatedTickets->filter(fn($t) => $t->checkin)->count();

                                    if ($totalTickets === 0) {
                                        $status = 'none';
                                    } elseif ($checkedTickets === 0) {
                                        $status = 'none';
                                    } elseif ($checkedTickets < $totalTickets) {
                                        $status = 'partial';
                                    } else {
                                        $status = 'all';
                                    }
                                @endphp

                                @if($status === 'all')
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(16,185,129,0.1); color: #10B981; border: 1px solid rgba(16,185,129,0.2); display: inline-flex; align-items: center; gap: 0.25rem;">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>Sudah
                                    </span>
                                @elseif($status === 'partial')
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(245,158,11,0.1); color: #F59E0B; border: 1px solid rgba(245,158,11,0.2);">
                                        Sebagian
                                    </span>
                                @else
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1.25rem 1rem; text-align: center; color: var(--text-primary); font-weight: 600;">
                                {{ 
                                    $reg->generatedTickets->count()
                                        ?: ($reg->eventTickets->count()
                                            ?: $reg->quantity)
                                }}
                            </td>
                            <td style="padding: 1.25rem 1rem;">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    @foreach($reg->generatedTickets as $ticket)
                                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); padding: 0.4rem 0.6rem; border-radius: 8px;">
                                            <span style="font-family: monospace; font-size: 0.75rem; color: var(--text-secondary); font-weight: 600;">
                                                {{ $ticket->ticket_number }}
                                            </span>
                                            <div style="display: flex; gap: 0.35rem;">
                                                <!-- Detail Button -->
                                                <a href="{{ route('admin.event.participants.participant', ['event' => $event->id, 'ticket' => $ticket->id]) }}"
                                                    style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 6px; background: rgba(212,175,55,0.1); color: var(--gold); border: 1px solid rgba(212,175,55,0.2); transition: all 0.2s;"
                                                    title="Lihat Detail Peserta"
                                                    onmouseover="this.style.background='rgba(212,175,55,0.2)'"
                                                    onmouseout="this.style.background='rgba(212,175,55,0.1)'">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                                <!-- Download Button -->
                                                <a href="{{ route('admin.event.participants.ticket.download', $ticket) }}"
                                                    style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #EF4444; border: 1px solid rgba(239,68,68,0.2); transition: all 0.2s;"
                                                    target="_blank"
                                                    title="Unduh Tiket PDF"
                                                    onmouseover="this.style.background='rgba(239,68,68,0.2)'"
                                                    onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                        <polyline points="7 10 12 15 17 10"></polyline>
                                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($reg->generatedTickets->isEmpty())
                                        <span style="font-size: 0.75rem; color: var(--text-secondary); font-style: italic;">Belum digenerate</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 4rem 2rem; text-align: center; color: var(--text-secondary);">
                                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.3; margin-bottom: 0.75rem; display: inline-block;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p style="margin: 0; font-size: 0.9rem;">Belum ada peserta terdaftar untuk event ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Check-in History Card (Outside) -->
    <div class="premium-card" style="padding: 1.5rem 2rem;">
        <div style="border-bottom: 1px solid var(--card-border); padding-bottom: 1rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: var(--gold);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0;">
                Riwayat Check-in Event Ini
            </h3>
        </div>

        @php
            $eventCheckins = \App\Models\EventCheckin::with('ticket')
                ->where('event_id', $event->id)
                ->latest()
                ->take(20)
                ->get();
        @endphp

        @if($eventCheckins->isEmpty())
            <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0; padding: 1rem 0; font-style: italic;">
                Belum ada peserta yang melakukan check-in.
            </p>
        @else
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @foreach($eventCheckins as $checkin)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); border-radius: 10px; transition: all 0.2s;"
                         onmouseover="this.style.background='rgba(255,255,255,0.04)'"
                         onmouseout="this.style.background='rgba(255,255,255,0.02)'">
                        <div>
                            <div style="font-weight: 600; color: var(--text-primary); font-size: 0.9rem;">
                                {{ $checkin->ticket?->full_name ?? 'Peserta' }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); font-family: monospace; margin-top: 0.15rem;">
                                {{ $checkin->ticket?->ticket_number ?? '-' }}
                            </div>
                        </div>

                        <div style="font-size: 0.8rem; color: #10B981; font-weight: 700; display: inline-flex; align-items: center; background: rgba(16,185,129,0.1); padding: 0.25rem 0.75rem; border-radius: 999px; border: 1px solid rgba(16,185,129,0.2);">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg> 
                            {{ $checkin->checked_in_at->format('H:i') }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection