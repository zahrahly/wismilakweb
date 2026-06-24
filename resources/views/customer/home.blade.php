@extends('layouts.customer')

@section('title', 'Home')

@push('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        /* ═══ HERO SECTION ═══ */
        #hero {
            position: relative;
            height: 100vh;
            min-height: 700px;
            display: flex;
            align-items: stretch;
            overflow: hidden;
            background: #080402;
        }

        /* Background image with Ken Burns */
        .hero__bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.55) contrast(1.1) saturate(0.85);
            animation: heroKenBurns 28s ease-in-out infinite alternate;
            will-change: transform;
        }

        /* Layered overlays for depth */
        .hero__overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background:
                linear-gradient(105deg, rgba(8,4,2,0.92) 0%, rgba(8,4,2,0.6) 40%, rgba(8,4,2,0.15) 70%, rgba(8,4,2,0.4) 100%),
                linear-gradient(to top, rgba(8,4,2,1) 0%, transparent 18%),
                linear-gradient(to bottom, rgba(8,4,2,0.6) 0%, transparent 12%);
        }

        /* Particle canvas */
        #particles {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
        }

        /* Main content container */
        .hero__inner {
            position: relative;
            z-index: 3;
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 3rem 6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
        }
        .hero__copy {
            max-width: 720px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Eyebrow — simple line + text, no pill badge */
        .hero__eyebrow {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-bottom: 2.8rem;
            opacity: 0;
            animation: heroFadeUp 0.9s 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .hero__eyebrow-line {
            width: 48px;
            height: 1px;
            background: var(--gold);
            flex-shrink: 0;
        }
        .hero__eyebrow-text {
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.35em;
            color: var(--gold);
            text-transform: uppercase;
        }

        /* Title — editorial asymmetric weight */
        .hero__title {
            font-family: 'Crimson Pro', serif;
            font-size: clamp(3.2rem, 6.5vw, 5.8rem);
            font-weight: 300;
            line-height: 1.04;
            color: var(--cream);
            letter-spacing: -0.025em;
            margin: 0 0 0.4rem 0;
        }
        .hero__title-line {
            display: block;
            overflow: hidden;
        }
        .hero__title-line span {
            display: block;
            opacity: 0;
            transform: translateY(105%);
        }
        .hero__title-line:nth-child(1) span {
            animation: heroSlideUp 1.1s 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .hero__title-line:nth-child(2) span {
            animation: heroSlideUp 1.1s 0.65s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .hero__title em {
            font-weight: 400;
            font-style: italic;
            color: var(--gold);
        }

        /* Subtitle */
        .hero__subtitle {
            font-family: 'Crimson Pro', serif;
            font-size: clamp(1.1rem, 2vw, 1.5rem);
            font-weight: 300;
            font-style: italic;
            color: var(--gold);
            letter-spacing: 0.02em;
            margin-bottom: 2.4rem;
            opacity: 0;
            animation: heroFadeUp 1s 0.85s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* Description */
        .hero__desc {
            font-size: 1.05rem;
            font-weight: 300;
            line-height: 1.8;
            color: rgba(245, 235, 224, 0.65);
            max-width: 560px;
            margin-bottom: 2.8rem;
            text-align: center;
            opacity: 0;
            animation: heroFadeUp 1s 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* Action buttons — sharp, no border-radius */
        .hero__actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.8rem;
            opacity: 0;
            animation: heroFadeUp 1s 1.15s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .hero__btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            padding: 1rem 2.6rem;
            background: var(--gold);
            color: #080402;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .hero__btn-primary:hover {
            background: var(--cream);
            color: #080402;
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.25);
        }
        .hero__btn-outline {
            display: inline-flex;
            align-items: center;
            padding: 1rem 2.6rem;
            background: transparent;
            color: rgba(245, 235, 224, 0.7);
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            text-decoration: none;
            border: 1px solid rgba(245, 235, 224, 0.15);
            transition: all 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .hero__btn-outline:hover {
            color: var(--gold);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        /* Right side — editorial image peek */
        .hero__visual {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 42%;
            z-index: 2;
            overflow: hidden;
            clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%);
            opacity: 0;
            animation: heroVisualIn 1.6s 0.3s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .hero__visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7) contrast(1.05) saturate(0.9);
            transition: transform 8s ease;
        }
        .hero__visual:hover img {
            transform: scale(1.04);
        }
        .hero__visual-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to left, transparent 60%, rgba(8,4,2,1) 100%),
                linear-gradient(to top, rgba(8,4,2,0.7) 0%, transparent 30%);
            pointer-events: none;
        }

        /* Scroll indicator — minimal */
        .hero__scroll {
            position: absolute;
            bottom: 2.5rem;
            left: 5rem;
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            text-decoration: none;
            opacity: 0;
            animation: heroFadeUp 0.8s 1.6s ease forwards;
        }
        .hero__scroll-line {
            width: 40px;
            height: 1px;
            background: rgba(245, 235, 224, 0.2);
            position: relative;
            overflow: hidden;
        }
        .hero__scroll-line::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 12px;
            height: 1px;
            background: var(--gold);
            animation: heroScrollPulse 2.5s ease-in-out infinite;
        }
        .hero__scroll-text {
            font-size: 0.6rem;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: rgba(245, 235, 224, 0.3);
            font-weight: 500;
            transition: color 0.3s;
        }
        .hero__scroll:hover .hero__scroll-text {
            color: var(--gold);
        }

        /* Year stamp — bottom right */
        .hero__year {
            position: absolute;
            bottom: 2.5rem;
            right: 5rem;
            z-index: 5;
            font-family: 'Crimson Pro', serif;
            font-size: 4.5rem;
            font-weight: 300;
            color: rgba(212, 175, 55, 0.06);
            line-height: 1;
            letter-spacing: -0.03em;
            user-select: none;
            pointer-events: none;
            opacity: 0;
            animation: heroFadeIn 1.5s 1.8s ease forwards;
        }

        /* ═══ HERO KEYFRAMES ═══ */
        @keyframes heroKenBurns {
            0%   { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.08) translate(-0.5%, -0.5%); }
        }
        @keyframes heroSlideUp {
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes heroFadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes heroAccentIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes heroScrollPulse {
            0%   { transform: translateX(-100%); }
            50%  { transform: translateX(300%); }
            100% { transform: translateX(300%); }
        }

        /* ═══ HERO RESPONSIVE ═══ */
        @media (max-width: 1024px) {
            .hero__visual { display: none; }
            .hero__inner { padding: 0 2.5rem; }
            .hero__copy { max-width: 100%; }
            .hero__scroll { left: 2.5rem; }
            .hero__year { right: 2.5rem; font-size: 3rem; }
        }
        @media (max-width: 640px) {
            .hero__inner { padding: 0 1.5rem; }
            .hero__title { font-size: clamp(2.4rem, 10vw, 3.5rem); }
            .hero__actions {
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 1rem;
                width: 100%;
            }
            .hero__btn-primary, .hero__btn-outline {
                width: 100%;
                max-width: 280px;
                justify-content: center;
                text-align: center;
            }
            .hero__scroll { left: 1.5rem; bottom: 1.5rem; }
            .hero__year { display: none; }
            .hero__accent-strip { display: none; }
        }

        /* ═══ COLLECTION CARDS (shared styles for other sections) ═══ */
        .collection-card {
            background: rgba(28, 15, 6, 0.4);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .collection-card:hover {
            transform: translateY(-8px);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .collection-card-image {
            position: relative;
            height: 400px;
            overflow: hidden;
            background: linear-gradient(135deg, #2a1a0d 0%, #1c0f06 100%);
        }
        .collection-card-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 8, 5, 0.9) 0%, transparent 60%);
            z-index: 1;
        }
        .collection-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .collection-card:hover .collection-card-image img {
            transform: scale(1.1);
        }
        .collection-card-body { padding: 2rem; }
        .collection-card-number {
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            color: rgba(212, 175, 55, 0.5);
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .collection-card-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--cream);
            margin-bottom: 0.75rem;
        }
        .collection-card-description {
            font-size: 0.95rem;
            font-weight: 300;
            line-height: 1.7;
            color: rgba(245, 235, 224, 0.5);
            margin-bottom: 1.5rem;
        }

        /* ═══ LEGACY (ABOUT) SECTION ═══ */
        .legacy-section {
            position: relative;
            overflow: hidden;
        }
        .legacy__grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 6rem;
            align-items: center;
        }
        .legacy__badge {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.75rem;
            letter-spacing: 0.25em;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 2rem;
        }
        .legacy__badge::before {
            content: '';
            width: 32px;
            height: 1px;
            background: var(--gold);
        }
        .legacy__geo {
            display: block;
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            color: rgba(245, 235, 224, 0.4);
            text-transform: uppercase;
            margin-top: 0.6rem;
            font-weight: 400;
        }
        .legacy__title {
            font-family: 'Crimson Pro', serif;
            font-size: clamp(2.5rem, 4.5vw, 3.8rem);
            font-weight: 300;
            line-height: 1.1;
            color: var(--cream);
            margin-bottom: 2.5rem;
            letter-spacing: -0.01em;
        }
        .legacy__title em {
            font-style: italic;
            color: var(--gold);
            font-weight: 400;
        }
        .legacy__p {
            font-size: 1.08rem;
            font-weight: 300;
            line-height: 1.85;
            color: rgba(245, 235, 224, 0.75);
            margin-bottom: 2rem;
        }
        .legacy__p-sub {
            font-size: 0.92rem;
            font-weight: 300;
            line-height: 1.8;
            color: rgba(245, 235, 224, 0.45);
            margin-bottom: 3rem;
            border-left: 2px solid rgba(212, 175, 55, 0.25);
            padding-left: 1.5rem;
        }
        .legacy__link {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            color: var(--cream);
            text-transform: uppercase;
            text-decoration: none;
            position: relative;
            padding-bottom: 0.5rem;
            transition: color 0.3s ease;
        }
        .legacy__link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--gold);
            transform: scaleX(0.3);
            transform-origin: left;
            transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .legacy__link:hover {
            color: var(--gold);
        }
        .legacy__link:hover::after {
            transform: scaleX(1);
        }
        
        /* Right Side visual */
        .legacy__visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .legacy__frame {
            position: relative;
            width: 100%;
            max-width: 380px;
        }
        .legacy__image-wrapper {
            position: relative;
            width: 100%;
            padding-bottom: 140%; /* Tall aspect ratio */
            border-radius: 200px 200px 20px 20px; /* Arch shape echoing Grha Wismilak architecture */
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .legacy__image-wrapper img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.85) contrast(1.05);
            transition: transform 1.2s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .legacy__frame:hover .legacy__image-wrapper img {
            transform: scale(1.06);
        }
        
        /* Floating premium badge/stats */
        .legacy__floating-card {
            position: absolute;
            bottom: -2rem;
            left: -4rem;
            width: 300px;
            background: rgba(20, 11, 5, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            padding: 2.2rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.55);
            z-index: 5;
        }
        .legacy__floating-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.8rem;
        }
        .legacy__floating-item {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .legacy__floating-number {
            font-family: 'Crimson Pro', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--gold);
            line-height: 1;
        }
        .legacy__floating-label {
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            color: rgba(245, 235, 224, 0.45);
            text-transform: uppercase;
            line-height: 1.3;
        }

        /* Responsive styling */
        @media (max-width: 1024px) {
            .legacy__grid {
                grid-template-columns: 1fr;
                gap: 7rem;
            }
            .legacy__visual {
                margin-top: 2rem;
            }
            .legacy__floating-card {
                left: 50%;
                transform: translateX(-50%);
                bottom: -3.5rem;
            }
        }

        /* ═══ PREMIUM HOME COLLECTION OVERHAUL ═══ */
        #collection .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4rem;
            align-items: start;
        }

        #collection .collection-card {
            background: rgba(20, 11, 5, 0.4);
            border: 1px solid rgba(212, 175, 55, 0.08);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
        }

        #collection .collection-card:hover {
            transform: translateY(-12px);
            border-color: rgba(212, 175, 55, 0.35);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.65), 0 0 20px rgba(212, 175, 55, 0.05);
            background: rgba(212, 175, 55, 0.02);
        }

        #collection .collection-card-image {
            position: relative;
            height: 440px;
            overflow: hidden;
            border-bottom: 1px solid rgba(212, 175, 55, 0.08);
        }

        #collection .collection-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.8) contrast(1.05);
            transition: transform 1.8s cubic-bezier(0.22, 1, 0.36, 1);
        }

        #collection .collection-card:hover .collection-card-image img {
            transform: scale(1.05);
            filter: brightness(0.9) contrast(1.05);
        }

        #collection .collection-card-body {
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        #collection .collection-card-number {
            font-family: 'Crimson Pro', serif;
            font-size: 1.1rem;
            font-style: italic;
            color: var(--gold);
            margin-bottom: 0.8rem;
            letter-spacing: 0;
            text-transform: none;
        }

        #collection .collection-card-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.9rem;
            font-weight: 400;
            color: var(--cream);
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }

        #collection .collection-card-description {
            font-size: 0.92rem;
            line-height: 1.8;
            color: rgba(245, 235, 224, 0.55);
            margin-bottom: 2rem;
        }

        /* Bespoke Luxury Link instead of simple button */
        #collection .collection-discover-link {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            color: var(--gold);
            text-transform: uppercase;
            text-decoration: none;
            position: relative;
            padding-bottom: 0.4rem;
            transition: color 0.3s ease;
            margin-top: auto;
        }

        #collection .collection-discover-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--gold);
            transform: scaleX(0.2);
            transform-origin: left;
            transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        #collection .collection-card:hover .collection-discover-link {
            color: var(--cream);
        }

        #collection .collection-card:hover .collection-discover-link::after {
            transform: scaleX(1);
            background: var(--cream);
        }

        /* Staggered magazine flow on desktop */
        @media (min-width: 1025px) {
            #collection .collection-card:nth-child(1) {
                margin-top: 0;
            }
            #collection .collection-card:nth-child(2) {
                margin-top: 5rem;
            }
            #collection .collection-card:nth-child(3) {
                margin-top: 2.5rem;
            }
        }

        @media (max-width: 1024px) {
            #collection .grid {
                grid-template-columns: 1fr 1fr;
                gap: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            #collection .grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
            #collection .collection-card-image {
                height: 360px;
            }
        }
    </style>

