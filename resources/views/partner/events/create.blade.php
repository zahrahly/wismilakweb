@extends('layouts.dashboard')

@section('title', isset($event) ? 'Edit Event' : 'Buat Event Baru')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('partner.events.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        KEMBALI KE DAFTAR EVENT
    </a>
</div>

<div style="margin-bottom: 2.5rem;">
    <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
        {{ isset($event) ? 'Edit Detail Event' : 'Buat Event Baru' }}
    </h1>
    <p style="color: var(--text-secondary); font-size: 0.95rem;">
        {{ isset($event) ? 'Perbarui informasi event Anda untuk menarik lebih banyak peserta.' : 'Lengkapi formulir di bawah ini untuk mendaftarkan event baru ke sistem.' }}
    </p>
</div>

<form method="POST" action="{{ isset($event) ? route('partner.events.update', $event) : route('partner.events.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($event)) @method('PUT') @endif

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem;">
        {{-- LEFT COLUMN: Basic Info --}}
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="premium-card" style="padding: 2rem;">
                <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">Informasi Utama</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Judul Event</label>
                        <input type="text" name="title" class="form-input" style="width: 100%;" value="{{ old('title', ($event ?? null)->title ?? '') }}" placeholder="Contoh: Wismilak Cigar Night Experience" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Tanggal Event</label>
                            <input type="date" name="date" class="form-input" style="width: 100%;" value="{{ old('date', isset($event->date) ? $event->date->format('Y-m-d') : '') }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Kuota Peserta</label>
                            <input type="number" name="quota" class="form-input" style="width: 100%;" value="{{ old('quota', ($event ?? null)->quota ?? '') }}" placeholder="0" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Jam Mulai</label>
                            <input type="time" name="start_time" class="form-input" style="width: 100%;" value="{{ old('start_time', ($event ?? null)->start_time ?? '') }}">
                        </div>
                        <div>
                            <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Jam Selesai</label>
                            <input type="time" name="end_time" class="form-input" style="width: 100%;" value="{{ old('end_time', ($event ?? null)->end_time ?? '') }}">
                        </div>
                    </div>

                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Lokasi Event</label>
                        <input type="text" name="location" class="form-input" style="width: 100%;" value="{{ old('location', ($event ?? null)->location ?? '') }}" placeholder="Contoh: Ballroom Hotel Grand Hyatt, Jakarta" required>
                    </div>
                </div>
            </div>

            <div class="premium-card" style="padding: 2rem;">
                <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">Deskripsi & Detail</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Deskripsi Lengkap</label>
                        <textarea name="description" class="form-input" style="width: 100%; min-height: 150px;" placeholder="Jelaskan detail event, agenda, dan apa yang akan didapatkan peserta..." required>{{ old('description', ($event ?? null)->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Privilege Peserta (Optional)</label>
                        <textarea name="packages[]" class="form-input" style="width: 100%; min-height: 100px;" placeholder="Gunakan baris baru untuk setiap privilege...&#10;Contoh:&#10;- Exclusive Cigar Pack&#10;- Welcome Drink&#10;- Networking Session">{{ old('packages.0', isset($event) && count($event->packages ?? []) > 0 ? implode("\n", $event->packages->pluck('title')->toArray()) : '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Pricing & Location & Media --}}
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="premium-card" style="padding: 2rem;">
                <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">Harga & Tiket</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Tipe Akses</label>
                        <select name="price_type" class="form-input" style="width: 100%;" id="priceType" onchange="togglePrice()">
                            <option value="free" {{ old('price_type', ($event ?? null)->price_type ?? '') == 'free' ? 'selected' : '' }}>Gratis (Free Entry)</option>
                            <option value="paid" {{ old('price_type', ($event ?? null)->price_type ?? '') == 'paid' ? 'selected' : '' }}>Berbayar (Premium Ticket)</option>
                        </select>
                    </div>

                    <div id="priceField" style="{{ old('price_type', ($event ?? null)->price_type ?? 'free') == 'free' ? 'display:none' : '' }}">
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Harga Tiket (IDR)</label>
                        <input type="number" name="price" class="form-input" style="width: 100%;" value="{{ old('price', ($event ?? null)->price ?? '') }}" placeholder="0">
                    </div>
                </div>
            </div>

            <div class="premium-card" style="padding: 2rem;">
                <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">Lokasi Outlet</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.4rem; font-size: 0.75rem;">Pilih Outlet</label>
                        <select name="outlet_id" class="form-input" style="width: 100%;">
                            <option value="">-- Pilih Outlet Wismilak --</option>
                            @foreach($outlets as $outlet)
                                <option value="{{ $outlet->id }}" {{ old('outlet_id', isset($event) ? ($event->outlets->first()?->id ?? '') : '') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label" style="display: block; margin-bottom: 0.4rem; font-size: 0.75rem;">Detail Area (Contoh: VIP Lounge)</label>
                        <input type="text" name="location_detail" class="form-input" style="width: 100%;" value="{{ old('location_detail', isset($event) ? ($event->outlets->first()?->pivot->location_detail ?? '') : '') }}" placeholder="Ballroom / Area Merokok">
                    </div>
                </div>
            </div>

            <div class="premium-card" style="padding: 2rem;">
                <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">Poster Event</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="position: relative; border: 2px dashed var(--card-border); border-radius: 12px; padding: 2rem; text-align: center; transition: border-color 0.3s;" onmouseover="this.style.borderColor='var(--gold-dim)'" onmouseout="this.style.borderColor='var(--card-border)'">
                        <input type="file" name="image" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: var(--text-secondary); margin-bottom: 1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <div style="font-size: 0.85rem; color: var(--text-primary); font-weight: 600;">Klik untuk Upload Poster</div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 4px;">PNG, JPG max 2MB</div>
                    </div>
                    @if(isset($event) && $event->image)
                        <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(255,255,255,0.03); padding: 0.75rem; border-radius: 8px; border: 1px solid var(--card-border);">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                            <div style="font-size: 0.75rem; color: var(--text-secondary);">Poster saat ini telah terpasang.</div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="premium-card" style="padding: 2rem;">
                <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">Kontak PIC</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <input type="text" name="contact_person_name" class="form-input" value="{{ old('contact_person_name', ($event ?? null)->contact_person_name ?? '') }}" placeholder="Nama Penanggung Jawab">
                    <input type="text" name="contact_person_phone" class="form-input" value="{{ old('contact_person_phone', ($event ?? null)->contact_person_phone ?? '') }}" placeholder="Nomor WhatsApp">
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div style="background: rgba(231,76,76,0.1); border: 1px solid rgba(231,76,76,0.3); color: var(--red); padding: 1rem 1.5rem; border-radius: 12px; margin: 2rem 0; font-size: 0.875rem;">
            <div style="font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Terjadi Kesalahan:
            </div>
            <ul style="padding-left: 1.5rem; margin: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="margin-top: 3rem; display: flex; justify-content: flex-end; gap: 1rem;">
        <a href="{{ route('partner.events.index') }}" class="btn-premium" style="background: transparent; color: var(--text-secondary); border: 1px solid var(--card-border);">
            BATAL
        </a>
        <button type="submit" class="btn-premium">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
            {{ isset($event) ? 'SIMPAN PERUBAHAN' : 'SIMPAN SEBAGAI DRAFT' }}
        </button>
    </div>
</form>

<script>
function togglePrice() {
    const field = document.getElementById('priceField');
    const type = document.getElementById('priceType').value;
    field.style.display = type === 'paid' ? 'block' : 'none';
}
</script>

@endsection