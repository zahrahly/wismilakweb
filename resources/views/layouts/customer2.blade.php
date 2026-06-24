<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Wismilak Premium Cigars</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap"
        rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <style>
        :root {
            --nav-black: #060504;
            --nav-choc: #120e0a;
            --nav-gold: #cba365;
            --nav-gold-dim: rgba(203, 163, 101, 0.3);
            --nav-cream: #f4f1eb;
            --nav-text: #b3a89e;
            --nav-border: rgba(203, 163, 101, 0.15);
            --serif: 'Playfair Display', serif;
            --sans: 'Inter', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--sans);
            background: var(--nav-black);
            color: var(--nav-cream);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .font-serif {
            font-family: var(--serif);
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--nav-black);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--nav-gold);
        }

        /* ── GLOBAL ALERTS ── */
        .global-alert {
            max-width: 900px;
            margin: 1rem auto;
            padding: 0.9rem 1.2rem;
            border-radius: 4px;
            font-size: 0.85rem;
            text-align: center;
            border: 1px solid;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 10000;
            position: relative;
        }

        .global-alert.success {
            color: #cba365;
            border-color: rgba(203, 163, 101, 0.4);
        }

        .global-alert.error {
            color: #A05252;
            border-color: rgba(160, 82, 82, 0.4);
        }

        /* ── LUXURY HEADER ── */
        #luxury-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: transparent;
            border-bottom: 1px solid transparent;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1.5rem 0;
        }

        #luxury-header.scrolled {
            background: rgba(6, 5, 4, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--nav-border);
            padding: 0.8rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .header-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 4vw;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ── LOGO ── */
        .header-logo {
            display: inline-block;
            transition: all 0.3s ease;
        }

        .header-logo img {
            height: 45px;
            width: auto;
            filter: drop-shadow(0 0 10px rgba(203, 163, 101, 0.2));
            transition: all 0.3s ease;
        }

        #luxury-header.scrolled .header-logo img {
            height: 35px;
        }

        /* ── NAVIGATION LINKS ── */
        .header-nav {
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .nav-item {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--nav-text);
            text-decoration: none;
            padding: 0.5rem 0;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 1px;
            background: var(--nav-gold);
            transition: width 0.3s ease;
        }

        .nav-item:hover,
        .nav-item.active {
            color: var(--nav-gold);
        }

        .nav-item:hover::after,
        .nav-item.active::after {
            width: 100%;
        }

        /* ── BUTTONS ── */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .btn-header {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--nav-gold);
            border: 1px solid var(--nav-gold);
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            background: transparent;
            cursor: pointer;
        }

        .btn-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--nav-gold);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .btn-header:hover {
            color: var(--nav-black);
        }

        .btn-header:hover::before {
            left: 0;
        }

        /* ── MEGA MENU ── */
        .mega-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(6, 5, 4, 0.98);
            border-bottom: 1px solid var(--nav-border);
            padding: 4rem 4vw;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.4s ease;
            backdrop-filter: blur(20px);
        }

        .nav-item-wrapper:hover .mega-menu {
            display: grid;
            opacity: 1;
            transform: translateY(0);
        }

        .mega-menu-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr 1.5fr;
            gap: 4rem;
        }

        .mega-title {
            font-family: var(--serif);
            font-size: 1.5rem;
            color: var(--nav-gold);
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .mega-link {
            display: block;
            color: var(--nav-cream);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .mega-link:hover {
            color: var(--nav-gold);
        }

        .mega-image {
            width: 100%;
            height: 200px;
            background: var(--nav-choc);
            border: 1px solid var(--nav-border);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ── MOBILE MENU ── */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--nav-gold);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(6, 5, 4, 0.98);
            backdrop-filter: blur(20px);
            z-index: 10000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s ease;
        }

        .mobile-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .mobile-close {
            position: absolute;
            top: 2rem;
            right: 4vw;
            background: none;
            border: none;
            color: var(--nav-gold);
            font-size: 2rem;
            cursor: pointer;
        }

        .mobile-nav {
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .mobile-nav a {
            font-family: var(--serif);
            font-size: 2.5rem;
            color: var(--nav-cream);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .mobile-nav a:hover {
            color: var(--nav-gold);
            font-style: italic;
        }

        /* ── LUXURY FOOTER ── */
        .luxury-footer {
            background: var(--nav-choc);
            position: relative;
            border-top: 1px solid var(--nav-border);
            padding: 8vw 4vw 4vw 4vw;
            overflow: hidden;
        }

        .footer-bg-texture {
            position: absolute;
            inset: 0;
            background-image: url('{{ asset("images/leather-texture.png") }}');
            opacity: 0.05;
            pointer-events: none;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 6rem;
            margin-bottom: 6rem;
        }

        .footer-brand img {
            height: 60px;
            width: auto;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 0 15px rgba(203, 163, 101, 0.2));
        }

        .footer-brand p {
            font-size: 0.95rem;
            line-height: 2;
            color: var(--nav-text);
            max-width: 400px;
        }

        .footer-col h4 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--nav-gold);
            margin-bottom: 2rem;
        }

        .footer-link {
            display: block;
            color: var(--nav-text);
            font-size: 0.9rem;
            text-decoration: none;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--nav-gold);
        }

        .newsletter-wrapper {
            border-top: 1px solid var(--nav-border);
            padding-top: 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4rem;
        }

        .newsletter-text h3 {
            font-family: var(--serif);
            font-size: 2rem;
            color: var(--nav-cream);
            margin-bottom: 0.5rem;
        }

        .newsletter-text p {
            color: var(--nav-text);
            font-size: 0.9rem;
        }

        .newsletter-form {
            display: flex;
            width: 400px;
        }

        .newsletter-input {
            flex-grow: 1;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--nav-border);
            padding: 1rem 0;
            color: var(--nav-cream);
            outline: none;
            font-size: 0.9rem;
            transition: border-color 0.3s;
        }

        .newsletter-input:focus {
            border-color: var(--nav-gold);
        }

        .newsletter-btn {
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--nav-border);
            color: var(--nav-gold);
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.75rem;
            cursor: pointer;
            padding: 0 1rem;
            transition: all 0.3s;
        }

        .newsletter-btn:hover {
            border-color: var(--nav-gold);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--nav-border);
            padding-top: 2rem;
        }

        .footer-copy {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--nav-text);
        }

        .footer-social {
            display: flex;
            gap: 2rem;
        }

        .footer-social a {
            color: var(--nav-text);
            text-decoration: none;
            transition: color 0.3s;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .footer-social a:hover {
            color: var(--nav-gold);
        }

        @media (max-width: 1024px) {
            .header-nav {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 4rem;
            }

            .newsletter-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 2rem;
            }

            .newsletter-form {
                width: 100%;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 2rem;
                text-align: center;
            }
        }

        /* ── TOM SELECT FIXES ── */
        .ts-control {
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid var(--nav-border) !important;
            color: white !important;
            padding: 12px 0 !important;
        }

        .ts-dropdown {
            background: var(--nav-choc) !important;
            border: 1px solid var(--nav-border) !important;
        }

        .ts-dropdown .option {
            background: transparent !important;
            color: white !important;
        }

        .ts-dropdown .option:hover {
            background: rgba(203, 163, 101, 0.1) !important;
        }

        .ts-dropdown .active {
            background: rgba(203, 163, 101, 0.2) !important;
        }

        .ts-control input {
            color: white !important;
        }
    </style>
    @stack('styles')
