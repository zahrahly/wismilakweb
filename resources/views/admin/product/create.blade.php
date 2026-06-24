@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
        <div>
            <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Visi Produk <em>Baru</em></h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem;">Rincikan karakteristik cerutu premium untuk katalog eksklusif Wismilak.</p>
        </div>
        <a href="{{ route('admin.product.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            KEMBALI KE LIST
        </a>
    </div>

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem;">
            
            {{-- LEFT: Essential Info --}}
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div class="premium-card" style="padding: 2rem;">
                    <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 1rem;">Informasi Dasar</h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Nama Produk</label>
                        <input type="text" name="name" required placeholder="Contoh: Wismilak Robusto" style="width: 100%;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Deskripsi Singkat</label>
                        <textarea name="short_description" rows="2" placeholder="Karakter singkat produk..." style="width: 100%;"></textarea>
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Tasting Notes / Deskripsi Lengkap</label>
                        <textarea name="description" rows="5" placeholder="Gambarkan aroma, rasa, dan pengalaman menghisap cerutu ini..." style="width: 100%;"></textarea>
                    </div>
                </div>

                <div class="premium-card" style="padding: 2rem;">
                    <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 1rem;">Spesifikasi Produk</h3>
                    
                    <!-- Fisik & Dimensi -->
                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--gold-dim); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        Fisik & Dimensi
                    </h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Weight (Berat)</label>
                            <input name="weight" placeholder="Contoh: 0.2 Kg" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Size (Ukuran / Ring Gauge)</label>
                            <input name="size" placeholder="Contoh: 50 x 127 mm" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Profile (Kekuatan)</label>
                            <input name="profile" placeholder="Contoh: Medium Strength" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Assembly (Pembuatan)</label>
                            <input name="assembly" placeholder="Contoh: 100% Handmade" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                    </div>

                    <!-- Komposisi Tembakau -->
                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--gold-dim); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem; border-top: 1px solid var(--card-border); padding-top: 1.5rem;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                        Komposisi Tembakau
                    </h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Genome (Genom/Jenis)</label>
                            <input name="genome" placeholder="Contoh: Robusto" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Varietal (Varietas)</label>
                            <input name="varietal" placeholder="Contoh: Premium Tobacco" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Wrapper</label>
                            <input name="wrapper" placeholder="Contoh: Ecuadorian" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">Filler</label>
                            <input name="filler" placeholder="Contoh: Java / Indonesia" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Media & Status --}}
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div class="premium-card" style="padding: 2rem;">
                    <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 1rem;">Media Produk</h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.8rem; text-transform: uppercase;">Gambar Utama</label>
                        <div style="border: 2px dashed var(--card-border); border-radius: 12px; padding: 1.5rem; text-align: center; background: rgba(255,255,255,0.02);">
                            <input type="file" name="image_main" required style="width: 100%; font-size: 0.8rem;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.8rem; text-transform: uppercase;">Gambar Detail</label>
                        <div style="border: 2px dashed var(--card-border); border-radius: 12px; padding: 1.5rem; text-align: center; background: rgba(255,255,255,0.02);">
                            <input type="file" name="image_detail" required style="width: 100%; font-size: 0.8rem;">
                        </div>
                    </div>
                </div>

                <div class="premium-card" style="padding: 2rem;">
                    <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.25rem; color: var(--gold); margin-bottom: 1.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 1rem;">Pengaturan</h3>
                    
                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase;">Status Publikasi</label>
                        <select name="status" style="width: 100%;">
                            <option value="aktif">Aktif (Tampilkan)</option>
                            <option value="nonaktif">Nonaktif (Sembunyikan)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-premium" style="width: 100%; justify-content: center; padding: 1rem;">
                        PUBLIKASIKAN PRODUK
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
