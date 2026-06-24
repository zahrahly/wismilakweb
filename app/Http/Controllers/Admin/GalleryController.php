<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'caption' => 'nullable',
            'category' => 'nullable',
            'status' => 'required'
        ]);

        $imageName = $request->image->store('gallery', 'public');

        Gallery::create([
            'image' => $imageName,
            'caption' => $request->caption,
            'category' => $request->category,
            'status' => $request->status
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil ditambahkan');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'caption' => 'nullable',
            'category' => 'nullable',
            'status' => 'required'
        ]);

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diupdate');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Galeri dihapus');
    }

}
