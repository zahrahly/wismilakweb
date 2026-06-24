@extends('layouts.admin')

@section('title', 'Kelola Pressroom')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.25rem;">Kelola dan publikasikan artikel, berita, atau siaran pers di sini.</p>
    </div>
    <a href="{{ route('admin.pressroom.create') }}" class="btn-premium">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Tambah Artikel
    </a>
</div>

<!-- FILTER -->
<div class="premium-card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <form method="GET" style="display: grid; grid-template-columns: 2fr 1.2fr 1.2fr auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">Cari Artikel</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau ringkasan..." style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">Status</label>
            <select name="status" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="publish" {{ request('status') === 'publish' ? 'selected' : '' }}>Publish</option>
            </select>
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: var(--text-secondary);">Tanggal Rilis</label>
            <input type="date" name="date" value="{{ request('date') }}" style="width: 100%; padding: 0.65rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px;">
        </div>

        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn-premium" style="padding: 0.65rem 1.5rem; height: 38px;">
                Filter
            </button>
            @if(request('search') || request('status') || request('date'))
                <a href="{{ route('admin.pressroom.index') }}" class="btn-premium" style="background: rgba(255,255,255,0.05); color: var(--text-primary) !important; border: 1px solid var(--card-border); padding: 0.65rem 1.25rem; height: 38px; display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem;">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- TABLE -->
<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 80px; text-align: center;">Cover</th>
                <th>Judul Artikel / Berita</th>
                <th>Tanggal Rilis</th>
                <th style="width: 150px;">Status</th>
                <th style="width: 180px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pressrooms as $item)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Cover" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--card-border);">
                        @else
                            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; color: var(--text-secondary); border: 1px dashed var(--card-border);">
                                No Cover
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem; margin-bottom: 0.25rem;">{{ $item->title }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 500px;">
                            {{ $item->excerpt }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem; color: var(--text-primary);">
                            {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : '-' }}
                        </div>
                    </td>
                    <td>
                        @if($item->status === 'publish')
                            <span class="badge-premium" style="background: rgba(16,185,129,0.15); color: #10B981;">PUBLISHED</span>
                        @else
                            <span class="badge-premium" style="background: rgba(245,158,11,0.15); color: #F59E0B;">DRAFT</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center; align-items: center;">
                            <a href="{{ route('admin.pressroom.edit', $item->id) }}" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: rgba(255,255,255,0.05); color: var(--text-primary) !important; border: 1px solid var(--card-border);">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; margin-right: 0.2rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>

                            <form action="{{ route('admin.pressroom.destroy', $item->id) }}" method="POST" style="margin: 0; display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: rgba(231,76,76,0.1); color: #E74C4C !important; border: 1px solid rgba(231,76,76,0.2);" onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; margin-right: 0.2rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-secondary);">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 48px; height: 48px; margin: 0 auto 1rem; opacity: 0.3;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 0.25rem;">Artikel Tidak Ditemukan</div>
                        <div style="font-size: 0.8rem;">Coba gunakan kata kunci pencarian lain atau tambahkan artikel baru.</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
