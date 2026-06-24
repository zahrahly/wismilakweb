@extends('layouts.customer')

@section('title', 'Detail Feedback')

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

    .fb-section-label {
        font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.18em;
        color: var(--gold); margin-bottom: 0.6rem; font-weight: 700;
    }

    .fb-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.15), transparent);
        margin: 1.75rem 0;
    }

    /* Star display */
    .fb-stars {
        display: flex; align-items: center; gap: 0.5rem;
    }
    .fb-stars-icons {
        display: flex; gap: 3px; color: var(--gold);
    }
    .fb-stars-icons svg { width: 26px; height: 26px; }
    .fb-rating-badge {
        background: rgba(212,175,55,0.1);
        border: 1px solid rgba(212,175,55,0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 100px;
        font-size: 0.85rem; font-weight: 700;
        color: var(--gold); margin-left: 0.5rem;
    }

    /* Comment box */
    .fb-comment {
        background: rgba(255,255,255,0.03);
        padding: 1.25rem 1.5rem;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.05);
        font-size: 0.95rem; line-height: 1.8;
        color: var(--cream); font-style: italic;
        position: relative;
    }
    .fb-comment::before {
        content: '"'; position: absolute;
        top: -10px; left: 12px;
        font-size: 3rem; color: rgba(212,175,55,0.15);
        font-family: 'Crimson Pro', serif;
    }

    /* Image */
    .fb-image {
        max-width: 100%; border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        transition: transform 0.3s;
    }
    .fb-image:hover { transform: scale(1.02); }

    /* Points banner */
    .fb-points {
        display: flex; align-items: center; gap: 0.85rem;
        background: rgba(16,185,129,0.08);
        border: 1px solid rgba(16,185,129,0.2);
        padding: 1rem 1.25rem;
        border-radius: 14px;
    }
    .fb-points-icon {
        width: 42px; height: 42px;
        background: rgba(16,185,129,0.12);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .fb-points-text {
        color: #10B981; font-weight: 600; font-size: 0.95rem;
    }
    .fb-points-sub {
        color: rgba(16,185,129,0.6); font-size: 0.75rem; margin-top: 0.15rem;
    }

    /* Buttons */
    .fb-actions {
        display: flex; gap: 1rem; padding-top: 1.75rem;
        border-top: 1px solid rgba(255,255,255,0.05);
    }
    .fb-btn-edit {
        flex: 1;
        display: inline-flex; align-items: center; justify-content: center; gap: 0.6rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #B8860B 0%, var(--gold) 50%, #F4D03F 100%);
        color: #0D0805; font-weight: 700; font-size: 0.8rem;
        letter-spacing: 0.1em; text-transform: uppercase;
        border: none; border-radius: 14px;
        text-decoration: none; transition: all 0.3s;
        position: relative; overflow: hidden;
    }
    .fb-btn-edit::before {
        content: ''; position: absolute; top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }
    .fb-btn-edit:hover::before { left: 100%; }
    .fb-btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212,175,55,0.35);
    }
    .fb-btn-back {
        flex: 1;
        display: inline-flex; align-items: center; justify-content: center;
        padding: 1rem;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px;
        color: rgba(245,235,224,0.6); font-weight: 600;
        font-size: 0.8rem; letter-spacing: 0.08em; text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
    }
    .fb-btn-back:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(255,255,255,0.2);
        color: var(--cream);
    }
</style>
@endpush

@section('content')
<div class="fb-container">
    <a href="{{ route('customer.dashboard') }}" class="fb-back">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Dashboard
    </a>

    <h1 class="font-serif" style="font-size: 2.25rem; font-weight: 600; color: var(--cream); margin-bottom: 0.5rem;">
        Review <em style="color: var(--gold);">Anda</em>
    </h1>
    <p style="color: rgba(245,235,224,0.5); font-size: 0.9rem; margin-bottom: 2rem;">
        Terima kasih telah berbagi pengalaman Anda bersama Wismilak.
    </p>

    <div class="fb-card">
        {{-- EVENT TITLE --}}
        <div style="margin-bottom: 1.75rem;">
            <div class="fb-section-label">Event</div>
            <h2 class="font-serif" style="color: var(--gold); font-weight: 600; font-size: 1.3rem; line-height: 1.4;">
                {{ $event->title }}
            </h2>
        </div>

        <div class="fb-divider"></div>

        {{-- RATING --}}
        <div style="margin-bottom: 1.75rem;">
            <div class="fb-section-label">Rating Experience</div>
            <div class="fb-stars">
                <div class="fb-stars-icons">
                    @for($i = 1; $i <= 5; $i++)
                        <svg viewBox="0 0 24 24" fill="{{ $i <= $feedback->rating ? 'currentColor' : 'none' }}" stroke="{{ $i <= $feedback->rating ? 'none' : 'rgba(255,255,255,0.12)' }}" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @endfor
                </div>
                <span class="fb-rating-badge">{{ $feedback->rating }}/5</span>
            </div>
        </div>

        {{-- COMMENT --}}
        @if($feedback->comment)
        <div class="fb-divider"></div>
        <div style="margin-bottom: 1.75rem;">
            <div class="fb-section-label">Ulasan</div>
            <div class="fb-comment">
                {{ $feedback->comment }}
            </div>
        </div>
        @endif

        {{-- IMAGE --}}
        @if($feedback->image)
        <div class="fb-divider"></div>
        <div style="margin-bottom: 1.75rem;">
            <div class="fb-section-label">Foto Attachment</div>
            <img src="{{ asset('storage/'.$feedback->image) }}" alt="Feedback Photo" class="fb-image">
        </div>
        @endif

        <div class="fb-divider"></div>

        {{-- POINT INFO --}}
        <div class="fb-points" style="margin-bottom: 1.75rem;">
            <div class="fb-points-icon">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#10B981">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/>
                </svg>
            </div>
            <div>
                <div class="fb-points-text">+{{ $feedback->points_awarded }} Poin didapatkan</div>
                <div class="fb-points-sub">Dari review event ini</div>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="fb-actions">
            <a href="{{ route('customer.event.feedback.edit', $event->id) }}" class="fb-btn-edit">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Review
            </a>
            <a href="{{ route('customer.dashboard') }}" class="fb-btn-back">Kembali</a>
        </div>
    </div>
</div>
@endsection