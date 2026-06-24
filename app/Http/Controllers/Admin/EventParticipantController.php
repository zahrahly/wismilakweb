<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;

class EventParticipantController extends Controller
{

    public function index()
    {
        $events = Event::whereIn('status', ['published', 'approved'])
            ->orWhere('verification_status', 'approved')
            ->withCount([
                'paidTickets as total_tickets_count',
                'paidTickets as checked_in_tickets_count' => function ($q) {
                    $q->whereHas('checkin');
                }
            ])
            ->latest()
            ->get();

        return view('admin.event.participants.index', compact('events'));
    }

    public function show(Event $event)
    {
        $participants = EventRegistration::where('event_id', $event->id)
            ->where('payment_status', 'paid')
            ->with(['user', 'generatedTickets.checkin', 'eventTickets'])
            ->latest()
            ->get();

        $totalTickets = $participants->sum(function ($reg) {
            return $reg->generatedTickets->count()
                ?: ($reg->eventTickets->count()
                ?: $reg->quantity);
        });

        return view(
            'admin.event.participants.detail',
            compact('event', 'participants', 'totalTickets')
        );
    }

    /**
     * Detail peserta individu — data registrasi lengkap (KTP, tanggal lahir, dll)
     */
    public function participantDetail(Event $event, Ticket $ticket)
    {
        if ($ticket->event_id !== $event->id) {
            abort(404);
        }

        $ticket->load([
            'event',
            'user',
            'eventRegistration.transaction',
            'eventRegistration.eventTickets',
            'eventRegistration.voucherRedemption.voucher',
            'eventRegistration.rewardRedemption.reward',
            'checkin',
        ]);

        // Find matching EventTicket for this participant's KTP/form data
        $eventTicket = null;
        if ($ticket->eventRegistration) {
            $eventTicket = $ticket->eventRegistration->eventTickets
                ->first(fn($et) => $et->full_name === $ticket->full_name || $et->email === $ticket->email);
        }

        return view('admin.event.participants.participant-detail', compact('event', 'ticket', 'eventTicket'));
    }

    /**
     * Download tiket PDF dari admin
     */
    public function downloadTicket(Ticket $ticket)
    {
        $ticket->load([
            'event.packages',
            'event.outlets',
            'eventRegistration.rewardRedemption.reward',
        ]);

        $pdf = Pdf::loadView('customer.tickets.pdf', compact('ticket'))
            ->setOptions([
                'isRemoteEnabled'     => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont'         => 'sans-serif',
            ]);

        $pdf->setPaper('A5', 'landscape');

        return $pdf->download('ticket-' . $ticket->ticket_number . '.pdf');
    }
}
