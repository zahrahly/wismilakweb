@extends('layouts.admin')

@section('title', 'Detail Peserta - ' . $ticket->full_name)

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.event.participants.detail', $event) }}" 
       style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;"
       onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Peserta
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    {{-- Info Peserta --}}
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">

        {{-- Data Utama --}}
        <div class="premium-card">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Informasi Peserta</h3>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Nama Lengkap</div>
                        <div style="font-weight: 600; font-size: 1.05rem; color: var(--text-primary);">{{ $ticket->full_name }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Email</div>
                        <div style="color: var(--text-primary);">{{ $ticket->email ?? $ticket->user->email ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Nomor Telepon</div>
                        <div style="color: var(--text-primary);">{{ $ticket->phone ?? $eventTicket->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Tanggal Lahir</div>
                        <div style="color: var(--text-primary);">{{ $ticket->date_of_birth ? \Carbon\Carbon::parse($ticket->date_of_birth)->format('d M Y') : ($eventTicket?->date_of_birth ? \Carbon\Carbon::parse($eventTicket->date_of_birth)->format('d M Y') : '-') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Nomor KTP</div>
                        <div style="font-family: monospace; color: var(--text-primary); font-size: 0.95rem;">{{ $ticket->ktp_number ?? $eventTicket->ktp_number ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Nomor Tiket</div>
                        <div style="font-family: monospace; color: var(--gold); font-weight: 700; font-size: 1rem;">{{ $ticket->ticket_number }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- File KTP --}}
        @if($eventTicket?->ktp_file)
        <div class="premium-card">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">File KTP</h3>
            </div>
            <div style="padding: 1.5rem;">
                <div style="text-align: left;">
                    <div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--card-border); max-width: 460px; background: rgba(0,0,0,0.2); padding: 8px;">
                        <img src="{{ asset('storage/' . $eventTicket->ktp_file) }}" alt="KTP {{ $ticket->full_name }}"
                             style="width: 100%; border-radius: 8px; display: block;">
                    </div>
                    <div style="margin-top: 1rem; padding-left: 0.5rem;">
                        <a href="{{ asset('storage/' . $eventTicket->ktp_file) }}" target="_blank"
                           style="font-size: 0.8rem; color: var(--gold); text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: opacity 0.2s;"
                           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            Lihat Ukuran Penuh
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Status Detail --}}
        <div class="premium-card">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Status & Registrasi</h3>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.5rem; font-weight: 700;">Status Pembayaran</div>
                        @php $payStatus = $ticket->eventRegistration?->payment_status ?? 'unknown'; @endphp
                        <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
                            {{ $payStatus === 'paid' ? 'background:rgba(16,185,129,0.1);color:#10B981;border:1px solid rgba(16,185,129,0.2);' : 'background:rgba(245,158,11,0.1);color:#F59E0B;border:1px solid rgba(245,158,11,0.2);' }}">
                            {{ $payStatus === 'paid' ? 'Paid' : ucfirst($payStatus) }}
                        </span>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.5rem; font-weight: 700;">Status Tiket</div>
                        <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
                            {{ $ticket->status === 'active' ? 'background:rgba(16,185,129,0.1);color:#10B981;border:1px solid rgba(16,185,129,0.2);' : 'background:rgba(255,255,255,0.05);color:var(--text-secondary);border:1px solid var(--card-border);' }}">
                            {{ ucfirst($ticket->status ?? 'active') }}
                        </span>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.5rem; font-weight: 700;">Status Check-in</div>
                        @if($ticket->checkin)
                            <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(16,185,129,0.1); color: #10B981; border: 1px solid rgba(16,185,129,0.2); display: inline-flex; align-items: center; gap: 0.25rem;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> 
                                Sudah ({{ $ticket->checkin->checked_in_at->format('H:i') }})
                            </span>
                        @else
                            <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">
                                Belum
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Registration details --}}
                @if($ticket->eventRegistration)
                <div style="padding-top: 1.5rem; border-top: 1px solid var(--card-border);">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; row-gap: 1.25rem;">
                        <div>
                            <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Jumlah Tiket</div>
                            <div style="color: var(--text-primary); font-weight: 600;">{{ $ticket->eventRegistration->quantity }} tiket</div>
                        </div>
                        <div>
                            <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Harga per Tiket</div>
                            <div style="color: var(--text-primary);">Rp {{ number_format($ticket->eventRegistration->ticket_price ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Total Bayar</div>
                            <div style="color: var(--gold); font-weight: 700; font-size: 1.05rem;">Rp {{ number_format($ticket->eventRegistration->total_amount ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Tanggal Daftar</div>
                            <div style="color: var(--text-primary);">{{ $ticket->eventRegistration->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>

                @if(($ticket->eventRegistration->voucherRedemption) || ($ticket->eventRegistration->rewardRedemption))
                <div style="padding-top: 1.5rem; margin-top: 1.5rem; border-top: 1px dashed var(--card-border);">
                    <h4 style="font-size: 0.8rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Voucher & Reward</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        @if($ticket->eventRegistration->voucherRedemption)
                        <div>
                            <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Voucher Digunakan</div>
                            <div style="color: var(--text-primary); font-weight: 600;">
                                {{ $ticket->eventRegistration->voucherRedemption->voucher_code }}
                                @if($ticket->eventRegistration->voucherRedemption->voucher)
                                    <span style="font-weight: normal; color: var(--text-secondary); font-size: 0.85rem;">
                                        ({{ $ticket->eventRegistration->voucherRedemption->voucher->title }})
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($ticket->eventRegistration->rewardRedemption)
                        <div>
                            <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700;">Reward Merchandise</div>
                            <div style="color: var(--text-primary); font-weight: 600;">
                                {{ $ticket->eventRegistration->rewardRedemption->reward->title ?? 'N/A' }}
                            </div>
                            <div style="font-size: 0.75rem; margin-top: 2px;">
                                Status Klaim: 
                                @if($ticket->eventRegistration->rewardRedemption->status === 'completed')
                                    <span style="color: #10B981; font-weight: 700;">Sudah Diambil (Saat Check-in)</span>
                                @else
                                    <span style="color: #F59E0B; font-weight: 700;">Belum Diambil (Ambil di Event)</span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>

    {{-- Info Event & Aksi --}}
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="premium-card">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Event</h3>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-weight: 700; font-size: 1.1rem; color: var(--text-primary); margin-bottom: 0.75rem; font-family: 'Crimson Pro', serif;">{{ $event->title }}</div>
                <div style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.8; display: flex; flex-direction: column; gap: 0.5rem;">
                    <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--gold);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        {{ $event->date ? $event->date->format('d M Y') : '-' }}
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--gold);"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        {{ $event->location }}
                    </span>
                    @if($event->start_time)
                    <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--gold);"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        {{ $event->start_time }} - {{ $event->end_time ?? 'Selesai' }}
                    </span>
                    @endif
                    @if($event->outlets->first())
                    <div style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid var(--card-border); font-size: 0.8rem;">
                        <strong style="color: var(--text-primary);">Outlet:</strong> {{ $event->outlets->first()->name }}<br>
                        <strong style="color: var(--text-primary);">Detail Lokasi:</strong> {{ $event->outlets->first()->pivot->location_detail }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="premium-card">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Akun Pendaftar</h3>
            </div>
            <div style="padding: 1.5rem;">
                @if($ticket->user)
                <div style="font-weight: 600; margin-bottom: 0.25rem; color: var(--text-primary);">{{ $ticket->user->name }}</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);">{{ $ticket->user->email }}</div>
                @if($ticket->user->phone)
                <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg> 
                    {{ $ticket->user->phone }}
                </div>
                @endif
                @else
                <div style="color: var(--text-secondary); font-style: italic;">Tidak ada info akun pendaftar</div>
                @endif
            </div>
        </div>

        <div class="premium-card">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Aksi</h3>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <a href="{{ route('admin.event.participants.ticket.download', $ticket) }}"
                   class="btn-premium" style="text-align: center; text-decoration: none; justify-content: center; display: inline-flex; align-items: center; gap: 0.5rem;" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> 
                    Download Tiket PDF
                </a>
                
                @if($ticket->eventRegistration && $ticket->eventRegistration->transaction)
                <div style="padding: 0.75rem 1rem; background: rgba(255,255,255,0.02); border-radius: 10px; border: 1px solid var(--card-border);">
                    <div style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.35rem; font-weight: 700;">Transaksi</div>
                    <div style="font-family: monospace; font-size: 0.8rem; color: var(--text-primary); font-weight: 600;">
                        {{ $ticket->eventRegistration->transaction->transaction_code }}
                    </div>
                    <div style="font-size: 0.85rem; color: var(--gold); font-weight: 700; margin-top: 0.25rem;">
                        Rp {{ number_format($ticket->eventRegistration->transaction->amount, 0, ',', '.') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
