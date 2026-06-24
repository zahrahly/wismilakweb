<!DOCTYPE html>
<html><head><meta charset="UTF-8">
<style>
  body{font-family:Arial,sans-serif;font-size:11px;color:#333;margin:30px;}
  h1{color:#B8860B;font-size:18px;border-bottom:2px solid #B8860B;padding-bottom:8px;margin-bottom:4px;}
  .meta{color:#888;font-size:10px;margin-bottom:16px;}
  table{width:100%;border-collapse:collapse;margin-top:12px;}
  th{background:#f5f0e8;font-size:10px;text-align:left;padding:6px 8px;border:1px solid #ddd;}
  td{padding:5px 8px;border:1px solid #eee;}
  tr:nth-child(even) td{background:#fafaf8;}
  .footer{margin-top:20px;font-size:9px;color:#aaa;border-top:1px solid #eee;padding-top:8px;}
  h2{font-size:13px;margin-top:20px;color:#555;}
  .stat-box { display: inline-block; width: 22%; margin-right: 2%; background: #fafaf8; border: 1px solid #eee; padding: 10px; text-align: center; }
  .stat-box h3 { margin: 0 0 5px 0; font-size: 10px; color: #888; text-transform: uppercase; }
  .stat-box p { margin: 0; font-size: 16px; font-weight: bold; color: #B8860B; }
</style>
</head>
<body>
<h1>Laporan Reward & Voucher — Wismilak Premium Cigars</h1>
<div class="meta">Digenerate: {{ now()->format('d M Y, H:i') }} WIB</div>

<div style="margin-bottom: 20px;">
    <div class="stat-box">
        <h3>Total Reward</h3>
        <p>{{ $stats['total_rewards'] }}</p>
    </div>
    <div class="stat-box">
        <h3>Total Voucher</h3>
        <p>{{ $stats['total_vouchers'] }}</p>
    </div>
    <div class="stat-box">
        <h3>Tukar Reward</h3>
        <p>{{ number_format($stats['total_reward_redemptions']) }}</p>
    </div>
    <div class="stat-box">
        <h3>Tukar Voucher</h3>
        <p>{{ number_format($stats['total_voucher_redemptions']) }}</p>
    </div>
</div>

<h2>Catalog Reward</h2>
<table>
  <thead><tr><th>Reward</th><th>Poin Diperlukan</th><th>Stok</th><th>Total Ditukar</th><th>Status</th></tr></thead>
  <tbody>
  @forelse($rewards as $r)
  <tr>
    <td><strong>{{ $r->title }}</strong></td>
    <td>{{ number_format($r->points_required) }}</td>
    <td>{{ $r->stock }}</td>
    <td>{{ $r->redemptions_count }}</td>
    <td>{{ ucfirst($r->status) }}</td>
  </tr>
  @empty
  <tr><td colspan="5" style="text-align: center;">Belum ada data reward.</td></tr>
  @endforelse
  </tbody>
</table>

<h2>Catalog Voucher</h2>
<table>
  <thead><tr><th>Voucher</th><th>Kode</th><th>Poin Diperlukan</th><th>Diskon</th><th>Total Ditukar</th><th>Status</th></tr></thead>
  <tbody>
  @forelse($vouchers as $v)
  <tr>
    <td><strong>{{ $v->title }}</strong></td>
    <td>{{ $v->code }}</td>
    <td>{{ number_format($v->points_required) }}</td>
    <td>{{ $v->discount_type === 'percent' ? $v->discount_value . '%' : 'Rp ' . number_format($v->discount_value, 0, ',', '.') }}</td>
    <td>{{ $v->redemptions_count }}</td>
    <td>{{ ucfirst($v->status) }}</td>
  </tr>
  @empty
  <tr><td colspan="6" style="text-align: center;">Belum ada data voucher.</td></tr>
  @endforelse
  </tbody>
</table>

<h2>Top User Berdasarkan Poin</h2>
<table>
  <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Total Poin</th></tr></thead>
  <tbody>
  @forelse($topUsers as $i => $up)
  <tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $up->user->name ?? '-' }}</td>
    <td>{{ $up->user->email ?? '-' }}</td>
    <td><strong>{{ number_format($up->total_points) }}</strong></td>
  </tr>
  @empty
  <tr><td colspan="4" style="text-align: center;">Belum ada data user poin.</td></tr>
  @endforelse
  </tbody>
</table>

<h2>Recent Redemptions (Merged)</h2>
<table>
  <thead><tr><th>Tipe</th><th>Item</th><th>User</th><th>Poin Digunakan</th><th>Status</th><th>Tanggal</th></tr></thead>
  <tbody>
  @forelse($recentRedemptions as $item)
  <tr>
    <td>{{ $item['type'] }}</td>
    <td><strong>{{ $item['item_name'] }}</strong></td>
    <td>{{ $item['user_name'] }}</td>
    <td>{{ number_format($item['points']) }}</td>
    <td>{{ ucfirst($item['status']) }}</td>
    <td>{{ $item['date'] ? $item['date']->format('d M Y, H:i') : '-' }}</td>
  </tr>
  @empty
  <tr><td colspan="6" style="text-align: center;">Belum ada riwayat penukaran.</td></tr>
  @endforelse
  </tbody>
</table>

<div class="footer">© {{ date('Y') }} PT Wismilak Inti Makmur Tbk</div>
</body></html>

