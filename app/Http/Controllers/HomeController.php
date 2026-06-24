<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\Product;


class HomeController extends Controller
{
    public function index()
    {
        // Auto-update event statuses
        Event::autoUpdateStatuses();

        $galleries = Gallery::where('status', 'tampil')
                            ->latest()
                            ->get();

         $products = Product::where('status', 1)
                    ->latest()
                    ->take(6)
                    ->get();

        // Upcoming events: published/ongoing, date >= today, nearest first
        $upcomingEvents = Event::upcoming()->take(6)->get();

        $instagramPosts = \App\Models\InstagramPost::active()->ordered()->take(8)->get();

        return view('customer.home', compact('galleries', 'products', 'upcomingEvents', 'instagramPosts'));
    }

    public function show(Product $product)
    {
        return view('customer.product.show', compact('product'));
    }
}
