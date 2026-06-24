@extends('layouts.customer')

@section('title', 'Pressroom — Wismilak Experiences')

@section('content')

<style>
/* ── PRESSROOM LUXURY STYLES ── */
:root {
    --pr-black: #060504;
    --pr-dark: #0d0805;
    --pr-card: #120e0a;
    --pr-gold: #d4af37;
    --pr-gold-dim: rgba(212,175,55,0.4);
    --pr-cream: #f4f1eb;
    --pr-text: #a8a096;
    --pr-border: rgba(212,175,55,0.12);
    --pr-serif: 'Playfair Display', serif;
    --pr-sans: 'Inter', sans-serif;
}

.pr-hero {
    padding: 8rem 0 3rem;
    text-align: center;
    position: relative;
    background: var(--pr-dark);
}
.pr-hero::after {
    content: '';
    position: absolute; bottom: 0; left: 10%; right: 10%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--pr-gold-dim), transparent);
}
.pr-label {
    display: inline-flex; align-items: center; gap: 12px;
    font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.3em;
    color: var(--pr-gold); font-weight: 600; margin-bottom: 1.5rem;
}
.pr-label::before, .pr-label::after {
    content: ''; width: 30px; height: 1px; background: var(--pr-gold);
}
.pr-hero h1 {
    font-family: var(--pr-serif); color: var(--pr-cream); font-size: clamp(2.25rem, 5vw, 3.75rem);
    font-weight: 400; line-height: 1.15; margin: 0 0 1rem;
}
.pr-hero h1 em { font-style: italic; color: var(--pr-gold); }
.pr-hero-sub {
    color: var(--pr-text); max-width: 580px; margin: 0 auto 2.5rem;
    font-size: 0.95rem; line-height: 1.7;
}

/* Tabs */
.pr-tabs { display: flex; gap: 12px; justify-content: center; margin-bottom: 3.5rem; }
.pr-tab {
    padding: 12px 32px; border-radius: 100px;
    font-size: 0.82rem; font-weight: 600; letter-spacing: 0.08em;
    cursor: pointer; transition: all 0.35s ease; border: 1px solid transparent;
    text-decoration: none; display: inline-block;
}
.pr-tab.active {
    background: var(--pr-gold); color: var(--pr-black);
    box-shadow: 0 6px 20px rgba(212,175,55,0.35);
}
.pr-tab:not(.active) {
    border-color: var(--pr-gold-dim); color: var(--pr-gold);
    background: transparent;
}
.pr-tab:not(.active):hover {
    border-color: var(--pr-gold); background: rgba(212,175,55,0.08);
}

/* Search bar */
.pr-search-input {
    width: 100%; background: linear-gradient(135deg, var(--pr-card) 0%, #1a1410 100%);
    border: 1px solid var(--pr-border); border-radius: 100px;
    padding: 1.1rem 1.5rem 1.1rem 3.5rem; color: var(--pr-cream);
    font-size: 0.9rem; outline: none; transition: all 0.3s;
}
.pr-search-input:focus {
    border-color: var(--pr-gold);
    box-shadow: 0 0 20px rgba(212,175,55,0.12);
}

/* News Editorial Card */
.pr-card {
    background: linear-gradient(135deg, var(--pr-card) 0%, #18130e 100%);
    border: 1px solid var(--pr-border);
    border-radius: 20px; overflow: hidden;
    transition: all 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    display: grid; grid-template-columns: 1.2fr 2fr;
}
.pr-card:hover {
    border-color: rgba(212,175,55,0.4);
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.6), 0 0 25px rgba(212,175,55,0.05);
}
.pr-card-img {
    height: 100%; min-height: 280px; overflow: hidden; position: relative;
    border-right: 1px solid var(--pr-border);
}
.pr-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.4,0,0.2,1);
}
.pr-card:hover .pr-card-img img { transform: scale(1.06); }
.pr-card-body {
    padding: 2.75rem; display: flex; flex-direction: column; justify-content: space-between;
}
.pr-card-badge {
    font-size: 0.65rem; text-transform: uppercase; tracking: 0.2em;
    color: var(--pr-gold); font-weight: 700; display: block; margin-bottom: 0.75rem;
}
.pr-card-title {
    font-family: var(--pr-serif); color: var(--pr-cream);
    font-size: 1.65rem; font-weight: 400; margin: 0 0 0.75rem;
    line-height: 1.35; transition: color 0.3s;
}
.pr-card:hover .pr-card-title { color: var(--pr-gold); }
.pr-card-date {
    color: rgba(168,160,150,0.5); font-size: 0.8rem; font-weight: 500; margin-bottom: 1.25rem;
}
.pr-card-text {
    color: var(--pr-text); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.75rem;
}

