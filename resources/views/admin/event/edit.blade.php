@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <!-- HEADER -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <div>
            <h1 style="font-family: 'Crimson Pro', serif; font-size: 1.8rem; font-weight: 700; color: var(--text-primary); margin: 0;">Edit Event</h1>
            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.25rem;">Perbarui informasi event</p>
        </div>
        <a href="{{ route('admin.event.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Event
        </a>
    </div>

    <form action="{{ route('admin.event.update', $event) }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
        @csrf
        @method('PUT')

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
                        <input type="text" id="title" name="title" required value="{{ old('title', $event->title) }}" placeholder="Contoh: Wismilak Festival 2026"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div>
                            <label for="outlet_id" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Outlet Event</label>
                            <select id="outlet_id" name="outlet_id" required
                                    style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                <option value="" style="background: #111;">-- Pilih Outlet --</option>
                                @foreach($outlets as $outlet)
                                    <option value="{{ $outlet->id }}" style="background: #111;" {{ old('outlet_id', $event->outlets->first()?->id ?? '') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }} ({{ $outlet->city }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="location" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Nama Lokasi / Area</label>
                            <input type="text" id="location" name="location" required value="{{ old('location', $event->location) }}" placeholder="Jakarta Convention Center"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                    </div>

                    <div>
                        <label for="location_detail" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Detail Lokasi Outlet</label>
                        <input type="text" id="location_detail" name="location_detail" value="{{ old('location_detail', $event->outlets->first()?->pivot->location_detail ?? '') }}" placeholder="Contoh: Lantai 2 Ballroom"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <div>
                        <label for="description" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Deskripsi Event</label>
                        <textarea id="description" name="description" rows="5" placeholder="Tuliskan detail event secara lengkap..."
                                  style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; resize: vertical; transition: all 0.3s; font-family: inherit; line-height: 1.5;">{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div>
                            <label for="contact_person_name" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Contact Person Name</label>
                            <input type="text" id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name', $event->contact_person_name) }}" placeholder="Nama kontak..."
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>

                        <div>
                            <label for="contact_person_phone" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Contact Person Phone</label>
                            <input type="text" id="contact_person_phone" name="contact_person_phone" value="{{ old('contact_person_phone', $event->contact_person_phone) }}" placeholder="Nomor telepon..."
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
                        <input type="date" id="date" name="date" required value="{{ old('date', optional($event->date)->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>
                    <div>
                        <label for="start_time" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Jam Mulai</label>
                        <input type="time" id="start_time" name="start_time" required value="{{ old('start_time', $event->start_time) }}"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <div>
                        <label for="end_time" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Jam Selesai</label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time) }}"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>
                    <div>
                        <label for="quota" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Kuota Peserta</label>
                        <input type="number" id="quota" name="quota" required value="{{ old('quota', $event->quota) }}" placeholder="100" min="1"
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
                            <option value="free" style="background: #111;" @selected($event->price_type=='free')>Gratis</option>
                            <option value="paid" style="background: #111;" @selected($event->price_type=='paid')>Berbayar</option>
                        </select>
                    </div>

                    <div>
                        <label for="price" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Harga Tiket (Rupiah)</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $event->price) }}" placeholder="50000" min="0"
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
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    
                    <div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--card-border); max-width: 140px; background: rgba(0,0,0,0.2); padding: 6px; margin-bottom: 0.5rem;">
                        @if($event->image)
                            <img src="{{ asset('storage/'.$event->image) }}" alt="Poster Event" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; display: block;">
                        @else
                            <div style="height: 160px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: var(--text-secondary); font-style: italic;">No Poster</div>
                        @endif
                    </div>

                    <label for="imageUpload" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Pilih Poster Baru</label>
                    <input type="file" id="imageUpload" name="image" accept="image/*"
                           style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    <p id="fileName" style="color: var(--text-secondary); font-size: 0.75rem; opacity: 0.75;">Kosongkan jika tidak ingin mengganti poster</p>
                </div>
            </div>

            <!-- PRIVILEGE PACKAGE -->
            <div class="premium-card">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gold); margin: 0;">Privilege Package</h3>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($event->packages as $package)
                        <input type="text" name="packages[]" value="{{ $package->title }}"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    @endforeach

                    <input type="text" name="packages[]" placeholder="Tambah privilege baru"
                           style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                </div>
            </div>

            <!-- ACTIONS -->
            <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <button type="submit" class="btn-premium" style="width: 100%; padding: 0.85rem; font-size: 0.95rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 20px rgba(212,175,55,0.15);">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H17m-.5 1h4V5"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.event.index') }}" style="padding: 0.85rem; border: 1px solid var(--card-border); border-radius: 10px; color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='none'">
                    Batal
                </a>
            </div>

        </div>
    </form>

</div>

<script>
document.getElementById('imageUpload').addEventListener('change', function(){
    const fileName = this.files[0]?.name ?? "Kosongkan jika tidak ingin mengganti poster";
    document.getElementById('fileName').textContent = 'Terpilih: ' + fileName;
});
</script>
@endsection
