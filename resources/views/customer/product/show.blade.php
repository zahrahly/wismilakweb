@extends('layouts.customer')

@section('title', $product->name)

@section('content')

<!-- ================= CIBAR DETAILS & HERO ================= -->
<section class="min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-[#060504] relative pt-24">
    <!-- background lighting effect -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_30%,rgba(212,175,55,0.04),transparent_50%)] pointer-events-none"></div>

    <!-- LEFT : TASTING NOTES & DECORATIVE FRAME -->
    <div class="px-8 sm:px-16 lg:px-24 py-16 lg:py-28 flex flex-col justify-center text-white relative z-10">
        <!-- Back link at top -->
        <div class="mb-10">
            <a href="{{ route('product.index') }}" 
               class="inline-flex items-center gap-3 text-xs tracking-[0.2em] text-[#a8a096] uppercase hover:text-[#D4AF37] transition duration-300">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Koleksi
            </a>
        </div>

        <div class="border-l-2 border-[#D4AF37]/40 pl-6 space-y-6">
            <span class="text-xs tracking-[0.4em] text-[#D4AF37] uppercase font-semibold block">
                Tasting Notes & Profile
            </span>

            <h1 class="text-4xl sm:text-5xl font-serif text-[#f4f1eb] leading-tight font-light">
                Sensory <span class="italic text-[#D4AF37]">Experience</span>
            </h1>

            <p class="text-[#a8a096] leading-relaxed max-w-xl text-lg font-light">
                {{ $product->description }}
            </p>
        </div>

        <!-- Flavor Notes Chips if available or custom ones based on product type -->
        <div class="mt-12 pt-8 border-t border-white/5 max-w-xl">
            <h4 class="text-xs tracking-[0.2em] text-[#D4AF37] uppercase mb-4 font-semibold">Karakter Utama</h4>
            <div class="flex flex-wrap gap-2.5">
                <span class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider bg-white/5 border border-white/10 text-[#f4f1eb]">Authentic Javano</span>
                <span class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider bg-white/5 border border-white/10 text-[#f4f1eb]">Cedar & Earthy</span>
                <span class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider bg-white/5 border border-white/10 text-[#f4f1eb]">Masterful Aging</span>
            </div>
        </div>
    </div>

    <!-- RIGHT : MAIN IMAGE CINEMATIC DISPLAY -->
    <div class="relative h-[60vh] lg:h-auto overflow-hidden flex items-center justify-center bg-[#0d0805] border-l border-white/5">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(212,175,55,0.06),transparent_70%)] pointer-events-none"></div>

        @if($product->image_main)
            <img src="{{ asset('storage/'.$product->image_main) }}"
                 class="w-full h-full object-cover transform hover:scale-105 transition duration-1000 ease-out filter brightness-[0.75] contrast-[1.05]">
        @else
            <div class="flex flex-col items-center justify-center text-gray-500 gap-3">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                <span class="text-xs uppercase tracking-widest text-[#a8a096]">Image Preview</span>
            </div>
        @endif

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-l from-black/60 via-transparent to-transparent"></div>
    </div>
</section>

<!-- ================= SPECIFICATION SECTION ================= -->
<section class="bg-[#0f0b08] py-24 sm:py-32 border-t border-white/5 relative">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_80%,rgba(212,175,55,0.03),transparent_50%)] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 px-6 sm:px-12 items-center">
        <!-- DETAIL IMAGE FRAME -->
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-[#D4AF37]/30 to-[#8B2E26]/20 rounded-2xl blur-md opacity-25 group-hover:opacity-40 transition duration-700"></div>
            
            <div class="relative rounded-2xl overflow-hidden border border-[#D4AF37]/20 bg-[#120e0a] p-3">
                @if($product->image_detail)
                    <img src="{{ asset('storage/'.$product->image_detail) }}"
                         class="rounded-xl w-full object-cover shadow-2xl filter brightness-90 group-hover:brightness-95 transition duration-500">
                @else
                    <div class="aspect-video flex items-center justify-center text-gray-600">
                        <span class="text-xs uppercase tracking-widest">Detail Image</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- PRODUCT SPEC -->
        <div class="text-[#f4f1eb] space-y-8">
            <div class="space-y-3">
                <span class="text-xs tracking-[0.3em] text-[#D4AF37] uppercase font-semibold">Premium Blueprint</span>
                <h3 class="text-3xl sm:text-4xl font-serif text-[#f4f1eb]">
                    {{ $product->name }}
                </h3>
                <div class="w-12 h-0.5 bg-[#D4AF37]/60"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-sm tracking-wide bg-[#120e0a]/60 border border-white/5 rounded-2xl p-6 sm:p-8 backdrop-blur-md">
                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3 sm:col-span-2">
                    <span class="text-[#a8a096]">Weight</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->weight ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3">
                    <span class="text-[#a8a096]">Genome</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->genome ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3">
                    <span class="text-[#a8a096]">Assembly</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->assembly ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3">
                    <span class="text-[#a8a096]">Varietal</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->varietal ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3">
                    <span class="text-[#a8a096]">Wrapper</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->wrapper ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3">
                    <span class="text-[#a8a096]">Filler</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->filler ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3">
                    <span class="text-[#a8a096]">Profile</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->profile ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-[#D4AF37]/10 pb-3 sm:col-span-2">
                    <span class="text-[#a8a096]">Size</span>
                    <span class="font-medium text-[#f4f1eb]">{{ $product->size ?? '-' }}</span>
                </div>
            </div>

            <!-- BACK TO COLLECTION ACTION -->
            <div class="pt-4">
                <a href="{{ route('product.index') }}"
                   class="relative inline-flex items-center justify-center overflow-hidden border border-[#D4AF37] px-8 py-3.5 group rounded-full text-xs uppercase tracking-[0.2em] font-semibold text-[#D4AF37] transition duration-300">
                    <span class="absolute inset-0 w-full h-full bg-[#D4AF37] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300 ease-out z-0"></span>
                    <span class="relative z-10 group-hover:text-black transition-colors duration-300">Kembali ke Koleksi</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection


