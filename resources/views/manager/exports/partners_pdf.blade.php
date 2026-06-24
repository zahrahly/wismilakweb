<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kinerja Partner</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Kinerja Partner</h2>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Partner</th>
                <th>Email</th>
                <th class="text-center">Total Event</th>
                <th class="text-center">Total Peserta</th>
                <th class="text-right">Total Revenue (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($partners as $index => $partner)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $partner->name }}</strong></td>
                <td>{{ $partner->email }}</td>
                <td class="text-center">{{ number_format($partner->events_count) }}</td>
                <td class="text-center">{{ number_format($partner->total_participants) }}</td>
                <td class="text-right">{{ number_format($partner->total_revenue, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data partner.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
