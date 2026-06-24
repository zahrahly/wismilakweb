@extends('layouts.customer')

@section('title', 'Riwayat Transaksi')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:2rem;">

  <div style="margin-bottom: 2rem;">
    <a href="{{ route('customer.dashboard') }}" style="display:inline-flex;align-items:center;gap:.5rem;color:rgba(245,235,224,0.6);text-decoration:none;font-size:.85rem;background:rgba(255,255,255,0.03);padding:0.5rem 1rem;border-radius:8px;border:1px solid rgba(255,255,255,0.08);transition:all .2s;" onmouseover="this.style.background='rgba(212,175,55,0.1)';this.style.color='#D4AF37';this.style.borderColor='rgba(212,175,55,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.03)';this.style.color='rgba(245,235,224,0.6)';this.style.borderColor='rgba(255,255,255,0.08)'">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      Kembali ke Dashboard
    </a>
  </div>

  <div style="margin-bottom:2rem;">
    <div class="section-label">My Account</div>
    <h1 class="font-serif" style="font-size:2.5rem;margin-bottom:.5rem;">Riwayat <em>Transaksi</em></h1>
    <p style="color:rgba(245,235,224,.5);">Semua registrasi dan pembayaran event Anda.</p>
  </div>

  @if(session('success'))
    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);color:#10B981;padding:.75rem 1rem;border-radius:10px;margin-bottom:1.5rem;font-size:.85rem;">{{ session('success') }}</div>
  @endif
  @if(session('info'))
    <div style="background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.3);color:#60A5FA;padding:.75rem 1rem;border-radius:10px;margin-bottom:1.5rem;font-size:.85rem;">{{ session('info') }}</div>
  @endif

  <div style="display:grid;gap:1rem;">
    @forelse($registrations as $reg)
    {{-- ✅ Skip expired registrations --}}
    @if($reg->payment_status === 'expired')
        @continue
    @endif

    <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:16px;padding:1.5rem;transition:border-color .3s;"
         onmouseover="this.style.borderColor='rgba(212,175,55,.25)'" onmouseout="this.style.borderColor='rgba(255,255,255,.07)'">

      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;gap:1rem;flex-wrap:wrap;">
        <div>
          <h3 style="font-size:1.05rem;font-weight:600;margin-bottom:.35rem;">
            {{ $reg->event?->title ?? '(Event dihapus)' }}
          </h3>
          <div style="display:flex;gap:1rem;flex-wrap:wrap;">
            <span style="font-size:.75rem;color:rgba(245,235,224,.45);">
              {{ $reg->event?->date?->format('d M Y') ?? '-' }}
            </span>
            <span style="font-size:.75rem;color:rgba(245,235,224,.45);">
              {{ $reg->event?->location ?? '-' }}
            </span>
            <span style="font-size:.75rem;color:rgba(245,235,224,.45);">
              {{ $reg->quantity ?? 1 }} tiket
            </span>
          </div>
        </div>

        <div style="display:flex;align-items:center;gap:.75rem;flex-shrink:0;">
          @php
            $statusMap = [
              'paid'    => ['bg'=>'rgba(16,185,129,.15)','color'=>'#10B981','label'=>'Paid'],
              'pending' => ['bg'=>'rgba(245,158,11,.15)', 'color'=>'#F59E0B','label'=>'Pending'],
              'failed'  => ['bg'=>'rgba(239,68,68,.15)',  'color'=>'#EF4444','label'=>'Failed'],
              'success' => ['bg'=>'rgba(16,185,129,.15)', 'color'=>'#10B981','label'=>'Paid'],
            ];
            $s = $statusMap[$reg->payment_status] ?? ['bg'=>'rgba(255,255,255,.08)','color'=>'#aaa','label'=>ucfirst($reg->payment_status)];
          @endphp
          <span style="background:{{ $s['bg'] }};color:{{ $s['color'] }};padding:.25rem .75rem;border-radius:999px;font-size:.7rem;font-weight:700;">
            {{ $s['label'] }}
          </span>
          <span style="font-size:1rem;font-weight:700;color:#D4AF37;">
            {{ $reg->total_amount > 0 ? 'Rp '.number_format($reg->total_amount,0,',','.') : 'Free' }}
          </span>
        </div>
      </div>

      {{-- Tickets --}}
      @if(in_array($reg->payment_status, ['paid','success']) && $reg->generatedTickets->count())
        <div style="border-top:1px solid rgba(255,255,255,.06);padding-top:1rem;display:flex;flex-wrap:wrap;gap:.6rem;align-items:center;">
          <span style="font-size:.75rem;color:rgba(245,235,224,.45);">Tiket:</span>
          @foreach($reg->generatedTickets as $ticket)
            <a href="{{ route('customer.ticket.pdf', $ticket->id) }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.25);color:#D4AF37;padding:.3rem .7rem;border-radius:6px;font-size:.72rem;text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='rgba(212,175,55,.2)'" onmouseout="this.style.background='rgba(212,175,55,.1)'">
              {{ $ticket->ticket_number }}
            </a>
          @endforeach
          @php
            $checkedTickets = $reg->generatedTickets->filter(fn($t)=>$t->checkin)->count();
            $totalTickets   = $reg->generatedTickets->count();
            $hasCheckedIn   = $totalTickets > 0 && $checkedTickets === $totalTickets;
            $isPastEvent    = $reg->event && \Carbon\Carbon::parse($reg->event->date)->endOfDay()->isPast();
          @endphp
          @if($hasCheckedIn || $isPastEvent)
            @if(in_array($reg->event_id, $userFeedbackEventIds))
              <span style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.3);color:#10B981;padding:.3rem .7rem;border-radius:6px;font-size:.72rem;cursor:not-allowed;margin-left:auto;" title="Feedback Terkirim">
                ✓ Feedback Terkirim
              </span>
              @if($reg->transaction)
                <a href="{{ route('customer.transactions.show', $reg->transaction->id) }}"
                   style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(99,102,241,.1);border:1px solid rgba(99,102,241,.25);color:#818CF8;padding:.3rem .7rem;border-radius:6px;font-size:.72rem;text-decoration:none;margin-left:0.5rem;"
                   onmouseover="this.style.background='rgba(99,102,241,.2)'" onmouseout="this.style.background='rgba(99,102,241,.1)'">
                  Detail →
                </a>
              @endif
            @else
              <span
  style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.25);color:#D4AF37;padding:.3rem .7rem;border-radius:6px;font-size:.72rem;text-decoration:none;margin-left:auto;">
  Isi Feedback
