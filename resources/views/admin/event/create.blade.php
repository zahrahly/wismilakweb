@extends('layouts.admin')

@section('title', 'Tambah Event')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <!-- PAGE HEADER -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <div>
            <h1 style="font-family: 'Crimson Pro', serif; font-size: 1.8rem; font-weight: 700; color: var(--text-primary); margin: 0;">Tambah Event</h1>
            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.25rem;">
                Kelola dan publikasikan event untuk customer
            </p>
        </div>
        <a href="{{ route('admin.event.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Event
        </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
        @csrf

        <!-- LEFT SIDE -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- INFORMASI EVENT -->
            <div class="premium-card">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Informasi Event</h3>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    <div>
                        <label for="title" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Judul Event</label>
                        <input type="text" id="title" name="title" required placeholder="Contoh: Wismilak Festival 2026"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div>
                            <label for="outlet_id" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Outlet Event</label>
                            <select id="outlet_id" name="outlet_id" required
                                    style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                <option value="" style="background: #111;">-- Pilih Outlet --</option>
                                @foreach($outlets as $outlet)
                                    <option value="{{ $outlet->id }}" style="background: #111;">{{ $outlet->name }} ({{ $outlet->city }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="location" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Nama Lokasi / Area</label>
                            <input type="text" id="location" name="location" required placeholder="Jakarta Convention Center"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                    </div>

                    <div>
                        <label for="location_detail" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Detail Lokasi Outlet</label>
                        <input type="text" id="location_detail" name="location_detail" placeholder="Contoh: Lantai 2 Ballroom"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <div>
                        <label for="description" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Deskripsi Event</label>
                        <textarea id="description" name="description" rows="5" placeholder="Tuliskan detail event secara lengkap..."
                                  style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; resize: vertical; transition: all 0.3s; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div>
                            <label for="contact_person_name" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Contact Person Name</label>
                            <input type="text" id="contact_person_name" name="contact_person_name" placeholder="Nama kontak..."
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>

                        <div>
                            <label for="contact_person_phone" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Contact Person Phone</label>
                            <input type="text" id="contact_person_phone" name="contact_person_phone" placeholder="Nomor telepon..."
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- JADWAL & KUOTA -->
            <div class="premium-card">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Jadwal & Kuota</h3>
                </div>
                <div style="padding: 1.5rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem;">
                    <div>
                        <label for="date" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Tanggal Event</label>
                        <input type="date" id="date" name="date" required min="{{ date('Y-m-d') }}"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>
                    <div>
                        <label for="start_time" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Jam Mulai</label>
                        <input type="time" id="start_time" name="start_time" required
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <div>
                        <label for="end_time" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Jam Selesai</label>
                        <input type="time" id="end_time" name="end_time"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>
                    <div>
                        <label for="quota" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Kuota Peserta</label>
                        <input type="number" id="quota" name="quota" required placeholder="100" min="1"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- HARGA -->
            <div class="premium-card">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Harga Event</h3>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    <div>
                        <label for="price_type" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Jenis Event</label>
                        <select id="price_type" name="price_type" required
                                style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                            <option value="free" style="background: #111;">Gratis</option>
                            <option value="paid" style="background: #111;">Berbayar</option>
                        </select>
                    </div>

                    <div>
                        <label for="price" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Harga Tiket (Rupiah)</label>
                        <input type="number" id="price" name="price" placeholder="50000" min="0"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.4rem; opacity: 0.75;">Kosongkan jika event gratis</p>
                    </div>
                </div>
            </div>

            <!-- POSTER -->
            <div class="premium-card">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Poster Event</h3>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <label for="image" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">File Poster</label>
                    <input type="file" id="image" name="image" accept="image/*" required
                           style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    <p style="color: var(--text-secondary); font-size: 0.75rem; opacity: 0.75;">Format gambar: JPG, PNG, WebP (Rasio disarankan: portrait, maks. 2MB)</p>
                </div>
            </div>

            <!-- PRIVILEGE PACKAGE -->
            <div class="premium-card">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Privilege Package</h3>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    <input type="text" name="packages[]" placeholder="Contoh: Free cigar"
                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">

                    <input type="text" name="packages[]" placeholder="Contoh: Free drink"
                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">

                    <input type="text" name="packages[]" placeholder="Contoh: Merchandise"
                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                </div>
            </div>

            <!-- ACTION -->
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn-premium" style="width: 100%; padding: 0.85rem; font-size: 0.95rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 20px rgba(212,175,55,0.15);">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Simpan Event Baru
                </button>
            </div>

        </div>
    </form>

</div>
@endsection


