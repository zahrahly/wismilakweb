<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\EventCheckin;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckinController extends Controller
{
    public function scan(Request $request)
    {
        $events = Event::where('created_by', Auth::id())
            ->whereIn('status', ['published', 'ongoing', 'approved'])
            ->latest()
            ->get();

        $eventId = $request->event_id;

        $recentCheckins = EventCheckin::with(['ticket.event'])
            ->whereHas('event', fn($q) => $q->where('created_by', Auth::id()))
            ->when($eventId, function ($q) use ($eventId) {
                $q->where('event_id', $eventId);
            })
            ->whereDate('checked_in_at', today())
            ->latest()
            ->take(10)
            ->get();

        return view('partner.checkin.scan', compact('recentCheckins', 'eventId', 'events'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {

            $raw = $request->qr_data;

            $data = json_decode($raw, true);

            /**
             * FORMAT 1: QR JSON SECURE
             */
            if ($data && isset($data['ticket_id']) && isset($data['hash'])) {

                $ticket = Ticket::with(['event', 'user'])
                    ->find($data['ticket_id']);

                if (!$ticket) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tiket tidak ditemukan.'
                    ], 404);
                }

                // VERIFY HASH
                $expectedHash = hash(
                    'sha256',
                    $ticket->ticket_number .
                    $ticket->id .
                    config('app.key')
                );

                if ($data['hash'] !== $expectedHash) {
                    return response()->json([
                        'success' => false,
                        'message' => 'QR code tidak valid (hash mismatch).'
                    ], 403);
                }

            }

            /**
             * FORMAT 2: TICKET NUMBER ONLY
             */
            else {

                $ticket = Ticket::with(['event', 'user'])
                    ->where('ticket_number', $raw)
                    ->first();

                if (!$ticket) {
                    return response()->json([
                        'success' => false,
                        'message' => 'QR code tidak valid.'
                    ], 400);
                }
            }


            /**
             * VALIDATE: event must belong to this partner
             */
            if ($ticket->event->created_by !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket ini bukan untuk event Anda.'
                ], 403);
            }


            /**
             * VALIDATE: ticket status
             */
            if ($ticket->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket tidak aktif.'
                ], 400);
            }


            /**
             * CHECK IF ALREADY CHECKED IN
             */
            if (EventCheckin::where('ticket_id', $ticket->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket sudah di-check-in sebelumnya.',
                    'ticket'  => [
                        'number' => $ticket->ticket_number,
                        'user' => $ticket->full_name ?? $ticket->user->name,
                        'event'  => $ticket->event->title,
                    ],
                ], 409);
            }


            /**
             * PROCESS CHECK-IN
             */
            $pointsAwarded = 10;

            EventCheckin::create([
                'ticket_id'      => $ticket->id,
                'user_id'        => $ticket->user_id,
                'event_id'       => $ticket->event_id,
                'checked_in_at'  => now(),
                'points_awarded' => $pointsAwarded,
            ]);

            $ticket->update([
                'status' => 'checked_in'
            ]);

            PointHistory::earn(
                $ticket->user_id,
                $pointsAwarded,
                'checkin',
                "Check-in event: {$ticket->event->title}",
                $ticket->id
            );

            // Dispatch Notifications
            try {
                // 1. Notify Customer (Attendee)
                \App\Models\Notification::send(
                    $ticket->user_id,
                    'Check-in Berhasil',
                    "Check-in Anda untuk event '{$ticket->event->title}' berhasil. Selamat, Anda mendapatkan +{$pointsAwarded} poin loyalty!",
                    'event'
                );

                // 2. Notify Partner (Event Creator)
                $eventCreatorId = $ticket->event->created_by;
                if ($eventCreatorId) {
                    \App\Models\Notification::send(
                        $eventCreatorId,
                        'Check-in Peserta Baru',
                        "Peserta '{$ticket->full_name}' telah berhasil melakukan check-in untuk event '{$ticket->event->title}' Anda.",
                        'event'
                    );
                }

                // 3. Notify Admins
                $admins = \App\Models\User::whereHas('role', function($q) { $q->where('name', 'admin'); })->get();
                foreach ($admins as $adm) {
                    if ($adm->id !== $eventCreatorId) {
                        \App\Models\Notification::send(
                            $adm->id,
                            'Check-in Peserta Baru',
                            "Peserta '{$ticket->full_name}' telah melakukan check-in untuk event '{$ticket->event->title}'.",
                            'event'
                        );
                    }
                }
            } catch (\Exception $ne) {
                Log::error('Check-in notification failed: ' . $ne->getMessage());
            }

            /**
             * PROSES KLAIM REWARD (JIKA ADA)
             */
            $rewardTitle = null;
            $ticket->load('eventRegistration.rewardRedemption.reward');
            if ($ticket->eventRegistration && $ticket->eventRegistration->rewardRedemption) {
                $redemption = $ticket->eventRegistration->rewardRedemption;
                if (in_array($redemption->status, ['pending', 'approved'])) {
                    $redemption->update(['status' => 'completed']);
                    $rewardTitle = $redemption->reward->title ?? null;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'ticket'  => [
                    'number' => $ticket->ticket_number,
                    'user' => $ticket->full_name ?? $ticket->user->name,
                    'event'  => $ticket->event->title,
                    'points' => $pointsAwarded,
                    'reward' => $rewardTitle,
                ],
            ]);


        } catch (\Exception $e) {

            Log::error('Partner checkin process failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }
}
