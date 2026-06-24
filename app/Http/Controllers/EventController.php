<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
   public function index(Request $request)
{
    $month = $request->month 
        ? \Carbon\Carbon::parse($request->month)
        : now();

    // Auto-update event statuses
    Event::autoUpdateStatuses();

    $events = Event::visibleToCustomers()
        ->orderBy('date')
        ->get();

    $eventsByDate = $events->groupBy(function ($event) {
        return \Carbon\Carbon::parse($event->date)->format('Y-m-d');
    });

    return view('customer.events.index', compact(
        'events',
        'eventsByDate',
        'month'
    ));
}

   public function show(Event $event)
{
    $alreadyRegistered = false;

    if(Auth::check()){
        $alreadyRegistered = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();
    }

    return view('customer.events.show', compact(
    'event',
    'alreadyRegistered'
    ));
}

    public function register(Event $event)
    {
   if (\Carbon\Carbon::parse($event->date)->endOfDay()->isPast()) {
    return back()->with('error', 'Event sudah berakhir.');
}

        if (in_array($event->status, ['quota_full', 'completed'])) {
            return back()->with('error', 'Event tidak tersedia untuk registrasi.');
        }
    
        if ($event->remaining_quota <= 0) {
            return back()->with('error', 'Kuota sudah penuh.');
        }

        // Prevent duplicate registrations
        $existing = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah terdaftar di event ini.');
        }

        $isFree = $event->price_type === 'free';

        $registration = EventRegistration::create([
            'event_id'       => $event->id,
            'user_id'        => Auth::id(),
            'full_name'      => Auth::user()->name,
            'phone'          => Auth::user()->customerProfile?->phone ?? '-',
            'quantity'        => 1,
            'ticket_price'   => $isFree ? 0 : $event->price,
            'total_amount'   => $isFree ? 0 : $event->price,
            'payment_status' => $isFree ? 'paid' : 'pending',
            'expired_at'     => $isFree ? null : now()->addHours(24),
        ]);

        if ($isFree) {
            // Create transaction
            \App\Models\Transaction::create([
                'registration_id'  => $registration->id,
                'user_id'          => Auth::id(),
                'amount'           => 0,
                'payment_method'   => 'free',
                'transaction_code' => \App\Models\Transaction::generateCode(),
                'status'           => 'paid',
                'paid_at'          => now(),
            ]);

            // Create ticket
            \App\Models\Ticket::create([
                'ticket_number'         => 'TCK-' . strtoupper(\Illuminate\Support\Str::random(10)),
                'event_registration_id' => $registration->id,
                'user_id'               => Auth::id(),
                'event_id'              => $event->id,
                'status'                => 'active',
            ]);

            // Award 10 points
            $userPoint = \App\Models\UserPoint::firstOrCreate(
                ['user_id' => Auth::id()],
                ['total_points' => 0]
            );
            $userPoint->increment('total_points', 10);

            // Record point history
            \App\Models\PointHistory::create([
                'user_id'      => Auth::id(),
                'points'       => 10,
                'type'         => 'earn',
                'source'       => 'event_registration',
                'reference_id' => $registration->id,
                'description'  => 'Pendaftaran event: ' . $event->title,
            ]);

            $event->decrement('remaining_quota');

            return back()->with('success', 'Berhasil mendaftar event! Tiket Anda sudah tersedia. +10 poin.');
        }

}
}