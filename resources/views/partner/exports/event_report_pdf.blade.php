<!DOCTYPE html>
<html><head><meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 30px; }
  h1 { color: #B8860B; font-size: 18px; border-bottom: 2px solid #B8860B; padding-bottom: 8px; margin-bottom: 4px; }
  .meta { color: #888; font-size: 10px; margin-bottom: 16px; }
  .summary { background: #fafaf8; border: 1px solid #ddd; padding: 12px; margin-bottom: 20px; border-radius: 4px; }
  .summary table { width: 100%; border: none; margin: 0; }
  .summary td { border: none; padding: 4px 8px; background: transparent; }
  .summary strong { color: #B8860B; }
  table { width: 100%; border-collapse: collapse; margin-top: 12px; }
  th { background: #f5f0e8; color: #333; font-size: 10px; text-align: left; padding: 6px 8px; border: 1px solid #ddd; }
  td { padding: 5px 8px; border: 1px solid #eee; vertical-align: top; }
  tr:nth-child(even) td { background: #fafaf8; }
  .badge { padding: 2px 7px; border-radius: 10px; font-size: 9px; font-weight: bold; }
  .published { background: #d1fae5; color: #065f46; }
  .pending { background: #fef3c7; color: #92400e; }
  .footer { margin-top: 20px; font-size: 9px; color: #aaa; border-top: 1px solid #eee; padding-top: 8px; }
</style>
</head>
<body>
<h1>Laporan Detail Event — {{ $event->title }}</h1>
<div class="meta">Digenerate: {{ now()->format('d M Y, H:i') }} WIB &nbsp;|&nbsp; Tanggal Event: {{ $event->date?->format('d M Y') }} &nbsp;|&nbsp; Lokasi: {{ $event->location }}</div>

<div class="summary">
  <table>
    <tr>
      <td>Total Registrasi: <br><strong>{{ $stats['total_registrations'] }}</strong></td>
      <td>Total Check-in: <br><strong>{{ $stats['total_checkins'] }}</strong></td>
      <td>Total Tiket Terjual: <br><strong>{{ $stats['total_tickets'] }}</strong></td>
      <td>Rata-rata Rating: <br><strong>{{ $stats['avg_rating'] }} / 5.0</strong></td>
      <td>Total Pendapatan: <br><strong>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</strong></td>
    </tr>
  </table>
</div>

<h3>Daftar Transaksi (Berhasil)</h3>
<table>
  <thead><tr><th>No</th><th>Kode Transaksi</th><th>Peserta</th><th>Jumlah Tiket</th><th>Total Bayar</th><th>Tanggal</th></tr></thead>
  <tbody>
  @forelse($transactions as $i => $trx)
  <tr>
    <td>{{ $i + 1 }}</td>
    <td><strong>{{ $trx->transaction_code }}</strong></td>
    <td>{{ $trx->registration->user->name ?? '-' }}<br><span style="color:#888;font-size:9px;">{{ $trx->registration->user->email ?? '-' }}</span></td>
    <td>{{ $trx->registration->quantity }} tiket</td>
    <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
    <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
  </tr>
  @empty
  <tr>
    <td colspan="6" style="text-align: center;">Belum ada transaksi berhasil untuk event ini.</td>
  </tr>
  @endforelse
  </tbody>
</table>

<div class="footer">© {{ date('Y') }} PT Wismilak Inti Makmur Tbk — Laporan ini bersifat rahasia</div>
</body></html>
