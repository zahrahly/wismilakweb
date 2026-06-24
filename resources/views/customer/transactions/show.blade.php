@extends('layouts.customer')

@section('title', 'Detail Transaksi')

@section('content')
  <div style="max-width:800px;margin:0 auto;padding:2rem;">

    <a href="{{ route('customer.transactions.index') }}"
      style="display:inline-flex;align-items:center;gap:.5rem;color:rgba(245,235,224,.5);text-decoration:none;font-size:.85rem;margin-bottom:2rem;transition:color .2s;"
      onmouseover="this.style.color='#D4AF37'" onmouseout="this.style.color='rgba(245,235,224,.5)'">
      ← Kembali ke Riwayat
    </a>

    <div class="section-label" style="margin-bottom:.5rem;">Transaction Detail</div>
    <h1 class="font-serif" style="font-size:2rem;margin-bottom:2rem;">Detail Transaksi</h1>

    {{-- Summary Card --}}
    <div
      style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;">
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;">
        <div>
          <div
            style="font-size:.7rem;letter-spacing:.15em;color:rgba(245,235,224,.4);text-transform:uppercase;margin-bottom:.35rem;">
            Event</div>
          <div style="font-size:.9rem;font-weight:600;">{{ $transaction->registration->event->title ?? 'N/A' }}</div>
        </div>
        <div>
          <div
            style="font-size:.7rem;letter-spacing:.15em;color:rgba(245,235,224,.4);text-transform:uppercase;margin-bottom:.35rem;">
            Status</div>
          @php
            $isPaid = $transaction->isPaid();
          @endphp
          <span
            style="background:{{ $isPaid ? 'rgba(16,185,129,.15)' : 'rgba(245,158,11,.15)' }};color:{{ $isPaid ? '#10B981' : '#F59E0B' }};padding:.2rem .6rem;border-radius:999px;font-size:.75rem;font-weight:700;">
            {{ $isPaid ? 'Paid' : ucfirst($transaction->status) }}
          </span>
        </div>
        <div>
          <div
            style="font-size:.7rem;letter-spacing:.15em;color:rgba(245,235,224,.4);text-transform:uppercase;margin-bottom:.35rem;">
            Metode Pembayaran</div>
          <div style="font-size:.9rem;">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method ?? 'Midtrans')) }}
          </div>
        </div>
        <div>
          <div
            style="font-size:.7rem;letter-spacing:.15em;color:rgba(245,235,224,.4);text-transform:uppercase;margin-bottom:.35rem;">
            Tanggal Bayar</div>
          <div style="font-size:.85rem;">{{ $transaction->paid_at?->format('d M Y, H:i') ?? '-' }}</div>
        </div>
      </div>
    </div>

    {{-- Price Breakdown --}}
    <div
      style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;">
      <h2 style="font-size:.9rem;font-weight:600;color:#D4AF37;margin-bottom:1rem;">Rincian Harga</h2>

      @php
        $reg = $transaction->registration;
        $subtotal = ($reg->ticket_price ?? 0) * ($reg->quantity ?? 1);
        $discount = $reg->discount_amount ?? 0;
      @endphp

      <div
        style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem;color:rgba(245,235,224,.6);">
        <span>Harga per tiket</span>
        <span>Rp {{ number_format($reg->ticket_price ?? 0, 0, ',', '.') }}</span>
      </div>

      <div
        style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem;color:rgba(245,235,224,.6);">
        <span>Jumlah tiket</span>
        <span>× {{ $reg->quantity ?? 1 }}</span>
      </div>

      <div
        style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem;color:rgba(245,235,224,.8);border-top:1px solid rgba(255,255,255,.05);padding-top:.5rem;">
        <span>Subtotal</span>
        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
      </div>

      @if($reg->voucherRedemption)
        <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem;color:rgba(245,235,224,.8);">
          <span>Voucher Digunakan</span>
          <span style="font-weight: 600; color: #D4AF37;">
            {{ $reg->voucherRedemption->voucher_code }} 
            @if($reg->voucherRedemption->voucher)
              ({{ $reg->voucherRedemption->voucher->title }})
            @endif
          </span>
        </div>
      @endif

      @if($discount > 0)
        <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem;color:#10B981;">
          <span>Diskon Voucher</span>
          <span>- Rp {{ number_format($discount, 0, ',', '.') }}</span>
        </div>
      @endif

      @if($reg->rewardRedemption)
        <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem;color:rgba(245,235,224,.8);border-top:1px solid rgba(255,255,255,.05);padding-top:.5rem;">
          <span>Reward Merchandise</span>
          <span style="font-weight: 600; color: #D4AF37;">
             {{ $reg->rewardRedemption->reward->title ?? 'N/A' }}
          </span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem;color:rgba(245,235,224,.6);">
          <span>Status Klaim Reward</span>
          <span>
            @if($reg->rewardRedemption->status === 'completed')
              <span style="color:#10B981; font-weight: 600;">Sudah Diambil (Saat Check-in)</span>
            @else
              <span style="color:#F59E0B; font-weight: 600;">Belum Diambil (Ambil di Event)</span>
            @endif
          </span>
        </div>
      @endif

      <div
        style="display:flex;justify-content:space-between;font-size:1.15rem;font-weight:700;color:#D4AF37;border-top:1px solid rgba(212,175,55,.2);padding-top:.75rem;margin-top:.5rem;">
        <span>Total</span>
        <span>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
      </div>
    </div>

    {{-- Tickets --}}
    <h2
      style="font-size:1rem;font-weight:600;color:#D4AF37;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
      Tiket Anda ({{ $transaction->registration->generatedTickets->count() }})
    </h2>

    <div style="margin-bottom: 1rem; color: #c8534f; font-size: 0.8rem; font-weight: 600; padding: 10px 14px; background: rgba(200,60,60,0.06); border: 1px dashed rgba(200,60,60,0.25); border-radius: 8px; display: flex; align-items: center; gap: 8px;">
      <span>⚠️ Seluruh tiket yang dibeli tidak dapat dibatalkan atau dikembalikan.</span>
    </div>

    <div style="display:grid;gap:1rem;">
      @forelse($transaction->registration->generatedTickets as $ticket)
        <div
          style="background:linear-gradient(135deg,rgba(212,175,55,.06),rgba(212,175,55,.02));border:1px solid rgba(212,175,55,.15);border-radius:16px;padding:1.5rem;display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
          <div>
            <div
              style="font-size:.7rem;letter-spacing:.15em;color:rgba(212,175,55,.6);text-transform:uppercase;margin-bottom:.35rem;">
              Ticket Number</div>
            <div style="font-size:1.1rem;font-weight:700;color:#D4AF37;font-family:monospace;">{{ $ticket->ticket_number }}
            </div>
            @if($ticket->full_name)
              <div style="font-size:.75rem;color:rgba(245,235,224,.5);margin-top:.25rem;">
                {{ $ticket->full_name }}
              </div>
            @endif
            <div style="font-size:.75rem;color:rgba(245,235,224,.4);margin-top:.35rem;">
              Status:
              @if($ticket->isCheckedIn())
                <span style="color:#10B981;">Checked In</span>
              @else
                <span style="color:#F59E0B;">Active</span>
              @endif
            </div>
          </div>
          <a href="{{ route('customer.ticket.pdf', $ticket->id) }}" target="_blank"
            style="display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#D4AF37,#B8860B);color:#000;padding:.6rem 1.25rem;border-radius:8px;font-size:.8rem;font-weight:700;text-decoration:none;white-space:nowrap;">
            ⬇ Download PDF
          </a>
        </div>
      @empty
        <p style="color:rgba(245,235,224,.4);text-align:center;padding:2rem;">Tiket belum digenerate.</p>
      @endforelse
    </div>

    {{-- Feedback Section --}}
    @if($transaction->registration->event)
      <div
        style="margin-top:2rem; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.07); border-radius:16px; padding:1.5rem;">
        <h2 style="font-size:.9rem;font-weight:600;color:#D4AF37;margin-bottom:1rem;">Feedback Event</h2>

        @if(isset($feedback) && $feedback)
          {{-- Already gave feedback --}}
          <div style="margin-bottom:1rem;">
            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.75rem;">
              <span style="color:#10B981;font-weight:600;font-size:.85rem;">Feedback sudah diberikan</span>
            </div>
            <div style="font-size:.85rem;color:rgba(245,235,224,.6);margin-bottom:.5rem;">
              Rating:
              @for($i = 1; $i <= 5; $i++)
                <span style="color:{{ $i <= $feedback->rating ? '#D4AF37' : 'rgba(245,235,224,.2)' }};">★</span>
              @endfor
              ({{ $feedback->rating }}/5)
            </div>
            @if($feedback->comment)
              <div style="font-size:.85rem;color:rgba(245,235,224,.5);font-style:italic;">
                "{{ Str::limit($feedback->comment, 100) }}"
              </div>
            @endif
          </div>

          <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <a href="{{ route('customer.event.feedback.show', $transaction->registration->event_id) }}"
              style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.2rem;border:1px solid rgba(212,175,55,.3);color:#D4AF37;border-radius:8px;font-size:.8rem;font-weight:600;text-decoration:none;transition:all .2s;"
              onmouseover="this.style.background='rgba(212,175,55,.1)'" onmouseout="this.style.background='transparent'">
              Lihat Feedback
            </a>
            <a href="{{ route('customer.event.feedback.edit', $transaction->registration->event_id) }}"
              style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.2rem;border:1px solid rgba(139,92,246,.3);color:#8B5CF6;border-radius:8px;font-size:.8rem;font-weight:600;text-decoration:none;transition:all .2s;"
              onmouseover="this.style.background='rgba(139,92,246,.1)'" onmouseout="this.style.background='transparent'">
              Edit Feedback
            </a>
          </div>
        @else
          {{-- No feedback yet --}}
          @php
            $checkedTickets = $transaction->registration->generatedTickets->filter(fn($t) => $t->checkin)->count();
            $totalTickets = $transaction->registration->generatedTickets->count();
            $canFeedback = $checkedTickets > 0 && $checkedTickets === $totalTickets;
          @endphp

          @if($canFeedback)
            <p style="font-size:.85rem;color:rgba(245,235,224,.5);margin-bottom:1rem;">
              Anda belum memberikan feedback untuk event ini. Berikan feedback dan dapatkan poin reward!
            </p>
            <a href="{{ route('customer.event.feedback.create', $transaction->registration->event_id) }}"
              style="display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#D4AF37,#B8860B);color:#000;padding:.6rem 1.5rem;border-radius:8px;font-size:.8rem;font-weight:700;text-decoration:none;">
              Beri Feedback (+{{ $totalTickets * 15 }} PTS)
            </a>
          @else
            <p style="font-size:.85rem;color:rgba(245,235,224,.4);">
              Feedback tersedia setelah semua tiket di-check-in pada hari event.
            </p>
          @endif
        @endif
      </div>
    @endif

  </div>
@endsection