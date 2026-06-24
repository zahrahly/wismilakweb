@extends('layouts.customer')

@section('title', 'Edit Feedback')

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

    /* Current image preview */
    .fb-current-img {
        display: flex; align-items: center; gap: 1rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .fb-current-img img {
        width: 70px; height: 70px;
        object-fit: cover; border-radius: 10px;
        border: 1px solid rgba(212,175,55,0.2);
    }
    .fb-current-img span {
        font-size: 0.8rem; color: rgba(245,235,224,0.4);
    }

    /* Buttons */
    .fb-actions {
        display: flex; gap: 1rem; margin-top: 0.5rem;
    }
    .fb-btn-save {
        flex: 2;
        display: inline-flex; align-items: center; justify-content: center; gap: 0.6rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #B8860B 0%, var(--gold) 50%, #F4D03F 100%);
        color: #0D0805; font-weight: 700; font-size: 0.8rem;
        letter-spacing: 0.1em; text-transform: uppercase;
        border: none; border-radius: 14px; cursor: pointer;
        transition: all 0.3s; position: relative; overflow: hidden;
    }
    .fb-btn-save::before {
        content: ''; position: absolute; top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }
    .fb-btn-save:hover::before { left: 100%; }
    .fb-btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212,175,55,0.35);
    }
    .fb-btn-cancel {
        flex: 1;
        display: inline-flex; align-items: center; justify-content: center;
        padding: 1rem;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px;
        color: rgba(245,235,224,0.6); font-weight: 600;
        font-size: 0.8rem; letter-spacing: 0.08em; text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s; cursor: pointer;
    }
    .fb-btn-cancel:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(255,255,255,0.2);
        color: var(--cream);
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
<div class="fb-container">
    <a href="{{ route('customer.event.feedback.show', $event->id) }}" class="fb-back">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Review
    </a>

    <h1 class="font-serif" style="font-size: 2.25rem; font-weight: 600; color: var(--cream); margin-bottom: 0.5rem;">
        Edit Review <em style="color: var(--gold);">Anda</em>
    </h1>
    <p style="color: rgba(245,235,224,0.5); font-size: 0.9rem; margin-bottom: 2rem;">
        Perbarui pengalaman Anda di <span style="color: var(--gold); font-weight: 600;">{{ $event->title }}</span>
    </p>

    <div class="fb-card">
        <form action="{{ route('customer.event.feedback.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- RATING --}}
            <div style="margin-bottom: 2rem;">
                <label class="fb-label">Rating Experience *</label>
                <div class="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" {{ old('rating', $feedback->rating) == $i ? 'checked' : '' }} required>
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
                <label for="comment" class="fb-label">Ulasan Detail</label>
                <textarea name="comment" id="comment" rows="5" class="fb-textarea" placeholder="Ceritakan pengalaman menarik Anda...">{{ old('comment', $feedback->comment) }}</textarea>
                @error('comment') <div class="fb-error">{{ $message }}</div> @enderror
            </div>

            <div class="fb-divider"></div>

            {{-- IMAGE UPLOAD --}}
            <div style="margin-bottom: 2.5rem;">
                <label class="fb-label">Foto Tambahan (Opsional)</label>

                @if($feedback->image)
                    <div class="fb-current-img">
                        <img src="{{ asset('storage/'.$feedback->image) }}" alt="Current Photo">
                        <div>
                            <div style="font-size: 0.85rem; color: var(--cream); font-weight: 500;">Foto saat ini</div>
                            <span>Upload baru untuk mengganti</span>
                        </div>
                    </div>
                @endif

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
                <button type="submit" class="fb-btn-save">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('customer.event.feedback.show', $event->id) }}" class="fb-btn-cancel">Batal</a>
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