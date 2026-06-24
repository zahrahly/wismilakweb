<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        // Fetch both vouchers and rewards, tag each with 'jenis'
        $vouchers = Voucher::all()->map(function ($v) {
            $v->jenis = 'voucher';
            return $v;
        });

        $rewards = Reward::all()->map(function ($r) {
            $r->jenis = 'reward';
            return $r;
        });

        // Merge and sort by latest
        $merged = $vouchers->concat($rewards)->sortByDesc('created_at')->values();

        // Manual pagination
        $perPage = 10;
        $page = $request->input('page', 1);
        $items = new LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.vouchers.index', compact('items'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $jenis = $request->input('type', 'voucher');

        if ($jenis === 'reward') {
            $validated = $request->validate([
                'title'           => 'required|string|max:255',
                'description'     => 'nullable|string',
                'points_required' => 'required|integer|min:0',
                'stock'           => 'required|integer|min:0',
                'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'status'          => 'required|in:active,inactive',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('rewards', 'public');
            }

            Reward::create($validated);
        } else {
            $validated = $request->validate([
                'title'           => 'required|string|max:255',
                'description'     => 'nullable|string',
                'discount_type'   => 'required|in:percentage,fixed',
                'discount_value'  => 'required|numeric|min:0',
                'min_purchase'    => 'nullable|numeric|min:0',
                'max_uses'        => 'nullable|integer|min:0',
                'points_required' => 'required|integer|min:0',
                'valid_from'      => 'nullable|date',
                'valid_until'     => 'nullable|date|after_or_equal:valid_from',
                'status'          => 'required|in:active,inactive',
            ]);

            $validated['code'] = 'WSMK-' . strtoupper(Str::random(8));

            Voucher::create($validated);
        }

        return redirect()->route('admin.vouchers.index')
            ->with('success', ($jenis === 'reward' ? 'Reward' : 'Voucher') . ' berhasil dibuat.');
    }

    public function edit(Request $request, $id)
    {
        $type = $request->query('type', 'voucher');

        if ($type === 'reward') {
            $item = Reward::findOrFail($id);
            $item->jenis = 'reward';
        } else {
            $item = Voucher::findOrFail($id);
            $item->jenis = 'voucher';
        }

        return view('admin.vouchers.edit', compact('item', 'type'));
    }

    public function update(Request $request, $id)
    {
        $type = $request->input('type', 'voucher');

        if ($type === 'reward') {
            $item = Reward::findOrFail($id);

            $validated = $request->validate([
                'title'           => 'required|string|max:255',
                'description'     => 'nullable|string',
                'points_required' => 'required|integer|min:0',
                'stock'           => 'required|integer|min:0',
                'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'status'          => 'required|in:active,inactive',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('rewards', 'public');
            }

            $item->update($validated);
        } else {
            $item = Voucher::findOrFail($id);

            $validated = $request->validate([
                'title'           => 'required|string|max:255',
                'description'     => 'nullable|string',
                'discount_type'   => 'required|in:percentage,fixed',
                'discount_value'  => 'required|numeric|min:0',
                'min_purchase'    => 'nullable|numeric|min:0',
                'max_uses'        => 'nullable|integer|min:0',
                'points_required' => 'required|integer|min:0',
                'valid_from'      => 'nullable|date',
                'valid_until'     => 'nullable|date|after_or_equal:valid_from',
                'status'          => 'required|in:active,inactive',
            ]);

            $item->update($validated);
        }

        return redirect()->route('admin.vouchers.index')
            ->with('success', ($type === 'reward' ? 'Reward' : 'Voucher') . ' berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $type = $request->query('type', 'voucher');

        if ($type === 'reward') {
            Reward::findOrFail($id)->delete();
        } else {
            Voucher::findOrFail($id)->delete();
        }

        return redirect()->route('admin.vouchers.index')
            ->with('success', ($type === 'reward' ? 'Reward' : 'Voucher') . ' berhasil dihapus.');
    }
}
