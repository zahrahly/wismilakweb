@extends('layouts.admin')

@section('title', 'Manage Instagram')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Konten Instagram</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola visual feed instagram untuk landing page Wismilak.</p>
    </div>
    <a href="{{ route('admin.instagram.create') }}" class="btn-premium">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        TAMBAH KONTEN
    </a>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem; width: 120px;">Visual</th>
                <th>Caption</th>
                <th style="text-align: center;">Tautan / Link</th>
                <th style="text-align: center;">Urutan</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td style="padding: 1.25rem 0 1.25rem 2rem;">
                    <div style="position: relative; width: 80px; height: 80px; border-radius: 12px; overflow: hidden; border: 1px solid var(--card-border);">
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Instagram" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 5px; right: 5px; background: rgba(0,0,0,0.5); width: 20px; height: 20px; border-radius: 4px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                            <svg width="12" height="12" fill="white" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-size: 0.9rem; color: var(--text-primary); max-width: 300px; line-height: 1.5;">
                        {{ Str::limit($post->caption, 80) ?? 'No caption provided' }}
                    </div>
                </td>
                <td style="text-align: center;">
                    @if($post->instagram_url)
                        <a href="{{ $post->instagram_url }}" target="_blank" class="badge-premium" style="background: rgba(255,255,255,0.05); color: var(--gold); border: 1px solid var(--gold-dim); text-decoration: none;">
                            VIEW POST
                        </a>
                    @else
                        <span style="font-size: 0.75rem; color: var(--text-secondary);">Direct Upload</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <span style="font-size: 1rem; font-weight: 700; color: var(--text-primary);">#{{ $post->sort_order }}</span>
                </td>
                <td style="text-align: center;">
                    @if($post->status === 'active')
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">ACTIVE</span>
                    @else
                        <span class="badge-premium" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">INACTIVE</span>
                    @endif
                </td>
                <td style="text-align: right; padding-right: 2rem;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.instagram.edit', $post) }}" class="table-action-btn btn-gold" title="Edit">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.instagram.destroy', $post) }}" method="POST" class="table-action-form" onsubmit="return confirm('Hapus konten ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="table-action-btn btn-red" title="Delete">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1rem; opacity: 0.1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>Belum ada konten instagram.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
