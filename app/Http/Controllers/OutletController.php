<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::where('status', 'active')
            ->withCount(['availableProducts'])
            ->get();
        return view('customer.outlets.index', compact('outlets'));
    }

    public function show(Outlet $outlet)
    {
        $outlet->load(['products']);

        $explicitEvents = $outlet->events()
            ->whereIn('status', ['published', 'ongoing'])
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();

        $allOutletEvents = \App\Models\Event::where('is_all_outlets', true)
            ->whereIn('status', ['published', 'ongoing'])
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();

        $mergedEvents = $explicitEvents->merge($allOutletEvents)->unique('id')->sortBy('date');
        $outlet->setRelation('events', $mergedEvents);

        return view('customer.outlets.show', compact('outlet'));
    }

    /**
     * JSON endpoint for Leaflet.js markers
     */
    public function apiIndex()
    {
        $outlets = Outlet::where('status', 'active')
            ->select('id', 'name', 'address', 'latitude', 'longitude', 'phone', 'opening_hours', 'city', 'region')
            ->withCount(['availableProducts'])
            ->get();

        return response()->json($outlets);
    }
}
