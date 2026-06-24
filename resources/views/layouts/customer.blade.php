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
        href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <style>
        :root {
            --tobacco: #1C0F06;
            --charcoal: #0D0805;
            --gold: #D4AF37;
            --gold-bright: #F4D03F;
            --red: #8B2E26;
            --cream: #F5EBE0;
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
            font-family: 'Inter', sans-serif;
            background: var(--charcoal);
            color: var(--cream);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .font-serif {
            font-family: 'Crimson Pro', serif;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--charcoal);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 2px;
        }

        /* ── HEADER & NAVIGATION ── */

        nav {
            position: fixed;
            top: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 92%;
            max-width: 1280px;
            z-index: 9999;
            background: rgba(20, 11, 5, 0.4);
            backdrop-filter: blur(24px) saturate(120%);
            -webkit-backdrop-filter: blur(24px) saturate(120%);
            border: 1px solid rgba(212, 175, 55, 0.18);
            border-radius: 100px;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 0.1rem 0;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }

        nav.scrolled {
            top: 0.8rem;
            width: 95%;
            background: rgba(13, 8, 5, 0.75);
            border-color: rgba(212, 175, 55, 0.28);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .nav-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0.6rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand img {
            height: 48px;
            width: auto;
            filter: drop-shadow(0 0 15px rgba(212, 175, 55, 0.2));
            transition: all 0.5s ease;
        }

        nav.scrolled .nav-brand img {
            height: 42px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 10;
        }

        .nav-links a {
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.2em;
            color: rgba(245, 235, 224, 0.65);
            text-decoration: none;
            text-transform: uppercase;
            transition: color 0.4s ease;
            position: relative;
            padding: 0.6rem 1.4rem;
            z-index: 2;
            border-radius: 8px;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .nav-links a.active {
            color: var(--gold);
            font-weight: 600;
        }

        /* Buttons */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .btn-nav {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.65rem 1.6rem;
            border-radius: 50px;
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-nav-login {
            color: var(--gold);
            border: 1px solid rgba(212, 175, 55, 0.3);
            background: transparent;
        }

        .btn-nav-login:hover {
            background: rgba(212, 175, 55, 0.05);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .btn-nav-register {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            border: 1px solid rgba(212, 175, 55, 0.35);
        }

        .btn-nav-register:hover {
            background: var(--gold);
            color: #000 !important;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }

        .btn-nav-dashboard {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            border: 1px solid rgba(212, 175, 55, 0.35);
        }

        .btn-nav-dashboard:hover {
            background: var(--gold);
            color: #000 !important;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }

        .btn-nav-logout {
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.35);
            background: rgba(239, 68, 68, 0.05);
            cursor: pointer;
        }

        .btn-nav-logout:hover {
            background: #EF4444;
            color: #fff !important;
            border-color: #EF4444;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }



        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.875rem 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-bright) 100%);
            color: var(--charcoal);
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.5);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid rgba(212, 175, 55, 0.4);
            color: var(--gold);
        }

        .btn-outline:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--gold);
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .section-label::before {
            content: '';
            width: 40px;
            height: 2px;
            background: var(--gold);
        }

        .section-title {
            font-family: 'Crimson Pro', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 600;
            line-height: 1.1;
            color: var(--cream);
        }

        .section-title em {
            font-style: italic;
            color: var(--gold);
        }

        /* ── FOOTER ── */
        footer {
            background: linear-gradient(to bottom, #0D0805 0%, #050302 100%);
            border-top: 1px solid rgba(212, 175, 55, 0.05);
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.3), transparent);
        }

        .footer-logo {
            font-family: 'Crimson Pro', serif;
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 1.5rem;
        }

        .footer-col-title {
            font-size: .8rem;
            letter-spacing: .3em;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 2.5rem;
            font-weight: 600;
        }

        .footer-link {
            display: block;
            color: rgba(245, 235, 224, 0.4);
            text-decoration: none;
            margin-bottom: 1.2rem;
            font-size: .95rem;
            transition: all 0.3s;
        }

        .footer-link:hover {
            color: var(--gold);
            transform: translateX(5px);
        }

        .newsletter-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 3rem;
        }

        .newsletter-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
            color: var(--cream);
            border-radius: 8px;
            width: 100%;
            margin-top: 1.5rem;
            outline: none;
            transition: border-color 0.3s;
        }

        .newsletter-input:focus {
            border-color: var(--gold);
        }

        /* Mobile Menu Toggle button */
        .mobile-menu-toggle {
            display: none;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 10001;
            align-items: center;
            justify-content: center;
        }

        .hamburger-icon {
            width: 24px;
            height: 18px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hamburger-icon span {
            display: block;
            width: 100%;
            height: 2px;
            background-color: var(--gold);
            border-radius: 2px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* When open, transform hamburger into X */
        .mobile-menu-open .hamburger-icon span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .mobile-menu-open .hamburger-icon span:nth-child(2) {
            opacity: 0;
            transform: translateX(-20px);
        }

        .mobile-menu-open .hamburger-icon span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        /* Mobile Drawer */
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background: #0d0805;
            z-index: 10002;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            pointer-events: none;
            transform: scale(0.95);
        }

        .mobile-drawer.open {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
        }

        .mobile-drawer-links {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2.2rem;
            margin-bottom: 3rem;
            width: 100%;
        }

        .mobile-drawer-links a {
            font-family: 'Crimson Pro', serif;
            font-size: 2.2rem;
            font-weight: 300;
            letter-spacing: 0.05em;
            color: var(--cream);
            text-decoration: none;
            transition: color 0.3s;
            text-transform: capitalize;
        }

        .mobile-drawer-links a:hover,
        .mobile-drawer-links a.active {
            color: var(--gold);
        }

        .mobile-drawer-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.2rem;
            width: 100%;
            max-width: 280px;
        }

        .mobile-drawer-actions .btn-nav {
            width: 100%;
            text-align: center;
            padding: 1rem 2rem;
            font-size: 0.85rem;
        }

        @media (max-width: 1024px) {
            .nav-container {
                padding: 0.8rem 2rem;
            }

            .nav-links {
                display: none;
            }

            .nav-actions {
                display: none;
                /* Hide desktop actions on mobile */
            }

            .mobile-menu-toggle {
                display: flex;
                /* Show hamburger menu toggle */
            }
        }

        @media (max-width: 768px) {

            nav,
            nav.scrolled {
                top: 1.2rem !important;
                width: 90% !important;
                border-radius: 100px !important;
                background: rgba(13, 8, 5, 0.85) !important;
                border-color: rgba(212, 175, 55, 0.28) !important;
            }

            .nav-container {
                padding: 0.7rem 1.8rem !important;
            }

            .nav-brand img,
            nav.scrolled .nav-brand img {
                height: 44px !important;
            }
        }

        /* TomSelect main box */
        .ts-control {
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid #374151 !important;
            color: white !important;
            padding: 12px 0 !important;
        }

        /* dropdown popup */
        .ts-dropdown {
            background: #1C0F06 !important;
            border: 1px solid rgba(212, 175, 55, 0.2) !important;
            border-radius: 10px !important;
        }

        /* dropdown item */
        .ts-dropdown .option {
            background: transparent !important;
            color: white !important;
        }

        /* hover dropdown item */
        .ts-dropdown .option:hover {
            background: rgba(212, 175, 55, 0.15) !important;
        }

        /* selected item */
        .ts-dropdown .active {
            background: rgba(212, 175, 55, 0.25) !important;
        }

        /* placeholder text */
        .ts-control input {
            color: white !important;
        }
    </style>

    @stack('styles')