@endpush

@section('content')

    <!-- ══════════════════════════════
         HERO
    ══════════════════════════════ -->
    <section id="hero">
        <!-- Gold accent strip -->
        <div class="hero__accent-strip"></div>

        <!-- Background image -->
        <div class="hero__bg">
            <img src="{{ asset('images/hero-wismilak.jpg') }}" alt="Wismilak Heritage Tobacco">
        </div>
        <div class="hero__overlay"></div>
        <canvas id="particles"></canvas>

        <!-- Content -->
        <div class="hero__inner">
            <div class="hero__copy">
                <div class="hero__eyebrow">
                    <span class="hero__eyebrow-line"></span>
                    <span class="hero__eyebrow-text">Est. 1962 · Surabaya</span>
                </div>

                <h1 class="hero__title">
                    <span class="hero__title-line"><span>The Heritage</span></span>
                    <span class="hero__title-line"><span>Taste <em>of Indonesia</em></span></span>
                </h1>

                <p class="hero__subtitle">Handcrafted excellence, six decades running.</p>

                <p class="hero__desc">
                    Every leaf hand-selected. Every roll a masterwork. Wismilak
                    Premium Cigars — where Indonesian tobacco artistry meets
                    quiet, uncompromising luxury.
                </p>

                <div class="hero__actions">
                    <a href="#collection" class="hero__btn-primary">
                        Explore Collection
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#about" class="hero__btn-outline">Our Story</a>
                </div>
            </div>
        </div>

        <!-- Editorial image peek (right side) -->
        <div class="hero__visual">
            <img src="{{ asset('images/story-tobacco.jpg') }}" alt="Tobacco Craftsmanship">
            <div class="hero__visual-overlay"></div>
        </div>

        <!-- Scroll indicator -->
        <a href="#about" class="hero__scroll">
            <span class="hero__scroll-line"></span>
            <span class="hero__scroll-text">Scroll</span>
        </a>

        <!-- Year watermark -->
        <div class="hero__year">1962</div>
    </section>

    <!-- ══════════════════════════════
         ABOUT (OUR LEGACY)
    ══════════════════════════════ -->
    <section id="about" class="legacy-section py-32 bg-gradient-to-b from-[#0D0805] to-[#1C0F06]">
        <div class="max-w-7xl mx-auto px-8">
            <div class="legacy__grid">
                <div class="reveal">
                    <div class="legacy__badge">
                        <div>
                            Our Legacy
                            <span class="legacy__geo">Surabaya, Indonesia // 7.2504° S, 112.7688° E</span>
                        </div>
                    </div>
                    
                    <h2 class="legacy__title">
                        We thrive in making<br>fine cigars that thrill<br>the taste & <em>soul.</em>
                    </h2>
                    
                    <p class="legacy__p">
                        For over six decades, Wismilak Premium Cigars has been a testament to Indonesian tobacco artistry.
                        Every cigar begins as a leaf — hand-selected, carefully aged, and meticulously rolled by masters.
                    </p>
                    
                    <p class="legacy__p-sub">
                        Our craft is not merely a process. It is a philosophy — a commitment to delivering
                        an experience of unmatched refinement.
                    </p>
                    
                    <a href="{{ route('about') }}" class="legacy__link">
                        Discover Our Heritage
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
                
                <div class="reveal legacy__visual">
                    <div class="legacy__frame">
                        <div class="legacy__image-wrapper">
                            <img src="{{ asset('images/story-tobacco.jpg') }}" alt="Tobacco Craftsmanship">
                        </div>
                        
                        <!-- Floating Glassmorphic Stats Panel -->
                        <div class="legacy__floating-card">
                            <div class="legacy__floating-grid">
                                <div class="legacy__floating-item">
                                    <span class="legacy__floating-number">60+</span>
                                    <span class="legacy__floating-label">Years of Mastery</span>
                                </div>
                                <div class="legacy__floating-item">
                                    <span class="legacy__floating-number">7</span>
                                    <span class="legacy__floating-label">Product Series</span>
                                </div>
                                <div class="legacy__floating-item">
                                    <span class="legacy__floating-number">100%</span>
                                    <span class="legacy__floating-label">Handcrafted</span>
                                </div>
                                <div class="legacy__floating-item">
                                    <span class="legacy__floating-number">∞</span>
                                    <span class="legacy__floating-label">Refined Moments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════════
         COLLECTION
    ══════════════════════════════ -->
    <section id="collection" class="py-32 bg-[#0D0805]">
        <div class="max-w-7xl mx-auto px-8">
            <!-- Section Header: split between editorial title left and link right -->
            <div class="flex justify-between items-end mb-20 reveal" style="border-bottom: 1px solid rgba(212,175,55,0.12); padding-bottom: 3rem;">
                <div>
                    <div style="display:inline-flex;align-items:center;gap:0.8rem;color:var(--gold);font-size:0.7rem;letter-spacing:0.3em;text-transform:uppercase;margin-bottom:1.2rem;">
                        <span style="display:block;width:20px;height:1px;background:var(--gold);"></span>
                        The Collection
                    </div>
                    <h2 class="section-title" style="max-width:560px;">
                        Discover Our Collection<br>
                        <em>Premium cigars crafted for every occasion.</em>
                    </h2>
                </div>
                <a href="{{ route('product.index') }}" style="display:inline-flex;align-items:center;gap:0.8rem;font-size:0.72rem;font-weight:600;letter-spacing:0.2em;color:var(--gold);text-transform:uppercase;text-decoration:none;flex-shrink:0;align-self:flex-end;padding-bottom:0.2rem;border-bottom:1px solid rgba(212,175,55,0.4);transition:all 0.3s ease;" onmouseover="this.style.color='var(--cream)';this.style.borderColor='var(--cream)';" onmouseout="this.style.color='var(--gold)';this.style.borderColor='rgba(212,175,55,0.4)';">
                    View Full Collection
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid">
                @forelse($products as $i => $product)
                    <div class="collection-card reveal" style="animation-delay: {{ $i * 0.15 }}s;">
                        <div class="collection-card-image">
                            @if($product->image_main)
                                <img src="{{ asset('storage/' . $product->image_main) }}" alt="{{ $product->name }}"
                                    loading="{{ $i < 3 ? 'eager' : 'lazy' }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg width="80" height="160" viewBox="0 0 80 160" fill="none">
                                        <rect x="30" y="10" width="20" height="130" rx="10" fill="rgba(212,175,55,0.1)" />
                                        <ellipse cx="40" cy="145" rx="15" ry="6" fill="rgba(212,175,55,0.05)" />
                                        <rect x="22" y="50" width="36" height="24" rx="2" fill="none" stroke="rgba(212,175,55,0.3)"
                                            stroke-width="1.5" />
                                        <text x="40" y="67" text-anchor="middle" font-family="serif" font-size="14"
                                            fill="rgba(212,175,55,0.6)">W</text>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="collection-card-body">
                            <div class="collection-card-number">Series {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <h3 class="collection-card-title">{{ $product->name }}</h3>
                            <p class="collection-card-description">{{ Str::limit($product->description, 120) }}</p>
                            <a href="{{ route('product.show', $product->id) }}" class="collection-discover-link">
                                Discover More
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align:center; padding: 5rem 0;">
                        <p style="color:rgba(212,175,55,0.4);font-size:0.75rem;letter-spacing:0.3em;text-transform:uppercase;">Collection Coming Soon</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ══════════════════════════════
         UPCOMING EVENTS
    ══════════════════════════════ -->
    <section id="events" style="padding: 8rem 0; background: linear-gradient(180deg, #0D0805 0%, #1C0F06 100%); border-top: 1px solid rgba(212,175,55,0.08);">
        <div class="max-w-7xl mx-auto px-8">
            <!-- Section Header -->
            <div class="flex justify-between items-end reveal" style="border-bottom: 1px solid rgba(212,175,55,0.12); padding-bottom: 3rem; margin-bottom: 5rem;">
                <div>
                    <div style="display:inline-flex;align-items:center;gap:0.8rem;color:var(--gold);font-size:0.7rem;letter-spacing:0.3em;text-transform:uppercase;margin-bottom:1.2rem;">
                        <span style="display:block;width:20px;height:1px;background:var(--gold);"></span>
                        Upcoming Events
                    </div>
                    <h2 class="section-title" style="max-width:480px;">
                        Don't miss our<br>exclusive <em>events.</em>
                    </h2>
                </div>
                <a href="{{ route('events.index') }}" style="display:inline-flex;align-items:center;gap:0.8rem;font-size:0.72rem;font-weight:600;letter-spacing:0.2em;color:var(--gold);text-transform:uppercase;text-decoration:none;flex-shrink:0;align-self:flex-end;padding-bottom:0.2rem;border-bottom:1px solid rgba(212,175,55,0.4);transition:all 0.3s ease;" onmouseover="this.style.color='var(--cream)';this.style.borderColor='var(--cream)';" onmouseout="this.style.color='var(--gold)';this.style.borderColor='rgba(212,175,55,0.4)';">
                    View All Events
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if(isset($upcomingEvents) && $upcomingEvents->count())
                <div style="display:flex;flex-direction:column;gap:1.5rem;">
                    @foreach($upcomingEvents as $i => $event)
                        <a href="{{ route('events.show', $event) }}" class="reveal" style="display:grid;grid-template-columns:auto 1fr auto;gap:3rem;align-items:center;padding:2.5rem 3rem;background:rgba(20,11,5,0.4);border:1px solid rgba(212,175,55,0.08);border-radius:12px;text-decoration:none;transition:all 0.5s cubic-bezier(0.22,1,0.36,1);animation-delay:{{ $i * 0.1 }}s;" onmouseover="this.style.background='rgba(212,175,55,0.03)';this.style.borderColor='rgba(212,175,55,0.28)';this.style.transform='translateX(8px)';" onmouseout="this.style.background='rgba(20,11,5,0.4)';this.style.borderColor='rgba(212,175,55,0.08)';this.style.transform='translateX(0)';">
                            <!-- Date Block -->
                            <div style="text-align:center;flex-shrink:0;min-width:72px;">
                                <div style="font-family:'Crimson Pro',serif;font-size:3rem;font-weight:300;color:var(--gold);line-height:1;letter-spacing:-0.02em;">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</div>
                                <div style="font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;color:rgba(212,175,55,0.6);margin-top:0.3rem;">{{ \Carbon\Carbon::parse($event->date)->format('M Y') }}</div>
                            </div>

                            <!-- Vertical Divider -->
                            <div style="position:relative;">
                                <!-- Time + Title + Location -->
                                <div style="display:flex;align-items:center;gap:1.2rem;margin-bottom:0.6rem;">
                                    @if($event->start_time)
                                        <span style="font-size:0.68rem;letter-spacing:0.18em;text-transform:uppercase;color:rgba(212,175,55,0.5);">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</span>
                                        <span style="width:16px;height:1px;background:rgba(212,175,55,0.2);display:inline-block;"></span>
                                    @endif
                                    @php $qs = $event->quota_status; @endphp
                                    <span style="font-size:0.65rem;font-weight:600;letter-spacing:0.1em;padding:0.2rem 0.7rem;border-radius:4px;
                                        {{ $qs === 'Full' ? 'background:rgba(231,76,76,.12);color:#E74C4C;' : ($qs === 'Almost Full' ? 'background:rgba(245,158,11,.12);color:#F59E0B;' : 'background:rgba(212,175,55,.10);color:var(--gold);') }}">
                                        {{ $qs }}
                                    </span>
                                </div>
                                <h3 style="font-family:'Crimson Pro',serif;font-size:1.6rem;font-weight:400;color:var(--cream);margin:0 0 0.5rem;letter-spacing:-0.01em;">{{ $event->title }}</h3>
                                @if($event->location)
                                    <p style="font-size:0.85rem;color:rgba(245,235,224,0.4);margin:0;display:flex;align-items:center;gap:0.5rem;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        {{ $event->location }}
                                    </p>
                                @endif
                            </div>

                            <!-- Price + CTA -->
                            <div style="text-align:right;flex-shrink:0;">
                                <div style="font-family:'Crimson Pro',serif;font-size:1.4rem;font-weight:400;color:var(--gold);margin-bottom:1rem;">
                                    {{ $event->price_type === 'free' ? 'Free' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                </div>
                                <span style="display:inline-flex;align-items:center;gap:0.5rem;font-size:0.68rem;font-weight:600;letter-spacing:0.18em;text-transform:uppercase;color:var(--gold);">
                                    View Event
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:5rem 0;">
                    <p style="color:rgba(212,175,55,0.4);font-size:0.75rem;letter-spacing:0.3em;text-transform:uppercase;">No upcoming events at this time</p>
                </div>
            @endif
        </div>
    </section>

    <!-- ══════════════════════════════
         INSTAGRAM GALLERY
    ══════════════════════════════ -->
    @if(isset($instagramPosts) && $instagramPosts->count() > 0)
        <section id="instagram" class="py-32 bg-[#0D0805]">
            <div class="max-w-7xl mx-auto px-8">
                <div class="text-center mb-16 reveal">
                    <div class="section-label" style="justify-content: center;">Follow Us</div>
                    <h2 class="section-title">
                        @Wismilak<em>Cigars</em>
                    </h2>
                    <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed mt-6">
                        Join our community and stay updated with our latest collections and events.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 reveal">
                    @foreach($instagramPosts as $post)
                        <a href="{{ $post->instagram_url ?? '#' }}" target="_blank"
                            class="group relative block aspect-square overflow-hidden rounded-xl bg-[#1C0F06] border border-[#D4AF37]/10">
                            @if($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ Str::limit($post->caption, 50) }}"
                                    class="w-full h-full object-cover transition duration-700 group-hover:scale-110 group-hover:opacity-60">
                            @endif
                            <div
                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- ══════════════════════════════
         CRAFTSMANSHIP
    ══════════════════════════════ -->
    <section id="craft" class="py-32 bg-gradient-to-b from-[#1C0F06] to-[#0D0805]">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16 reveal">
                <div class="section-label" style="justify-content: center;">Craftsmanship</div>
                <h2 class="section-title mb-6">
                    The Art of<br><em>Exceptional</em> Tobacco
                </h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed mb-8">
                    From the selection of the leaf to the final roll, every step is an act of devotion.
                    This is how Wismilak has defined premium craftsmanship for six decades.
                </p>
                <a href="#" class="btn btn-primary">Discover The Process</a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // Subtle gold dust particles
        (function () {
            const canvas = document.getElementById('particles');
            if (!canvas || !window.THREE) return;

            const hero = document.getElementById('hero');
            if (!hero) return;

            const scene = new THREE.Scene();
            const w = hero.offsetWidth, h = hero.offsetHeight;
            const camera = new THREE.PerspectiveCamera(60, w / h, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: false });
            renderer.setSize(w, h);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));
            camera.position.z = 5;

            // Soft glow texture
            const tc = document.createElement('canvas');
            tc.width = tc.height = 16;
            const ctx = tc.getContext('2d');
            const g = ctx.createRadialGradient(8, 8, 0, 8, 8, 8);
            g.addColorStop(0, 'rgba(212,175,55,0.9)');
            g.addColorStop(0.4, 'rgba(212,175,55,0.2)');
            g.addColorStop(1, 'rgba(212,175,55,0)');
            ctx.fillStyle = g;
            ctx.fillRect(0, 0, 16, 16);

            const count = 800;
            const geo = new THREE.BufferGeometry();
            const pos = new Float32Array(count * 3);
            const vel = new Float32Array(count);

            for (let i = 0; i < count; i++) {
                pos[i * 3]     = (Math.random() - 0.5) * 14;
                pos[i * 3 + 1] = (Math.random() - 0.5) * 10;
                pos[i * 3 + 2] = (Math.random() - 0.5) * 6;
                vel[i] = 0.0003 + Math.random() * 0.0008;
            }
            geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));

            const mat = new THREE.PointsMaterial({
                size: 0.04,
                map: new THREE.CanvasTexture(tc),
                transparent: true,
                opacity: 0.5,
                blending: THREE.AdditiveBlending,
                depthWrite: false
            });

            const pts = new THREE.Points(geo, mat);
            scene.add(pts);

            let mx = 0, my = 0;
            document.addEventListener('mousemove', e => {
                mx = (e.clientX / window.innerWidth - 0.5) * 0.15;
                my = (e.clientY / window.innerHeight - 0.5) * 0.08;
            });

            (function loop() {
                requestAnimationFrame(loop);
                const arr = geo.attributes.position.array;
                for (let i = 0; i < count; i++) {
                    arr[i * 3 + 1] += vel[i];
                    if (arr[i * 3 + 1] > 5) arr[i * 3 + 1] = -5;
                }
                geo.attributes.position.needsUpdate = true;
                pts.rotation.y += (mx - pts.rotation.y) * 0.03;
                pts.rotation.x += (my - pts.rotation.x) * 0.03;
                renderer.render(scene, camera);
            })();

            window.addEventListener('resize', () => {
                const nw = hero.offsetWidth, nh = hero.offsetHeight;
                camera.aspect = nw / nh;
                camera.updateProjectionMatrix();
                renderer.setSize(nw, nh);
            });
        })();
    </script>
@endpush