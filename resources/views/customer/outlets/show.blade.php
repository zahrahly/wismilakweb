@extends('layouts.customer')

@section('title', $outlet->name)

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map-container {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(212,175,55,0.18);
        margin-bottom: 2rem;
        box-shadow: 0 20px 45px rgba(0,0,0,0.7);
        background: #0d0805;
    }
    #outlet-map {
        height: 420px;
        width: 100%;
        background: #0d0805;
    }
    .leaflet-popup-content-wrapper {
        background: #120e0a !important;
        color: #f4f1eb !important;
        border-radius: 12px !important;
        border: 1px solid rgba(212,175,55,0.2) !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.6) !important;
    }
    .leaflet-popup-tip { background: #120e0a !important; }
    .leaflet-popup-content { margin: 12px 16px !important; }
    .popup-title {
        font-size: 0.95rem; font-weight: 700; color: #D4AF37;
        margin-bottom: 0.4rem;
        font-family: 'Playfair Display', serif;
    }
    .leaflet-tile-pane { filter: saturate(0.3) brightness(0.6) contrast(1.25); }

    .content-card {
        background: rgba(20,14,10,0.45);
        border: 1px solid rgba(212,175,55,0.08);
        border-radius: 20px;
        padding: 2rem;
        backdrop-filter: blur(12px);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .product-card {
        background: rgba(10,8,6,0.5);
        border: 1px solid rgba(212,175,55,0.06);
        border-radius: 14px;
        padding: 1.2rem;
        display: flex;
        gap: 1.2rem;
        align-items: center;
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .product-card:hover {
        transform: translateY(-4px);
        border-color: rgba(212,175,55,0.28);
        box-shadow: 0 12px 30px rgba(0,0,0,0.5);
        background: rgba(20,14,10,0.8);
    }

    .status-badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        font-weight: 700;
        letter-spacing: 0.12em;
    }
    .status-available { background: rgba(16,185,129,0.12); color: #10B981; border: 1px solid rgba(16,185,129,0.2); }
    .status-unavailable { background: rgba(239,68,68,0.12); color: #EF4444; border: 1px solid rgba(239,68,68,0.2); }
</style>
@endpush

@section('content')
<section class="min-h-screen bg-[#060504] py-24 relative">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(212,175,55,0.03),transparent_50%)] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 sm:px-12 relative z-10">
        
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs tracking-widest text-[#a8a096] uppercase mb-12">
            <a href="{{ route('outlets.index') }}" class="hover:text-[#D4AF37] transition">Outlet kami</a>
            <span class="text-white/20">/</span>
            <span class="text-[#D4AF37] font-semibold">{{ $outlet->name }}</span>
        </div>

        <!-- Header Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 mb-16 items-start">
            <div class="space-y-8">
                <div class="space-y-4">
                    <span class="text-xs tracking-[0.3em] text-[#D4AF37] uppercase font-semibold block">// Premium Outlet</span>
                    <h1 class="text-4xl sm:text-5xl font-serif text-[#f4f1eb] leading-tight font-light">
                        {{ $outlet->name }}
                    </h1>
                    <div class="w-16 h-0.5 bg-[#D4AF37]/50"></div>
                </div>

                <p class="text-[#a8a096] leading-relaxed text-lg font-light">
                    {{ $outlet->address }}
                </p>

                <div class="flex flex-col gap-4 text-sm bg-white/5 border border-white/5 rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center justify-center w-10 h-10 bg-[#D4AF37]/15 text-[#D4AF37] border border-[#D4AF37]/20 rounded-full">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </span>
                        <div>
                            <span class="block text-xs text-[#a8a096] uppercase tracking-wider font-semibold">Jam Buka</span>
                            <span class="text-[#f4f1eb]">{{ $outlet->opening_hours ?? '-' }}</span>
                        </div>
                    </div>
                    
                    @if($outlet->phone)
                    <div class="flex items-center gap-4">
                        <span class="flex items-center justify-center w-10 h-10 bg-[#D4AF37]/15 text-[#D4AF37] border border-[#D4AF37]/20 rounded-full">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <div>
                            <span class="block text-xs text-[#a8a096] uppercase tracking-wider font-semibold">Telepon</span>
                            <span class="text-[#f4f1eb]">{{ $outlet->phone }}</span>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $outlet->latitude }},{{ $outlet->longitude }}" 
                       target="_blank" 
                       class="relative inline-flex items-center justify-center overflow-hidden bg-[#D4AF37] px-8 py-3.5 group rounded-full text-xs uppercase tracking-[0.2em] font-semibold text-black transition duration-300 hover:shadow-lg hover:shadow-[#D4AF37]/25">
                       Dapatkan Rute
                    </a>
                </div>
            </div>

            <!-- Map -->
            <div id="map-container">
                <div id="outlet-map"></div>
            </div>
        </div>

        <!-- Content Split: Products & Events -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Products -->
            <div class="content-card lg:col-span-2 space-y-6">
                <div class="border-b border-white/5 pb-4">
                    <h2 class="text-xl font-serif text-[#D4AF37] tracking-wider">Ketersediaan Produk</h2>
                </div>
                
                @if($outlet->products->count() > 0)
                    <div class="product-grid">
                        @foreach($outlet->products as $product)
                        <div class="product-card">
                            @if($product->image_main)
                                <img src="{{ asset('storage/' . $product->image_main) }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-lg object-cover border border-[#D4AF37]/15">
                            @else
                                <div class="w-14 h-14 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-gray-500">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                                </div>
                            @endif
                            <div class="space-y-1">
                                <h4 class="font-serif text-[#f4f1eb] text-sm hover:text-[#D4AF37] transition">
                                    <a href="{{ route('product.show', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </h4>
                                <div class="flex items-center gap-2">
                                    @if($product->pivot->is_available)
                                        <span class="status-badge status-available">TERSEDIA</span>
                                    @else
                                        <span class="status-badge status-unavailable">HABIS</span>
                                    @endif
                                </div>
                                @if($product->pivot->notes)
                                    <div class="text-[11px] text-[#a8a096]/60 italic font-light pt-0.5">
                                        {{ $product->pivot->notes }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-[#a8a096]/40 text-sm font-light">
                        Informasi ketersediaan produk belum tersedia di outlet ini.
                    </div>
                @endif
            </div>

            <!-- Upcoming Events -->
            <div class="content-card space-y-6">
                <div class="border-b border-white/5 pb-4">
                    <h2 class="text-xl font-serif text-[#D4AF37] tracking-wider">Event Mendatang</h2>
                </div>

                @if($outlet->events->count() > 0)
                    <div class="flex flex-col gap-4">
                        @foreach($outlet->events as $event)
                        <a href="{{ route('events.show', $event) }}" class="group block p-5 border border-white/5 hover:border-[#D4AF37]/20 rounded-xl bg-black/35 hover:bg-[#120e0a] transition duration-300">
                            <h4 class="font-serif text-[#f4f1eb] text-sm group-hover:text-[#D4AF37] transition duration-300 mb-2">{{ $event->title }}</h4>
                            <div class="text-[11px] text-[#a8a096]/60 flex flex-col gap-1 font-light">
                                <span>{{ $event->date ? $event->date->format('d M Y') : '-' }}</span>
                                <span>{{ $event->location }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-[#a8a096]/40 text-xs font-light">
                        Belum ada event mendatang di outlet ini.
                    </div>
                @endif
            </div>

        </div>

    </div>

</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const lat = {{ $outlet->latitude ?? '-6.2' }};
    const lng = {{ $outlet->longitude ?? '106.8' }};
    
    const map = L.map('outlet-map', {
        zoomControl: false,
    }).setView([lat, lng], 15);

    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO',
        maxZoom: 19,
    }).addTo(map);

    const goldIcon = L.divIcon({
        className: 'custom-marker',
        html: `<div style="
            width: 28px; height: 28px;
            background: linear-gradient(135deg, #D4AF37, #B8860B);
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            border: 2px solid rgba(212,175,55,0.5);
            box-shadow: 0 3px 10px rgba(212,175,55,0.4);
            display: flex; align-items: center; justify-content: center;
        "><div style="
            width: 8px; height: 8px;
            background: #000;
            border-radius: 50%;
            transform: rotate(45deg);
        "></div></div>`,
        iconSize: [28, 28],
        iconAnchor: [14, 28],
        popupAnchor: [0, -28],
    });

    L.marker([lat, lng], { icon: goldIcon })
        .bindPopup(`
            <div class="popup-title">{{ $outlet->name }}</div>
            <div class="popup-detail" style="font-size: 0.8rem; color: #8A8A9A;">{{ Str::limit($outlet->address, 50) }}</div>
        `)
        .addTo(map)
        .openPopup();
</script>
@endpush
