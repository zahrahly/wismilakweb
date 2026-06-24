@extends('layouts.admin')

@section('title', 'Feedback Intelligence')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseGlow {
        0%, 100% { opacity: 0.2; transform: scale(1); }
        50% { opacity: 0.35; transform: scale(1.05); }
    }
    .animate-in {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .premium-card-detail {
        background: rgba(26, 26, 37, 0.65);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4), inset 0 0 30px rgba(255, 255, 255, 0.01);
        position: relative;
    }
    .glowing-bg-circle {
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0) 70%);
        filter: blur(40px);
        pointer-events: none;
        z-index: 0;
        animation: pulseGlow 8s infinite ease-in-out;
    }
    .ticket-stub {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(212, 175, 55, 0.2);
        padding: 1.5rem;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .ticket-stub:hover {
        border-color: var(--gold);
        background: rgba(212, 175, 55, 0.03);
        transform: translateY(-2px);
    }
    .ticket-stub::before, .ticket-stub::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        background: #13131A; /* matches --body-bg */
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }
    .ticket-stub::before { left: -9px; }
    .ticket-stub::after { right: -9px; }
    
    .rating-giant {
        font-family: 'Crimson Pro', serif;
        font-size: 5.5rem;
        font-weight: 700;
        line-height: 1;
        background: linear-gradient(135deg, #FFF 30%, var(--gold) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .feedback-bubble {
        background: rgba(255, 255, 255, 0.015);
        border: 1px solid rgba(255, 255, 255, 0.04);
        padding: 2.5rem;
        border-radius: 20px;
        font-size: 1.15rem;
        line-height: 1.8;
        color: #f3f3f6;
        font-style: italic;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.02);
    }
    .star-glow {
        filter: drop-shadow(0 0 6px rgba(212, 175, 55, 0.5));
    }
</style>
@endpush

