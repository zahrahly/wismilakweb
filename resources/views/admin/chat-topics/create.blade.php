@extends('layouts.admin')

@section('title', 'Tambah Chat Topic')

@section('content')
<div style="max-width: 650px; margin: 0 auto;">
    
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.chat-topics.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="premium-card">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--gold); margin: 0;">Tambah Topik Baru</h3>
            <p style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">Tentukan trigger kata kunci dan balasan bot otomatis.</p>
        </div>
        <div style="padding: 2rem;">
            
            <form action="{{ route('admin.chat-topics.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="keyword" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Keyword / Trigger</label>
                    <input type="text" id="keyword" name="keyword" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--card-border); background: rgba(255,255,255,0.05); color: var(--text-primary); border-radius: 8px; font-size: 0.9rem; transition: all 0.3s;" value="{{ old('keyword') }}" required placeholder="e.g. halo, event, bayar">
                    <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 0.25rem;">Anda dapat memasukkan beberapa kata kunci sekaligus dengan dipisahkan menggunakan koma (misal: <code>halo, hallo, hi, hei</code>).</div>
                    @error('keyword') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="category" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Kategori</label>
                    <input type="text" id="category" name="category" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--card-border); background: rgba(255,255,255,0.05); color: var(--text-primary); border-radius: 8px; font-size: 0.9rem; transition: all 0.3s;" value="{{ old('category') }}" required list="categories-list" placeholder="Pilih atau ketik kategori baru">
                    <datalist id="categories-list">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                    @error('category') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="response" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Response / Balasan Otomatis</label>
                    <textarea id="response" name="response" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--card-border); background: rgba(255,255,255,0.05); color: var(--text-primary); border-radius: 8px; font-size: 0.9rem; transition: all 0.3s;" rows="5" required placeholder="Balasan bot untuk keyword ini...">{{ old('response') }}</textarea>
                    <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 0.25rem;">Anda dapat menggunakan format teks biasa (baris baru akan dipertahankan).</div>
                    @error('response') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div>
                        <label for="sort_order" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Sort Order (Opsional)</label>
                        <input type="number" id="sort_order" name="sort_order" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--card-border); background: rgba(255,255,255,0.05); color: var(--text-primary); border-radius: 8px; font-size: 0.9rem; transition: all 0.3s;" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div style="display: flex; align-items: flex-end; padding-bottom: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer; user-select: none;">
                            <input type="checkbox" name="is_escalation" value="1" {{ old('is_escalation') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--gold); cursor: pointer;">
                            <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary);">Perlu Eskalasi ke Admin?</span>
                        </label>
                    </div>
                </div>

                <div style="text-align: right; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 2rem;">
                    <button type="submit" class="btn-premium">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Simpan Topik
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
