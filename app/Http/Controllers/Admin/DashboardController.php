<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ChatSession;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events'       => Event::count(),
            'published_events'   => Event::where('status', 'published')->count(),
            'total_participants' => EventRegistration::where('payment_status', 'paid')->count(),
            'total_revenue'      => Transaction::where('status', 'paid')->sum('amount'),
            'total_users'        => User::count(),
            'active_chats'       => ChatSession::where('status', 'open')->count(),
        ];

        $recentEvents = Event::latest()->take(5)->get();

        $recentTransactions = Transaction::with(['user', 'registration.event'])
            ->where('status', 'paid')
            ->latest('paid_at')
            ->take(5)
            ->get();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyRevenue[] = [
                'month'   => $date->format('M Y'),
                'revenue' => Transaction::where('status', 'paid')
                    ->whereYear('paid_at', $date->year)
                    ->whereMonth('paid_at', $date->month)
                    ->sum('amount'),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentTransactions', 'monthlyRevenue'));
    }
}
