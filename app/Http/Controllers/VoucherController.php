<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Event;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * API endpoint to check voucher validity and calculate discount.
     * ✅ FIX: Now accepts quantity to calculate discount on total, not per-ticket.
     */
    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ]);

        $code = $request->input('code');
        $eventId = $request->input('event_id');
        $quantity = max(1, (int) $request->input('quantity', 1));
        $event = Event::findOrFail($eventId);

        // Find in voucher_redemptions (user's redeemed vouchers)
        $redemption = \App\Models\VoucherRedemption::with('voucher')
            ->where('voucher_code', $code)
            ->where('status', 'unused')
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>=', now());
            })
            ->first();

        if (!$redemption) {
            return response()->json(['valid' => false, 'message' => 'Invalid or already used voucher.']);
        }

        $voucher = $redemption->voucher;

        $discount = 0;
        if ($event->price_type === 'paid') {
            /**
             * ✅ FIX: Calculate discount based on total (price × quantity),
             * not just per-ticket price
             */
            $total = ($event->price ?? 0) * $quantity;

            if ($voucher->discount_type === 'percentage') {
                $discount = ($total * $voucher->discount_value) / 100;
                if ($voucher->max_discount && $discount > $voucher->max_discount) {
                    $discount = $voucher->max_discount;
                }
            } else {
                $discount = min($voucher->discount_value, $total);
            }
        }

        return response()->json([
            'valid' => true,
            'discount' => (int) $discount,
            'message' => 'Voucher applied successfully!'
        ]);
    }
}