</head>

<body x-data="{ mobileMenuOpen: false }">

    <nav id="main-nav" :class="{ 'mobile-menu-open': mobileMenuOpen }">
        <div class="nav-container">
            <!-- LOGO -->
            <a href="{{ route('home') }}" class="nav-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Wismilak Premium Cigars">
            </a>

            <!-- MENU -->
            <div class="nav-links">
                <!-- Sliding active background pill -->
                <div id="nav-active-pill" style="
                    position: absolute;
                    background: rgba(212, 175, 55, 0.08);
                    border: 1px solid rgba(212, 175, 55, 0.25);
                    border-radius: 89px;
                    transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
                    pointer-events: none;
                    z-index: 1;
                    opacity: 0;
                "></div>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('product.index') }}"
                    class="{{ request()->routeIs('product.*') ? 'active' : '' }}">Collection</a>
                <a href="{{ route('events.index') }}"
                    class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Event</a>
                <a href="{{ route('pressroom.index') }}"
                    class="{{ request()->routeIs('pressroom.*') ? 'active' : '' }}">Pressroom</a>
                <a href="{{ route('outlets.index') }}"
                    class="{{ request()->routeIs('outlets.*') ? 'active' : '' }}">Find Us</a>
            </div>

            <!-- ACTIONS -->
            <div class="nav-actions">
                @auth
                    @include('partials.notification-bell')
                    <a href="{{ route('dashboard') }}" class="btn-nav btn-nav-dashboard">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-nav btn-nav-logout">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-nav btn-nav-register" style="font-weight: 700;">Let's
                        Connect</a>
                @endauth
            </div>

            <!-- MOBILE MENU TOGGLE -->
            <button class="mobile-menu-toggle" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle Menu">
                <div class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
    </nav>

    <!-- MOBILE DRAWER -->
    <div id="mobile-drawer" class="mobile-drawer" :class="{ 'open': mobileMenuOpen }"
        @click.away="mobileMenuOpen = false">
        <!-- Drawer Header -->
        <div class="mobile-drawer-header" style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 1.5rem 2rem;
            position: absolute;
            top: 0;
            left: 0;
        ">
            <a href="{{ route('home') }}" class="nav-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Wismilak Premium Cigars" style="height: 44px;">
            </a>
            <button class="mobile-menu-close" id="mobile-close" aria-label="Close Menu" style="
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0.5rem;
            ">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="mobile-drawer-links">
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"
                @click="mobileMenuOpen = false">About</a>
            <a href="{{ route('product.index') }}" class="{{ request()->routeIs('product.*') ? 'active' : '' }}"
                @click="mobileMenuOpen = false">Collection</a>
            <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}"
                @click="mobileMenuOpen = false">Event</a>
            <a href="{{ route('pressroom.index') }}" class="{{ request()->routeIs('pressroom.*') ? 'active' : '' }}"
                @click="mobileMenuOpen = false">Pressroom</a>
            <a href="{{ route('outlets.index') }}" class="{{ request()->routeIs('outlets.*') ? 'active' : '' }}"
                @click="mobileMenuOpen = false">Find Us</a>
        </div>
        <div class="mobile-drawer-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-nav btn-nav-dashboard"
                    @click="mobileMenuOpen = false">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display: block; width: 100%;">
                    @csrf
                    <button type="submit" class="btn-nav btn-nav-logout" style="width: 100%;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-nav btn-nav-register"
                    style="font-weight: 700; width: 100%; text-align: center;" @click="mobileMenuOpen = false">Let's
                    Connect</a>
            @endauth
        </div>
    </div>

    @if(session('success'))

        <div style="
            max-width:900px;
            margin:1rem auto;
            padding:.9rem 1.2rem;
            background:rgba(16,185,129,.12);
            border:1px solid rgba(16,185,129,.35);
            border-radius:10px;
            color:#10B981;
            font-size:.85rem;
            ">

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div style="
            max-width:900px;
            margin:1rem auto;
            padding:.9rem 1.2rem;
            background:rgba(239,68,68,.12);
            border:1px solid rgba(239,68,68,.35);
            border-radius:10px;
            color:#EF4444;
            font-size:.85rem;
            ">

            {{ session('error') }}

        </div>

    @endif


    @if(session('info'))

        <div style="
            max-width:900px;
            margin:1rem auto;
            padding:.9rem 1.2rem;
            background:rgba(245,158,11,.12);
            border:1px solid rgba(245,158,11,.35);
            border-radius:10px;
            color:#F59E0B;
            font-size:.85rem;
            ">

            {{ session('info') }}

        </div>

    @endif

    <main class="pt-28">
        @yield('content')
    </main>


    @if(!request()->routeIs('customer.chat.*') && !request()->is('customer/messages*'))
        <footer class="py-12">
            <div class="max-w-7xl mx-auto px-8">

                <!-- Newsletter Section Removed -->

                <div class="grid md:grid-cols-3 gap-16 mb-10">
                    <div class="col-span-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Wismilak Premium Cigars"
                            style="height: 50px; margin-bottom: 1.5rem; filter: drop-shadow(0 0 10px rgba(212,175,55,0.2));">
                        <p class="text-sm text-gray-500 leading-relaxed font-light">
                            An Indonesian legacy of tobacco mastery, established in 1962. We define the art of premium
                            handcrafted cigars for the global connoisseur.
                        </p>
                        <div class="flex gap-4 mt-8">
                            <a href="https://www.instagram.com/wismilakcigars" target="_blank"
                                class="text-gray-600 hover:text-gold transition" title="Instagram"><svg class="w-5 h-5"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.607.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.063 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.245-3.607 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.063-2.633-.333-3.608-1.308-.975-.975-1.245-2.242-1.308-3.607-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.332-2.633 1.308-3.608.975-.975 2.242-1.245 3.607-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98-1.281-.058-1.689-.072-4.948-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg></a>
                            <a href="mailto:wismilakpremium.cigar@gmail.com"
                                class="text-gray-600 hover:text-gold transition" title="Email"><svg class="w-5 h-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg></a>
                        </div>
                    </div>
                    <div class="border-l border-white/5 pl-8 md:pl-12">
                        <h4 class="footer-col-title">Collections</h4>
                        <ul class="space-y-4">
                            <li><a href="{{ route('product.index') }}" class="footer-link">Cigar Collections</a></li>
                            <li><a href="{{ route('events.index') }}" class="footer-link">Private Experiences</a></li>
                            <li><a href="{{ route('outlets.index') }}" class="footer-link">Sanctuary Outlets</a></li>
                            <li><a href="{{ route('pressroom.index') }}" class="footer-link">Journal Archives</a></li>
                        </ul>
                    </div>
                    <div class="border-l border-white/5 pl-8 md:pl-12">
                        <h4 class="footer-col-title">Sanctuary</h4>
                        <p class="text-sm leading-relaxed mb-1"
                            style="color: var(--gold); font-weight: 600; font-family: 'Crimson Pro', serif; font-size: 1.1rem; font-style: italic;">
                            Grha Wismilak</p>
                        <p class="text-xs text-gray-500 leading-relaxed font-light mb-4">
                            Jl. Raya Darmo No.36, Dr. Soetomo, Kec. Tegalsari, Surabaya, Jawa Timur 60264
                        </p>
                        <div class="overflow-hidden rounded-lg mb-4"
                            style="border: 1px solid rgba(212,175,55,0.15); box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
                            <iframe
                                src="https://maps.google.com/maps?q=Grha%20Wismilak%20Surabaya&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                width="100%" height="130"
                                style="border:0; filter: grayscale(1) invert(0.9) contrast(1.2); opacity: 0.85;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <a href="https://maps.google.com/?q=Grha+Wismilak+Surabaya" target="_blank"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--gold); text-decoration: none; font-size: 0.8rem; font-weight: 600; padding: 0.5rem 1rem; border: 1px solid rgba(212,175,55,0.2); border-radius: 8px; background: rgba(212,175,55,0.03); transition: all 0.3s; letter-spacing: 0.05em;"
                            onmouseover="this.style.background='rgba(212,175,55,0.1)'; this.style.borderColor='var(--gold)';"
                            onmouseout="this.style.background='rgba(212,175,55,0.03)'; this.style.borderColor='rgba(212,175,55,0.2)';">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            OPEN IN GOOGLE MAPS
                        </a>
                    </div>
                </div>
                <div class="border-t border-white/5 pt-12 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-[10px] text-gray-600 tracking-[0.3em] uppercase">© {{ date('Y') }} WISMILAK PREMIUM
                        CIGARS. THE ART OF LUXURY.</p>
                    <div class="flex gap-8">
                        <a href="#"
                            class="text-[10px] text-gray-600 tracking-[0.2em] uppercase hover:text-gold transition">Privacy
                            Policy</a>
                        <a href="#"
                            class="text-[10px] text-gray-600 tracking-[0.2em] uppercase hover:text-gold transition">Terms of
                            Service</a>
                    </div>
                </div>
            </div>
        </footer>
    @endif

    <script>
        // Mobile menu toggle script (Vanilla JS)
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.querySelector('.mobile-menu-toggle');
            const closeBtn = document.getElementById('mobile-close');
            const drawer = document.querySelector('.mobile-drawer');
            const mainNav = document.getElementById('main-nav');

            const closeMenu = () => {
                if (drawer) drawer.classList.remove('open');
                if (mainNav) mainNav.classList.remove('mobile-menu-open');
                document.body.style.overflow = '';
            };

            const openMenu = () => {
                if (drawer) drawer.classList.add('open');
                if (mainNav) mainNav.classList.add('mobile-menu-open');
                document.body.style.overflow = 'hidden';
            };

            if (toggleBtn && drawer && mainNav) {
                toggleBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = drawer.classList.contains('open');
                    if (isOpen) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    closeMenu();
                });
            }

            // Close drawer when clicking outside
            document.addEventListener('click', (e) => {
                if (drawer && drawer.classList.contains('open') && !drawer.contains(e.target) && (!toggleBtn || !toggleBtn.contains(e.target))) {
                    closeMenu();
                }
            });

            // Close drawer when clicking links
            if (drawer) {
                drawer.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        closeMenu();
                    });
                });
            }
        });

        window.addEventListener('scroll', () => {
            document.getElementById('main-nav').classList.toggle('scrolled', window.scrollY > 50);
            setTimeout(updateActivePill, 200);
        });

        // Sliding Active Background Pill logic
        const navLinks = document.querySelector('.nav-links');
        const pill = document.getElementById('nav-active-pill');
        let activeLink = navLinks ? navLinks.querySelector('a.active') : null;

        function positionPill(element) {
            if (element && pill) {
                pill.style.width = `${element.offsetWidth}px`;
                pill.style.height = `${element.offsetHeight}px`;
                pill.style.left = `${element.offsetLeft}px`;
                pill.style.top = `${element.offsetTop}px`;
                pill.style.opacity = '1';
            } else if (pill) {
                pill.style.opacity = '0';
            }
        }

        function updateActivePill() {
            activeLink = navLinks ? navLinks.querySelector('a.active') : null;
            positionPill(activeLink);
        }

        if (navLinks && pill) {
            const links = navLinks.querySelectorAll('a');

            // Initial positioning with brief delay to let CSS load
            setTimeout(updateActivePill, 300);

            links.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    positionPill(link);
                });
            });

            navLinks.addEventListener('mouseleave', () => {
                updateActivePill();
            });
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

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

    @if(!request()->routeIs('customer.chat.*') && !request()->is('customer/messages*'))
        <x-chat-widget />
    @endif

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
</body>

</html>