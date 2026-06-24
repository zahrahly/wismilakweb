<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramPost;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function index()
    {
        $posts = InstagramPost::orderBy('sort_order')->latest()->get();
        return view('admin.instagram.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.instagram.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'instagram_url' => 'nullable|url',
            'caption'       => 'nullable|string|max:255',
            'sort_order'    => 'integer|min:0',
        ]);

        $validated['image_path'] = $request->file('image')->store('instagram', 'public');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['status'] = 'active';
        unset($validated['image']);

        InstagramPost::create($validated);

        return redirect()->route('admin.instagram.index')
            ->with('success', 'Konten Instagram berhasil ditambahkan.');
    }

    public function edit(InstagramPost $instagram)
    {
        return view('admin.instagram.edit', compact('instagram'));
    }

    public function update(Request $request, InstagramPost $instagram)
    {
        $validated = $request->validate([
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'instagram_url' => 'nullable|url',
            'caption'       => 'nullable|string|max:255',
            'sort_order'    => 'integer|min:0',
            'status'        => 'in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('instagram', 'public');
        }
        unset($validated['image']);

        $instagram->update($validated);

        return redirect()->route('admin.instagram.index')
            ->with('success', 'Konten Instagram berhasil diperbarui.');
    }

    public function destroy(InstagramPost $instagram)
    {
        $instagram->delete();
        return back()->with('success', 'Konten Instagram berhasil dihapus.');
    }
}
