<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardRedemption;

class RewardRedemptionController extends Controller
{
    public function index()
    {
        $redemptions = RewardRedemption::with('user','reward')
            ->latest()
            ->get();

        return view('admin.points.redemptions.index', compact('redemptions'));
    }
}
