<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\EventRegistration;
use App\Models\EventTicket;
use App\Models\VoucherRedemption;
use App\Models\PointHistory;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\View\View;
use App\Http\Controllers\MidtransNotificationController;

class EventRegistrationController extends Controller
{

    public function create(Event $event)
    {

if (\Carbon\Carbon::parse($event->date)->isPast()) {
    return redirect()->route('events.show', $event)
        ->with('error', 'Event sudah berakhir.');
}

        if (in_array($event->status, ['quota_full', 'completed'])) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Event tidak tersedia untuk registrasi.');
        }

        if ($event->remaining_quota <= 0) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Event is sold out.');
        }



        /**
         * ✅ FIX: Cek apakah ada pending registration yang belum expired
         */
        $existingPending = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->where('expired_at', '>', now())
            ->first();

        if ($existingPending) {
            return redirect()->route('customer.payment.show', $existingPending->id)
                ->with('info', 'Anda sudah memiliki pendaftaran yang belum diselesaikan.');
        }

        $vouchers = VoucherRedemption::with('voucher')
            ->where('user_id', Auth::id())
            ->where('status', 'unused')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>=', now());
            })
            ->get();

        $rewards = \App\Models\RewardRedemption::with('reward')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->whereDoesntHave('eventRegistration', function ($q) {
                $q->whereIn('payment_status', ['pending', 'paid']);
            })
            ->get();

        return view('customer.events.register', compact(
            'event',
            'vouchers',
            'rewards'
        ));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'tickets'                  => 'required|array|min:1|max:5',
            'tickets.*.full_name'      => 'required|string|min:3|max:255',
            'tickets.*.email'          => 'required|email',
            'tickets.*.phone'          => 'required|min:10|max:20',
            'tickets.*.date_of_birth'  => 'required|date',
            'tickets.*.ktp_number'     => 'required|digits:16',