</span>
              @if($reg->transaction)
                <a href="{{ route('customer.transactions.show', $reg->transaction->id) }}"
                   style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(99,102,241,.1);border:1px solid rgba(99,102,241,.25);color:#818CF8;padding:.3rem .7rem;border-radius:6px;font-size:.72rem;text-decoration:none;margin-left:0.5rem;"
                   onmouseover="this.style.background='rgba(99,102,241,.2)'" onmouseout="this.style.background='rgba(99,102,241,.1)'">
                  Detail →
                </a>
              @endif
            @endif
          @else
            @if($reg->transaction)
              <a href="{{ route('customer.transactions.show', $reg->transaction->id) }}"
                 style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(99,102,241,.1);border:1px solid rgba(99,102,241,.25);color:#818CF8;padding:.3rem .7rem;border-radius:6px;font-size:.72rem;text-decoration:none;margin-left:auto;"
                 onmouseover="this.style.background='rgba(99,102,241,.2)'" onmouseout="this.style.background='rgba(99,102,241,.1)'">
                Detail →
              </a>
            @endif
          @endif
        </div>
      @elseif($reg->payment_status === 'pending' && $reg->snap_token)
        <div style="border-top:1px solid rgba(255,255,255,.06);padding-top:1rem;">
          <a href="{{ route('customer.payment.show', $reg->id) }}"
             style="display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#D4AF37,#B8860B);color:#000;padding:.5rem 1.25rem;border-radius:8px;font-size:.8rem;font-weight:700;text-decoration:none;">
            Lanjutkan Pembayaran
          </a>
        </div>
      @endif
    </div>
    @empty
    <div style="text-align:center;padding:4rem 2rem;background:rgba(255,255,255,.02);border:1px dashed rgba(255,255,255,.08);border-radius:16px;">
      <div style="font-size:3rem;margin-bottom:1rem;color:rgba(212,175,55,0.3);"><svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
      <p style="color:rgba(245,235,224,.4);margin-bottom:1.5rem;">Belum ada transaksi. Mulai ikuti event!</p>
      <a href="{{ route('events.index') }}" style="background:linear-gradient(135deg,#D4AF37,#B8860B);color:#000;padding:.65rem 1.5rem;border-radius:8px;font-size:.85rem;font-weight:700;text-decoration:none;">
        Lihat Event →
      </a>
    </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if($registrations->hasPages())
    <div style="margin-top:2rem;">{{ $registrations->links() }}</div>
  @endif

</div>
@endsection