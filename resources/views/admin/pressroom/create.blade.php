@extends('layouts.admin')

@section('title', 'Tambah Pressroom')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">

    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.pressroom.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Artikel
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
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--gold); margin: 0;">Tulis Artikel Baru</h3>
            <p style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">Publikasikan rilis pers, artikel, atau berita terbaru seputar Wismilak.</p>
        </div>
        
        <div style="padding: 2rem;">
            <form method="POST" action="{{ route('admin.pressroom.store') }}" enctype="multipart/form-data">
                @csrf

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- TITLE -->
                    <div>
                        <label for="title" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Judul Artikel</label>
                        <input type="text" id="title" name="title" required placeholder="Masukkan judul menarik..."
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <!-- IMAGE COVER -->
                    <div>
                        <label for="image" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Gambar Cover / Thumbnail</label>
                        <input type="file" id="image" name="image" accept="image/*"
                               style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.4rem; opacity: 0.75;">Format gambar yang didukung: JPG, PNG, WebP (Maks. 2MB)</p>
                    </div>

                    <!-- EXCERPT -->
                    <div>
                        <label for="excerpt" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Ringkasan Singkat (Excerpt)</label>
                        <textarea id="excerpt" name="excerpt" rows="3" placeholder="Tulis ringkasan singkat artikel untuk preview halaman depan..."
                                  style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; resize: vertical; transition: all 0.3s; font-family: inherit;"></textarea>
                    </div>

                    <!-- CONTENT -->
                    <div>
                        <label for="content_text" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Isi Artikel Lengkap</label>
                        <textarea id="content_text" name="content" rows="12" required placeholder="Tulis artikel lengkap di sini..."
                                  style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; resize: vertical; transition: all 0.3s; font-family: inherit; line-height: 1.6;"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <!-- DATE -->
                        <div>
                            <label for="published_at" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Tanggal Publikasi</label>
                            <input type="date" id="published_at" name="published_at"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>

                        <!-- STATUS -->
                        <div>
                            <label for="status" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Status</label>
                            <select id="status" name="status" required
                                    style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                <option value="draft">Draft</option>
                                <option value="publish">Publish</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="text-align: right; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 2.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <a href="{{ route('admin.pressroom.index') }}" style="padding: 0.75rem 1.5rem; border: 1px solid var(--card-border); border-radius: 10px; color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='none'">Batal</a>
                    <button type="submit" class="btn-premium" style="padding: 0.75rem 1.5rem;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Simpan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
