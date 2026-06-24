<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket — {{ $ticket->ticket_number }}</title>
    <style>
        @page {
            margin: 10px;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            background: #fdfbf7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        /* Main Container */
        .ticket-wrapper {
            width: 100%;
            border-radius: 12px;
            border: 2px solid #D4AF37;
            background: #ffffff;
        }

        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Left Side (Main) */
        .ticket-main {
            width: 70%;
            padding: 24px;
            vertical-align: top;
            background: #ffffff;
        }

        /* Right Side (Stub) */
        .ticket-stub {
            width: 30%;
            padding: 15px;
            background: #1a1a24;
            color: #ffffff;
            vertical-align: middle;
            text-align: center;
            border-left: 2px dashed #D4AF37;
        }

        /* Branding */
        .brand-header {
            width: 100%;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .brand-title {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #1a1a24;
            display: inline-block;
        }
        .brand-subtitle {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #D4AF37;
            font-weight: 700;
            float: right;
            margin-top: 4px;
        }

        /* Event Info */
        .event-title {
            font-size: 18px;
            font-weight: 700;
            color: #111;
            margin-bottom: 10px;
            line-height: 1.25;
        }

        /* Grid data using tables for DomPDF safety */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .info-table td {
            vertical-align: top;
            padding-bottom: 8px;
            width: 50%;
        }
        
        .label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #888;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .value {
            font-size: 12px;
            color: #222;
            font-weight: 600;
            line-height: 1.35;
        }
        .value-sub {
            font-size: 10px;
            color: #666;
            font-weight: 400;
            margin-top: 2px;
        }

        /* Privileges */
        .privilege-box {
            background: #fdfbf7;
            border: 1px solid #f0e6d2;
            padding: 8px;
            border-radius: 6px;
            margin-top: 4px;
        }
        .privilege-text {
            font-size: 10px;
            color: #555;
            font-style: italic;
        }

        /* Footer */
        .ticket-footer {
            margin-top: 10px;
            padding-top: 6px;
            border-top: 1px solid #eee;
            font-size: 8px;
            color: #aaa;
        }
        .footer-left { float: left; }
        .footer-right { float: right; }

        /* Stub Elements */
        .stub-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #D4AF37;
            margin-bottom: 12px;
            font-weight: 700;
        }
        .qr-container {
            background: #ffffff;
            padding: 8px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 12px;
        }
        .qr-container img {
            width: 100px;
            height: 100px;
            display: block;
        }
        .ticket-number {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #ffffff;
            margin-bottom: 12px;
        }
        .admit-badge {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #1a1a24;
            background: #D4AF37;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="ticket-wrapper">
        <table class="ticket-table">
            <tr>
                <!-- MAIN SECTION -->
                <td class="ticket-main">
                    <div class="brand-header">
                        <div class="brand-title">Wismilak Cigars</div>
                        <div class="brand-subtitle">Official e-Ticket</div>
                        <div class="clear"></div>
                    </div>

                    <div class="event-title">{{ $ticket->event->title ?? 'N/A' }}</div>

                    <table class="info-table">
                        <tr>
                            <td>
                                <div class="label">Date</div>
                                <div class="value">
                                    {{ $ticket->event->date ? \Carbon\Carbon::parse($ticket->event->date)->format('l, j F Y') : 'TBA' }}
                                </div>
                            </td>
                            <td>
                                <div class="label">Time</div>
                                <div class="value">
                                    {{ $ticket->event->start_time ? \Carbon\Carbon::parse($ticket->event->start_time)->format('H:i') : '-' }}
                                    @if($ticket->event->end_time) &mdash; {{ \Carbon\Carbon::parse($ticket->event->end_time)->format('H:i') }} @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label">Participant</div>
                                <div class="value">{{ $ticket->full_name ?? $ticket->user->name ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="label">Ticket Number</div>
                                <div class="value">{{ $ticket->ticket_number }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label">Location</div>
                                <div class="value">
                                    @if($ticket->event->outlets && $ticket->event->outlets->count() > 0)
                                        {{ $ticket->event->outlets->first()->name }}
                                        <div class="value-sub">{{ $ticket->event->outlets->first()->pivot->location_detail ?? $ticket->event->outlets->first()->city }}</div>
                                    @else
                                        {{ $ticket->event->location ?? 'N/A' }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($ticket->event->contact_person_name)
                                    <div class="label">Contact Person</div>
                                    <div class="value">{{ $ticket->event->contact_person_name }}</div>
                                    <div class="value-sub">{{ $ticket->event->contact_person_phone }}</div>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($ticket->event->packages && $ticket->event->packages->count() > 0)
                    <div class="privilege-box">
                        <div class="label" style="color: #D4AF37;">Privileges</div>
                        <div class="privilege-text">
                            @foreach($ticket->event->packages as $package)
                                {{ $package->title }}@if(!$loop->last) &bull; @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($ticket->eventRegistration && $ticket->eventRegistration->rewardRedemption && $ticket->eventRegistration->rewardRedemption->reward)
                    <div class="privilege-box" style="border-color: #D4AF37; background: #fffcf5; margin-top: 8px;">
                        <div class="label" style="color: #D4AF37; font-weight: bold;">🎁 Reward Merchandise</div>
                        <div class="privilege-text" style="color: #111; font-weight: 600; font-style: normal;">
                            {{ $ticket->eventRegistration->rewardRedemption->reward->title }}
                        </div>
                    </div>
                    @endif


                    <div class="ticket-footer">
                        <div class="footer-left">Present this ticket (printed or digital) at the registration desk.</div>
                        <div class="footer-right">Issued: {{ $ticket->created_at->format('j M Y, H:i') }}</div>
                        <div class="clear"></div>
                        <div style="color: #c8534f; font-weight: bold; margin-top: 5px; font-size: 8px;">* Seluruh tiket yang dibeli tidak dapat dibatalkan atau dikembalikan.</div>
                    </div>
                </td>

                <!-- STUB SECTION -->
                <td class="ticket-stub">
                    <div class="stub-title">Scan to Check-in</div>
                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($ticket->ticket_number) }}&margin=0" alt="QR Code">
                    </div>
                    <div class="ticket-number">{{ $ticket->ticket_number }}</div>
                    <div class="admit-badge">Admit One</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
