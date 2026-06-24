@extends('layouts.customer')

@section('title', 'Feedback — ' . $event->title)

@push('styles')
<style>
    .fb-container {
        max-width: 650px;
        margin: 2rem auto;
        padding: 0 1rem;
        animation: fadeUp 0.6s ease forwards;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fb-back {
        display: inline-flex; align-items: center; gap: 0.5rem;
        color: rgba(245,235,224,0.5); text-decoration: none;
        font-size: 0.85rem; margin-bottom: 1.5rem; transition: color 0.3s;
    }
    .fb-back:hover { color: var(--gold); }

    .fb-card {
        background: rgba(28, 15, 6, 0.6);
        border: 1px solid rgba(212, 175, 55, 0.12);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        position: relative;
        overflow: hidden;
    }
    .fb-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    .fb-label {
        display: block;
        font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.18em;
        color: var(--gold); margin-bottom: 0.75rem; font-weight: 700;
    }

    /* Star Rating */
    .star-rating {
        display: flex; flex-direction: row-reverse;
        justify-content: flex-end; gap: 0.4rem;
    }
    .star-rating input { display: none; }
    .star-rating label {
        cursor: pointer; color: rgba(255,255,255,0.08);
        transition: color 0.2s, transform 0.2s;
    }
    .star-rating label:hover { transform: scale(1.15); }
    .star-rating label svg { width: 36px; height: 36px; fill: currentColor; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: var(--gold);
    }

    /* Textarea */
    .fb-textarea {
        width: 100%;
        padding: 1rem 1.25rem;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px;
        color: var(--cream);
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        resize: vertical;
        min-height: 130px;
        transition: border-color 0.3s, box-shadow 0.3s;
        line-height: 1.7;
    }
    .fb-textarea::placeholder { color: rgba(245,235,224,0.25); }
    .fb-textarea:focus {
        outline: none;
        border-color: rgba(212,175,55,0.5);
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    /* File Upload Zone */
    .fb-upload-zone {
        border: 2px dashed rgba(212,175,55,0.2);
        border-radius: 14px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: rgba(255,255,255,0.02);
        position: relative;
    }
    .fb-upload-zone:hover,
    .fb-upload-zone.drag-over {
        border-color: rgba(212,175,55,0.5);
        background: rgba(212,175,55,0.05);
    }
    .fb-upload-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer;
    }
    .fb-upload-icon {
        width: 40px; height: 40px;
        margin: 0 auto 0.75rem;
        color: rgba(212,175,55,0.4);
    }
    .fb-upload-text {
        font-size: 0.85rem; color: rgba(245,235,224,0.5);
    }
    .fb-upload-text strong {
        color: var(--gold); font-weight: 600;
    }
    .fb-upload-hint {
        font-size: 0.7rem; color: rgba(245,235,224,0.25);
        margin-top: 0.5rem;
    }

    /* Points banner */
    .fb-points {
        display: flex; align-items: center; gap: 0.85rem;
        background: rgba(212,175,55,0.08);
        border: 1px solid rgba(212,175,55,0.2);
        padding: 1rem 1.25rem;
        border-radius: 14px;
        margin-bottom: 2rem;
    }
    .fb-points-icon {
        width: 42px; height: 42px;
        background: rgba(212,175,55,0.12);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .fb-points-text {
        color: var(--gold); font-weight: 600; font-size: 0.95rem;
    }
    .fb-points-sub {
        color: rgba(245,235,224,0.5); font-size: 0.75rem; margin-top: 0.15rem;
    }

    /* Buttons */
    .fb-actions {
        display: flex; gap: 1rem; margin-top: 0.5rem;
    }
    .fb-btn-submit {
        flex: 1;
        display: inline-flex; align-items: center; justify-content: center; gap: 0.6rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #B8860B 0%, var(--gold) 50%, #F4D03F 100%);
        color: #0D0805; font-weight: 700; font-size: 0.8rem;
        letter-spacing: 0.1em; text-transform: uppercase;
        border: none; border-radius: 14px; cursor: pointer;
        transition: all 0.3s; position: relative; overflow: hidden;
    }
    .fb-btn-submit::before {
        content: ''; position: absolute; top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }
    .fb-btn-submit:hover::before { left: 100%; }
    .fb-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212,175,55,0.35);
    }

    .fb-error { color: #EF4444; font-size: 0.75rem; margin-top: 0.5rem; }
    .fb-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.15), transparent);
        margin: 2rem 0;
    }
