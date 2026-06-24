@extends('layouts.customer')

@section('title', 'Collection')

@push('styles')
<style>
    .editorial-hero {
        position: relative;
        background: radial-gradient(circle at 50% 50%, #150C05 0%, #0D0805 100%);
        border-bottom: 1px solid rgba(212, 175, 55, 0.08);
        overflow: hidden;
        padding-top: 8rem;
        padding-bottom: 5rem;
    }
    
    .editorial-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 0%, rgba(212, 175, 55, 0.05) 0%, transparent 60%);
        pointer-events: none;
    }

    .editorial-line {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 1px;
        background: linear-gradient(to bottom, rgba(212, 175, 55, 0) 0%, rgba(212, 175, 55, 0.12) 10%, rgba(212, 175, 55, 0.12) 90%, rgba(212, 175, 55, 0) 100%);
        transform: translateX(-50%);
        z-index: 0;
    }

    .editorial-row {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 6rem;
        align-items: center;
        transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1), transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .editorial-img-container {
        position: relative;
        padding: 1.5rem;
        background: rgba(20, 11, 5, 0.35);
        border: 1px solid rgba(212, 175, 55, 0.06);
        border-radius: 24px;
        transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .editorial-img-frame {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(212, 175, 55, 0.15);
        aspect-ratio: 4/5;
    }

    .editorial-img-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.8s cubic-bezier(0.22, 1, 0.36, 1);
        filter: brightness(0.8) contrast(1.05);
    }

    .editorial-img-container:hover {
        border-color: rgba(212, 175, 55, 0.25);
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.85), 0 0 40px rgba(212, 175, 55, 0.04);
        transform: translateY(-8px);
    }

    .editorial-img-container:hover .editorial-img-frame img {
        transform: scale(1.06);
        filter: brightness(0.9) contrast(1.05);
    }

    .spec-table {
        width: 100%;
        border-collapse: collapse;
    }

    .spec-table td {
        padding: 0.85rem 0;
        font-size: 0.85rem;
        border-bottom: 1px solid rgba(212, 175, 55, 0.08);
    }

    .spec-table tr:last-child td {
        border-bottom: none;
    }

    .spec-label {
        color: rgba(245, 235, 224, 0.4);
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-size: 0.68rem;
    }

    .spec-value {
        color: var(--cream);
        text-align: right;
        font-weight: 500;
    }

    .editorial-cta {
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        color: var(--gold);
        text-decoration: none;
        padding: 1.1rem 2.2rem;
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 8px;
        background: rgba(212, 175, 55, 0.02);
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        margin-top: 1.5rem;
    }

    .editorial-cta:hover {
        background: var(--gold);
        color: #000;
        border-color: var(--gold);
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        transform: translateY(-3px);
    }

    .editorial-cta svg {
        transition: transform 0.4s ease;
    }

    .editorial-cta:hover svg {
        transform: translateX(6px);
    }

    #profile-dropdown option {
        background: #1C0F06;
        color: white;
    }

    @media (max-width: 1024px) {
        .editorial-row {
            grid-template-columns: 1fr;
            gap: 4rem;
        }
        .editorial-line {
            display: none;
        }
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="editorial-hero">
    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <div style="text-align: center; display: flex; flex-direction: column; align-items: center;">
            <div style="display:inline-flex;align-items:center;gap:0.8rem;color:var(--gold);font-size:0.75rem;letter-spacing:0.4em;text-transform:uppercase;margin-bottom:1.5rem;">
                <span style="display:block;width:30px;height:1px;background:var(--gold);"></span>
                Heritage Portfolio
                <span style="display:block;width:30px;height:1px;background:var(--gold);"></span>
            </div>

            <h1 class="section-title font-serif" style="margin-bottom: 1.8rem; letter-spacing: -0.01em;">
                Explore Our <em>Signature</em> Series
            </h1>

            <p style="color: rgba(245,235,224,0.5); max-width: 650px; margin: 0 auto; font-size: 1rem; line-height: 1.9; font-weight: 300;">
                A curated legacy of Indonesian tobacco mastery. Each masterpiece is handcrafted with generations of expertise, precision, and passion since 1962.
            </p>
        </div>
    </div>
</section>

<!-- MAIN SHOWCASE WITH DYNAMIC FILTER -->
<section class="bg-[#0D0805] pt-12 pb-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 relative">

        @php
            $profiles = $products->pluck('profile')->filter()->unique()->values();
        @endphp

        <!-- LUXURY STANDALONE SEARCH FILTER -->
        <div class="mb-14 relative z-10 flex justify-center">
            <div class="relative w-full max-w-md">
                <input type="text" id="search-input" placeholder="Search our signature series..." 
                       class="w-full bg-[#150C05]/60 border border-[#D4AF37]/25 rounded-full py-3.5 pl-12 pr-6 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/20 transition duration-500 font-light tracking-wide shadow-lg hover:border-[#D4AF37]/45">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-[#D4AF37]/75">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.3-4.3"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Center connecting timeline line on desktop -->
        <div class="editorial-line"></div>

        <div class="space-y-40" id="editorial-rows-container">

            @forelse($products as $i => $product)
                @php
                    $isEven = $i % 2 === 0;
                @endphp

                <div class="editorial-row reveal" data-name="{{ $product->name }}" data-description="{{ $product->description }}" data-profile-slug="{{ Str::slug($product->profile) }}">
                    
                    @if($isEven)
                        <!-- Image Left -->
                        <div class="col-span-12 lg:col-span-6 {{ $isEven ? 'lg:pr-8' : 'lg:pl-8' }} editorial-img-col">
                            <div class="editorial-img-container">
                                <div class="editorial-img-frame">
                                    @if($product->image_main)
                                        <img src="{{ asset('storage/'.$product->image_main) }}" alt="{{ $product->name }}" loading="{{ $i < 2 ? 'eager' : 'lazy' }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#150C05]">
                                            <svg width="100" height="200" viewBox="0 0 80 160" fill="none">
                                                <rect x="30" y="10" width="20" height="130" rx="10" fill="rgba(212,175,55,0.1)" />
                                                <ellipse cx="40" cy="145" rx="15" ry="6" fill="rgba(212,175,55,0.05)" />
                                                <rect x="22" y="50" width="36" height="24" rx="2" fill="none" stroke="rgba(212,175,55,0.3)" stroke-width="1.5" />
                                                <text x="40" y="67" text-anchor="middle" font-family="serif" font-size="14" fill="rgba(212,175,55,0.6)">W</text>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Content (Left or Right depending on alignment) -->
                    <div class="col-span-12 lg:col-span-6 flex flex-col justify-center space-y-8 {{ $isEven ? 'lg:pl-12' : 'lg:pr-12' }} editorial-content-col">
                        <div class="space-y-4">
                            <span class="text-xs font-semibold tracking-[0.3em] text-[#D4AF37] uppercase block">
                                // PORTFOLIO SERIES NO. {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <h2 class="text-4xl lg:text-5xl font-serif text-white font-medium leading-tight">
                                {{ $product->name }}
                            </h2>
                            <p class="text-gray-400 text-base leading-relaxed font-light pt-2">
                                {{ $product->description }}
                            </p>
                        </div>

                        <!-- Technical Specs Comparison Minimalist Table -->
                        <div class="pt-4 max-w-md">
                            <table class="spec-table">
                                <tbody>
                                    @if($product->profile)
                                        <tr>
                                            <td class="spec-label">Flavor Profile</td>
                                            <td class="spec-value">{{ $product->profile }}</td>
                                        </tr>
                                    @endif
                                    @if($product->size)
                                        <tr>
                                            <td class="spec-label">Size / Format</td>
                                            <td class="spec-value">{{ $product->size }}</td>
                                        </tr>
                                    @endif
                                    @if($product->wrapper)
                                        <tr>
                                            <td class="spec-label">Wrapper Leaf</td>
                                            <td class="spec-value">{{ $product->wrapper }}</td>
                                        </tr>
                                    @endif
                                    @if($product->filler)
                                        <tr>
                                            <td class="spec-label">Filler Blend</td>
                                            <td class="spec-value">{{ $product->filler }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <a href="{{ route('product.show', $product) }}" class="editorial-cta">
                                Discover Masterpiece
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    @if(!$isEven)
                        <!-- Image Right -->
                        <div class="col-span-12 lg:col-span-6 {{ $isEven ? 'lg:pr-8' : 'lg:pl-8' }} editorial-img-col">
                            <div class="editorial-img-container">
                                <div class="editorial-img-frame">
                                    @if($product->image_main)
                                        <img src="{{ asset('storage/'.$product->image_main) }}" alt="{{ $product->name }}" loading="{{ $i < 2 ? 'eager' : 'lazy' }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#150C05]">
                                            <svg width="100" height="200" viewBox="0 0 80 160" fill="none">
                                                <rect x="30" y="10" width="20" height="130" rx="10" fill="rgba(212,175,55,0.1)" />
                                                <ellipse cx="40" cy="145" rx="15" ry="6" fill="rgba(212,175,55,0.05)" />
                                                <rect x="22" y="50" width="36" height="24" rx="2" fill="none" stroke="rgba(212,175,55,0.3)" stroke-width="1.5" />
                                                <text x="40" y="67" text-anchor="middle" font-family="serif" font-size="14" fill="rgba(212,175,55,0.6)">W</text>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            @empty

                <div class="text-center py-32">
                    <p class="text-[#D4AF37]/50 uppercase tracking-[0.3em] text-xs">
                        Collection Coming Soon
                    </p>
                </div>

            @endforelse

        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const rows = document.querySelectorAll('.editorial-row');
        const searchInput = document.getElementById('search-input');
        
        let searchQuery = '';

        function filterProducts() {
            let visibleIndex = 0;
            rows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const description = row.getAttribute('data-description').toLowerCase();

                const matchesSearch = (name.includes(searchQuery) || description.includes(searchQuery));

                if (matchesSearch) {
                    row.style.display = 'grid';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                    
                    // Rearrange grid elements to maintain strict alternating layout for visible items
                    const imgCol = row.querySelector('.editorial-img-col');
                    const contentCol = row.querySelector('.editorial-content-col');
                    
                    if (imgCol && contentCol) {
                        const isEven = visibleIndex % 2 === 0;
                        
                        // Remove padding alignment classes
                        imgCol.classList.remove('lg:pr-8', 'lg:pl-8');
                        contentCol.classList.remove('lg:pl-12', 'lg:pr-12');
                        
                        // Add correct alignment depending on order
                        if (isEven) {
                            row.insertBefore(imgCol, contentCol);
                            imgCol.classList.add('lg:pr-8');
                            contentCol.classList.add('lg:pl-12');
                        } else {
                            row.appendChild(imgCol);
                            imgCol.classList.add('lg:pl-8');
                            contentCol.classList.add('lg:pr-12');
                        }
                    }
                    
                    visibleIndex++;
                } else {
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(15px)';
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.toLowerCase().trim();
            filterProducts();
        });
        
        // Initial call to ensure proper grid order
        filterProducts();
    });
</script>
@endpush
