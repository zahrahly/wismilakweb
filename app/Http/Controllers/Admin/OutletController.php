<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index(Request $request)
    {
        $outlets = Outlet::query()
        ->with('partners')
        ->when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        })
        ->when($request->region, function ($q) use ($request) {
            $q->where('region', $request->region);
        })
        ->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        })
        ->latest()
        ->get();

        $partners = User::whereHas('role', fn($q) => $q->where('name', 'partner'))->get();
        $regions = Outlet::select('region')->distinct()->whereNotNull('region')->where('region', '!=', '')->orderBy('region')->pluck('region');

    return view('admin.outlets.index', compact('outlets', 'partners', 'regions'));
    }

    public function create()
    {
        return view('admin.outlets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'region' => 'required',
            'city' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        Outlet::create($request->all());

        return redirect()->route('admin.outlets.index')
            ->with('success', 'Outlet berhasil ditambahkan');
    }

    public function edit(Outlet $outlet)
    {
        $partners = User::whereHas('role', fn($q) => $q->where('name', 'partner'))->get();
        return view('admin.outlets.edit', compact('outlet', 'partners'));
    }

    public function update(Request $request, Outlet $outlet)
    {
        $outlet->update($request->except('partner_id'));

        // sync partner assignment
        if ($request->has('partner_id')) {
            if ($request->partner_id) {
                $outlet->partners()->sync([$request->partner_id]);
            } else {
                $outlet->partners()->detach();
            }
        }

        return redirect()->route('admin.outlets.index')
            ->with('success', 'Outlet berhasil diperbarui');
    }

    public function destroy(Outlet $outlet)
    {
        $outlet->update(['status' => 'inactive']);

        return back()->with('success', 'Outlet dinonaktifkan');
    }

    public function toggleStatus(Outlet $outlet)
    {
        $outlet->update([
            'status' => $outlet->status === 'active'
                ? 'inactive'
                : 'active'
        ]);

        return back()->with(
            'success',
            'Status outlet berhasil diperbarui'
        );
    }

    public function assignPartner(Request $request, Outlet $outlet)
    {
        if ($request->partner_id) {
            $outlet->partners()->sync([$request->partner_id]);
        } else {
            $outlet->partners()->detach();
        }

        return back()->with('success', 'Partner berhasil di-assign ke outlet');
    }

    /**
     * Manage product availability for an outlet
     */
    public function manageProducts(Outlet $outlet)
    {
        $allProducts = Product::where('status', 1)->orderBy('name')->get();
        $outletProducts = $outlet->products()->pluck('products.id')->toArray();
        $availabilityMap = $outlet->products()
            ->get()
            ->mapWithKeys(fn($p) => [$p->id => ['is_available' => $p->pivot->is_available, 'notes' => $p->pivot->notes]])
            ->toArray();

        return view('admin.outlets.products', compact('outlet', 'allProducts', 'outletProducts', 'availabilityMap'));
    }

    /**
     * Update product availability for an outlet
     */
    public function updateProducts(Request $request, Outlet $outlet)
    {
        $products = $request->input('products', []);
        $syncData = [];

        foreach ($products as $productId => $data) {
            if (isset($data['assigned'])) {
                $syncData[$productId] = [
                    'is_available' => isset($data['available']),
                    'notes'        => $data['notes'] ?? null,
                ];
            }
        }

        $outlet->products()->sync($syncData);

        return redirect()->route('admin.outlets.index')
            ->with('success', 'Product availability berhasil diperbarui untuk ' . $outlet->name);
    }
}
