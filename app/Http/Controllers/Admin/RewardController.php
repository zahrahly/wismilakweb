<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::latest()->get();
        return view('admin.points.rewards.index', compact('rewards'));
    }

    public function create()
    {
        return view('admin.points.rewards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'points_required' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('rewards', 'public');
        }

        Reward::create([
            'title' => $request->title,
            'description' => $request->description,
            'points_required' => $request->points_required,
            'stock' => $request->stock,
            'image' => $imagePath,
            'status' => 'active',
        ]);

        return redirect()->route('admin.points.rewards.index')
            ->with('success', 'Reward berhasil ditambahkan');
    }

    public function edit(Reward $reward)
    {
        return view('admin.points.rewards.edit', compact('reward'));
    }

    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'points_required' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'points_required' => $request->points_required,
            'stock' => $request->stock,
        ];

        // 🔥 HANDLE GAMBAR BARU
        if ($request->hasFile('image')) {

            // hapus gambar lama (jika ada)
            if ($reward->image && Storage::disk('public')->exists($reward->image)) {
                Storage::disk('public')->delete($reward->image);
            }

            // simpan gambar baru
            $data['image'] = $request->file('image')
                ->store('rewards', 'public');
        }

        $reward->update($data);

        return redirect()->route('admin.points.rewards.index')
            ->with('success', 'Reward berhasil diperbarui');
    }

    public function toggleStatus(Reward $reward)
    {
        $reward->update([
            'status' => $reward->status === 'active'
                ? 'inactive'
                : 'active'
        ]);

        return back()->with('success', 'Status reward berhasil diperbarui');
    }
}
