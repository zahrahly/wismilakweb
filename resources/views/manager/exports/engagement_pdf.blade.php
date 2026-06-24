<!DOCTYPE html>
<html>
<head>
    <title>Laporan Engagement - Wismilak Premium Cigars</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #2D2D2D; line-height: 1.5; }

        .page-header {
            background: linear-gradient(135deg, #1A1A25 0%, #2A2A3A 100%);
            color: #fff;
            padding: 30px 40px;
            margin-bottom: 30px;
        }
        .page-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #D4AF37;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        .page-header .subtitle {
            font-size: 11px;
            color: #A0A0B0;
        }
        .page-header .brand {
            font-size: 9px;
            color: #D4AF37;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .content { padding: 0 40px 40px; }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            background: #F8F7F5;
            border: 1px solid #E8E4DC;
            border-left: 3px solid #D4AF37;
            border-radius: 6px;
            padding: 14px 16px;
            vertical-align: top;
        }
        .stat-box .stat-label {
            font-size: 8px;
            color: #8A8A9A;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .stat-box .stat-value {
            font-size: 18px;
            font-weight: 800;
            color: #1A1A25;
        }
        .stat-box .stat-sub {
            font-size: 9px;
            color: #8A8A9A;
            margin-top: 2px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #1A1A25;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #D4AF37;
            display: inline-block;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table.data-table thead th {
            background: #1A1A25;
            color: #D4AF37;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 10px 12px;
            text-align: left;
        }
        table.data-table tbody td {
            padding: 9px 12px;
            border-bottom: 1px solid #EDEDEB;
            font-size: 10px;
            color: #2D2D2D;
        }
        table.data-table tbody tr:nth-child(even) {
            background: #FAFAF8;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #E8E4DC;
            text-align: center;
            font-size: 8px;
            color: #A0A0B0;
        }
        .footer strong { color: #D4AF37; }

        .metric-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        .metric-label {
            display: table-cell;
            width: 60%;
            font-size: 10px;
            color: #555;
            padding: 6px 0;
            border-bottom: 1px dotted #E0E0E0;
        }
        .metric-value {
            display: table-cell;
            width: 40%;
            font-size: 10px;
            font-weight: 700;
            color: #1A1A25;
            text-align: right;
            padding: 6px 0;
            border-bottom: 1px dotted #E0E0E0;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="brand">Wismilak Premium Cigars</div>
        <h1>Website Engagement Report</h1>
        <div class="subtitle">Periode: Januari - {{ now()->format('F Y') }} &bull; Generated: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="content">
        {{-- STATS GRID --}}
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                <div class="stat-sub">{{ $stats['active_users'] }} active</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Registrations</div>
                <div class="stat-value">{{ number_format($stats['total_registrations']) }}</div>
                <div class="stat-sub">event sign-ups</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Feedbacks</div>
                <div class="stat-value">{{ number_format($stats['total_feedbacks']) }}</div>
                <div class="stat-sub">user reviews</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Events</div>
                <div class="stat-value">{{ number_format($stats['total_events']) }}</div>
                <div class="stat-sub">all-time</div>
            </div>
        </div>

        {{-- DETAILED METRICS --}}
        <div class="section-title">Detailed Platform Metrics</div>
        <div style="margin-bottom: 25px;">
            <div class="metric-row">
                <span class="metric-label">Total Registered Users</span>
                <span class="metric-value">{{ number_format($stats['total_users']) }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Active Users (Earned Points)</span>
                <span class="metric-value">{{ number_format($stats['active_users']) }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">User Activation Rate</span>
                <span class="metric-value">{{ $stats['total_users'] > 0 ? round(($stats['active_users'] / $stats['total_users']) * 100, 1) : 0 }}%</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Total Event Registrations</span>
                <span class="metric-value">{{ number_format($stats['total_registrations']) }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Total Feedback Submissions</span>
                <span class="metric-value">{{ number_format($stats['total_feedbacks']) }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Feedback-to-Registration Ratio</span>
                <span class="metric-value">{{ $stats['total_registrations'] > 0 ? round(($stats['total_feedbacks'] / $stats['total_registrations']) * 100, 1) : 0 }}%</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Total Events Created</span>
                <span class="metric-value">{{ number_format($stats['total_events']) }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Average Registrations per Event</span>
                <span class="metric-value">{{ $stats['total_events'] > 0 ? round($stats['total_registrations'] / $stats['total_events'], 1) : 0 }}</span>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <strong>WISMILAK PREMIUM CIGARS</strong> &mdash; Confidential Report<br>
            This document is auto-generated. Data reflects real-time platform analytics as of {{ now()->format('d M Y, H:i') }}.
        </div>
    </div>
</body>
</html>
