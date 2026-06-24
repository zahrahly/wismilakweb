<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use App\Models\VoucherRedemption;
use App\Models\Voucher;
use App\Models\Reward;
use App\Models\RewardRedemption;
use App\Models\PointHistory;
use App\Models\EventFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_points' => $user->point?->total_points ?? 0,

            'total_events' => EventRegistration::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->count(),

            'active_vouchers' => VoucherRedemption::where('user_id', $user->id)
                ->where('status', 'unused')
                ->count(),
        ];

        $totalTransactions = EventRegistration::where('user_id', $user->id)->count();

        /**
         * ✅ FIX: Only show paid registrations in "Riwayat Event"
         * ✅ FIX: Eager-load feedback to avoid N+1 queries
         */
        $recentEvents = EventRegistration::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->with([
                'event',
                'generatedTickets.checkin',
            ])
            ->latest()
            ->take(5)
            ->get();

        /**
         * Pre-load feedbacks for all displayed events to avoid N+1
         */
        $eventIds = $recentEvents->pluck('event_id')->filter()->unique();
        $userFeedbacks = EventFeedback::where('user_id', $user->id)
            ->whereIn('event_id', $eventIds)
            ->get()
            ->keyBy('event_id');

        $availableVouchers = Voucher::where('status', 'active')
            ->where(function($q){
                $q->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', today());
            })
            ->get();

        $availableRewards = Reward::where('status', 'active')->get();

        $myVouchers = VoucherRedemption::where('user_id', $user->id)
            ->where('status', 'unused')
            ->with('voucher')
            ->latest()
            ->get();

        $myRewards = RewardRedemption::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->with('reward')
            ->latest()
            ->get();

        $voucherHistories = VoucherRedemption::where('user_id', $user->id)
            ->with('voucher')
            ->latest()
            ->take(5)
            ->get();

        $userRedeemedVoucherIds = VoucherRedemption::where('user_id', $user->id)
            ->pluck('voucher_id')
            ->toArray();

        $userRedeemedRewardIds = RewardRedemption::where('user_id', $user->id)
            ->pluck('reward_id')
            ->toArray();

        return view('customer.dashboard', compact(
            'stats',
            'recentEvents',
            'totalTransactions',
            'availableVouchers',
            'availableRewards',
            'myVouchers',
            'myRewards',
            'voucherHistories',
            'userFeedbacks',
            'userRedeemedVoucherIds',
            'userRedeemedRewardIds'
        ));
    }



    public function redeemVoucher(Voucher $voucher)
    {
        $user = Auth::user();

        $userPoints = $user->point?->total_points ?? 0;

        if ($userPoints < $voucher->points_required) {
            return back()->with('error', 'Poin Anda tidak cukup.');
        }

        if (VoucherRedemption::where('user_id', $user->id)->where('voucher_id', $voucher->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah menukarkan voucher ini.');
        }

        if (!$voucher->isValid()) {
            return back()->with('error', 'Voucher tidak tersedia.');
        }

        try {
            DB::transaction(function() use ($user, $voucher) {

                $user->point->decrement('total_points', $voucher->points_required);

                PointHistory::create([
                    'user_id'      => $user->id,
                    'points'       => $voucher->points_required,
                    'type'         => 'spend',
                    'source'       => 'voucher_redemption',
                    'reference_id' => $voucher->id,
                    'description'  => 'Tukar voucher: '.$voucher->title,
                ]);

                VoucherRedemption::create([
                    'voucher_id'   => $voucher->id,
                    'user_id'      => $user->id,
                    'points_spent' => $voucher->points_required,
                    'voucher_code' => 'VCH-'.strtoupper(Str::random(8)),
                    'status'       => 'unused',
                    'redeemed_at'  => now(),
                    'expired_at'   => $voucher->valid_until ?? now()->addDays(30),
                ]);

                $voucher->increment('used_count');
            });

            // Kirim notifikasi
            try {
                \App\Models\Notification::send(
                    $user->id,
                    'Penukaran Voucher Sukses',
                    "Anda telah menukarkan voucher '{$voucher->title}' seharga {$voucher->points_required} poin.",
                    'voucher'
                );

                $admins = \App\Models\User::whereHas('role', function($q) {
                    $q->where('name', 'admin');
                })->get();
                foreach ($admins as $admin) {
                    \App\Models\Notification::send(
                        $admin->id,
                        'Penukaran Voucher Baru',
                        "Customer {$user->name} menukarkan voucher '{$voucher->title}'.",
                        'voucher'
                    );
                }
            } catch (\Exception $ne) {
                Log::error('Voucher redeem notification failed: ' . $ne->getMessage());
            }

            return redirect()
                ->route('customer.dashboard')
                ->with('success', 'Voucher berhasil ditukar!');

        } catch (\Exception $e) {
            Log::error('Voucher redeem failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menukar voucher.');
        }
    }

    public function redeemReward(Reward $reward)
    {
        $user = Auth::user();
        $userPoints = $user->point?->total_points ?? 0;

        if ($userPoints < $reward->points_required) {
            return back()->with('error', 'Poin Anda tidak cukup.');
        }

        if (RewardRedemption::where('user_id', $user->id)->where('reward_id', $reward->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah menukarkan reward ini.');
        }

        if ($reward->stock <= 0) {
            return back()->with('error', 'Stok reward habis.');
        }

        try {
            DB::transaction(function() use ($user, $reward) {
                // Decrement stock
                $reward->decrement('stock');

                // Create redemption record
                RewardRedemption::create([
                    'reward_id'   => $reward->id,
                    'user_id'     => $user->id,
                    'points_used' => $reward->points_required,
                    'status'      => 'pending',
                ]);

                // Deduct points via PointHistory
                PointHistory::spend(
                    $user->id,
                    $reward->points_required,
                    'reward_redemption',
                    'Tukar merchandise: '.$reward->title,
                    $reward->id
                );
            });

            // Kirim notifikasi
            try {
                \App\Models\Notification::send(
                    $user->id,
                    'Penukaran Reward Sukses',
                    "Anda telah menukarkan reward '{$reward->title}' seharga {$reward->points_required} poin. Status: Pending.",
                    'reward'
                );

                $admins = \App\Models\User::whereHas('role', function($q) {
                    $q->where('name', 'admin');
                })->get();
                foreach ($admins as $admin) {
                    \App\Models\Notification::send(
                        $admin->id,
                        'Penukaran Reward Baru',
                        "Customer {$user->name} menukarkan reward '{$reward->title}'.",
                        'reward'
                    );
                }
            } catch (\Exception $ne) {
                Log::error('Reward redeem notification failed: ' . $ne->getMessage());
            }

            return back()->with('success', 'Reward berhasil ditukar! Tim kami akan segera memprosesnya.');
        } catch (\Exception $e) {
            Log::error('Reward redeem failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menukar reward.');
        }
    }



    public function myVouchers()
    {
        $user = Auth::user();

        $vouchers = VoucherRedemption::where('user_id', $user->id)
            ->with('voucher')
            ->orderBy('status', 'asc')
            ->latest('redeemed_at')
            ->paginate(12);

        return view('customer.vouchers.index', compact('vouchers'));
    }

    public function generateTicketPdf(\App\Models\Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->load([
            'event.packages',
            'event.outlets',
            'eventRegistration.rewardRedemption.reward',
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'customer.tickets.pdf',
            compact('ticket')
        )->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);

        $pdf->setPaper('A5', 'landscape');

        return $pdf->download(
            'ticket-' . $ticket->ticket_number . '.pdf'
        );
    }

    public function pointHistory()
    {
        $user = Auth::user();

        $histories = PointHistory::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        $totalEarned = PointHistory::where('user_id', $user->id)
            ->where('type', 'earn')
            ->sum('points');

        $totalSpent = PointHistory::where('user_id', $user->id)
            ->where('type', 'spend')
            ->sum('points');

        return view('customer.points.history', compact(
            'histories',
            'totalEarned',
            'totalSpent'
        ));
    }
}