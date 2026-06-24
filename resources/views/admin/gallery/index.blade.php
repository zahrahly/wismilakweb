@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Galeri Visual</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola dokumentasi foto dan video eksklusif Wismilak Cigars.</p>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="btn-premium">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        TAMBAH GALERI
    </a>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem; width: 80px;">No</th>
                <th style="width: 150px;">Visual Artifact</th>
                <th>Caption / Deskripsi</th>
                <th>Kategori</th>
                <th style="text-align: center;">Display</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($galleries as $item)
            <tr>
                <td style="padding-left: 2rem; color: var(--text-secondary); font-weight: 600;">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div style="width: 120px; height: 80px; border-radius: 12px; overflow: hidden; border: 1px solid var(--card-border);">
                        <img src="{{ asset('storage/'.$item->image) }}"
                             alt="Gallery Item"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </td>
                <td>
                    <div style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500; max-width: 300px; line-height: 1.5;">
                        {{ $item->caption ?? 'No description provided' }}
                    </div>
                </td>
                <td>
                    <span class="badge-premium" style="background: rgba(212,175,55,0.05); color: var(--gold); border: 1px solid var(--gold-dim);">{{ strtoupper($item->category ?? 'UNSET') }}</span>
                </td>
                <td style="text-align: center;">
                    @if($item->status === 'tampil')
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">TAMPIL</span>
                    @else
                        <span class="badge-premium" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">DISEMBUNYIKAN</span>
                    @endif
                </td>
                <td style="padding-right: 2rem; text-align: right;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.gallery.edit', $item->id) }}" class="table-action-btn btn-gold" title="Edit Entry">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="table-action-form" onsubmit="return confirm('Yakin hapus galeri ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="table-action-btn btn-red" title="Delete Permanently">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1.5rem; opacity: 0.1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>Basis data galeri masih kosong.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

