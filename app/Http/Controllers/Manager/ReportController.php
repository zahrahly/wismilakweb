<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\EventRegistration;
use App\Models\User;
use App\Models\Reward;
use App\Models\RewardRedemption;
use App\Models\UserPoint;
use App\Models\EventFeedback;
use App\Models\Voucher;
use App\Models\VoucherRedemption;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_events'       => Event::count(),
            'total_revenue'      => Transaction::whereIn('status', ['paid', 'success'])->sum('amount'),
            'total_participants' => EventRegistration::whereIn('payment_status', ['paid', 'success'])->count(),
            'total_transactions' => Transaction::whereIn('status', ['paid', 'success'])->count(),
            'total_users'        => User::count(),
            'total_rewards'      => Reward::count(),
        ];

        // Monthly revenue for Chart.js
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[] = Transaction::whereIn('status', ['paid', 'success'])
                ->whereMonth('paid_at', $i)
                ->whereYear('paid_at', now()->year)
                ->sum('amount');
        }

        $recentTransactions = Transaction::with(['user', 'registration.event'])
            ->whereIn('status', ['paid', 'success'])
            ->latest('paid_at')
            ->take(8)
            ->get();

        return view('manager.dashboard', compact('stats', 'recentTransactions', 'monthlyRevenue'));
    }

    // ── EVENTS ────────────────────────────────────────────────

    public function events(Request $request)
    {
        $query = Event::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $events = $query->latest()->paginate(15);
        return view('manager.events.index', compact('events'));
    }

    public function exportEventsPdf()
    {
        $events = Event::with('creator')->latest()->get();
        $pdf = Pdf::loadView('manager.exports.events_pdf', compact('events'));
        return $pdf->download('laporan_event_' . now()->format('Ymd') . '.pdf');
    }

    public function exportEventsCsv()
    {
        $events   = Event::with('creator')->latest()->get();
        $filename = 'laporan_event_' . now()->format('Ymd') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        $callback = function () use ($events) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['ID', 'Judul', 'Pembuat', 'Status', 'Tanggal', 'Kuota', 'Harga']);
            foreach ($events as $event) {
                fputcsv($handle, [
                    $event->id,
                    $event->title,
                    $event->creator->name ?? 'N/A',
                    $event->status,
                    $event->date?->format('Y-m-d H:i'),
                    $event->quota,
                    $event->price_type === 'free' ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.'),
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── USERS ─────────────────────────────────────────────────

    public function users(Request $request)
    {
        $query = User::with(['role', 'point']);
        if ($request->filled('role')) {
            $query->whereHas('role', fn($q) => $q->where('name', $request->role));
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        $users = $query->latest()->paginate(15);
        return view('manager.users.index', compact('users'));
    }

    public function exportUsersPdf()
    {
        $users = User::with(['role', 'point'])->latest()->get();
        $pdf   = Pdf::loadView('manager.exports.users_pdf', compact('users'));
        return $pdf->download('laporan_user_' . now()->format('Ymd') . '.pdf');
    }

    public function exportUsersCsv()
    {
        $users    = User::with(['role', 'point'])->latest()->get();
        $filename = 'laporan_user_' . now()->format('Ymd') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['ID', 'Nama', 'Email', 'Role', 'Status', 'Poin', 'Bergabung']);
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id, $user->name, $user->email,
                    $user->role->name ?? '-', $user->status,
                    $user->point->total_points ?? 0,
                    $user->created_at->format('Y-m-d'),
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── TRANSACTIONS ──────────────────────────────────────────

    private function getFilteredTransactionsQuery(Request $request)
    {
        $query = Transaction::with(['user', 'registration.event']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('transaction_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }
        if ($request->filled('start_date')) {
            $query->whereDate('paid_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('paid_at', '<=', $request->end_date);
        }
        return $query;
    }

    public function transactions(Request $request)
    {
        $transactions = $this->getFilteredTransactionsQuery($request)->latest('paid_at')->paginate(15);
        return view('manager.transactions.index', compact('transactions'));
    }

    public function exportTransactionsPdf(Request $request)
    {
        $transactions = $this->getFilteredTransactionsQuery($request)->latest('paid_at')->get();
        $pdf = Pdf::loadView('manager.exports.transactions_pdf', compact('transactions'));
        return $pdf->download('laporan_transaksi_' . now()->format('Ymd') . '.pdf');
    }

    public function exportTransactionsCsv(Request $request)
    {
        $transactions = $this->getFilteredTransactionsQuery($request)->latest('paid_at')->get();
        $filename     = 'laporan_transaksi_' . now()->format('Ymd') . '.csv';
        $headers      = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        $callback     = function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['Kode', 'User', 'Event', 'Jumlah', 'Metode', 'Status', 'Tanggal']);
            foreach ($transactions as $t) {
                fputcsv($handle, [
                    $t->transaction_code,
                    $t->user->name ?? '-',
                    $t->registration->event->title ?? '-',
                    'Rp ' . number_format($t->amount, 0, ',', '.'),
                    $t->payment_method,
                    $t->status,
                    $t->paid_at?->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── REWARDS ───────────────────────────────────────────────

    public function rewards(Request $request)
    {
        // 4 Stat Cards
        $stats = [
            'total_rewards' => Reward::count(),
            'total_vouchers' => Voucher::count(),
            'active_rewards' => Reward::where('status', 'active')->count(),
            'active_vouchers' => Voucher::where('status', 'active')->count(),
            'total_reward_redemptions' => RewardRedemption::count(),
            'total_voucher_redemptions' => VoucherRedemption::count(),
            'total_redemptions' => RewardRedemption::count() + VoucherRedemption::count(),
        ];

        // Catalogs with pagination (independent page parameters)
        $rewards = Reward::withCount('redemptions')->latest()->paginate(10, ['*'], 'rewards_page');
        $vouchers = Voucher::withCount('redemptions')->latest()->paginate(10, ['*'], 'vouchers_page');

        // Top 10 users by points
        $topUsers = UserPoint::with('user')->orderByDesc('total_points')->take(10)->get();

        // Recent 20 merged redemptions
        $rewardRedemptions = RewardRedemption::with(['user', 'reward'])->latest()->take(20)->get()->map(function ($item) {
            return [
                'type' => 'Reward',
                'item_name' => $item->reward->title ?? '-',
                'user_name' => $item->user->name ?? '-',
                'points' => $item->points_used,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $voucherRedemptions = VoucherRedemption::with(['user', 'voucher'])->latest()->take(20)->get()->map(function ($item) {
            return [
                'type' => 'Voucher',
                'item_name' => $item->voucher->title ?? '-',
                'user_name' => $item->user->name ?? '-',
                'points' => $item->points_spent,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $recentRedemptions = collect($rewardRedemptions)->concat($voucherRedemptions)->sortByDesc('date')->take(20);

        return view('manager.rewards.index', compact('rewards', 'vouchers', 'stats', 'topUsers', 'recentRedemptions'));
    }

    public function exportRewardsPdf()
    {
        $rewards  = Reward::withCount('redemptions')->get();
        $vouchers = Voucher::withCount('redemptions')->get();
        $topUsers = UserPoint::with('user')->orderByDesc('total_points')->take(10)->get();

        $stats = [
            'total_rewards' => Reward::count(),
            'total_vouchers' => Voucher::count(),
            'active_rewards' => Reward::where('status', 'active')->count(),
            'active_vouchers' => Voucher::where('status', 'active')->count(),
            'total_reward_redemptions' => RewardRedemption::count(),
            'total_voucher_redemptions' => VoucherRedemption::count(),
            'total_redemptions' => RewardRedemption::count() + VoucherRedemption::count(),
        ];

        $rewardRedemptions = RewardRedemption::with(['user', 'reward'])->latest()->take(20)->get()->map(function ($item) {
            return [
                'type' => 'Reward',
                'item_name' => $item->reward->title ?? '-',
                'user_name' => $item->user->name ?? '-',
                'points' => $item->points_used,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $voucherRedemptions = VoucherRedemption::with(['user', 'voucher'])->latest()->take(20)->get()->map(function ($item) {
            return [
                'type' => 'Voucher',
                'item_name' => $item->voucher->title ?? '-',
                'user_name' => $item->user->name ?? '-',
                'points' => $item->points_spent,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $recentRedemptions = collect($rewardRedemptions)->concat($voucherRedemptions)->sortByDesc('date')->take(20);

        $pdf      = Pdf::loadView('manager.exports.rewards_pdf', compact('rewards', 'vouchers', 'topUsers', 'stats', 'recentRedemptions'));
        return $pdf->download('laporan_reward_' . now()->format('Ymd') . '.pdf');
    }

    public function exportRewardsCsv()
    {
        $rewards  = Reward::withCount('redemptions')->get();
        $vouchers = Voucher::withCount('redemptions')->get();
        $topUsers = UserPoint::with('user')->orderByDesc('total_points')->take(10)->get();

        $rewardRedemptions = RewardRedemption::with(['user', 'reward'])->latest()->take(20)->get()->map(function ($item) {
            return [
                'type' => 'Reward',
                'item_name' => $item->reward->title ?? '-',
                'user_name' => $item->user->name ?? '-',
                'points' => $item->points_used,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $voucherRedemptions = VoucherRedemption::with(['user', 'voucher'])->latest()->take(20)->get()->map(function ($item) {
            return [
                'type' => 'Voucher',
                'item_name' => $item->voucher->title ?? '-',
                'user_name' => $item->user->name ?? '-',
                'points' => $item->points_spent,
                'status' => $item->status,
                'date' => $item->created_at,
            ];
        });

        $recentRedemptions = collect($rewardRedemptions)->concat($voucherRedemptions)->sortByDesc('date')->take(20);

        $filename = 'laporan_reward_' . now()->format('Ymd') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        
        $callback = function () use ($rewards, $vouchers, $topUsers, $recentRedemptions) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            
            fputcsv($handle, ['--- CATALOG REWARD ---']);
            fputcsv($handle, ['Reward', 'Poin Diperlukan', 'Stok', 'Total Ditukar', 'Status']);
            foreach ($rewards as $r) {
                fputcsv($handle, [$r->title, $r->points_required, $r->stock, $r->redemptions_count, ucfirst($r->status)]);
            }
            fputcsv($handle, []);

            fputcsv($handle, ['--- CATALOG VOUCHER ---']);
            fputcsv($handle, ['Voucher', 'Kode', 'Poin Diperlukan', 'Diskon', 'Total Ditukar', 'Status']);
            foreach ($vouchers as $v) {
                $discount = $v->discount_type === 'percent' ? $v->discount_value . '%' : 'Rp ' . number_format($v->discount_value, 0, ',', '.');
                fputcsv($handle, [$v->title, $v->code, $v->points_required, $discount, $v->redemptions_count, ucfirst($v->status)]);
            }
            fputcsv($handle, []);

            fputcsv($handle, ['--- TOP 10 USERS BY POIN ---']);
            fputcsv($handle, ['No', 'Nama', 'Email', 'Total Poin']);
            foreach ($topUsers as $i => $up) {
                fputcsv($handle, [$i + 1, $up->user->name ?? '-', $up->user->email ?? '-', $up->total_points]);
            }
            fputcsv($handle, []);

            fputcsv($handle, ['--- RECENT REDEMPTIONS ---']);
            fputcsv($handle, ['Tipe', 'Item', 'User', 'Poin', 'Status', 'Tanggal']);
            foreach ($recentRedemptions as $item) {
                fputcsv($handle, [
                    $item['type'],
                    $item['item_name'],
                    $item['user_name'],
                    $item['points'],
                    ucfirst($item['status']),
                    $item['date'] ? $item['date']->format('Y-m-d H:i') : '-'
                ]);
            }

            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── ENGAGEMENT ────────────────────────────────────────────

    public function engagement()
    {
        $stats = [
            'total_users'         => User::count(),
            'active_users'        => User::whereHas('point', fn($q) => $q->where('total_points', '>', 0))->count(),
            'total_registrations' => EventRegistration::count(),
            'paid_registrations'  => EventRegistration::whereIn('payment_status', ['paid', 'success'])->count(),
            'total_feedbacks'     => EventFeedback::count(),
            'avg_rating'          => round(EventFeedback::avg('rating') ?? 0, 1),
            'total_events'        => Event::count(),
            'published_events'    => Event::where('status', 'published')->count(),
            'completed_events'    => Event::where('status', 'completed')->count(),
            'total_revenue'       => Transaction::whereIn('status', ['paid', 'success'])->sum('amount'),
        ];

        $months = collect(range(1, 12))->map(fn($m) => now()->startOfYear()->addMonths($m - 1)->format('M'));

        $registrationsChart = [];
        $feedbacksChart = [];
        $userGrowthChart = [];
        foreach (range(1, 12) as $m) {
            $registrationsChart[] = EventRegistration::whereMonth('created_at', $m)->whereYear('created_at', now()->year)->count();
            $feedbacksChart[] = EventFeedback::whereMonth('created_at', $m)->whereYear('created_at', now()->year)->count();
            $userGrowthChart[] = User::whereMonth('created_at', $m)->whereYear('created_at', now()->year)->count();
        }

        // Top events by registration count
        $topEvents = Event::withCount(['registrations' => fn($q) => $q->whereIn('payment_status', ['paid', 'success'])])
            ->orderByDesc('registrations_count')
            ->take(5)
            ->get();

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[] = EventFeedback::where('rating', $i)->count();
        }

        return view('manager.engagement.index', compact(
            'stats', 'months', 'registrationsChart', 'feedbacksChart',
            'userGrowthChart', 'topEvents', 'ratingDistribution'
        ));
    }

    public function exportEngagementPdf()
    {
        $stats = [
            'total_users'         => User::count(),
            'active_users'        => User::whereHas('point', fn($q) => $q->where('total_points', '>', 0))->count(),
            'total_registrations' => EventRegistration::count(),
            'paid_registrations'  => EventRegistration::whereIn('payment_status', ['paid', 'success'])->count(),
            'total_feedbacks'     => EventFeedback::count(),
            'avg_rating'          => round(EventFeedback::avg('rating') ?? 0, 1),
            'total_events'        => Event::count(),
            'published_events'    => Event::where('status', 'published')->count(),
            'completed_events'    => Event::where('status', 'completed')->count(),
            'total_revenue'       => Transaction::whereIn('status', ['paid', 'success'])->sum('amount'),
        ];
        $pdf = Pdf::loadView('manager.exports.engagement_pdf', compact('stats'));
        return $pdf->download('laporan_engagement_' . now()->format('Ymd') . '.pdf');
    }

    public function exportEngagementCsv()
    {
        $stats = [
            'total_users'         => User::count(),
            'active_users'        => User::whereHas('point', fn($q) => $q->where('total_points', '>', 0))->count(),
            'total_registrations' => EventRegistration::count(),
            'total_feedbacks'     => EventFeedback::count(),
            'total_events'        => Event::count(),
        ];
        $filename = 'laporan_engagement_' . now()->format('Ymd') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        
        $callback = function () use ($stats) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['Metric', 'Value']);
            foreach ($stats as $key => $value) {
                fputcsv($handle, [$key, $value]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── FEEDBACKS ─────────────────────────────────────────────

    public function feedbacks(Request $request)
    {
        $query = EventFeedback::with(['event', 'user']);
        
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('search')) {
            $query->where('comment', 'like', '%' . $request->search . '%');
        }
        
        $feedbacks = $query->latest()->paginate(15);
        $events = Event::has('feedbacks')->get();
        
        // Calculate Stats
        $baseQuery = EventFeedback::query();
        if ($request->filled('event_id')) $baseQuery->where('event_id', $request->event_id);
        
        $totalFeedbacks = $baseQuery->count();
        $avgRating = $baseQuery->avg('rating') ?? 0;
        $fiveStar = (clone $baseQuery)->where('rating', 5)->count();
        $oneStar = (clone $baseQuery)->where('rating', 1)->count();
        
        $distribution = [];
        for($i=5; $i>=1; $i--) {
            $distribution[] = (clone $baseQuery)->where('rating', $i)->count();
        }
        
        $stats = [
            'total' => $totalFeedbacks,
            'avg_rating' => $avgRating,
            'five_star' => $fiveStar,
            'one_star' => $oneStar,
            'distribution' => $distribution
        ];
        
        return view('manager.feedback.index', compact('feedbacks', 'events', 'stats'));
    }

    public function exportFeedbacksPdf()
    {
        $feedbacks = EventFeedback::with(['event', 'user'])->latest()->get();
        $pdf = Pdf::loadView('manager.exports.feedbacks_pdf', compact('feedbacks'));
        return $pdf->download('laporan_feedback_' . now()->format('Ymd') . '.pdf');
    }

    public function exportFeedbacksCsv()
    {
        $feedbacks = EventFeedback::with(['event', 'user'])->latest()->get();
        $filename  = 'laporan_feedback_' . now()->format('Ymd') . '.csv';
        $headers   = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        
        $callback = function () use ($feedbacks) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['ID', 'Event', 'User', 'Rating', 'Foto URL', 'Comment', 'Tanggal']);
            foreach ($feedbacks as $f) {
                fputcsv($handle, [
                    $f->id,
                    $f->event->title ?? '-',
                    $f->user->name ?? '-',
                    $f->rating,
                    $f->image ? asset('storage/' . $f->image) : '-',
                    $f->comment,
                    $f->created_at->format('Y-m-d H:i')
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── PARTNERS ──────────────────────────────────────────────

    public function partners(Request $request)
    {
        $query = User::whereHas('role', fn($q) => $q->where('name', 'partner'))
            ->withCount('events');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $partners = $query->get()->map(function ($partner) {
                // Optimize: Get revenue in one query per partner (still not perfect but better than nested loops if there were any)
                // Actually, I'll use a more robust calculation
                $partner->total_revenue = Transaction::whereHas('registration.event', fn($q) => $q->where('created_by', $partner->id))
                    ->whereIn('status', ['paid', 'success'])
                    ->sum('amount');
                
                $partner->total_participants = EventRegistration::whereHas('event', fn($q) => $q->where('created_by', $partner->id))
                    ->where('payment_status', 'paid')
                    ->sum('quantity');
                    
                return $partner;
            });

        return view('manager.partners.index', compact('partners'));
    }

    public function exportPartnersPdf()
    {
        $partners = User::whereHas('role', fn($q) => $q->where('name', 'partner'))
            ->withCount('events')
            ->get()
            ->map(function ($partner) {
                // Optimized revenue calculation including 'success' status
                $partner->total_revenue = Transaction::whereHas('registration.event', function ($q) use ($partner) {
                        $q->where('created_by', $partner->id);
                    })
                    ->whereIn('status', ['paid', 'success'])
                    ->sum('amount');

                // Optimized participants calculation
                $partner->total_participants = EventRegistration::whereHas('event', function ($q) use ($partner) {
                        $q->where('created_by', $partner->id);
                    })
                    ->whereIn('payment_status', ['paid', 'success'])
                    ->sum('quantity');

                return $partner;
            });
            
        $pdf = Pdf::loadView('manager.exports.partners_pdf', compact('partners'));
        return $pdf->download('laporan_partner_' . now()->format('Ymd') . '.pdf');
    }

    public function exportPartnersCsv()
    {
        $partners = User::whereHas('role', fn($q) => $q->where('name', 'partner'))
            ->withCount('events')
            ->get()
            ->map(function ($partner) {
                // Optimized revenue calculation including 'success' status
                $partner->total_revenue = Transaction::whereHas('registration.event', function ($q) use ($partner) {
                        $q->where('created_by', $partner->id);
                    })
                    ->whereIn('status', ['paid', 'success'])
                    ->sum('amount');

                // Optimized participants calculation
                $partner->total_participants = EventRegistration::whereHas('event', function ($q) use ($partner) {
                        $q->where('created_by', $partner->id);
                    })
                    ->whereIn('payment_status', ['paid', 'success'])
                    ->sum('quantity');

                return $partner;
            });

        $filename = 'laporan_partner_' . now()->format('Ymd') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        
        $callback = function () use ($partners) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['Nama Partner', 'Email', 'Jumlah Event', 'Total Partisipan', 'Total Revenue']);
            foreach ($partners as $p) {
                fputcsv($handle, [
                    $p->name,
                    $p->email,
                    $p->events_count,
                    $p->total_participants,
                    $p->total_revenue
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── CUSTOMERS ─────────────────────────────────────────────

    public function customers(Request $request)
    {
        $query = User::whereHas('role', fn($q) => $q->where('name', 'customer'))
            ->with('point')
            ->withCount(['eventRegistrations' => fn($q) => $q->where('payment_status', 'paid')]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(15);
            
        return view('manager.customers.index', compact('customers'));
    }

    public function exportCustomersPdf()
    {
        $customers = User::whereHas('role', fn($q) => $q->where('name', 'customer'))
            ->with('point')
            ->withCount(['eventRegistrations' => fn($q) => $q->where('payment_status', 'paid')])
            ->get();
            
        $pdf = Pdf::loadView('manager.exports.customers_pdf', compact('customers'));
        return $pdf->download('laporan_customer_' . now()->format('Ymd') . '.pdf');
    }

    public function exportCustomersCsv()
    {
        $customers = User::whereHas('role', fn($q) => $q->where('name', 'customer'))
            ->with('point')
            ->withCount(['eventRegistrations' => fn($q) => $q->where('payment_status', 'paid')])
            ->get();

        $filename = 'laporan_customer_' . now()->format('Ymd') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        
        $callback = function () use ($customers) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            fputcsv($handle, ['Nama', 'Email', 'Total Event', 'Total Poin']);
            foreach ($customers as $c) {
                fputcsv($handle, [
                    $c->name,
                    $c->email,
                    $c->event_registrations_count,
                    $c->point->total_points ?? 0
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }
}
