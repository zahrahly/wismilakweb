@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Koleksi Produk</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola inventaris cerutu premium dan aksesoris Wismilak.</p>
    </div>
    <a href="{{ route('admin.product.create') }}" class="btn-premium">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        TAMBAH PRODUK
    </a>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem; width: 100px;">No</th>
                <th style="width: 150px;">Visual</th>
                <th>Nama Produk</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $item)
            <tr>
                <td style="padding-left: 2rem; color: var(--text-secondary); font-weight: 600;">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div style="width: 100px; height: 60px; border-radius: 10px; overflow: hidden; border: 1px solid var(--card-border);">
                        <img src="{{ asset('storage/'.$item->image_main) }}"
                             alt="{{ $item->name }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </td>
                <td style="font-weight: 600; color: var(--text-primary); font-size: 1rem;">{{ $item->name }}</td>
                <td style="text-align: center;">
                    @if($item->status === 'aktif')
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">AKTIF</span>
                    @else
                        <span class="badge-premium" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">NONAKTIF</span>
                    @endif
                </td>
                <td style="padding-right: 2rem; text-align: right;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.product.edit', $item->id) }}" class="table-action-btn btn-gold" title="Edit">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.product.destroy', $item->id) }}" method="POST" class="table-action-form" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="table-action-btn btn-red" title="Delete">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
