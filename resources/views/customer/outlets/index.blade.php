@extends('layouts.customer')

@section('title', 'Find Us')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
<style>
    #map-container {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(212,175,55,0.15);
        margin-bottom: 3rem;
        z-index: 10;
        min-height: 550px;
        display: block;
    }
    #outlet-map {
        height: 550px;
        width: 100%;
        background: #1a1a25;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
    }
    .leaflet-popup-content-wrapper {
        background: #1A1A25 !important;
        color: #E8E8ED !important;
        border-radius: 12px !important;
        border: 1px solid rgba(212,175,55,0.2) !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5) !important;
    }
    .leaflet-popup-tip { background: #1A1A25 !important; }
    .leaflet-popup-content { margin: 12px 16px !important; }
    .popup-title {
        font-size: 0.95rem; font-weight: 700; color: #D4AF37;
        margin-bottom: 0.5rem;
    }
    .popup-detail {
        font-size: 0.8rem; color: #8A8A9A;
        line-height: 1.6; margin-bottom: 0.25rem;
    }
    .outlet-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px; padding: 1.5rem;
        transition: all 0.3s ease; cursor: pointer;
    }
    .outlet-card:hover {
        border-color: rgba(212,175,55,0.3);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .leaflet-tile-pane { filter: saturate(0.8) contrast(1.1); }
    :root {
    --lounge-black: #080808;
    --lounge-matte: #111111;
    --lounge-charcoal: #1a1a1a;
    --lounge-gold: #c5a059;
    --lounge-gold-dim: rgba(197, 160, 89, 0.5);
    --lounge-border: rgba(255, 255, 255, 0.05);
    --lounge-text: #eaeaea;
    --lounge-text-dim: #888888;
    --serif: 'Playfair Display', serif;
    --sans: 'Inter', sans-serif;
}

.serif-heading {
    font-family: var(--serif);
    color: var(--lounge-text);
    line-height: 1.1;
}

.gold-accent {
    color: var(--lounge-gold);
    font-style: italic;
}

.lounges-section {
    background: #0D0805;
    padding-top: 2rem;
}

.lounges-header {
    text-align: center;
    padding: 3rem 0 3rem 0;
}

.lounges-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 3rem;
    max-width: 1600px;
    margin: 0 auto;
}

.lounge-card {
    background: var(--lounge-matte);
    border: 1px solid var(--lounge-border);
    transition: all 0.5s ease;
    position: relative;
    overflow: hidden;
}

.lounge-card:hover {
    border-color: var(--lounge-gold-dim);
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

.lounge-card-img {
    height: 300px;
    background: var(--lounge-charcoal);
    width: 100%;
    position: relative;
    overflow: hidden;
}

.lounge-card-img::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, var(--lounge-matte), transparent);
}

.lounge-card-content {
    padding: 3rem;
    position: relative;
    z-index: 2;
}

.link-arrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--lounge-text);
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-size: 0.75rem;
    transition: color 0.3s ease;
}

.link-arrow span {
    display: block;
    width: 30px;
    height: 1px;
    background: currentColor;
    transition: width 0.3s ease;
}

.link-arrow:hover {
    color: var(--lounge-gold);
}

.link-arrow:hover span {
    width: 50px;
}

.map-focus-btn {
    background: transparent;
    border: none;
    color: var(--lounge-gold);
    cursor: pointer;
    transition: transform 0.3s ease;
}

.map-focus-btn:hover {
    transform: scale(1.15);
}