</head>

<body x-data="{ mobileMenuOpen: false }">

    {{-- ── GLOBAL ALERTS ── --}}
    @if(session('success'))
        <div class="global-alert success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="global-alert error">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="global-alert success" style="color: #F59E0B; border-color: rgba(245,158,11,0.4);">{{ session('info') }}
        </div>
    @endif

    {{-- ── GLOBAL HEADER ── --}}
    <header id="luxury-header">
        <div class="header-container">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="header-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Wismilak Premium Cigars">
            </a>

            {{-- DESKTOP NAVIGATION --}}
            <nav class="header-nav">
                <a href="{{ route('about') }}"
                    class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">Heritage</a>

                <a href="{{ route('product.index') }}"
                    class="nav-item {{ request()->routeIs('product.*') ? 'active' : '' }}">Collections</a>

                <a href="{{ route('events.index') }}"
                    class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">Experiences</a>
                <a href="{{ route('pressroom.index') }}"
                    class="nav-item {{ request()->routeIs('pressroom.*') ? 'active' : '' }}">Journal</a>
                <a href="{{ route('outlets.index') }}"
                    class="nav-item {{ request()->routeIs('outlets.*') ? 'active' : '' }}">Sanctuaries</a>
            </nav>

            {{-- ACTIONS --}}
            <div class="header-actions">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="nav-item flex items-center justify-center w-8 h-8 rounded-full border border-[rgba(203,163,101,0.3)] hover:bg-[rgba(203,163,101,0.1)] transition-colors"
                        title="My Dashboard">
                        <svg class="w-4 h-4 text-[#cba365]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-header"
                            style="border-color: rgba(160,82,82,0.5); color: #A05252;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-item" style="font-size: 0.65rem;">Login</a>
                    <a href="{{ route('register') }}" class="btn-header">Inner Circle</a>
                @endauth

                <button class="mobile-toggle" @click="mobileMenuOpen = true">☰</button>
            </div>

        </div>
    </header>

    {{-- ── MOBILE FULLSCREEN OVERLAY ── --}}
    <div class="mobile-overlay" :class="mobileMenuOpen ? 'open' : ''">
        <button class="mobile-close" @click="mobileMenuOpen = false">×</button>
        <nav class="mobile-nav">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('about') }}">Heritage</a>
            <a href="{{ route('product.index') }}">Collections</a>
            <a href="{{ route('events.index') }}">Experiences</a>
            <a href="{{ route('pressroom.index') }}">Journal</a>
            <a href="{{ route('outlets.index') }}">Sanctuaries</a>
        </nav>
    </div>

    {{-- ── MAIN CONTENT ── --}}
    <main>
        @yield('content')
    </main>

    {{-- ── GLOBAL FOOTER ── --}}
    <footer class="luxury-footer">
        <div class="footer-bg-texture"></div>
        <div class="footer-container">

            <div class="footer-top">
                <div class="footer-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="Wismilak Premium Cigars">
                    <p>An Indonesian legacy of tobacco mastery, established in 1962. We define the art of premium
                        handcrafted cigars for the global connoisseur. Patience is our virtue; elegance is our standard.
                    </p>
                </div>

                <div class="footer-col">
                    <h4>Navigation</h4>
                    <a href="{{ route('about') }}" class="footer-link">Our Heritage</a>
                    <a href="{{ route('product.index') }}" class="footer-link">Signature Collections</a>
                    <a href="{{ route('events.index') }}" class="footer-link">Private Experiences</a>
                    <a href="{{ route('pressroom.index') }}" class="footer-link">The Journal</a>
                </div>

                <div class="footer-col">
                    <h4>Concierge</h4>
                    <a href="#" class="footer-link">Exclusive Sanctuaries</a>
                    <a href="#" class="footer-link">Inner Circle Membership</a>
                    <a href="mailto:concierge@wismilak.com" class="footer-link"
                        style="color: var(--nav-gold); margin-top: 1rem;">concierge@wismilak.com</a>
                    <p style="color: var(--nav-text); font-size: 0.9rem; margin-top: 0.5rem;">PT Wismilak Inti Makmur
                        Tbk<br>Surabaya, Indonesia</p>
                </div>
            </div>

            <div class="newsletter-wrapper">
                <div class="newsletter-text">
                    <h3>The Inner Circle</h3>
                    <p>Subscribe to receive exclusive access to limited editions and private invitations.</p>
                </div>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Welcome to the Inner Circle.');">
                    <input type="email" placeholder="Enter your email address" class="newsletter-input" required>
                    <button type="submit" class="newsletter-btn">Subscribe</button>
                </form>
            </div>

            <div class="footer-bottom">
                <div class="footer-copy">© {{ date('Y') }} WISMILAK PREMIUM CIGARS. THE ART OF LUXURY.</div>
                <div class="footer-social">
                    <a href="https://www.instagram.com/wismilakcigars" target="_blank">Instagram</a>
                    <a href="mailto:wismilakpremium.cigar@gmail.com">Email</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>

        </div>
    </footer>

    <script>
        // Header Scroll Effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('luxury-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Simple smooth scroll for anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>

    <x-chat-widget />

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
</body>

</html>