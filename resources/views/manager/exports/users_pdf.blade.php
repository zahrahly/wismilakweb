<!DOCTYPE html>
<html><head><meta charset="UTF-8">
<style>
  body{font-family:Arial,sans-serif;font-size:11px;color:#333;margin:30px;}
  h1{color:#B8860B;font-size:18px;border-bottom:2px solid #B8860B;padding-bottom:8px;margin-bottom:4px;}
  .meta{color:#888;font-size:10px;margin-bottom:16px;}
  table{width:100%;border-collapse:collapse;margin-top:12px;}
  th{background:#f5f0e8;color:#333;font-size:10px;text-align:left;padding:6px 8px;border:1px solid #ddd;}
  td{padding:5px 8px;border:1px solid #eee;vertical-align:top;}
  tr:nth-child(even) td{background:#fafaf8;}
  .footer{margin-top:20px;font-size:9px;color:#aaa;border-top:1px solid #eee;padding-top:8px;}
</style>
</head>
<body>
<h1>Laporan User — Wismilak Premium Cigars</h1>
<div class="meta">Digenerate: {{ now()->format('d M Y, H:i') }} WIB &nbsp;|&nbsp; Total: {{ $users->count() }} user</div>
<table>
  <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Poin</th><th>Bergabung</th></tr></thead>
  <tbody>
  @foreach($users as $user)
  <tr>
    <td>{{ $user->id }}</td>
    <td><strong>{{ $user->name }}</strong></td>
    <td>{{ $user->email }}</td>
    <td>@roleLabel($user->role->name ?? '-')</td>
    <td>{{ ucfirst($user->status ?? '-') }}</td>
    <td>{{ number_format($user->point->total_points ?? 0) }}</td>
    <td>{{ $user->created_at->format('d M Y') }}</td>
  </tr>
  @endforeach
  </tbody>
</table>
<div class="footer">© {{ date('Y') }} PT Wismilak Inti Makmur Tbk</div>
</body></html>

