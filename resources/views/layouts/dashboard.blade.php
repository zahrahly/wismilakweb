<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Wismilak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    <style>
        :root {
            --sidebar-bg: #0F0F12;
            --sidebar-hover: #1A1A23;
            --sidebar-active: rgba(212, 175, 55, 0.1);
            --sidebar-text: #8A8A9A;
            --sidebar-text-active: #D4AF37;
            --body-bg: #13131A;
            --card-bg: #1A1A25;
            --card-border: rgba(255, 255, 255, 0.05);
            --text-primary: #E8E8ED;
            --text-secondary: #8A8A9A;
            --gold: #D4AF37;
            --gold-dim: rgba(212, 175, 55, 0.3);
            --red: #E74C4C;
            --green: #10B981;
            --blue: #3B82F6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--body-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold-dim);
            border-radius: 2px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--card-border);
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 2rem 1.25rem;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .sidebar-brand img {
            width: 140px;
            filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.2));
        }

        .sidebar-brand h2 {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--gold);
            letter-spacing: 0.1em;
            margin-bottom: 2px;
            font-family: 'Crimson Pro', serif;
        }

        .sidebar-brand small {
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            color: var(--sidebar-text);
            text-transform: uppercase;
            font-weight: 600;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
        }

        .nav-section {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.2);
            padding: 1.5rem 1.5rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.8rem 1.25rem;
            margin: 0.2rem 0.75rem;
            font-size: 0.85rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-primary);
            padding-left: 1.5rem;
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0) 100%);
            color: var(--gold);
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            width: 3px;
            height: 60%;
            background: var(--gold);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 15px var(--gold);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            opacity: 0.6;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .nav-link.active .nav-icon {
            opacity: 1;
            filter: drop-shadow(0 0 5px var(--gold));
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: radial-gradient(circle at top right, rgba(212, 175, 55, 0.03), transparent 40%), var(--body-bg);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: rgba(15, 15, 20, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--card-border);
            padding: 0 2.5rem;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            font-family: 'Crimson Pro', serif;
            letter-spacing: -0.01em;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.4rem 1.5rem 0.4rem 0.4rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .topbar-user::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.1), transparent);
            transition: 0.5s;
        }

        .topbar-user:hover::before {
            left: 100%;
        }

        .topbar-user:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(212, 175, 55, 0.4);
            transform: translateY(-1px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .topbar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 800;
            color: var(--gold);
            border: 2px solid var(--gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .topbar-avatar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent, rgba(212, 175, 55, 0.3), transparent 30%);
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .topbar-user:hover .topbar-avatar {
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.6);
            transform: rotate(5deg);
        }

        .topbar-link {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .topbar-link:hover {
            background: rgba(231, 76, 76, 0.12) !important;
            border-color: rgba(231, 76, 76, 0.4) !important;
            color: #ff5f5f !important;
            transform: scale(1.02);
        }

        .content-area {
            flex: 1;
            padding: 2rem;
        }

        /* Stat Cards */
        .stat-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.25rem;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--gold-dim);
        }

        .stat-card .stat-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 0.5rem;
        }

        .stat-card .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--card-border);
        }

        .data-table td {
            padding: 0.75rem 1rem;
            font-size: 0.825rem;
            color: var(--text-primary);
            border-bottom: 1px solid var(--card-border);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Badges */
        .text-success {
            color: var(--green) !important;
        }

        .text-danger {
            color: var(--red) !important;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: var(--green);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: #F59E0B;
        }

        .badge-danger {
            background: rgba(231, 76, 76, 0.15);
            color: var(--red);
        }

        .badge-info {
            background: rgba(59, 130, 246, 0.15);
            color: var(--blue);
        }

        .badge-gold {
            background: rgba(212, 175, 55, 0.15);
            color: var(--gold);
        }

        /* Premium Classes */
        .premium-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            min-width: 0;
            width: 100%;
        }

        .btn-premium {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
            color: #000;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        .badge-premium {
            padding: 0.35rem 0.85rem;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .data-table thead th {
            background: rgba(255, 255, 255, 0.02);
            padding: 1.25rem 1rem;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-secondary);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .data-table tbody td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid var(--card-border);
        }

        /* Form inputs */
        .form-input {
            width: 100%;
            padding: 0.65rem 1rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 0.85rem;
            transition: border-color 0.2s;
        }

        .form-input option {
            background-color: #1A1A25;
            color: #E8E8ED;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.35rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Responsive */
        .mobile-toggle {
            display: none;
        }

        .header-section-premium {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2.5rem;
            gap: 1.5rem;
        }

        @media (max-width: 1024px) {

            /* Stack all inline grid columns to a single column on tablet and mobile viewports */
            div[style*="grid-template-columns"],
            form[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 768px) {

            html,
            body {
                max-width: 100vw;
                overflow-x: auto;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
            }

            .mobile-toggle {
                display: block !important;
            }

            .content-area {
                padding: 1rem;
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
            }

            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            /* Generalized flex selectors to stack space-between headers and flex forms on mobile */
            .content-area div[style*="display: flex"][style*="justify-content: space-between"],
            .content-area div[style*="display: flex"][style*="justify-content:space-between"],
            .content-area div[style*="display:flex"][style*="justify-content:space-between"],
            .content-area div[style*="display:flex"][style*="justify-content: space-between"],
            .content-area form[style*="display: flex"],
            .content-area form[style*="display:flex"],
            .content-area div[style*="display: flex"][style*="gap:"],
            .content-area div[style*="display:flex"][style*="gap:"] {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 1rem !important;
                margin-bottom: 1.25rem !important;
                width: 100% !important;
            }

            .content-area div[style*="display: flex"][style*="justify-content: space-between"] a,
            .content-area div[style*="display: flex"][style*="justify-content: space-between"] button,
            .content-area div[style*="display: flex"][style*="justify-content:space-between"] a,
            .content-area div[style*="display: flex"][style*="justify-content:space-between"] button,
            .content-area form[style*="display: flex"] select,
            .content-area form[style*="display: flex"] input,
            .content-area form[style*="display: flex"] button,
            .content-area form[style*="display: flex"] a {
                width: 100% !important;
                justify-content: center !important;
            }

            /* Stack all inline grid columns to a single column on mobile */
            .content-area div[style*="grid-template-columns"],
            .content-area form[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }

            /* Scale down large inline padding on mobile to maximize content space */
            .content-area div[style*="padding:"][style*="3rem"],
            .content-area div[style*="padding:"][style*="2.5rem"],
            .content-area div[style*="padding:"][style*="2rem"] {
                padding: 1.25rem 1rem !important;
            }

            /* Prevent action containers inside tables from stacking vertically on mobile */
            .content-area td div[style*="display: flex"][style*="gap"],
            .content-area td div[style*="display:flex"][style*="gap"] {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: flex-end !important;
                gap: 0.75rem !important;
                width: auto !important;
                margin-bottom: 0 !important;
            }

            .content-area td div[style*="display: flex"] a:not(.btn-premium),
            .content-area td div[style*="display: flex"] form:not(.btn-premium):not(:has(.btn-premium)),
            .content-area td div[style*="display: flex"] button:not(.btn-premium),
            .content-area td div[style*="display:flex"] a:not(.btn-premium),
            .content-area td div[style*="display:flex"] form:not(.btn-premium):not(:has(.btn-premium)),
            .content-area td div[style*="display:flex"] button:not(.btn-premium) {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin: 0 !important;
                padding: 0 !important;
                vertical-align: middle !important;
                height: 20px !important;
                width: 20px !important;
                background: none !important;
                border: none !important;
            }

            .content-area td div[style*="display: flex"] .btn-premium,
            .content-area td div[style*="display:flex"] .btn-premium {
                width: auto !important;
                height: auto !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.4rem 0.8rem !important;
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                border-radius: 8px !important;
                margin: 0 !important;
            }

            /* Prevent card horizontal breaking by putting tables inside a scrollable container */
            .content-area div:has(> table),
            .content-area div:has(> .data-table),
            .content-area .premium-card:has(table),
            .content-area .premium-card:has(.data-table),
            .content-area .card:has(table) {
                overflow-x: auto !important;
                max-width: 100% !important;
                -webkit-overflow-scrolling: touch;
            }

            .premium-card,
            .card {
                padding: 1.25rem !important;
            }

            .data-table {
                min-width: 800px !important;
            }

            .topbar {
                padding: 0 1rem;
                height: 70px;
            }

            .topbar-user {
                padding: 0.2rem 0.4rem;
            }

            .topbar-user div:last-child {
                display: none !important;
            }

            .topbar form,
            .topbar-actions>div:last-child {
                display: none !important;
                /* Hide logout button and divider on mobile topbar */
            }

            .topbar-title {
                font-size: 1.1rem;
            }

            .mobile-only-nav {
                display: block !important;
            }

            form.mobile-only-nav {
                display: flex !important;
            }
        }

        /* Premium Table Action Buttons and Hover Classes */
        .table-action-form {
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            vertical-align: middle !important;
        }

        .table-action-btn {
            background: none !important;
            border: none !important;
            color: var(--text-secondary) !important;
            cursor: pointer;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            vertical-align: middle !important;
            width: 20px !important;
            height: 20px !important;
            transition: all 0.2s ease;
        }

        .table-action-btn:hover {
            transform: scale(1.2) !important;
        }

        .table-action-btn.btn-gold:hover {
            color: var(--gold) !important;
        }

        .table-action-btn.btn-red:hover {
            color: var(--red) !important;
        }

        .table-action-btn.btn-green:hover {
            color: var(--green) !important;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- SIDEBAR OVERLAY -->
    <div id="sidebar-overlay"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:39; opacity:0; transition:opacity 0.3s ease;">
    </div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Wismilak Logo">
        </div>
        <!-- Close button (mobile only) -->
        <button id="sidebar-close"
            style="display:none; position:absolute; top:1rem; right:1rem; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; width:34px; height:34px; align-items:center; justify-content:center; cursor:pointer; color:var(--text-secondary); transition:all 0.2s; z-index:5;"
            aria-label="Close Menu">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <nav class="sidebar-nav">
            @yield('sidebar')

            <!-- Logout for Mobile -->
            <div class="nav-section mobile-only-nav" style="display: none;">Session</div>
            <form method="POST" action="{{ route('logout') }}" class="mobile-only-nav"
                style="display: none; width: 100%;">
                @csrf
                <button type="submit" class="nav-link"
                    style="color: #E74C4C; border: none; background: none; width: calc(100% - 1rem); text-align: left; cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </nav>

    </aside>

    <!-- MAIN -->
    <div class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <button class="mobile-toggle" id="sidebar-toggle"
                    style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:0.5rem; color: var(--text-primary); cursor:pointer; width:40px; height:40px; display:flex; align-items:center; justify-content:center; transition:all 0.2s; flex-shrink:0;">
                    <!-- Hamburger icon -->
                    <svg id="toggle-menu-icon" width="20" height="20" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- X icon (hidden by default) -->
                    <svg id="toggle-x-icon" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h1 class="topbar-title">@yield('title')</h1>
            </div>

            <div class="topbar-actions">
                @include('partials.notification-bell')
                <div class="topbar-user" onclick="window.location='{{ route('profile.manage') }}'">
                    <div class="topbar-avatar"
                        style="overflow: hidden; padding: 0; display: flex; align-items: center; justify-content: center;">
                        @if(auth()->user()->avatar_url)
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        @endif
                    </div>
                    <div style="display: flex; flex-direction: column; margin-right: 0.5rem;">
                        <div
                            style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem; line-height: 1.2;">
                            {{ auth()->user()->name }}
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <div
                                style="width: 6px; height: 6px; background: var(--gold); border-radius: 50%; box-shadow: 0 0 5px var(--gold);">
                            </div>
                            <span
                                style="font-size: 0.65rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;">
                                {{ auth()->user()->role->name ?? 'Member' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div style="width: 1px; height: 30px; background: rgba(255,255,255,0.1);"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="topbar-link"
                        style="background:rgba(231, 76, 76, 0.05); border: 1px solid rgba(231, 76, 76, 0.2); padding: 0.6rem 1rem; border-radius: 14px; color: #E74C4C; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: all 0.3s;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span style="font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">LOGOUT</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="content-area">
            @if(session('success'))
                <div style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3);
                            color:#10B981; padding:0.75rem 1rem; border-radius:8px; margin-bottom:1rem;
                            font-size:0.85rem;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background:rgba(231,76,76,0.1); border:1px solid rgba(231,76,76,0.3);
                            color:#E74C4C; padding:0.75rem 1rem; border-radius:8px; margin-bottom:1rem;
                            font-size:0.85rem;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const closeBtn = document.getElementById('sidebar-close');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const menuIcon = document.getElementById('toggle-menu-icon');
            const xIcon = document.getElementById('toggle-x-icon');

            function openSidebar() {
                sidebar.classList.add('open');
                if (overlay) {
                    overlay.style.display = 'block';
                    setTimeout(() => { overlay.style.opacity = '1'; }, 10);
                }
                if (menuIcon) menuIcon.style.display = 'none';
                if (xIcon) xIcon.style.display = 'block';
                if (closeBtn) closeBtn.style.display = 'flex';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                if (overlay) {
                    overlay.style.opacity = '0';
                    setTimeout(() => { overlay.style.display = 'none'; }, 300);
                }
                if (menuIcon) menuIcon.style.display = 'block';
                if (xIcon) xIcon.style.display = 'none';
                if (closeBtn) closeBtn.style.display = 'none';
            }

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    closeSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', () => closeSidebar());
            }

            // Close sidebar when a nav link is clicked on mobile
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) closeSidebar();
                });
            });
        });
    </script>
</body>

</html>