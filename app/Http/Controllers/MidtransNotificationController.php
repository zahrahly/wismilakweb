<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\EventTicket;
use App\Models\VoucherRedemption;
use App\Models\PointHistory;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class MidtransNotificationController extends Controller
{
    /**
     * Midtrans status → internal payment_status mapping
     */
    private function mapPaymentStatus(string $midtransStatus, string $fraudStatus = 'accept'): string
    {
        if (in_array($midtransStatus, ['capture', 'settlement'])) {
            return $fraudStatus === 'challenge' ? 'pending' : 'paid';
        }

        if (in_array($midtransStatus, ['cancel', 'deny', 'expire'])) {
            return 'failed';
        }

        if ($midtransStatus === 'pending') {
            return 'pending';
        }

        return 'pending';
    }

    public function handleNotification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification || empty($notification->order_id)) {
            Log::warning('Midtrans: invalid payload');
            return response(['message'=>'Invalid payload'],400);
        }

        /**
         * VERIFY SIGNATURE
         */
        $signatureKey = hash(
            'sha512',
            $notification->order_id .
            $notification->status_code .
            $notification->gross_amount .
            config('services.midtrans.server_key')
        );

        if ($notification->signature_key !== $signatureKey) {
            Log::warning('Midtrans invalid signature');
            return response(['message'=>'Invalid signature'],403);
        }

        /**
         * GET REGISTRATION ID
         * format: EVT-{id}-{timestamp}
         */
        $parts = explode('-', $notification->order_id);
        $registrationId = $parts[1] ?? null;

        if (!$registrationId) {
            return response(['message'=>'Bad order_id'],400);
        }

        $registration = EventRegistration::with('event')->find($registrationId);

        if (!$registration) {
            return response(['message'=>'Registration not found'],404);
        }

        $midtransStatus = $notification->transaction_status;
        $fraud  = $notification->fraud_status ?? 'accept';

        Log::info('Midtrans webhook received', [
            'registration'     => $registrationId,
            'midtrans_status'  => $midtransStatus,
            'fraud_status'     => $fraud,
            'order_id'         => $notification->order_id,
        ]);

        /**
         * ✅ Map Midtrans status to internal payment_status
         */
        $paymentStatus = $this->mapPaymentStatus($midtransStatus, $fraud);

        /**
         * SUCCESS PAYMENT
         */
        if ($paymentStatus === 'paid') {
            $this->processSuccessPayment($registration, $notification);
        }

        /**
         * FAILED PAYMENT
         */
        elseif ($paymentStatus === 'failed') {
            $registration->update([
                'payment_status' => 'failed'
            ]);

            Log::info("Registration #{$registrationId} marked as failed (midtrans: {$midtransStatus})");
        }

        /**
         * STILL PENDING
         */
        elseif ($paymentStatus === 'pending') {
            $registration->update([
                'payment_status' => 'pending'
            ]);
        }

        return response(['message'=>'OK'],200);
    }


    /**
     * Single source of truth for all payment success logic.
     * Called from webhook AND fallback payment success check.
     *
     * ✅ Idempotent: will not double-process if already paid
     * ✅ All final logic here: quota, tickets, voucher, points, transaction
     */
    public function processSuccessPayment(
        EventRegistration $registration,
        object $notification
    ): void
    {

        /**
         * Prevent duplicate processing
         */
        if ($registration->payment_status === 'paid') {
            Log::info("Registration #{$registration->id} already paid, skipping.");
            return;
        }

        DB::transaction(function () use (
            $registration,
            $notification
        ){

            /**
             * ✅ ATOMIC QUOTA CHECK — prevent overbooking (race condition)
             */
            $event = Event::lockForUpdate()->find($registration->event_id);

            if ($event->remaining_quota < $registration->quantity) {
                Log::error("Overbooking prevented for registration #{$registration->id}. Quota: {$event->remaining_quota}, requested: {$registration->quantity}");
                // Mark as failed — not enough quota
                $registration->update(['payment_status' => 'failed']);
                return;
            }


            /**
             * UPDATE REGISTRATION STATUS
             * ✅ Use mapped status: 'paid'
             */
            $registration->update([
                'payment_status' => 'paid'
            ]);


            /**
             * ✅ REDUCE EVENT QUOTA — only here, single source of truth
             */
            $event->decrement(
                'remaining_quota',
                $registration->quantity
            );

            // Auto-update event status if quota is now zero
            if ($event->remaining_quota <= 0) {
                $event->update(['status' => 'quota_full']);
            }


            /**
             * ✅ CREATE TRANSACTION — always new record, never updateOrCreate
             */
            $transactionCode = $notification->transaction_id
                ?? ('TRX-' . strtoupper(uniqid()) . '-' . now()->format('Ymd'));

            /**
             * ✅ Use paid_at from Midtrans transaction_time, not now()
             */
            $paidAt = isset($notification->transaction_time)
                ? Carbon::parse($notification->transaction_time)
                : now();

            Transaction::create([
                'registration_id'  => $registration->id,
                'user_id'          => $registration->user_id,
                'amount'           => $registration->total_amount,
                'payment_method'   => $notification->payment_type ?? 'midtrans',
                'transaction_code' => $transactionCode,
                'status'           => 'paid',
                'paid_at'          => $paidAt,

                /**
                 * ✅ Store raw Midtrans response for debugging & audit
                 */
                'gateway_response' => json_encode($notification),
            ]);


            /**
             * ✅ GENERATE TICKETS — idempotent
             */
            $this->generateTickets($registration);


            /**
             * ✅ UPDATE VOUCHER STATUS — only on payment success
             */
            if ($registration->voucher_redemption_id) {

                $redemption = VoucherRedemption::with('voucher')
                    ->find($registration->voucher_redemption_id);

                if ($redemption && $redemption->status !== 'used') {
                    $redemption->update(['status' => 'used']);

                    if ($redemption->voucher) {
                        $redemption->voucher->increment('used_count');
                    }
                }

            }


            /**
             * GIVE POINTS
             */
            PointHistory::earn(

                $registration->user_id,

                $registration->quantity * 10,

                'event_payment',

                "Reward tiket event: {$registration->event->title}",

                $registration->id

            );

            // Dispatch payment success notifications
            try {
                // 1. Notify Customer
                Notification::send($registration->user_id, 'Pembayaran Sukses', 'Pembayaran Anda sebesar Rp' . number_format($registration->total_amount, 0, ',', '.') . ' untuk event "' . $registration->event->title . '" telah berhasil diterima. Tiket Anda aktif.', 'transaction');

                // 2. Notify Admins
                $admins = User::whereHas('role', function($q) { $q->where('name', 'admin'); })->get();
                foreach ($admins as $adm) {
                    Notification::send($adm->id, 'Pembayaran Sukses (Admin)', 'Pembayaran tiket event "' . $registration->event->title . '" oleh customer ' . $registration->user->name . ' telah diverifikasi.', 'transaction');
                }

                // 3. Notify Partner (Event Creator)
                $eventCreatorId = $registration->event->created_by;
                if ($eventCreatorId && $eventCreatorId !== $registration->user_id) {
                    Notification::send($eventCreatorId, 'Tiket Terjual', 'Tiket event "' . $registration->event->title . '" Anda telah dibeli oleh ' . $registration->user->name . '.', 'transaction');
                }
            } catch (\Exception $ne) {
                Log::error('Failed to send payment success notifications: ' . $ne->getMessage());
            }

        });

        Log::info("Payment success processed for registration #{$registration->id}");
    }


    /**
     * Generate final tickets from EventTicket participant data.
     * ✅ Idempotent: will not generate if tickets already exist.
     */
    protected function generateTickets(EventRegistration $registration): void
    {
        $registration->refresh()->load('eventTickets');

        /**
         * Prevent duplicate ticket generation
         */
        if (Ticket::where('event_registration_id', $registration->id)->exists()) {
            Log::info("Tickets already exist for registration #{$registration->id}, skipping generation.");
            return;
        }

        /**
         * Get participant records
         */
        $eventTickets = EventTicket::where(
            'registration_id',
            $registration->id
        )->get();


        /**
         * MULTI PARTICIPANT FLOW
         */
        if ($eventTickets->isNotEmpty()) {

            foreach ($eventTickets as $et) {

                $ticketNumber = 'TCK-' . strtoupper(
                    substr(md5(
                        $registration->id .
                        $et->id .
                        microtime()
                    ), 0, 10)
                );

                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'event_registration_id' => $registration->id,
                    'user_id' => $registration->user_id,
                    'event_id' => $registration->event_id,

                    // participant data
                    'full_name' => $et->full_name,
                    'email' => $et->email,
                    'phone' => $et->phone,
                    'date_of_birth' => $et->date_of_birth,
                    'ktp_number' => $et->ktp_number,

                    'status' => 'active'
                ]);

            }

        }


        /**
         * FALLBACK: generate tickets based on quantity
         */
        else {

            for ($i = 0; $i < $registration->quantity; $i++) {

                $ticketNumber = 'TCK-' . strtoupper(
                    substr(md5(
                        $registration->id .
                        $i .
                        microtime()
                    ), 0, 10)
                );

                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'event_registration_id' => $registration->id,
                    'user_id' => $registration->user_id,
                    'event_id' => $registration->event_id,
                    'status' => 'active'
                ]);

            }

        }

        $generatedCount = Ticket::where('event_registration_id', $registration->id)->count();
        Log::info("Generated {$generatedCount} tickets for registration #{$registration->id} (expected: {$registration->quantity})");
    }

}