@media (max-width: 768px) {
    .lounges-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .lounge-card-content {
        padding: 2rem;
    }
}
.lounge-card-top {
    min-height: 150px;
    padding: 2.5rem 3rem;
    background:
        radial-gradient(circle at top right, rgba(197,160,89,0.18), transparent 35%),
        linear-gradient(135deg, #161616, #0b0b0b);
    border-bottom: 1px solid var(--lounge-border);
    display: flex;
    align-items: center;
    gap: 1.2rem;
    position: relative;
    overflow: hidden;
}

.lounge-card-top::after {
    content: '';
    position: absolute;
    right: -40px;
    bottom: -40px;
    width: 130px;
    height: 130px;
    border: 1px solid rgba(197,160,89,0.18);
    border-radius: 50%;
}

.lounge-location-icon {
    width: 58px;
    height: 58px;
    border: 1px solid rgba(197,160,89,0.4);
    color: var(--lounge-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(197,160,89,0.06);
    flex-shrink: 0;
}

.lounge-city {
    color: var(--lounge-gold);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.22em;
    display: block;
    margin-bottom: 0.4rem;
}

.lounge-subtitle {
    color: var(--lounge-text-dim);
    font-size: 0.85rem;
    margin: 0;
}
</style>
@endpush

@section('content')
<section class="bg-[#0D0805] pt-20 pb-24">
    <div class="max-w-7xl mx-auto px-8">

        <!-- HERO HEADER -->
         <div style="text-align: center; margin-bottom: 3rem;">
        <span class="section-label" style="justify-content: center;">Find Us</span>
        <h1 class="section-title">Discover Our <em>Outlets</em></h1>
        <p style="color: rgba(245,235,224,0.4); max-width: 600px; margin: 1rem auto; font-size: 0.95rem;">
            Temukan outlet Wismilak Premium Cigars terdekat dari lokasi Anda.
        </p>
    </div>

    <!-- Map -->
    <div id="map-container">
        <div id="outlet-map"></div>
    </div>

   <!-- Outlet List Premium -->
<section class="lounges-section">
    <div class="lounges-header">
        <span class="section-label" style="justify-content: center;">The Destinations</span>
        <h2 class="section-title">Our <em>Lounges</em></h2>
        <p style="color: rgba(245,235,224,0.4); max-width: 600px; margin: 1rem auto; font-size: 0.9rem;">
            Jelajahi lokasi outlet resmi Wismilak Premium Cigars yang tersedia di berbagai wilayah.
        </p>
        <!-- Search Bar -->
        <div style="max-width:480px;margin:1.5rem auto 0;">
            <div style="position:relative;">
                <svg width="18" height="18" fill="none" stroke="rgba(197,160,89,0.5)" stroke-width="2" viewBox="0 0 24 24" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="outletSearch" placeholder="Cari outlet berdasarkan nama, kota, atau alamat..."
                    oninput="filterOutlets(this.value)"
                    style="width:100%;padding:12px 16px 12px 44px;background:rgba(255,255,255,0.03);border:1px solid rgba(197,160,89,0.2);border-radius:10px;color:#eaeaea;font-size:0.88rem;outline:none;transition:border-color .25s;"
                    onfocus="this.style.borderColor='rgba(197,160,89,0.5)'" onblur="this.style.borderColor='rgba(197,160,89,0.2)'">
            </div>
        </div>
    </div>

    <div class="lounges-grid" id="loungesGrid">
        @foreach($outlets as $outlet)
        <div class="lounge-card" data-name="{{ strtolower($outlet->name) }}" data-city="{{ strtolower($outlet->city ?? $outlet->region ?? '') }}" data-address="{{ strtolower($outlet->address ?? '') }}">

            <!-- Card Header Pengganti Interior Visual -->
            <div class="lounge-card-top">
                <div class="lounge-location-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>

                <div>
                    <span class="lounge-city">
                        {{ $outlet->city ?? $outlet->region ?? 'Wismilak Outlet' }}
                    </span>
                    <p class="lounge-subtitle">Official Outlet Location</p>
                </div>
            </div>

            <!-- Card Content -->
            <div class="lounge-card-content">
                <span style="
                    color: var(--lounge-gold);
                    font-size: 0.7rem;
                    text-transform: uppercase;
                    letter-spacing: 0.2em;
                    display: block;
                    margin-bottom: 1rem;
                ">
                    {{ $outlet->region ?? 'Location' }}
                </span>

                <h3 class="serif-heading" style="font-size: 2rem; margin-bottom: 1.5rem;">
                    {{ $outlet->name }}
                </h3>

                <p style="
                    color: var(--lounge-text-dim);
                    font-size: 0.9rem;
                    line-height: 1.8;
                    margin-bottom: 2rem;
                ">
                    {{ $outlet->address }}
                </p>

                <div style="
                    border-top: 1px solid var(--lounge-border);
                    padding-top: 1.5rem;
                    margin-bottom: 2.5rem;
                ">
                    <p style="color: var(--lounge-text); font-size: 0.8rem; margin-bottom: 0.5rem;">
                        <span style="color:var(--lounge-text-dim); display:inline-block; width:80px;">
                            Hours
                        </span>
                        {{ $outlet->opening_hours ?? '-' }}
                    </p>

                    @if($outlet->phone)
                    <p style="color: var(--lounge-text); font-size: 0.8rem;">
                        <span style="color:var(--lounge-text-dim); display:inline-block; width:80px;">
                            Contact
                        </span>
                        {{ $outlet->phone }}
                    </p>
                    @endif
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('outlets.show', $outlet) }}" class="link-arrow">
                        Lihat Detail <span></span>
                    </a>

                    @if($outlet->latitude && $outlet->longitude)
                    <button
                        type="button"
                        class="map-focus-btn"
                        onclick="flyToOutlet({{ $outlet->latitude }}, {{ $outlet->longitude }})"
                        aria-label="Lihat lokasi di maps"
                    >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div id="noResults" style="display:none;text-align:center;padding:3rem;color:rgba(245,235,224,0.4);font-size:0.9rem;">
        Tidak ada outlet yang cocok dengan pencarian Anda.
    </div>
