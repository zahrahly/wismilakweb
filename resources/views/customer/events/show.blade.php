@extends('layouts.customer')

@section('title', $event->title . ' - Wismilak Experiences')

@push('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<style>
/* ── CORE DESIGN VARIABLES ── */
:root {
    --vip-black: #060504;
    --vip-choc: #120e0a;
    --vip-choc-light: #1c1510;
    --vip-gold: #d4af37;
    --vip-gold-dim: rgba(212, 175, 55, 0.4);
    --vip-cream: #f4f1eb;
    --vip-text: #a8a096;
    --vip-border: rgba(212, 175, 55, 0.15);
    --serif: 'Playfair Display', serif;
    --sans: 'Inter', sans-serif;
}

body {
    background-color: var(--vip-black) !important;
    color: var(--vip-text);
    font-family: var(--sans);
    overflow-x: hidden;
}

/* ── TYPOGRAPHY ── */
.serif-heading { font-family: var(--serif); color: var(--vip-cream); line-height: 1.1; }
.text-massive { font-size: clamp(2.5rem, 6vw, 5rem); }
.text-gold { color: var(--vip-gold); }
.editorial-label { 
    text-transform: uppercase; letter-spacing: 0.3em; font-size: 0.75rem; 
    color: var(--vip-gold); font-weight: 600; display: inline-flex; align-items: center; gap: 1rem; 
}
.editorial-label::before, .editorial-label::after { 
    content: ''; display: block; width: 30px; height: 1px; background: var(--vip-gold); 
}

/* ── BUTTONS ── */
.btn-luxury {
    display: inline-flex; align-items: center; justify-content: center; width: 100%;
    background: transparent; border: 1px solid var(--vip-gold);
    color: var(--vip-gold); text-transform: uppercase; letter-spacing: 0.2em;
    font-size: 0.8rem; font-weight: 600; padding: 1.2rem 2rem; text-decoration: none;
    transition: all 0.4s ease; position: relative; overflow: hidden; cursor: pointer;
}
.btn-luxury::before {
    content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
    background: var(--vip-gold); transition: all 0.4s ease; z-index: -1;
}
.btn-luxury:hover { color: var(--vip-black); }
.btn-luxury:hover::before { left: 0; }

.btn-luxury-outline {
    display: inline-flex; align-items: center; justify-content: center; width: 100%;
    background: transparent; border: 1px solid var(--vip-border);
    color: var(--vip-text); text-transform: uppercase; letter-spacing: 0.2em;
    font-size: 0.8rem; font-weight: 600; padding: 1.2rem 2rem; text-decoration: none;
    transition: all 0.4s ease;
}
.btn-luxury-outline:hover { border-color: var(--vip-gold); color: var(--vip-gold); }

/* ── HERO SECTION ── */
.vip-hero {
    height: 80vh; position: relative; display: flex; flex-direction: column; 
    align-items: center; justify-content: flex-end; text-align: center; 
    padding-bottom: 5rem; overflow: hidden; background: var(--vip-black);
}
.hero-bg-wrapper {
    position: absolute; inset: -50px; z-index: 0;
}
.hero-img {
    width: 100%; height: 100%; object-fit: cover; filter: grayscale(30%); opacity: 0.6;
}
.hero-overlay {
    position: absolute; inset: 0; z-index: 1;
    background: linear-gradient(to bottom, rgba(6,5,4,0.1) 0%, rgba(6,5,4,0.8) 60%, rgba(6,5,4,1) 100%);
}
.hero-content {
    position: relative; z-index: 2; max-width: 1000px; padding: 0 2rem;
}

/* ── CONTENT SPLIT ── */
.vip-container {
    max-width: 1400px; margin: 0 auto; padding: 5vw 4vw 10vw 4vw;
    display: grid; grid-template-columns: 1fr 400px; gap: 6rem;
}

/* ── LEFT: THE EXPERIENCE ── */
.experience-content {
    font-family: var(--serif); font-size: 1.25rem; line-height: 2; color: var(--vip-cream);
}
.experience-content p { margin-bottom: 2.5rem; }
.experience-content::first-letter {
    color: var(--vip-gold); font-size: 5rem; line-height: 0.8; float: left;
    margin: 0.2rem 0.8rem 0 0; text-transform: uppercase;
}

/* ── RIGHT: CONCIERGE DESK ── */
.concierge-desk {
    position: sticky; top: 120px;
    background: var(--vip-choc); border: 1px solid var(--vip-border);
    padding: 3rem; display: flex; flex-direction: column; gap: 2.5rem;
}
.desk-label {
    font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.2em;
    color: var(--vip-text); margin-bottom: 0.5rem;
}
.desk-value {
    font-family: var(--serif); font-size: 1.2rem; color: var(--vip-gold);
}
.desk-item { border-bottom: 1px solid var(--vip-border); padding-bottom: 1.5rem; }
.desk-item:last-of-type { border-bottom: none; padding-bottom: 0; }

/* ── STATUS BADGES ── */
.status-badge {
    padding: 1rem; text-align: center; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.75rem;
    border: 1px solid; margin-top: 1rem;
}
.status-badge.sold-out { border-color: #A05252; color: #A05252; background: rgba(160, 82, 82, 0.1); }
.status-badge.ended { border-color: var(--vip-text); color: var(--vip-text); background: rgba(168, 160, 150, 0.1); }
.status-badge.success { border-color: #4CAF50; color: #4CAF50; background: rgba(76, 175, 80, 0.1); }
.status-badge.error { border-color: #A05252; color: #A05252; background: rgba(160, 82, 82, 0.1); }

/* ── PRIVILEGES MENU ── */
.privilege-list {
    list-style: none; padding: 0; margin: 0;
}
.privilege-list li {
    font-size: 0.9rem; color: var(--vip-cream); margin-bottom: 0.8rem;
    display: flex; align-items: flex-start; gap: 0.8rem;
}
.privilege-list li::before {
    content: '✦'; color: var(--vip-gold); font-size: 0.8rem; margin-top: 2px;
}

@media (max-width: 1024px) {
    .vip-container { grid-template-columns: 1fr; gap: 4rem; }
    .concierge-desk { position: relative; top: 0; padding: 2rem; }
    .vip-hero { height: 60vh; }
}
</style>
@endpush

@section('content')

{{-- ── 1. DIGITAL INVITATION HERO ── --}}
<section class="vip-hero">
    <div class="hero-bg-wrapper">
        <img src="{{ asset('storage/'.$event->image) }}" class="hero-img" alt="{{ $event->title }}">
    </div>
    <div class="hero-overlay"></div>
    
    <div class="hero-content">
        <div class="reveal-element" style="margin-bottom: 2rem;">
            <span class="editorial-label">Official Invitation</span>
        </div>
        <h1 class="serif-heading text-massive reveal-element">
            {{ $event->title }}
        </h1>
        <div class="reveal-element" style="margin-top: 1.5rem; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--vip-text);">
            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }} — {{ $event->location }}
        </div>
    </div>
</section>

{{-- ── 2. ASYMMETRICAL CONTENT SPLIT ── --}}
<section style="background: var(--vip-black);">
    <div class="vip-container">

        {{-- LEFT: THE EXPERIENCE (DESCRIPTION) --}}
        <div class="experience-content reveal-scroll">
            <h2 class="serif-heading" style="font-size: 2.5rem; margin-bottom: 2rem;">The Experience</h2>
            <p>
                {{ $event->description }}
            </p>
        </div>

        {{-- RIGHT: THE CONCIERGE DESK (SIDEBAR) --}}
        <div>
            <div class="concierge-desk reveal-scroll">
                
                {{-- Date & Time --}}
                <div class="desk-item">
                    <div class="desk-label">Date & Time</div>
                    <div class="desk-value">
                        {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                        @if($event->start_time)
                            <br><span style="font-size: 0.9rem; color: var(--vip-cream); font-family: var(--sans);">{{ $event->start_time }} @if($event->end_time) — {{ $event->end_time }} @endif</span>
                        @endif
                    </div>
                </div>

                {{-- Location --}}
                <div class="desk-item">
                    <div class="desk-label">Location</div>
                    <div class="desk-value" style="font-size: 1rem; color: var(--vip-cream); font-family: var(--sans);">
                        @if($event->outlets->count())
                            @foreach($event->outlets as $outlet)
                                <div>{{ $outlet->name }}</div>
                                @if($outlet->pivot?->location_detail)
                                    <div style="font-size: 0.85rem; color: var(--vip-text);">{{ $outlet->pivot->location_detail }}</div>
                                @endif
                            @endforeach
                        @else
                            {{ $event->location }}
                        @endif
                    </div>
                </div>

                {{-- Privileges --}}
                @if($event->packages->count())
                <div class="desk-item">
                    <div class="desk-label">VIP Privileges</div>
                    <ul class="privilege-list">
                        @foreach($event->packages as $package)
                            <li>{{ $package->title }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Access / Price --}}
                <div class="desk-item">
                    <div class="desk-label">Access</div>
                    <div class="desk-value">
                        @if($event->price_type == 'free')
                            Complimentary
                        @else
                            Rp {{ number_format($event->price) }}
                        @endif
                    </div>
                    <div style="font-size: 0.75rem; color: var(--vip-text); margin-top: 0.5rem;">
                        {{ $event->computed_remaining_quota }} / {{ $event->quota }} Invitations Remaining
                    </div>
                </div>

                {{-- Contact Person --}}
                @if($event->contact_person_name)
                <div class="desk-item">
                    <div class="desk-label">Concierge Contact</div>
                    <div style="color: var(--vip-cream); font-size: 0.9rem;">
                        {{ $event->contact_person_name }}
                        @if($event->contact_person_phone)
                            <br><span style="color: var(--vip-gold);">{{ $event->contact_person_phone }}</span>
                        @endif
                    </div>
                </div>
                @endif

                {{-- ALERTS --}}
                @if(session('success'))
                    <div class="status-badge success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="status-badge error">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- CTA REGISTRATION LOGIC --}}
                <div style="margin-top: 1rem;">
                    @php $publicStatus = $event->public_status; @endphp

                    @if($publicStatus === 'Event Passed')
                        <div class="status-badge ended">Event Concluded</div>
                    @elseif($publicStatus === 'Full')
                        <div class="status-badge sold-out">Fully Booked</div>
                    @else
                        
                        @guest
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn-luxury">
                                    Login to Request
                                </a>
                                <a href="{{ route('register', ['redirect' => url()->current()]) }}" class="btn-luxury-outline">
                                    Create Account
                                </a>
                            </div>
                        @endguest

                        @auth
                            <a href="{{ route('event.register', $event) }}" class="btn-luxury">
                                Request Invitation
                            </a>
                        @endauth

                    @endif
                </div>

            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- GSAP ANIMATIONS ---
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            // Parallax Hero
            gsap.to(".hero-img", {
                yPercent: 15,
                ease: "none",
                scrollTrigger: {
                    trigger: ".vip-hero",
                    start: "top top",
                    end: "bottom top",
                    scrub: true
                }
            });

            // Hero Text Fade
            gsap.from(".reveal-element", {
                y: 40, opacity: 0, duration: 1.5, stagger: 0.2, ease: "power3.out", delay: 0.2
            });

            // Standard Scroll Reveals
            document.querySelectorAll('.reveal-scroll').forEach(el => {
                gsap.from(el, {
                    y: 40, opacity: 0, duration: 1.2, ease: "power3.out",
                    scrollTrigger: {
                        trigger: el, start: "top 85%", toggleActions: "play none none none"
                    }
                });
            });
        }
    });
</script>
@endpush
