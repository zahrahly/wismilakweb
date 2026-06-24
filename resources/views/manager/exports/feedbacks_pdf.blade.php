<!DOCTYPE html>
<html>
<head>
    <title>Laporan Feedback</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Customer Feedback</h2>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Event</th>
                <th>Rating</th>
                <th>Foto</th>
                <th>Comment</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feedbacks as $index => $feedback)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $feedback->user->name ?? '-' }}</td>
                <td>{{ $feedback->event->title ?? '-' }}</td>
                <td>{{ $feedback->rating }} / 5</td>
                <td>
                    @if($feedback->image && file_exists(public_path('storage/' . $feedback->image)))
                        <img src="{{ public_path('storage/' . $feedback->image) }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $feedback->comment }}</td>
                <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada data feedback.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
