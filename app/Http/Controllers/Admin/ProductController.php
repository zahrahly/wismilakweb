<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'image_main' => 'required|image',
        'image_detail' => 'required|image',
        'status' => 'required',
    ]);

    $imageMain = $request->file('image_main')->store('products', 'public');
    $imageDetail = $request->file('image_detail')->store('products', 'public');

    Product::create([
        'name' => $request->name,
        'image_main' => $imageMain,
        'image_detail' => $imageDetail,

        'short_description' => $request->short_description,
        'description' => $request->description,

        'weight' => $request->weight,
        'genome' => $request->genome,
        'assembly' => $request->assembly,
        'varietal' => $request->varietal,
        'wrapper' => $request->wrapper,
        'filler' => $request->filler,
        'profile' => $request->profile,
        'size' => $request->size,

        'status' => $request->status,
    ]);

    return redirect()->route('admin.product.index')
        ->with('success', 'Produk berhasil ditambahkan');
}


    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

   public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'name' => 'required',
        'status' => 'required',
    ]);

    // IMAGE OPTIONAL
    if ($request->hasFile('image_main')) {
        $data['image_main'] =
            $request->file('image_main')->store('products', 'public');
    }

    if ($request->hasFile('image_detail')) {
        $data['image_detail'] =
            $request->file('image_detail')->store('products', 'public');
    }

    // SPEC
    $data += [
        'short_description' => $request->short_description,
        'description' => $request->description,

        'weight' => $request->weight,
        'genome' => $request->genome,
        'assembly' => $request->assembly,
        'varietal' => $request->varietal,
        'wrapper' => $request->wrapper,
        'filler' => $request->filler,
        'profile' => $request->profile,
        'size' => $request->size,
    ];

    $product->update($data);

    return redirect()->route('admin.product.index')
        ->with('success', 'Produk berhasil diperbarui');
}


    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }
}
