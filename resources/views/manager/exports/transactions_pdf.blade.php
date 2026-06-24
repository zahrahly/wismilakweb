<!DOCTYPE html>
<html><head><meta charset="UTF-8">
<style>
  body{font-family:Arial,sans-serif;font-size:11px;color:#333;margin:30px;}
  h1{color:#B8860B;font-size:18px;border-bottom:2px solid #B8860B;padding-bottom:8px;margin-bottom:4px;}
  .meta{color:#888;font-size:10px;margin-bottom:16px;}
  table{width:100%;border-collapse:collapse;margin-top:12px;}
  th{background:#f5f0e8;color:#333;font-size:10px;text-align:left;padding:6px 8px;border:1px solid #ddd;}
  td{padding:5px 8px;border:1px solid #eee;}
  tr:nth-child(even) td{background:#fafaf8;}
  .footer{margin-top:20px;font-size:9px;color:#aaa;border-top:1px solid #eee;padding-top:8px;}
  .total{font-size:13px;font-weight:bold;color:#B8860B;margin:10px 0;}
</style>
</head>
<body>
<h1>Laporan Transaksi — Wismilak Premium Cigars</h1>
<div class="meta">Digenerate: {{ now()->format('d M Y, H:i') }} WIB &nbsp;|&nbsp; Total: {{ $transactions->count() }} transaksi</div>
<div class="total">Total Revenue: Rp {{ number_format($transactions->where('status','paid')->sum('amount'),0,',','.') }}</div>
<table>
  <thead><tr><th>Kode</th><th>User</th><th>Event</th><th>Jumlah</th><th>Metode</th><th>Status</th><th>Tanggal</th></tr></thead>
  <tbody>
  @foreach($transactions as $t)
  <tr>
    <td style="font-family:monospace;font-size:9px;">{{ $t->transaction_code }}</td>
    <td>{{ $t->user->name ?? '-' }}</td>
    <td>{{ $t->registration->event->title ?? '-' }}</td>
    <td><strong>Rp {{ number_format($t->amount,0,',','.') }}</strong></td>
    <td>{{ ucfirst($t->payment_method ?? 'midtrans') }}</td>
    <td>{{ ucfirst($t->status) }}</td>
    <td>{{ $t->paid_at?->format('d M Y') ?? '-' }}</td>
  </tr>
  @endforeach
  </tbody>
</table>
<div class="footer">© {{ date('Y') }} PT Wismilak Inti Makmur Tbk</div>
</body></html>