/* Premium Buttons */
.pr-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--pr-gold); color: var(--pr-black);
    padding: 11px 26px; border-radius: 100px; text-decoration: none;
    font-size: 0.82rem; font-weight: 700; letter-spacing: 0.05em;
    transition: all 0.3s; border: none; cursor: pointer;
}
.pr-btn:hover { box-shadow: 0 6px 20px rgba(212,175,55,0.4); transform: translateY(-1px); }
.pr-btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    background: transparent; color: var(--pr-gold);
    border: 1px solid var(--pr-gold-dim);
    padding: 10px 24px; border-radius: 100px; text-decoration: none;
    font-size: 0.82rem; font-weight: 600; letter-spacing: 0.05em;
    transition: all 0.3s; cursor: pointer;
}
.pr-btn-outline:hover {
    border-color: var(--pr-gold); background: rgba(212,175,55,0.06);
    color: var(--pr-gold);
}

/* Form Styles */
.pr-form-input {
    width: 100%; background: transparent; border: none;
    border-bottom: 1px solid rgba(212,175,55,0.15);
    padding: 12px 4px; color: var(--pr-cream); font-size: 0.9rem;
    outline: none; transition: border-color 0.3s;
}
.pr-form-input:focus {
    border-color: var(--pr-gold);
}
.pr-form-input::placeholder {
    color: rgba(168,160,150,0.4);
}

@media (max-width: 768px) {
    .pr-card { grid-template-columns: 1fr; }
    .pr-card-img { border-right: none; border-bottom: 1px solid var(--pr-border); height: 200px; min-height: 200px; }
    .pr-card-body { padding: 1.75rem; }
}
</style>

