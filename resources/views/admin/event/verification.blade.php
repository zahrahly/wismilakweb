@extends('layouts.admin')

@section('title', 'Verifikasi Event')

@section('content')
<div style="margin-bottom: 2.5rem;">
    <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Antrian Verifikasi</h1>
    <p style="color: var(--text-secondary); font-size: 0.9rem;">Review dan publikasikan event eksklusif dari para partner.</p>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Detail Event</th>
                <th style="text-align: center;">Jadwal</th>
                <th style="text-align: center;">Partner</th>
                <th style="text-align: center;">Status Verifikasi</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td style="padding: 1.25rem 2rem;">
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">{{ $event->title }}</div>
                    <div style="font-size: 0.75rem; color: var(--gold); margin-top: 4px; font-weight: 500;">
                        {{ $event->price_type === 'free' ? 'Complementary' : 'IDR ' . number_format($event->price, 0, ',', '.') }}
                        &bull; {{ $event->quota }} Slots
                    </div>
                </td>
                <td style="text-align: center;">
                    <div style="font-size: 0.85rem; color: var(--text-primary);">{{ $event->date ? $event->date->format('d M Y') : '-' }}</div>
                </td>
                <td style="text-align: center;">
                    <div style="font-size: 0.85rem; color: var(--text-secondary); font-weight: 500;">{{ $event->creator?->name ?? '-' }}</div>
                </td>
                <td style="text-align: center;">
                    @php
                        $badgeStyle = match($event->verification_status) {
                            'pending' => 'border: 1px solid rgba(245,158,11,0.3); color: #F59E0B;',
                            'approved' => 'border: 1px solid rgba(16,185,129,0.3); color: #10B981;',
                            'rejected' => 'border: 1px solid rgba(231,76,76,0.3); color: #E74C4C;',
                            default => 'border: 1px solid var(--card-border); color: var(--text-secondary);',
                        };
                    @endphp
                    <span class="badge-premium" style="{{ $badgeStyle }}">
                        {{ match($event->verification_status) {
                            'pending' => ($event->status === 'resubmitted' ? 'RESUBMITTED' : 'WAITING REVIEW'),
                            'approved' => 'APPROVED',
                            'rejected' => 'REJECTED',
                            default => strtoupper($event->verification_status ?? $event->status),
                        } }}
                    </span>
                </td>
                <td style="padding: 1.25rem 2rem; text-align: right;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.event.detail', $event) }}" class="table-action-btn btn-gold" title="View Detail">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>

                        @if($event->verification_status === 'pending')
                            <form action="{{ route('admin.event.verify', $event) }}" method="POST" class="table-action-form">
                                @csrf
                                <button type="submit" onclick="return confirm('Terima event ini?')" class="table-action-btn btn-green" title="Approve">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $event->id }}, '{{ addslashes($event->title) }}')" class="table-action-btn btn-red" title="Reject">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        @elseif($event->verification_status === 'approved' && !in_array($event->status, ['published', 'completed', 'quota_full']))
                            <form action="{{ route('admin.event.publish', $event) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" onclick="return confirm('Publish event ini?')" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem;">
                                    PUBLISH
                                </button>
                            </form>
                        @elseif(in_array($event->status, ['published', 'completed', 'quota_full']))
                            <form action="{{ route('admin.event.unpublish', $event) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" onclick="return confirm('Sembunyikan/Hide event ini?')" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: rgba(255,255,255,0.05); color: var(--text-primary) !important; border: 1px solid var(--card-border);">
                                    HIDE
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1rem; opacity: 0.2;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p>Tidak ada event yang menunggu verifikasi.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- REJECT MODAL -->
<div id="rejectModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.8); z-index:100; display:none; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 2.5rem; max-width: 480px; width: 90%; margin: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
        <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Tolak Event</h3>
        <p id="rejectEventTitle" style="font-size: 0.9rem; color: var(--gold); margin-bottom: 2rem;"></p>

        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-secondary); display: block; margin-bottom: 0.75rem;">
                    Alasan Penolakan
                </label>
                <textarea name="rejection_reason" required rows="4" placeholder="Berikan alasan yang jelas untuk partner..."
                    style="width: 100%; padding: 1rem; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 12px; color: var(--text-primary); font-size: 0.9rem; resize: none; font-family: inherit; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='var(--gold-dim)'" onblur="this.style.borderColor='var(--card-border)'"
                ></textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="closeRejectModal()" style="padding: 0.75rem 1.5rem; border-radius: 10px; border: 1px solid var(--card-border); background: transparent; color: var(--text-secondary); cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                    Batal
                </button>
                <button type="submit" style="padding: 0.75rem 1.5rem; border-radius: 10px; border: none; background: var(--red); color: #fff; cursor: pointer; font-weight: 700; font-size: 0.85rem;">
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openRejectModal(eventId, eventTitle) {
    document.getElementById('rejectModal').style.display = 'block';
    document.getElementById('rejectEventTitle').textContent = eventTitle;
    document.getElementById('rejectForm').action = '/admin/event/' + eventId + '/reject';
}
function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endpush
@endsection
