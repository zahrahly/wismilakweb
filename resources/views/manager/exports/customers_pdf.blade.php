<!DOCTYPE html>
<html>
<head>
    <title>Laporan Demografi Customer</title>
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
        <h2>Laporan Demografi Customer</h2>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Cigar Member</th>
                <th>Email</th>
                <th class="text-center">Total Event (Paid)</th>
                <th class="text-center">Total Poin</th>
                <th>Terdaftar Sejak</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $customer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $customer->name }}</strong></td>
                <td>{{ $customer->email }}</td>
                <td class="text-center">{{ number_format($customer->event_registrations_count) }}</td>
                <td class="text-center">{{ number_format($customer->point->total_points ?? 0) }}</td>
                <td>{{ $customer->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data customer.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