<section class="bg-[#0D0805]" style="padding-bottom: 7rem;">

    <!-- HERO -->
    <div class="pr-hero">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <span class="pr-label">Pressroom</span>
            <h1>News & <em>Media</em> Relations</h1>
            <p class="pr-hero-sub">Stay informed with official updates, news announcements, and exclusive brand statements from Wismilak.</p>

            <div class="pr-tabs">
                <a href="{{ route('pressroom.index', ['tab' => 'press']) }}"
                   class="pr-tab {{ $tab === 'press' ? 'active' : '' }}">
                    PRESS RELEASES
                </a>

                <a href="{{ route('pressroom.index', ['tab' => 'media']) }}"
                   class="pr-tab {{ $tab === 'media' ? 'active' : '' }}">
                    MEDIA INQUIRIES
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTAINER -->
    <div style="max-width: 1100px; margin: 4rem auto 0; padding: 0 2rem;">

        @if($tab === 'press')
            <!-- SEARCH BAR -->
            <div style="margin-bottom: 3.5rem;">
                <form method="GET" action="{{ route('pressroom.index') }}">
                    <input type="hidden" name="tab" value="press">
                    <div style="position: relative; width: 100%;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari rilis berita..." class="pr-search-input">
                        <button type="submit" style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--pr-gold); cursor: pointer; padding: 0; outline: none;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- NEWS LIST -->
            <div style="display: flex; flex-direction: column; gap: 2.5rem;">
                @forelse($pressrooms as $press)
                    <div class="pr-card">
                        <div class="pr-card-img">
                            <img src="{{ asset('storage/'.$press->image) }}" alt="{{ $press->title }}" loading="lazy">
                        </div>
                        <div class="pr-card-body">
                            <div>
                                <span class="pr-card-badge">PRESS RELEASE</span>
                                <h2 class="pr-card-title">{{ $press->title }}</h2>
                                <div class="pr-card-date">
                                    {{ \Carbon\Carbon::parse($press->published_at)->format('d F Y') }}
                                </div>
                                <p class="pr-card-text">
                                    {{ \Illuminate\Support\Str::limit($press->excerpt, 180) }}
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('pressroom.show', $press->slug) }}" class="pr-btn-outline">
                                    Read Article <span>→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 6rem 2rem; border: 1px dashed var(--pr-border); border-radius: 20px; background: var(--pr-card);">
                        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin: 0 auto 1.25rem; color: var(--pr-gold); opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                        <p style="color: var(--pr-text); font-size: 1rem;">Belum ada press release yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            <div style="margin-top: 3.5rem;">
                {{ $pressrooms->links() }}
            </div>

        @elseif($tab === 'media')
            <!-- MEDIA INQUIRIES CONTENT -->
            <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 4rem; align-items: start; margin-top: 1rem;">
                <!-- LEFT SIDE TEXT -->
                <div style="padding-top: 1rem;">
                    <h2 class="font-serif" style="font-size: 2.25rem; color: var(--pr-cream); font-weight: 400; margin-bottom: 1.5rem; line-height: 1.25;">Official <em style="color: var(--pr-gold); font-style: italic;">Media</em> Center</h2>
                    <p style="color: var(--pr-text); font-size: 0.95rem; line-height: 1.8; margin-bottom: 2rem;">
                        Kami berkomitmen untuk mendukung jurnalisme dan keterbukaan informasi. Untuk keperluan rilis pers resmi, konfirmasi berita, undangan liputan event eksklusif, maupun kemitraan publikasi, silakan mengirimkan permohonan resmi melalui formulir terlampir.
                    </p>
                    <p style="color: rgba(168,160,150,0.6); font-size: 0.85rem; line-height: 1.6; border-left: 2px solid var(--pr-gold); padding-left: 1.25rem; font-style: italic;">
                        Tim Media Relations kami akan merespons pertanyaan dan permintaan konfirmasi Anda dalam waktu maksimal 24 jam kerja.
                    </p>
                </div>

                <!-- RIGHT SIDE FORM -->
                <div style="background: linear-gradient(135deg, var(--pr-card) 0%, #15100b 100%); border: 1px solid var(--pr-border); border-radius: 20px; padding: 3rem;">
                    
                    @if(session('success'))
                        <div style="background: rgba(46, 204, 113, 0.1); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; padding: 1rem 1.25rem; border-radius: 10px; font-size: 0.85rem; font-weight: 600; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                            ✔ {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pressroom.media.send') }}" style="display: flex; flex-direction: column; gap: 1.75rem;">
                        @csrf

                        <div>
                            <input type="text" name="name" placeholder="Nama Lengkap Anda *" required class="pr-form-input">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <input type="email" name="email" placeholder="Email Kantor *" required class="pr-form-input">
                            <input type="text" name="phone" placeholder="Nomor Telepon *" required class="pr-form-input">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <input type="text" name="organization" placeholder="Nama Media / Organisasi *" required class="pr-form-input">
                            
                            <div style="position: relative;">
                                <select name="inquiry_type" id="inquiry_type" required class="pr-form-input" style="padding-right: 2rem; cursor: pointer; color: var(--pr-cream);">
                                    <option value="" disabled selected hidden>Pilih Jenis Inquiry *</option>
                                    <option value="Press Coverage" style="background:#120e0a; color:#fff;">Press Coverage</option>
                                    <option value="Collaboration" style="background:#120e0a; color:#fff;">Collaboration</option>
                                    <option value="Interview Request" style="background:#120e0a; color:#fff;">Interview Request</option>
                                    <option value="Sponsorship" style="background:#120e0a; color:#fff;">Sponsorship</option>
                                    <option value="Media Partnership" style="background:#120e0a; color:#fff;">Media Partnership</option>
                                </select>
                                <span style="position: absolute; right: 4px; top: 50%; transform: translateY(-50%); color: var(--pr-gold); pointer-events: none; font-size: 0.75rem;">▼</span>
                            </div>
                        </div>

                        <div>
                            <input type="text" name="subject" placeholder="Subjek / Judul Permohonan *" required class="pr-form-input">
                        </div>

                        <div>
                            <textarea name="message" rows="4" placeholder="Detail Permohonan Anda... *" required class="pr-form-input" style="resize: vertical; font-family: inherit;"></textarea>
                        </div>

                        <div style="margin-top: 1rem;">
                            <button type="submit" class="pr-btn" style="width: 100%; padding: 14px; font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; display: flex; justify-content: center; align-items: center; gap: 8px;">
                                KIRIM PERMOHONAN <span>→</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            @if(request()->isMobile ?? false)
            <style>
                div[style*="grid-template-columns: 1fr 1.2fr"] {
                    grid-template-columns: 1fr !important;
                    gap: 3rem !important;
                }
                div[style*="grid-template-columns: 1fr 1fr"] {
                    grid-template-columns: 1fr !important;
                    gap: 1.75rem !important;
                }
            </style>
            @endif
        @endif

    </div>

</section>

@endsection
