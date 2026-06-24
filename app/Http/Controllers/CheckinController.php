<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\EventCheckin;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckinController extends Controller
{
    public function scan()
    {
        return view('admin.checkin.scan');
    }

    public function process(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            $qrData = json_decode($request->qr_data, true);

            if (!$qrData || !isset($qrData['ticket_id'], $qrData['ticket_number'], $qrData['hash'])) {
                return response()->json(['success' => false, 'message' => 'Invalid QR code data.'], 400);
            }

            $ticket = Ticket::with(['event', 'user'])->find($qrData['ticket_id']);

            if (!$ticket) {
                return response()->json(['success' => false, 'message' => 'Ticket not found.'], 404);
            }

            // Verify hash
            $expectedHash = hash('sha256', $ticket->ticket_number . $ticket->id . config('app.key'));
            if ($qrData['hash'] !== $expectedHash) {
                return response()->json(['success' => false, 'message' => 'Invalid ticket - hash mismatch.'], 403);
            }

            // Check if already checked in
            if ($ticket->isCheckedIn()) {
                $checkin = $ticket->checkin;
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket already checked in at ' . $checkin->checked_in_at->format('H:i, d M Y'),
                ], 409);
            }

            // Process check-in
            $pointsAwarded = 10;

            $ticket->update([
                'status' => 'checked_in'
            ]);

            $checkin = EventCheckin::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->user_id,
                'event_id' => $ticket->event_id,
                'checked_in_at' => now(),
                'points_awarded' => $pointsAwarded,
            ]);

            // Award points
            PointHistory::earn(
                $ticket->user_id,
                $pointsAwarded,
                'checkin',
                "Check-in at event: {$ticket->event->title}",
                $checkin->id
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

            return response()->json([
                'success' => true,
                'message' => 'Check-in successful!',
                'data' => [
                    'ticket_number' => $ticket->ticket_number,
                    'attendee' => $ticket->full_name ?? $ticket->user->name ?? 'Unknown',
                    'event' => $ticket->event->title ?? 'Unknown',
                    'checked_in_at' => now()->format('H:i, d M Y'),
                    'points_awarded' => $pointsAwarded,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Check-in failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Check-in failed. Please try again.'], 500);
        }
    }
}