'tickets.*.ktp_file' => 'required|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        /**
         * VALIDATE AGE ≥ 21
         */
        foreach ($request->tickets as $ticket) {
            if (Carbon::parse($ticket['date_of_birth'])->age < 21) {
                return back()->withErrors([
                    'tickets' => 'All participants must be at least 21 years old.'
                ])->withInput();
            }
        }

        $ticketCount = count($request->tickets);

        /**
         * VALIDATE QUOTA (pre-check, final check inside DB transaction)
         */
        if ($ticketCount > $event->remaining_quota) {
            return back()->withErrors([
                'tickets' => 'Requested tickets exceed available quota.'
            ])->withInput();
        }

        /**
         * CHECK FOR EXISTING PENDING REGISTRATION
         * If user has a non-expired pending registration, redirect to payment
         */
        $existing = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->where('expired_at', '>', now())
            ->first();

        if ($existing) {
            return redirect()->route('customer.payment.show', $existing->id);
        }



        /**
         * VALIDATE VOUCHER (pre-check only, actual usage in callback)
         */
        $discountAmount = 0;
        $voucherCode = $request->input('voucher_code');

        $appliedRedemption = null;
        $appliedVoucher = null;

        if ($voucherCode) {

            $appliedRedemption = VoucherRedemption::with('voucher')
                ->where('voucher_code', $voucherCode)
                ->where('user_id', Auth::id())
                ->where('status', 'unused')
                ->where(function ($q) {
                    $q->whereNull('expired_at')
                      ->orWhere('expired_at', '>=', now());
                })
                ->first();

            if (!$appliedRedemption) {
                return back()
                    ->withInput()
                    ->with('error', 'Invalid or already used voucher code.');
            }

            $appliedVoucher = $appliedRedemption->voucher;
        }

        /**
         * VALIDATE REWARD MERCHANDISE
         */
        $rewardRedemptionId = $request->input('reward_redemption_id');
        $appliedRewardRedemption = null;

        if ($rewardRedemptionId) {
            $appliedRewardRedemption = \App\Models\RewardRedemption::where('id', $rewardRedemptionId)
                ->where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'approved'])
                ->whereDoesntHave('eventRegistration', function ($q) {
                    $q->whereIn('payment_status', ['pending', 'paid']);
                })
                ->first();

            if (!$appliedRewardRedemption) {
                return back()
                    ->withInput()
                    ->with('error', 'Reward merchandise tidak valid atau sudah dipilih di pendaftaran lain.');
            }
        }

        /**
         * CALCULATE TOTAL
         * Discount applied to total of all tickets
         */
        $totalAmount = 0;
        $ticketPrice = $event->price ?? 0;

        if ($event->price_type === 'paid') {

            $totalAmount = $ticketPrice * $ticketCount;

            if ($appliedVoucher) {

                if ($appliedVoucher->discount_type === 'percentage') {

                    $discountAmount =
                        ($totalAmount * $appliedVoucher->discount_value) / 100;

                    if (
                        $appliedVoucher->max_discount !== null &&
                        $discountAmount > $appliedVoucher->max_discount
                    ) {
                        $discountAmount =
                            $appliedVoucher->max_discount;
                    }

                } else {

                    $discountAmount =
                        $appliedVoucher->discount_value;

                }

                $totalAmount =
                    max(0, $totalAmount - $discountAmount);

                /**
                 * ✅ FIX: Do NOT increment used_count here.
                 * Voucher usage is finalized ONLY in Midtrans callback.
                 */
            }

        }

        DB::beginTransaction();

        try {

            /**
             * ✅ FIX: Always CREATE new registration (not updateOrCreate)
             * This prevents orphaning old EventTicket records.
             * Old expired/failed registrations are separate records.
             */

            // Expire any old pending registrations for same event+user
            EventRegistration::where('event_id', $event->id)
                ->where('user_id', Auth::id())
                ->where('payment_status', 'pending')
                ->update(['payment_status' => 'expired']);

            $registration = EventRegistration::create([
                'event_id'              => $event->id,
                'user_id'               => Auth::id(),
                'quantity'              => $ticketCount,
                'ticket_price'          => $ticketPrice,
                'total_amount'          => $totalAmount,
                'payment_status'        => 'pending',
                'expired_at'            => now()->addMinutes(30),
                'voucher_redemption_id' => $appliedRedemption?->id,
                'reward_redemption_id'  => $appliedRewardRedemption?->id,
            ]);

            /**
             * SAVE PARTICIPANTS (EventTickets)
             */
            foreach ($request->tickets as $ticket) {

                $ktpPath = $ticket['ktp_file']->store('ktp', 'public');

                EventTicket::create([
                    'registration_id' => $registration->id,
                    'full_name'       => $ticket['full_name'],
                    'email'           => $ticket['email'],
                    'phone'           => $ticket['phone'],
                    'date_of_birth'   => $ticket['date_of_birth'],
                    'ktp_number'      => $ticket['ktp_number'],
                    'ktp_file'        => $ktpPath,
                ]);

            }

            /**
             * FREE EVENT — process immediately
             * ✅ Quota decrement happens here for free events only
             */
            if ($totalAmount <= 0) {

                // Atomic quota check inside transaction
                $freshEvent = Event::lockForUpdate()->find($event->id);
                if ($freshEvent->remaining_quota < $ticketCount) {
                    DB::rollBack();
                    return back()->withErrors([
                        'tickets' => 'Kuota event habis saat proses registrasi.'
                    ])->withInput();
                }

                $registration->update([
                    'payment_status' => 'paid'
                ]);

                $freshEvent->decrement(
                    'remaining_quota',
                    $ticketCount
                );

                $this->generateTickets($registration);

                PointHistory::earn(
                    Auth::id(),
                    $ticketCount * 5,
                    'event_registration',
                    "Event: {$event->title}",
                    $registration->id
                );

                /**
                 * ✅ Mark voucher as used for free event (completed immediately)
                 */
                if ($appliedRedemption) {
                    $appliedRedemption->update(['status' => 'used']);
                    $appliedVoucher->increment('used_count');
                }

                // Dispatch notifications
                try {
                    // 1. Notify Customer
                    Notification::send(Auth::id(), 'Pendaftaran Event Sukses', 'Registrasi gratis untuk event "' . $event->title . '" berhasil. Tiket Anda telah diterbitkan.', 'event');

                    // 2. Notify Admins
                    $admins = \App\Models\User::whereHas('role', function($q) { $q->where('name', 'admin'); })->get();
                    foreach ($admins as $adm) {
                        Notification::send($adm->id, 'Pendaftaran Event Baru (Gratis)', 'Customer ' . Auth::user()->name . ' mendaftar gratis untuk event "' . $event->title . '".', 'event');
                    }

                    // 3. Notify Partner (Event Creator)
                    $eventCreatorId = $event->created_by;
                    if ($eventCreatorId && $eventCreatorId !== Auth::id()) {
                        Notification::send($eventCreatorId, 'Tiket Terjual (Gratis)', 'Customer ' . Auth::user()->name . ' mendaftar gratis untuk event "' . $event->title . '".', 'event');
                    }
                } catch (\Exception $ne) {
                    Log::error('Failed to send free event notifications: ' . $ne->getMessage());
                }

                // Create transaction for free event
                $transaction = \App\Models\Transaction::create([
                    'registration_id'  => $registration->id,
                    'user_id'          => Auth::id(),
                    'amount'           => 0,
                    'payment_method'   => 'free',
                    'transaction_code' => \App\Models\Transaction::generateCode(),
                    'status'           => 'paid',
                    'paid_at'          => now(),
                ]);

                DB::commit();

                return redirect()
                    ->route('customer.transactions.show', $transaction->id)
                    ->with(
                        'success',
                        'Registrasi event gratis berhasil!'
                    );
            }

            /**
             * PAID EVENT — Create Midtrans Snap Token
             * ✅ FIX: item_details must match gross_amount exactly
             * ✅ FIX: Do NOT decrement quota here — only in callback
             * ✅ FIX: Do NOT increment voucher used_count — only in callback
             */
            \Midtrans\Config::$serverKey =
                config('services.midtrans.server_key');

            \Midtrans\Config::$isProduction =
                config('services.midtrans.is_production');

            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            /**
             * ✅ FIX: Build item_details so sum matches gross_amount
             */
            $items = [[
                'id'       => 'EVT-' . $event->id,
                'price'    => (int) $ticketPrice,
                'quantity' => $ticketCount,
                'name'     => substr($event->title, 0, 50),
            ]];

            if ($discountAmount > 0) {
                $items[] = [
                    'id'       => 'DISC-VOUCHER',
                    'price'    => (int) (-$discountAmount),
                    'quantity' => 1,
                    'name'     => 'Voucher Discount',
                ];
            }

            $params = [

                'transaction_details' => [
                    'order_id' =>
                        'EVT-' . $registration->id . '-' . time(),

                    'gross_amount' =>
                        (int) $totalAmount,
                ],

                'customer_details' => [
                    'first_name' =>
                        Auth::user()->name,

                    'email' =>
                        Auth::user()->email,
                ],

                'item_details' => $items,

                'callbacks' => [

                    'finish' =>
                        route('customer.transactions.index')

                ]

            ];

            $snapToken =
                \Midtrans\Snap::getSnapToken($params);

            $registration->update([
                'snap_token' => $snapToken
            ]);

            // Dispatch pending notifications
            try {
                // 1. Notify Customer
                Notification::send(Auth::id(), 'Pembayaran Menunggu', 'Pendaftaran event "' . $event->title . '" berhasil diajukan. Silakan selesaikan pembayaran.', 'transaction');

                // 2. Notify Admins
                $admins = \App\Models\User::whereHas('role', function($q) { $q->where('name', 'admin'); })->get();
                foreach ($admins as $adm) {
                    Notification::send($adm->id, 'Pendaftaran Event (Pending)', 'Customer ' . Auth::user()->name . ' mengajukan pendaftaran untuk event "' . $event->title . '" (Pending).', 'event');
                }
            } catch (\Exception $ne) {
                Log::error('Failed to send pending event notifications: ' . $ne->getMessage());
            }

            DB::commit();

            return redirect()
                ->route(
                    'customer.payment.show',
                    $registration->id
                );

        } catch (\Exception $e) {

            DB::rollBack();


            Log::error(
                'EventRegistration store failed',
                [
                    'error' =>
                        $e->getMessage(),

                    'event_id' =>
                        $event->id,

                    'user_id' =>
                        Auth::id(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pendaftaran gagal. Silakan coba lagi.'
                );
        }
    }

    public function payment(EventRegistration $registration): View
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $registration->load('event', 'eventTickets');
        return view('customer.events.payment', compact('registration'));
    }

    public function paymentSuccess(Request $request, EventRegistration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $registration->refresh();

        /**
         * If webhook already processed this payment
         */
        if ($registration->payment_status === 'paid' && $registration->transaction) {

            return redirect()->route(
                'customer.transactions.show',
                $registration->transaction->id
            )->with('success', 'Payment successful! Your tickets are ready.');
        }

        /**
         * Fallback: check Midtrans API directly
         * ✅ All final logic delegated to processSuccessPayment()
         */
        if ($request->has('order_id')) {

            try {

                \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');

                /** @var object $status */
                $status = (object) \Midtrans\Transaction::status(
                    $request->order_id
                );

                if (
                    isset($status->transaction_status)
                    && in_array($status->transaction_status, ['capture', 'settlement'])
                ) {

                    app(MidtransNotificationController::class)
                        ->processSuccessPayment(
                            $registration,
                            $status
                        );

                    $registration->refresh();

                    if ($registration->transaction) {

                        return redirect()->route(
                            'customer.transactions.show',
                            $registration->transaction->id
                        )->with(
                            'success',
                            'Payment successful! Your tickets are ready.'
                        );

                    }

                }

            } catch (\Exception $e) {

                Log::error('Midtrans fallback check failed', [
                    'error' => $e->getMessage(),
                    'registration_id' => $registration->id
                ]);

            }

        }

        /**
         * If webhook hasn't arrived yet — redirect to transactions list
         */
        return redirect()->route(
            'customer.transactions.index'
        )->with(
            'success',
            'Payment successful! Your ticket has been generated.'
        );
    }

    /**
     * Generate final tickets from EventTicket participant data.
     * ✅ Idempotent: will not generate if tickets already exist.
     */
    protected function generateTickets(EventRegistration $registration): void
    {
        if (Ticket::where('event_registration_id', $registration->id)->exists()) {
            Log::info('Tickets already exist for registration #' . $registration->id);
            return;
        }

        $eventTickets = EventTicket::where(
            'registration_id',
            $registration->id
        )->get();


        /**
         * Generate one ticket per participant
         */
        if ($eventTickets->count()) {

            foreach ($eventTickets as $et) {

                Ticket::create([
                    'ticket_number' => 'TCK-' . strtoupper(
                        substr(md5(
                            $registration->id .
                            $et->id .
                            microtime()
                        ), 0, 10)
                    ),

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
         * Fallback if no participant records found
         */
        else {

            for ($i = 0; $i < $registration->quantity; $i++) {

                Ticket::create([
                    'ticket_number' => 'TCK-' . strtoupper(
                        substr(md5(
                            $registration->id .
                            $i .
                            microtime()
                        ), 0, 10)
                    ),

                    'event_registration_id' => $registration->id,
                    'user_id' => $registration->user_id,
                    'event_id' => $registration->event_id,

                    // fallback participant = user login
                    'full_name' => $registration->user->name,
                    'email' => $registration->user->email,

                    'status' => 'active'
                ]);

            }
        }

        $generatedCount = Ticket::where('event_registration_id', $registration->id)->count();
        Log::info("Generated {$generatedCount} tickets for registration #{$registration->id} (expected: {$registration->quantity})");
    }
}