</section>

    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script>
    function filterOutlets(query) {
        const q = query.toLowerCase().trim();
        const cards = document.querySelectorAll('.lounge-card');
        let visibleCount = 0;
        cards.forEach(card => {
            const name = card.dataset.name || '';
            const city = card.dataset.city || '';
            const address = card.dataset.address || '';
            if (!q || name.includes(q) || city.includes(q) || address.includes(q)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
    }
    // Initialize map centered on Indonesia
    const map = L.map('outlet-map', {
        zoomControl: false,
    }).setView([-6.2, 106.8], 5);

    L.control.zoom({ position: 'topright' }).addTo(map);

    // Dark tile layer
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO',
        maxZoom: 19,
    }).addTo(map);

    // Custom gold marker icon
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

    // Marker cluster
    const markers = L.markerClusterGroup({
        iconCreateFunction: function(cluster) {
            return L.divIcon({
                html: `<div style="
                    background: linear-gradient(135deg, #D4AF37, #B8860B);
                    width: 36px; height: 36px; border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    color: #000; font-weight: 700; font-size: 0.85rem;
                    box-shadow: 0 3px 15px rgba(212,175,55,0.5);
                ">${cluster.getChildCount()}</div>`,
                className: 'custom-cluster',
                iconSize: [36, 36],
            });
        }
    });

    // Load outlets from API
    fetch('{{ route("api.outlets") }}')
        .then(res => res.json())
        .then(outlets => {
            outlets.forEach(outlet => {
                if (!outlet.latitude || !outlet.longitude) return;

                const marker = L.marker([outlet.latitude, outlet.longitude], { icon: goldIcon })
                    .bindPopup(`
                        <div class="popup-title">${outlet.name}</div>
                        <div class="popup-detail">${outlet.address}</div>
                        <div class="popup-detail">${outlet.opening_hours || '-'}</div>
                        ${outlet.phone ? `<div class="popup-detail">${outlet.phone}</div>` : ''}
                    `);
                markers.addLayer(marker);
            });

            map.addLayer(markers);

            if (outlets.length > 0) {
                const bounds = markers.getBounds();
                if (bounds.isValid()) {
                    map.fitBounds(bounds, { padding: [50, 50] });
                }
            }
        });

    function flyToOutlet(lat, lng) {
    map.flyTo([lat, lng], 15, { duration: 1.5 });

    const mapContainer = document.getElementById('map-container');
    if (mapContainer) {
        mapContainer.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
}
</script>
@endpush

