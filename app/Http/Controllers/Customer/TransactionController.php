<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $registrations = EventRegistration::where('user_id', Auth::id())
            ->with(['event', 'transaction', 'generatedTickets'])
            ->latest()
            ->paginate(10);

        $userFeedbackEventIds = \App\Models\EventFeedback::where('user_id', Auth::id())
            ->pluck('event_id')
            ->toArray();

        return view('customer.transactions.index', compact('registrations', 'userFeedbackEventIds'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load([
            'registration.event',
            'registration.generatedTickets.checkin',
            'registration.voucherRedemption.voucher',
            'registration.rewardRedemption.reward',
        ]);

        // Load feedback for this event
        $feedback = \App\Models\EventFeedback::where('event_id', $transaction->registration->event_id)
            ->where('user_id', Auth::id())
            ->first();

        return view('customer.transactions.show', compact('transaction', 'feedback'));
    }
}
