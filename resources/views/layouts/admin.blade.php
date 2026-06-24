<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | Wismilak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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
            --card-border: rgba(255, 255, 255, 0.18);
            --text-primary: #E8E8ED;
            --text-secondary: #8A8A9A;
            --gold: #D4AF37;
            --gold-dim: rgba(212, 175, 55, 0.4);
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
            background: var(--body-bg) !important;
            color: var(--text-primary) !important;
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
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid var(--card-border);
        }

        .sidebar-brand h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 0.05em;
        }

        .sidebar-brand small {
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            color: var(--sidebar-text);
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .nav-section {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--sidebar-text);
            padding: 1.25rem 1.25rem 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.25rem;
            margin: 0.1rem 0.5rem;
            font-size: 0.825rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
            border: none;
            background: none;
            cursor: pointer;
            width: calc(100% - 1rem);
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: var(--sidebar-active);
            color: var(--sidebar-text-active);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: var(--gold);
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .nav-link.active .nav-icon {
            opacity: 1;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: rgba(15, 15, 20, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--card-border);
            padding: 0 2rem;
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
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 0.4rem 1.5rem 0.4rem 0.4rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
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
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
            transition: all 0.3s;
        }

        .topbar-link {
            font-size: 0.75rem;
            color: #E74C4C;
            text-decoration: none;
            transition: all 0.2s;
            background: rgba(231, 76, 76, 0.05);
            border: 1px solid rgba(231, 76, 76, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .topbar-link:hover {
            background: rgba(231, 76, 76, 0.1);
            color: #ff5f5f;
            transform: scale(1.02);
        }

        .content-area {
            flex: 1;
            padding: 2rem;
        }

        /* Override Tailwind classes for dark theme */
        .bg-white {
            background: var(--card-bg) !important;
        }

        .bg-\[#F8F9FB\] {
            background: var(--body-bg) !important;
        }

        .bg-gray-50,
        .hover\:bg-gray-50:hover {
            background: rgba(255, 255, 255, 0.02) !important;
        }

        .bg-gray-100,
        .hover\:bg-gray-100:hover {
            background: rgba(255, 255, 255, 0.04) !important;
        }

        .bg-gray-200 {
            background: rgba(255, 255, 255, 0.06) !important;
        }

        .text-gray-800,
        .text-gray-700,
        .text-gray-900 {
            color: var(--text-primary) !important;
        }

        .text-gray-600,
        .text-gray-500,
        .text-gray-400 {
            color: var(--text-secondary) !important;
        }

        .border,
        .border-gray-200,
        .border-b,
        .border-r,
        .divide-y> :not([hidden])~ :not([hidden]) {
            border-color: var(--card-border) !important;
        }

        .shadow,
        .shadow-lg,
        .shadow-sm {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
        }

        .rounded-2xl,
        .rounded-xl {
            border-radius: 12px !important;
        }

        /* Status badges dark theme */
        .bg-blue-100 {
            background: rgba(59, 130, 246, 0.15) !important;
        }

        .text-blue-600 {
            color: #3B82F6 !important;
        }

        .bg-green-100 {
            background: rgba(16, 185, 129, 0.15) !important;
        }

        .text-green-600,
        .text-green-700 {
            color: #10B981 !important;
        }

        .bg-red-100 {
            background: rgba(231, 76, 76, 0.15) !important;
        }

        .text-red-600,
        .text-\[#B91C1C\] {
            color: #E74C4C !important;
        }

        .bg-yellow-100 {
            background: rgba(245, 158, 11, 0.15) !important;
        }

        .text-yellow-700 {
            color: #F59E0B !important;
        }

        .bg-indigo-100 {
            background: rgba(99, 102, 241, 0.15) !important;
        }

        .text-indigo-700 {
            color: #6366F1 !important;
        }

        /* Button overrides */
        .bg-indigo-700,
        .bg-indigo-800 {
            background: linear-gradient(135deg, var(--gold), #B8860B) !important;
            color: #000 !important;
        }

        .bg-red-50,
        .bg-red-100.hover\:bg-red-200:hover {
            background: rgba(231, 76, 76, 0.15) !important;
        }

        .bg-yellow-100.hover\:bg-yellow-200:hover {
            background: rgba(245, 158, 11, 0.25) !important;
        }

        /* Form inputs dark theme */
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="date"],
        input[type="datetime-local"],
        input[type="file"],
        input[type="tel"],
        input[type="url"],
        input[type="time"],
        textarea,
        select {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: var(--card-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
            color-scheme: dark;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--gold) !important;
            box-shadow: 0 0 0 3px var(--gold-dim) !important;
            outline: none !important;
        }

        label {
            color: var(--text-secondary) !important;
        }

        /* Additional dark theme overrides */
        .border-gray-300 {
            border-color: var(--card-border) !important;
        }

        .text-gray-400 {
            color: var(--text-secondary) !important;
        }

        .text-gray-300 {
            color: var(--text-secondary) !important;
        }

        .bg-indigo-50 {
            background: rgba(99, 102, 241, 0.15) !important;
        }

        .text-indigo-700 {
            color: #6366F1 !important;
        }

        .file\:bg-indigo-50::-webkit-file-upload-button {
            background: rgba(99, 102, 241, 0.15) !important;
            color: #6366F1 !important;
            border: none !important;
        }

        input::placeholder,
        textarea::placeholder {
            color: var(--text-secondary) !important;
            opacity: 0.7;
        }

        option {
            background: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }

        /* Alert overrides */
        .bg-green-100,
        .bg-green-50 {
            background: rgba(16, 185, 129, 0.1) !important;
        }

        .text-green-800 {
            color: #10B981 !important;
        }

        /* Pagination dark theme */
        nav[role="navigation"] span,
        nav[role="navigation"] a {
            background: var(--card-bg) !important;
            border-color: var(--card-border) !important;
            color: var(--text-secondary) !important;
        }

        nav[role="navigation"] span[aria-current] {
            background: var(--gold) !important;
            color: #000 !important;
        }

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

            /* Flex actions in forms and details stacking */
            .content-area div[style*="display: flex; gap: 1rem;"],
            .content-area div[style*="display: flex; gap: 1.5rem;"],
            .content-area div[style*="display: flex; gap: 0.5rem;"],
            .scanner-actions,
            .manual-input-box div[style*="display: flex; gap: 1rem;"],
            .manual-input-box div[style*="display: flex; gap: 1rem"] {
                flex-direction: column !important;
                align-items: stretch !important;
                width: 100% !important;
                gap: 1rem !important;
            }

            .content-area div[style*="display: flex; gap: 1rem;"] form,
            .content-area div[style*="display: flex; gap: 1.5rem;"] form,
            .content-area div[style*="display: flex; gap: 0.5rem;"] form {
                width: 100% !important;
                max-width: 100% !important;
            }

            .content-area div[style*="display: flex; gap: 1rem;"] button,
            .content-area div[style*="display: flex; gap: 1.5rem;"] button,
            .scanner-actions button,
            .manual-input-box button {
                width: 100% !important;
                min-width: unset !important;
                justify-content: center !important;
            }

            .scanner-hero {
                padding: 1.25rem !important;
            }

            .manual-input-box {
                padding: 1rem !important;
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

            .premium-card {
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

            .topbar form {
                display: none !important;
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

        /* Standardized Premium UI Components */
        .premium-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.02), 0 10px 30px rgba(0, 0, 0, 0.4);
            min-width: 0;
            width: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--card-border);
            font-weight: 700;
        }

        .data-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .data-table tr:hover {
            background: rgba(255, 255, 255, 0.01);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .badge-premium {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            display: inline-block;
            text-transform: uppercase;
        }

        .btn-premium {
            background: linear-gradient(135deg, var(--gold), #B8860B);
            color: #000 !important;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.2);
        }

        .btn-premium svg {
            width: 18px;
            height: 18px;
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
        <div class="sidebar-brand"
            style="display: flex; justify-content: center; align-items: center; padding: 2rem 1.25rem; position: relative;">
            <img src="{{ asset('images/logo.png') }}" alt="Wismilak Logo"
                style="width: 140px; filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.2));">
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
            @include('admin.partials.sidebar')
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="main-content">
        <!-- TOPBAR -->
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="mobile-toggle" id="sidebar-toggle"
                    style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:0.5rem; color: var(--text-primary); cursor:pointer; width:40px; height:40px; display:flex; align-items:center; justify-content:center; transition:all 0.2s; flex-shrink:0;">
                    <svg id="toggle-menu-icon" width="20" height="20" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="toggle-x-icon" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h1 class="topbar-title">@yield('title')</h1>
            </div>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
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
                            {{ auth()->user()->name }}</div>
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <div
                                style="width: 6px; height: 6px; background: var(--gold); border-radius: 50%; box-shadow: 0 0 5px var(--gold);">
                            </div>
                            <span
                                style="font-size: 0.65rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase;">Admin</span>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="topbar-link">LOGOUT</button>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="content-area">
            @if(session('success'))
                <div class="flash-msg flash-success"
                    style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); color:#10B981; padding:0.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:0.85rem; display:flex; justify-content:space-between; align-items:center; animation: fadeIn 0.3s ease;">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()"
                        style="background:none; border:none; color:#10B981; cursor:pointer; font-size:1.1rem; padding:0 0.25rem;">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="flash-msg flash-error"
                    style="background:rgba(231,76,76,0.1); border:1px solid rgba(231,76,76,0.3); color:#E74C4C; padding:0.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:0.85rem; display:flex; justify-content:space-between; align-items:center; animation: fadeIn 0.3s ease;">
                    <span>❌ {{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()"
                        style="background:none; border:none; color:#E74C4C; cursor:pointer; font-size:1.1rem; padding:0 0.25rem;">&times;</button>
                </div>
            @endif
            @if(session('info'))
                <div class="flash-msg flash-info"
                    style="background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.3); color:#3B82F6; padding:0.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:0.85rem; display:flex; justify-content:space-between; align-items:center; animation: fadeIn 0.3s ease;">
                    <span>ℹ️ {{ session('info') }}</span>
                    <button onclick="this.parentElement.remove()"
                        style="background:none; border:none; color:#3B82F6; cursor:pointer; font-size:1.1rem; padding:0 0.25rem;">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        // Auto-dismiss flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.flash-msg').forEach(function (el) {
                setTimeout(function () {
                    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(function () { el.remove(); }, 500);
                }, 5000);
            });

            const toggleBtn = document.getElementById('sidebar-toggle');
            const closeBtn = document.getElementById('sidebar-close');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const menuIcon = document.getElementById('toggle-menu-icon');
            const xIcon = document.getElementById('toggle-x-icon');

            function openSidebar() {
                sidebar.classList.add('open');
                if (overlay) { overlay.style.display = 'block'; setTimeout(() => { overlay.style.opacity = '1'; }, 10); }
                if (menuIcon) menuIcon.style.display = 'none';
                if (xIcon) xIcon.style.display = 'block';
                if (closeBtn) closeBtn.style.display = 'flex';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                if (overlay) { overlay.style.opacity = '0'; setTimeout(() => { overlay.style.display = 'none'; }, 300); }
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
            if (closeBtn) closeBtn.addEventListener('click', (e) => { e.stopPropagation(); closeSidebar(); });
            if (overlay) overlay.addEventListener('click', () => closeSidebar());
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => { if (window.innerWidth <= 768) closeSidebar(); });
            });
        });
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>