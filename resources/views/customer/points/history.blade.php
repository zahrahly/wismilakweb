@extends('layouts.customer')

@section('title', 'Riwayat Poin')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:2rem;">

  <div style="margin-bottom: 2rem;">
    <a href="{{ route('customer.dashboard') }}" style="display:inline-flex;align-items:center;gap:.5rem;color:rgba(245,235,224,0.6);text-decoration:none;font-size:.85rem;background:rgba(255,255,255,0.03);padding:0.5rem 1rem;border-radius:8px;border:1px solid rgba(255,255,255,0.08);transition:all .2s;" onmouseover="this.style.background='rgba(212,175,55,0.1)';this.style.color='#D4AF37';this.style.borderColor='rgba(212,175,55,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.03)';this.style.color='rgba(245,235,224,0.6)';this.style.borderColor='rgba(255,255,255,0.08)'">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
      Kembali ke Dashboard
    </a>
  </div>

  <div style="margin-bottom:2rem;">
    <div class="section-label">My Rewards</div>
    <h1 class="font-serif" style="font-size:2.5rem;margin-bottom:.5rem;">Riwayat <em>Poin</em></h1>
    <p style="color:rgba(245,235,224,.5);">Semua aktivitas poin Anda.</p>
  </div>

  {{-- Summary Cards --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:2rem;">
    <div style="background:rgba(212,175,55,.06);border:1px solid rgba(212,175,55,.15);border-radius:14px;padding:1.25rem;text-align:center;">
      <div style="font-size:.65rem;letter-spacing:.2em;color:rgba(212,175,55,.6);text-transform:uppercase;margin-bottom:.5rem;">Poin Aktif</div>
      <div style="font-size:2rem;font-weight:800;color:#D4AF37;">{{ number_format(auth()->user()->point?->total_points ?? 0) }}</div>
    </div>
    <div style="background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.15);border-radius:14px;padding:1.25rem;text-align:center;">
      <div style="font-size:.65rem;letter-spacing:.2em;color:rgba(16,185,129,.6);text-transform:uppercase;margin-bottom:.5rem;">Total Diperoleh</div>
      <div style="font-size:2rem;font-weight:800;color:#10B981;">+{{ number_format($totalEarned) }}</div>
    </div>
    <div style="background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.15);border-radius:14px;padding:1.25rem;text-align:center;">
      <div style="font-size:.65rem;letter-spacing:.2em;color:rgba(239,68,68,.6);text-transform:uppercase;margin-bottom:.5rem;">Total Digunakan</div>
      <div style="font-size:2rem;font-weight:800;color:#EF4444;">-{{ number_format($totalSpent) }}</div>
    </div>
  </div>

  {{-- History Table --}}
  <div style="background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:16px;overflow:hidden;">
    <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;justify-content:space-between;">
      <h2 style="font-size:.9rem;font-weight:600;">Semua Transaksi Poin</h2>
      <a href="{{ route('customer.dashboard') }}" style="font-size:.78rem;color:#D4AF37;text-decoration:none;">← Dashboard</a>
    </div>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="border-bottom:1px solid rgba(255,255,255,.06);">
          <th style="text-align:left;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:rgba(245,235,224,.35);padding:.75rem 1.5rem;">Tanggal</th>
          <th style="text-align:left;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:rgba(245,235,224,.35);padding:.75rem 1rem;">Keterangan</th>
          <th style="text-align:left;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:rgba(245,235,224,.35);padding:.75rem 1rem;">Sumber</th>
          <th style="text-align:right;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:rgba(245,235,224,.35);padding:.75rem 1.5rem;">Poin</th>
        </tr>
      </thead>
      <tbody>
        @forelse($histories as $h)
        <tr style="border-bottom:1px solid rgba(255,255,255,.04);transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.02)'" onmouseout="this.style.background='transparent'">
          <td style="padding:.85rem 1.5rem;font-size:.78rem;color:rgba(245,235,224,.4);">
            {{ $h->created_at->format('d M Y') }}<br>
            <span style="font-size:.7rem;">{{ $h->created_at->format('H:i') }}</span>
          </td>
          <td style="padding:.85rem 1rem;font-size:.85rem;">{{ $h->description }}</td>
          <td style="padding:.85rem 1rem;">
            <span style="background:rgba(255,255,255,.06);padding:.2rem .6rem;border-radius:999px;font-size:.7rem;color:rgba(245,235,224,.5);">
              {{ str_replace('_', ' ', ucfirst($h->source)) }}
            </span>
          </td>
          <td style="padding:.85rem 1.5rem;text-align:right;font-size:.95rem;font-weight:700;color:{{ $h->type === 'earn' ? '#10B981' : '#EF4444' }};">
            {{ $h->type === 'earn' ? '+' : '-' }}{{ number_format($h->points) }}
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" style="text-align:center;padding:3rem;color:rgba(245,235,224,.3);">
            <div style="font-size:2rem;margin-bottom:1rem;color:rgba(212,175,55,0.3);"><svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26"/></svg></div>
            Belum ada riwayat poin. Mulai ikuti event untuk mengumpulkan poin!
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
    @if($histories->hasPages())
      <div style="padding:1rem 1.5rem;">{{ $histories->links() }}</div>
    @endif
  </div>
</div>
@endsection

