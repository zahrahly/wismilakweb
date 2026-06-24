@extends('layouts.customer')

@section('title', $pressroom->title)

@section('content')

<section class="py-24 sm:py-32 bg-[#060504] relative">
    <!-- background lighting glow -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(212,175,55,0.03),transparent_60%)] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10" x-data="{ copyText: 'Salin Tautan', copyLink() { navigator.clipboard.writeText(window.location.href); this.copyText = 'Tersalin!'; setTimeout(() => this.copyText = 'Salin Tautan', 2000); } }">

        <!-- BACK BUTTON -->
        <div class="mb-10">
            <a href="{{ route('pressroom.index') }}" 
               class="inline-flex items-center gap-2.5 text-xs tracking-[0.2em] text-[#a8a096] uppercase hover:text-[#d4af37] font-semibold transition duration-300">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Pressroom
            </a>
        </div>

        <!-- CATEGORY BADGE & METRICS -->
        <div class="flex items-center gap-4 mb-6">
            <span class="px-3 py-1 bg-[#d4af37]/10 text-[#d4af37] border border-[#d4af37]/20 rounded-full text-[10px] uppercase tracking-[0.2em] font-semibold">
                {{ $pressroom->category ?? 'News' }}
            </span>
            <span class="w-1.5 h-1.5 rounded-full bg-white/20"></span>
            <span class="text-xs text-gray-500 font-light">
                {{ \Carbon\Carbon::parse($pressroom->published_at)->format('d F Y') }}
            </span>
        </div>

        <!-- TITLE -->
        <h1 class="text-3xl sm:text-5xl font-serif text-[#f4f1eb] leading-tight mb-8 font-light">
            {{ $pressroom->title }}
        </h1>

        <!-- SHARE ACTIONS ROW -->
        <div class="flex flex-wrap items-center justify-between gap-4 py-5 border-y border-white/5 mb-10">
            <div class="flex items-center gap-2">
                <span class="text-xs text-[#a8a096] uppercase tracking-wider font-semibold">Bagikan :</span>
            </div>
            
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- WhatsApp -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($pressroom->title . ' - ' . url()->current()) }}" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 text-xs font-semibold bg-white/5 border border-white/10 text-[#f4f1eb] hover:bg-[#25D366]/10 hover:border-[#25D366]/30 hover:text-[#25D366] px-4 py-2 rounded-full transition duration-300">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.49-3.993l.363.216c1.558.927 3.348 1.417 5.162 1.418 5.666 0 10.278-4.606 10.282-10.273.002-2.743-1.063-5.321-2.998-7.258a10.187 10.187 0 00-7.27-2.996C6.463 2.914 1.854 7.522 1.85 13.19c-.001 1.9.497 3.755 1.442 5.378l.235.404-.954 3.486 3.574-.937zm11.3-7.854c-.29-.146-1.72-.85-1.987-.946-.268-.097-.463-.146-.659.146-.196.29-.757.946-.928 1.14-.17.195-.342.22-.632.074-.29-.147-1.228-.453-2.338-1.444-.864-.77-1.448-1.72-1.617-2.013-.17-.29-.018-.448.127-.592.13-.13.29-.34.436-.51.145-.17.196-.29.29-.485.097-.195.048-.364-.025-.51-.073-.145-.66-1.59-.904-2.176-.237-.57-.48-.493-.66-.502-.17-.008-.366-.01-.562-.01-.197 0-.517.073-.787.363-.27.29-1.03 1.007-1.03 2.454 0 1.447 1.053 2.845 1.2 3.039.147.194 2.072 3.165 5.02 4.44.701.303 1.248.484 1.674.62.704.223 1.344.192 1.85.117.564-.084 1.72-.703 1.962-1.383.243-.68.243-1.261.17-1.38-.073-.118-.27-.195-.56-.341z"/></svg>
                    WhatsApp
                </a>
                
                <!-- Instagram Copy Link -->
                <button @click="copyLink()" 
                        class="inline-flex items-center gap-2 text-xs font-semibold bg-white/5 border border-white/10 text-[#f4f1eb] hover:bg-[#e1306c]/10 hover:border-[#e1306c]/30 hover:text-[#e1306c] px-4 py-2 rounded-full transition duration-300">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051C.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    Salin Tautan
                </button>
            </div>
        </div>

        <!-- MAIN IMAGE DISPLAY WITH BORDER FRAME -->
        <div class="relative rounded-2xl overflow-hidden border border-[#d4af37]/20 bg-[#120e0a] p-3 mb-12">
            @if($pressroom->image)
                <img src="{{ asset('storage/'.$pressroom->image) }}"
                     class="w-full h-[300px] sm:h-[450px] object-cover rounded-xl filter brightness-90">
            @else
                <div class="h-[300px] flex items-center justify-center text-gray-500">No Image</div>
            @endif
        </div>

        <!-- EDITORIAL ARTICLE CONTENT -->
        <div class="prose prose-invert max-w-none prose-headings:font-serif prose-headings:font-light prose-headings:text-[#f4f1eb] prose-p:text-gray-300 prose-p:leading-relaxed prose-p:text-lg prose-a:text-[#d4af37] prose-blockquote:border-[#d4af37] prose-blockquote:bg-white/5 prose-blockquote:p-6 prose-blockquote:rounded-r-lg">
            {!! $pressroom->content !!}
        </div>

    </div>
</section>

@endsection

