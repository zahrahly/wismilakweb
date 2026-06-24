<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PointHistory;

class UserPointController extends Controller
{
    public function index()
    {
        $users = User::with(['point', 'role'])
            ->whereHas('point')
            ->get();

        return view('admin.points.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['point', 'role']);

        $histories = PointHistory::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $totalEarned = PointHistory::where('user_id', $user->id)->where('type', 'earn')->sum('points');
        $totalSpent  = PointHistory::where('user_id', $user->id)->where('type', 'spend')->sum('points');

        return view('admin.points.users.detail', compact('user', 'histories', 'totalEarned', 'totalSpent'));
    }
}
