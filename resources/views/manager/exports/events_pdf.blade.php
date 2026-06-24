<!DOCTYPE html>
<html><head><meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 30px; }
  h1 { color: #B8860B; font-size: 18px; border-bottom: 2px solid #B8860B; padding-bottom: 8px; margin-bottom: 4px; }
  .meta { color: #888; font-size: 10px; margin-bottom: 16px; }
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
<h1>Laporan Event — Wismilak Premium Cigars</h1>
<div class="meta">Digenerate: {{ now()->format('d M Y, H:i') }} WIB &nbsp;|&nbsp; Total: {{ $events->count() }} event</div>
<table>
  <thead><tr><th>ID</th><th>Judul Event</th><th>Pembuat</th><th>Status</th><th>Tanggal</th><th>Kuota</th><th>Harga</th></tr></thead>
  <tbody>
  @foreach($events as $event)
  <tr>
    <td>{{ $event->id }}</td>
    <td><strong>{{ $event->title }}</strong><br><span style="color:#888;font-size:9px;">{{ $event->location }}</span></td>
    <td>{{ $event->creator->name ?? 'N/A' }}</td>
    <td><span class="badge {{ $event->status === 'published' ? 'published' : 'pending' }}">{{ ucfirst($event->status) }}</span></td>
    <td>{{ $event->date?->format('d M Y') }}</td>
    <td>{{ $event->computed_remaining_quota }}/{{ $event->quota }}</td>
    <td>{{ $event->price_type === 'free' ? 'Gratis' : 'Rp '.number_format($event->price,0,',','.') }}</td>
  </tr>
  @endforeach
  </tbody>
</table>
<div class="footer">© {{ date('Y') }} PT Wismilak Inti Makmur Tbk — Laporan ini bersifat rahasia</div>
</body></html>