@section('content')
<div style="max-width: 1050px; margin: 0 auto; position: relative;">
    
    <!-- Glow effects in background -->
    <div class="glowing-bg-circle" style="top: -50px; right: -50px; background: radial-gradient(circle, rgba(212, 175, 55, 0.12) 0%, rgba(212, 175, 55, 0) 70%);"></div>
    <div class="glowing-bg-circle" style="bottom: -100px; left: -100px; background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0) 70%);"></div>

    <div class="animate-in" style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1;">
        <a href="{{ route('admin.feedback.index') }}" class="btn-premium" style="background: rgba(255,255,255,0.03); color: var(--text-primary) !important; padding: 0.6rem 1.25rem; font-size: 0.75rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.06);">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            KEMBALI KE ANALISIS
        </a>
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <span class="badge-premium" style="background: rgba(16,185,129,0.08); color: var(--green); border: 1px solid rgba(16,185,129,0.2); padding: 5px 12px; border-radius: 12px; font-size: 0.65rem;">VERIFIED REVIEW</span>
            <div style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600; background: rgba(255,255,255,0.03); padding: 5px 12px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                ID: #FB-{{ str_pad($feedback->id, 5, '0', STR_PAD_LEFT) }}
            </div>
        </div>
    </div>

    <div class="premium-card-detail animate-in" style="animation-delay: 0.05s; z-index: 1;">
        <div style="padding: 2.5rem 3rem;">
            
            <!-- Profile Banner -->
            <div style="display: flex; align-items: center; gap: 2.5rem; margin-bottom: 3rem; padding-bottom: 2.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); position: relative; flex-wrap: wrap;">
                @php
                    $name = $feedback->user->name ?? 'Anonymous';
                    $initials = '';
                    $words = explode(' ', $name);
                    foreach($words as $w) $initials .= strtoupper(substr($w, 0, 1));
                    $initials = substr($initials, 0, 2);
                    
                    $colors = ['#D4AF37', '#E74C4C', '#3B82F6', '#10B981', '#8B5CF6', '#F59E0B'];
                    $bgColor = $colors[ord(substr($name, 0, 1)) % count($colors)];
                @endphp
                
                <div style="position: relative;">
                    <div style="width: 84px; height: 84px; border-radius: 20px; background: {{ $bgColor }}; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: #fff; box-shadow: 0 10px 25px {{ $bgColor }}33; border: 3px solid rgba(255,255,255,0.15);">
                        {{ $initials }}
                    </div>
                    <div style="position: absolute; right: -4px; bottom: -4px; background: var(--green); width: 22px; height: 22px; border-radius: 50%; border: 3px solid #1c1c25; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                    </div>
                </div>

                <div style="flex: 1; min-width: 250px;">
                    <div style="font-size: 0.7rem; color: var(--gold); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 800; margin-bottom: 0.4rem;">Customer Profile</div>
                    <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.3rem; font-family: 'Crimson Pro', serif; letter-spacing: -0.01em;">{{ $name }}</h2>
                    <div style="display: flex; gap: 1.25rem; align-items: center; flex-wrap: wrap;">
                        <div style="font-size: 0.9rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.7;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $feedback->user->email ?? '-' }}
                        </div>
                        <div style="width: 1px; height: 12px; background: rgba(255,255,255,0.1); display: inline-block;"></div>
                        <div style="font-size: 0.85rem; color: var(--text-secondary);">Member sejak {{ $feedback->user->created_at->format('M Y') }}</div>
                    </div>
                </div>

                <!-- Event Stub -->
                <div class="ticket-stub" style="min-width: 280px;">
                    <div style="font-size: 0.65rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.4rem;">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        ASSOCIATED EVENT
                    </div>
                    <div style="font-size: 1.15rem; font-weight: 700; color: var(--gold); font-family: 'Crimson Pro', serif; line-height: 1.3;">{{ $feedback->event->title ?? '-' }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.4rem; font-weight: 500;">
                        Tanggal: {{ $feedback->event->start_date ? \Carbon\Carbon::parse($feedback->event->start_date)->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1.6fr; gap: 3.5rem;" class="grid-layout">
                
                <!-- Left: Score & Integrity -->
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    
                    <!-- Score Box -->
                    <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.03); border-radius: 20px; padding: 2rem; position: relative;">
                        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 800; margin-bottom: 1.25rem;">EXPERIENCE SCORE</div>
                        
                        <div style="display: flex; align-items: flex-end; gap: 0.5rem; margin-bottom: 1rem;">
                            <span class="rating-giant">{{ $feedback->rating }}</span>
                            <span style="font-size: 1.5rem; color: var(--text-secondary); font-weight: 500; padding-bottom: 0.8rem;">/ 5.0</span>
                        </div>
                        
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; gap: 4px; margin-bottom: 0.75rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $feedback->rating)
                                        <svg class="star-glow" width="22" height="22" viewBox="0 0 24 24" fill="var(--gold)">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @else
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.1)" stroke-width="1.5">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            
                            <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-primary); text-transform: uppercase; letter-spacing: 0.08em; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <span style="width: 6px; height: 6px; background: {{ $feedback->rating >= 4 ? 'var(--green)' : ($feedback->rating >= 3 ? 'var(--gold)' : 'var(--red)') }}; border-radius: 50%;"></span>
                                @if($feedback->rating == 5) Exceptional Experience
                                @elseif($feedback->rating == 4) Highly Satisfactory
                                @elseif($feedback->rating == 3) Standard Quality
                                @elseif($feedback->rating == 2) Needs Improvement
                                @else Critical Attention Required
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Integrity Info -->
                    <div style="padding: 1.75rem; background: linear-gradient(135deg, rgba(212, 175, 55, 0.06), rgba(212, 175, 55, 0.01)); border-radius: 20px; border: 1px solid var(--gold-dim); position: relative; overflow: hidden;">
                        <div style="position: absolute; right: -8px; top: -8px; opacity: 0.04; color: var(--gold);">
                            <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        </div>
                        <div style="font-size: 0.75rem; font-weight: 800; color: var(--gold); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center; gap: 0.4rem;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            DATA INTEGRITY
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.6; margin: 0;">Waktu submit tercatat otomatis. Identitas pengguna divalidasi via secure token otentikasi. Feedback merefleksikan sentimen murni peserta event.</p>
                    </div>
                </div>

                <!-- Right: Qualitative Feedback & Image -->
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    
                    <!-- Feedback Bubble -->
                    <div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 800; margin-bottom: 1rem;">QUALITATIVE FEEDBACK</div>
                        <div class="feedback-bubble">
                            <svg style="position: absolute; left: 1.25rem; top: 1.25rem; opacity: 0.08; color: var(--gold);" width="50" height="50" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                            <div style="position: relative; z-index: 1;">
                                "{{ $feedback->comment ?? 'Tidak ada komentar ulasan tertulis yang diberikan.' }}"
                            </div>
                        </div>
                    </div>

                    <!-- Image attachment if exists -->
                    @if($feedback->image)
                    <div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 800; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.4rem;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            UPLOADED IMAGE ATTACHMENT
                        </div>
                        <div style="border-radius: 20px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.08); background: rgba(0, 0, 0, 0.25); max-width: 100%; text-align: center; position: relative;">
                            <a href="{{ asset('storage/' . $feedback->image) }}" target="_blank" title="Klik untuk perbesar gambar" style="display: block; cursor: zoom-in;">
                                <img src="{{ asset('storage/' . $feedback->image) }}" alt="Feedback Attachment" style="max-width: 100%; max-height: 380px; object-fit: contain; display: block; margin: 0 auto; transition: all 0.4s ease;" onmouseover="this.style.transform='scale(1.015)';" onmouseout="this.style.transform='scale(1)';">
                                <div style="position: absolute; right: 12px; bottom: 12px; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(10px); padding: 6px 12px; border-radius: 30px; font-size: 0.7rem; color: #fff; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; border: 1px solid rgba(255,255,255,0.1);">
                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                    ZOOM IMAGE
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Submit date -->
                    <div style="display: flex; justify-content: flex-end; align-items: center; font-size: 0.8rem; color: var(--text-secondary); gap: 0.4rem; margin-top: auto; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 1.25rem;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.7;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Dikirimkan {{ $feedback->created_at->diffForHumans() }} ({{ $feedback->created_at->format('d M Y, H:i') }})
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
@endsection