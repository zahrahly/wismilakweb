@extends('layouts.admin')

@section('title', 'Detail Event')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.event.verification') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem;">← Kembali ke Verifikasi</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 1.5rem;">
    <!-- POSTER -->
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.5rem;">
        <h2 style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 1rem;">Poster Event</h2>
        <div style="display: flex; justify-content: center;">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                     style="max-width: 100%; max-height: 280px; object-fit: contain; border-radius: 8px;">
            @else
                <div style="width: 160px; height: 220px; border: 1px dashed var(--card-border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 0.85rem;">
                    Tidak ada poster
                </div>
            @endif
        </div>
    </div>

    <!-- INFO -->
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.5rem;">
        <h2 style="font-size: 1.1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">Informasi Event</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; font-size: 0.85rem;">
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Judul Event</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $event->title }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Lokasi</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $event->location }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Tanggal</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $event->date ? $event->date->format('d M Y, H:i') : '-' }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Status</div>
                @php
                    $sStyle = match($event->verification_status) {
                        'pending' => 'background:rgba(245,158,11,0.15);color:#F59E0B;',
                        'approved' => 'background:rgba(16,185,129,0.15);color:#10B981;',
                        'rejected' => 'background:rgba(231,76,76,0.15);color:#E74C4C;',
                        default => 'background:rgba(139,92,246,0.15);color:#8B5CF6;',
                    };
                @endphp
                <span style="padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; {{ $sStyle }}">
                    {{ ucfirst($event->verification_status ?? $event->status) }}
                </span>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Jenis & Harga</div>
                <div style="font-weight: 600; color: var(--text-primary);">
                    {{ $event->price_type === 'free' ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                </div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Kuota</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $event->quota }} orang</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Dibuat Oleh</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $event->creator?->name ?? '-' }}</div>
            </div>
            <div>
                <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Pendaftar</div>
                <div style="font-weight: 600; color: var(--text-primary);">{{ $event->registrations?->count() ?? 0 }} orang</div>
            </div>
        </div>

        <div style="margin-top: 1.25rem;">
            <div style="color: var(--text-secondary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Deskripsi</div>
            <p style="color: var(--text-primary); line-height: 1.6; font-size: 0.85rem;">{{ $event->description ?? '-' }}</p>
        </div>

        @if($event->rejection_reason)
        <div style="margin-top: 1.25rem; padding: 1rem; background: rgba(231,76,76,0.08); border: 1px solid rgba(231,76,76,0.2); border-radius: 8px;">
            <div style="color: #E74C4C; font-weight: 600; font-size: 0.8rem; margin-bottom: 0.25rem;">Alasan Penolakan</div>
            <p style="color: var(--text-secondary); font-size: 0.85rem;">{{ $event->rejection_reason }}</p>
        </div>
        @endif
    </div>
</div>

<!-- ACTIONS -->
<div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 1.5rem;">
    @if($event->verification_status === 'pending')
        <div style="display: flex; gap: 1rem; align-items: flex-end;">
            <form action="{{ route('admin.event.verify', $event) }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Terima event ini?')"
                    style="padding: 0.6rem 1.5rem; border-radius: 8px; background: rgba(16,185,129,0.9); color: #fff; border: none; cursor: pointer; font-weight: 600; font-size: 0.85rem;">
                    ✔ Verifikasi Event
                </button>
            </form>

            <form action="{{ route('admin.event.reject', $event) }}" method="POST" style="flex: 1; max-width: 500px;">
                @csrf
                <label style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-secondary) !important; display: block; margin-bottom: 0.4rem;">
                    Alasan Penolakan
                </label>
                <div style="display: flex; gap: 0.5rem;">
                    <textarea name="rejection_reason" required rows="2" placeholder="Jelaskan alasan penolakan..."
                        style="flex: 1; padding: 0.5rem 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; font-family: inherit; resize: vertical;"></textarea>
                    <button type="submit" onclick="return confirm('Tolak event ini?')"
                        style="padding: 0.6rem 1.25rem; border-radius: 8px; background: rgba(231,76,76,0.9); color: #fff; border: none; cursor: pointer; font-weight: 600; font-size: 0.85rem; white-space: nowrap; align-self: flex-end;">
                        ✖ Tolak
                    </button>
                </div>
            </form>
        </div>

    @elseif($event->verification_status === 'approved' && !in_array($event->status, ['published', 'completed', 'quota_full']))
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span style="padding: 0.5rem 1rem; border-radius: 8px; background: rgba(16,185,129,0.15); color: #10B981; font-weight: 600; font-size: 0.85rem;">
                ✓ Event sudah diverifikasi
            </span>
            <form action="{{ route('admin.event.publish', $event) }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Publish event ini?')"
                    style="padding: 0.6rem 1.5rem; border-radius: 8px; background: linear-gradient(135deg, var(--gold), #B8860B); color: #000; border: none; cursor: pointer; font-weight: 600; font-size: 0.85rem;">
                    Publish Event
                </button>
            </form>
        </div>

    @elseif(in_array($event->status, ['published', 'completed', 'quota_full']))
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span style="padding: 0.5rem 1rem; border-radius: 8px; background: rgba(16,185,129,0.15); color: #10B981; font-weight: 600; font-size: 0.85rem;">
                ✓ Event sudah dipublish
            </span>
            <form action="{{ route('admin.event.unpublish', $event) }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Sembunyikan/Hide event ini?')"
                    style="padding: 0.6rem 1.5rem; border-radius: 8px; background: rgba(255,255,255,0.05); color: var(--text-primary); border: 1px solid var(--card-border); cursor: pointer; font-weight: 600; font-size: 0.85rem;">
                    Hide Event
                </button>
            </form>
        </div>

    @else
        <span style="padding: 0.5rem 1rem; border-radius: 8px; background: rgba(231,76,76,0.15); color: #E74C4C; font-weight: 600; font-size: 0.85rem;">
            ✖ Event ditolak
        </span>
    @endif
</div>
@endsection
