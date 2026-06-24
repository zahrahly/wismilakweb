<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
{
    // Mengambil seluruh katalog data produk untuk pelanggan umum.
    $products = Product::latest()->get();
    return view('customer.product.index', compact('products'));
}


    public function show(Product $product)
    {
        return view('customer.product.show', compact('product'));
    }
}
