@extends('layouts.admin')

@section('title', 'Kelola Voucher dan Reward')

@section('content')
<div class="header-section-premium">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Kelola Voucher & Reward</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Buat, edit, dan kelola voucher diskon serta reward penukaran poin loyalty untuk customer.</p>
    </div>
    <a href="{{ route('admin.vouchers.create') }}" class="btn-premium">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        TAMBAH VOUCHER/REWARD
    </a>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Voucher / Reward</th>
                <th style="text-align: center;">Jenis</th>
                <th>Detail / Kode</th>
                <th style="text-align: center;">Poin Butuh</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        @if($item->jenis === 'reward' && $item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08);">
                        @elseif($item->jenis === 'reward')
                            <div style="width: 44px; height: 44px; background: rgba(255,255,255,0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 0.65rem; border: 1px dashed var(--card-border);">No Image</div>
                        @else
                            <div style="width: 44px; height: 44px; background: rgba(212,175,55,0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 1.25rem; border: 1px solid rgba(212,175,55,0.15);">🎫</div>
                        @endif
                        <div>
                            <div style="font-weight: 700; font-size: 0.95rem; color: var(--text-primary);">{{ $item->title }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 1px;">{{ Str::limit($item->description, 45) }}</div>
                        </div>
                    </div>
                </td>
                <td style="text-align: center;">
                    <span class="badge-premium" style="{{ $item->jenis === 'voucher' ? 'background: rgba(212,175,55,0.1); color: var(--gold); border: 1px solid var(--gold-dim);' : 'background: rgba(59,130,246,0.1); color: var(--blue); border: 1px solid rgba(59,130,246,0.2);' }}">
                        {{ strtoupper($item->jenis) }}
                    </span>
                </td>
                <td>
                    @if($item->jenis === 'voucher')
                        <span style="background: rgba(255,255,255,0.05); color: var(--text-primary); padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700; font-family: monospace; border: 1px solid var(--card-border);">{{ $item->code }}</span>
                        <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 0.4rem;">
                            Diskon: {{ $item->discount_type === 'percentage' ? $item->discount_value . '%' : 'Rp ' . number_format($item->discount_value, 0, ',', '.') }}
                        </div>
                    @else
                        <span style="color: var(--text-primary); font-size: 0.85rem; font-weight: 600;">Stok: {{ $item->stock }}</span>
                    @endif
                </td>
                <td style="text-align: center; font-size: 0.95rem; color: var(--gold); font-weight: 700; font-family: 'Inter', sans-serif;">
                    {{ number_format($item->points_required) }}
                </td>
                <td style="text-align: center;">
                    <span class="badge-premium" style="{{ $item->status === 'active' ? 'background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);' : 'background: rgba(231,76,76,0.1); color: var(--red); border: 1px solid rgba(231,76,76,0.2);' }}">
                        {{ strtoupper($item->status) }}
                    </span>
                </td>
                <td style="padding-right: 2rem; text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                        <a href="{{ route('admin.vouchers.edit', [$item->id, 'type' => $item->jenis]) }}" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: rgba(255,255,255,0.05); color: var(--text-primary) !important; border: 1px solid var(--card-border);">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.vouchers.destroy', [$item->id, 'type' => $item->jenis]) }}" style="margin: 0; display: inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus {{ $item->jenis }} ini?')" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: rgba(231,76,76,0.1); color: var(--red) !important; border: 1px solid rgba(231,76,76,0.2);">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 4rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎫</div>
                    <div style="font-weight: 600; font-size: 0.95rem;">Belum ada Voucher atau Reward</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($items->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $items->appends(request()->query())->links() }}
</div>
@endif
@endsection
