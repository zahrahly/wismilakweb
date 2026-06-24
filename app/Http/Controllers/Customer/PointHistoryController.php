<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PointHistory;
use Illuminate\Support\Facades\Auth;

class PointHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $histories = PointHistory::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $totalPoints = $user->point?->total_points ?? 0;
        $totalEarned = PointHistory::where('user_id', $user->id)->where('type', 'earn')->sum('points');
        $totalSpent = PointHistory::where('user_id', $user->id)->where('type', 'spend')->sum('points');

        return view('customer.points.history', compact('histories', 'totalPoints', 'totalEarned', 'totalSpent'));
    }
}
