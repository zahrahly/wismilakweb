@extends('layouts.admin')

@section('title', 'Tambah Outlet')

@section('content')
<div style="max-width: 750px; margin: 0 auto;">

    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.outlets.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div style="background: rgba(231,76,76,0.1); border: 1px solid rgba(231,76,76,0.3); color: #E74C4C; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem;">
            <ul style="list-style: disc; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="premium-card">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--gold); margin: 0;">Tambah Outlet</h3>
            <p style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">Buat data lokasi outlet atau cabang toko virtual Wismilak yang baru.</p>
        </div>
        
        <div style="padding: 2rem;">
            <form action="{{ route('admin.outlets.store') }}" method="POST">
                @csrf

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- NAME -->
                    <div>
                        <label for="name" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Nama Outlet</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Wismilak Cafe Surabaya"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <!-- ADDRESS -->
                    <div>
                        <label for="address" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Alamat</label>
                        <textarea id="address" name="address" rows="3" required placeholder="Detail alamat lengkap outlet..."
                                  style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; resize: vertical; transition: all 0.3s;">{{ old('address') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <!-- REGION -->
                        <div>
                            <label for="region" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Wilayah</label>
                            <input type="text" id="region" name="region" value="{{ old('region') }}" required placeholder="e.g. Bali atau Jakarta"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                        <!-- CITY -->
                        <div>
                            <label for="city" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Kota</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}" required placeholder="e.g. Denpasar"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <!-- LATITUDE -->
                        <div>
                            <label for="latitude" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Latitude</label>
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" required placeholder="e.g. -8.6704"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                        <!-- LONGITUDE -->
                        <div>
                            <label for="longitude" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Longitude</label>
                            <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" required placeholder="e.g. 115.2126"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <!-- PHONE -->
                        <div>
                            <label for="phone" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="e.g. 0361-123456"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                        <!-- OPENING HOURS -->
                        <div>
                            <label for="opening_hours" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Jam Operasional</label>
                            <input type="text" id="opening_hours" name="opening_hours" placeholder="10.00 - 22.00" value="{{ old('opening_hours') }}" required
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>
                    </div>
                </div>

                <div style="text-align: right; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 2.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <a href="{{ route('admin.outlets.index') }}" style="padding: 0.75rem 1.5rem; border: 1px solid var(--card-border); border-radius: 10px; color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='none'">Batal</a>
                    <button type="submit" class="btn-premium" style="padding: 0.75rem 1.5rem;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Simpan Outlet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
