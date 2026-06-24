<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pressroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PressroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Pressroom::query();

        // SEARCH
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // FILTER DATE
        if ($request->date) {
            $query->whereDate('published_at', $request->date);
        }

        $pressrooms = $query->latest()->paginate(10);

        return view('admin.pressroom.index', compact('pressrooms'));
    }

    public function create()
    {
        return view('admin.pressroom.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pressroom', 'public');
        }

        Pressroom::create([
    'title' => $request->title,
    'slug' => Str::slug($request->title),
    'image' => $imagePath,
    'excerpt' => $request->excerpt,
    'content' => $request->content,
    'published_at' => $request->published_at,
    'status' => $request->status,
]);


        return redirect()->route('admin.pressroom.index')
            ->with('success', 'Pressroom berhasil ditambahkan');
    }

    public function edit(Pressroom $pressroom)
    {
        return view('admin.pressroom.edit', compact('pressroom'));
    }

    public function update(Request $request, Pressroom $pressroom)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] =
                $request->file('image')->store('pressroom', 'public');
        }

        $data['slug'] = Str::slug($request->title);
        $data['excerpt'] = $request->excerpt;
        $data['published_at'] = $request->published_at;

        $pressroom->update($data);

        return redirect()->route('admin.pressroom.index')
            ->with('success', 'Pressroom berhasil diperbarui');
    }

    public function destroy(Pressroom $pressroom)
    {
        $pressroom->delete();

        return back()->with('success', 'Pressroom berhasil dihapus');
    }
}