</style>
@endpush

@section('content')

@php
$ticketCount = \App\Models\Ticket::where('event_id', $event->id)
    ->where('user_id', auth()->id())
    ->whereHas('checkin')
    ->count();

$pointsPreview = $ticketCount * 15;
@endphp

<div class="fb-container">
    <a href="{{ route('customer.dashboard') }}" class="fb-back">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Dashboard
    </a>

    <h1 class="font-serif" style="font-size: 2.25rem; font-weight: 600; color: var(--cream); margin-bottom: 0.5rem;">
        Event <em style="color: var(--gold);">Feedback</em>
    </h1>
    <p style="color: rgba(245,235,224,0.5); font-size: 0.9rem; margin-bottom: 2rem;">
        Share your experience for <span style="color: var(--gold); font-weight: 600;">{{ $event->title }}</span>
    </p>

    <div class="fb-card">
        <form action="{{ route('customer.event.feedback.store', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- POINTS PREVIEW --}}
            <div class="fb-points">
                <div class="fb-points-icon">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="var(--gold)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/>
                    </svg>
                </div>
                <div>
                    <div class="fb-points-text">Reward Points: {{ $pointsPreview }} poin</div>
                    <div class="fb-points-sub">Poin diberikan berdasarkan jumlah tiket yang telah digunakan pada event ini.</div>
                </div>
            </div>

            {{-- RATING --}}
            <div style="margin-bottom: 2rem;">
                <label class="fb-label">Rating Experience *</label>
                <div class="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" {{ (old('rating') == $i || $i == 5) ? 'checked' : '' }} required>
                        <label for="star{{$i}}">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </label>
                    @endfor
                </div>
                @error('rating') <div class="fb-error">{{ $message }}</div> @enderror
            </div>

            <div class="fb-divider"></div>

            {{-- COMMENT --}}
            <div style="margin-bottom: 2rem;">
                <label for="comment" class="fb-label">Ulasan Detail (Opsional)</label>
                <textarea name="comment" id="comment" rows="5" class="fb-textarea" placeholder="Bagikan pengalaman Anda di event ini...">{{ old('comment') }}</textarea>
                @error('comment') <div class="fb-error">{{ $message }}</div> @enderror
            </div>

            <div class="fb-divider"></div>

            {{-- IMAGE UPLOAD --}}
            <div style="margin-bottom: 2.5rem;">
                <label class="fb-label">Foto Tambahan (Opsional)</label>

                <div class="fb-upload-zone" id="uploadZone">
                    <input type="file" name="image" id="image" accept="image/*">
                    <svg class="fb-upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div class="fb-upload-text" id="uploadText">
                        <strong>Klik untuk upload</strong> atau drag & drop
                    </div>
                    <div class="fb-upload-hint">JPG, PNG, GIF — Maksimal 2MB</div>
                </div>
                @error('image') <div class="fb-error">{{ $message }}</div> @enderror
            </div>

            {{-- ACTIONS --}}
            <div class="fb-actions">
                <button type="submit" class="fb-btn-submit">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Kirim Feedback
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // File upload UX
    const zone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('image');
    const uploadText = document.getElementById('uploadText');

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            uploadText.innerHTML = '<strong style="color:#10B981;">✓ ' + this.files[0].name + '</strong>';
        }
    });

    zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.classList.remove('drag-over');
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            uploadText.innerHTML = '<strong style="color:#10B981;">✓ ' + e.dataTransfer.files[0].name + '</strong>';
        }
    });
</script>
@endpush