@extends('layouts.admin')

@section('title', 'Kelola Produk - ' . $outlet->name)

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.outlets.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Outlet
    </a>
</div>

<div class="premium-card" style="max-width: 950px; padding: 2rem; margin: 0 auto;">
    <div style="border-bottom: 1px solid var(--card-border); padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-family: 'Crimson Pro', serif; font-size: 1.6rem; font-weight: 700; color: var(--gold); margin-bottom: 0.25rem;">Ketersediaan Produk</h2>
            <p style="color: var(--text-secondary); font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; color: var(--gold);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $outlet->name }} &bull; {{ $outlet->address }}, {{ $outlet->city }}, {{ $outlet->region }}
            </p>
        </div>
        <div style="background: rgba(212,175,55,0.05); border: 1px solid var(--gold-dim); padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.75rem; font-weight: 600; color: var(--gold);">
            Total Produk Aktif: {{ $allProducts->count() }}
        </div>
    </div>

    <form action="{{ route('admin.outlets.products.update', $outlet) }}" method="POST">
        @csrf
        
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch; margin-bottom: 1.5rem; border-radius: 8px; border: 1px solid var(--card-border);">
            <table class="data-table" style="min-width: 800px; margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="width: 100px; text-align: center;">Tugaskan</th>
                        <th>Produk</th>
                        <th style="width: 240px;">Status Ketersediaan</th>
                        <th>Catatan / Keterangan Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allProducts as $product)
                        @php
                            $isAssigned = in_array($product->id, $outletProducts);
                            $isAvailable = $isAssigned ? ($availabilityMap[$product->id]['is_available'] ?? false) : false;
                            $notes = $isAssigned ? ($availabilityMap[$product->id]['notes'] ?? '') : '';
                        @endphp
                        <tr>
                            <td style="text-align: center; vertical-align: middle;">
                                <input type="checkbox" name="products[{{ $product->id }}][assigned]" value="1" {{ $isAssigned ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--gold);">
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($product->image_main)
                                        <img src="{{ asset('storage/' . $product->image_main) }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid var(--card-border);">
                                    @else
                                        <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; border: 1px dashed var(--card-border);">📦</div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem;">{{ $product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <label style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.35rem 0.75rem; background: rgba(255,255,255,0.02); border: 1px solid var(--card-border); border-radius: 6px; user-select: none;">
                                    <input type="checkbox" name="products[{{ $product->id }}][available]" value="1" {{ $isAvailable ? 'checked' : '' }} style="accent-color: var(--green); cursor: pointer;">
                                    <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary);">Tersedia (Ready)</span>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="products[{{ $product->id }}][notes]" value="{{ $notes }}" placeholder="Contoh: Stok terbatas, Pre-order" style="width: 100%; padding: 0.5rem 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); color: var(--text-primary); border-radius: 8px; font-size: 0.85rem;">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 3rem; color: var(--text-secondary);">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 48px; height: 48px; margin: 0 auto 1rem; opacity: 0.2;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 0.25rem;">Produk Tidak Ditemukan</div>
                                <div style="font-size: 0.8rem;">Tambahkan produk aktif ke sistem terlebih dahulu.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 2rem;">
            <a href="{{ route('admin.outlets.index') }}" class="btn-premium" style="background: rgba(255,255,255,0.05); color: var(--text-primary) !important; border: 1px solid var(--card-border); padding: 0.65rem 1.5rem; text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; justify-content: center;">
                Batal
            </a>
            <button type="submit" class="btn-premium">
                Simpan Ketersediaan Produk
            </button>
        </div>
    </form>
</div>
@endsection
