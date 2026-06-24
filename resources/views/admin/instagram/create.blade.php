@extends('layouts.admin')

@section('title', 'Tambah Konten Instagram')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.instagram.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Konten
    </a>
</div>

<div class="premium-card" style="max-width: 700px; padding: 2rem; margin: 0 auto;">
    <h2 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--gold); margin-bottom: 0.25rem;">Tambah Konten Instagram</h2>
    <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 2rem;">Unggah gambar visual dan isi detail untuk ditampilkan pada halaman beranda utama.</p>

    <form action="{{ route('admin.instagram.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">
                Gambar Visual <span style="color: var(--red);">*</span>
            </label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" required style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.02); border: 1px dashed var(--card-border); color: var(--text-primary); border-radius: 8px; font-size: 0.85rem;">
            <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.35rem;">Rekomendasi format: JPG, PNG, WEBP (Square / 1:1, Maks. 2MB)</p>
            @error('image') 
                <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.35rem;">⚠️ {{ $message }}</div> 
            @enderror
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">Caption (Opsional)</label>
            <textarea id="caption" name="caption" rows="4" placeholder="Tulis deskripsi atau caption konten di sini..." style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px; font-family: inherit; resize: vertical; line-height: 1.5;">{{ old('caption') }}</textarea>
            @error('caption') 
                <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.35rem;">⚠️ {{ $message }}</div> 
            @enderror
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">Link Instagram (Opsional)</label>
            <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url') }}" placeholder="https://www.instagram.com/p/..." style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
            <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.35rem;">Masukkan tautan URL langsung ke postingan Instagram jika ada</p>
            @error('instagram_url') 
                <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.35rem;">⚠️ {{ $message }}</div> 
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">Urutan Tampilan (Sort Order)</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.35rem;">Urutan prioritas visualisasi (angka terkecil tampil pertama)</p>
            </div>

            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">Status Tampilan</label>
                <select name="status" style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif (Tampilkan)</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                </select>
                <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.35rem;">Pilih apakah konten ini langsung dipublikasi</p>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 1rem;">
            <a href="{{ route('admin.instagram.index') }}" class="btn-premium" style="background: rgba(255,255,255,0.05); color: var(--text-primary) !important; border: 1px solid var(--card-border); padding: 0.65rem 1.5rem; text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; justify-content: center;">
                Batal
            </a>
            <button type="submit" class="btn-premium">
                Simpan Konten
            </button>
        </div>
    </form>
</div>
@endsection
