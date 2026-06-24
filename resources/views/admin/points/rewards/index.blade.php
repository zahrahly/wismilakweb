@extends('layouts.admin')

@section('title', 'Data Reward')

@section('content')
<div class="header-section-premium">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Data Reward</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola reward produk atau merchandise penukaran poin loyalty.</p>
    </div>
    <a href="{{ route('admin.points.rewards.create') }}" class="btn-premium">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        TAMBAH REWARD
    </a>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem; width: 100px;">Gambar</th>
                <th>Judul Reward</th>
                <th style="text-align: center;">Poin Butuh</th>
                <th style="text-align: center;">Stok</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rewards as $reward)
            <tr>
                <td style="padding-left: 2rem; vertical-align: middle;">
                    @if($reward->image)
                        <img src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--card-border);">
                    @else
                        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; color: var(--text-secondary); border: 1px dashed var(--card-border);">
                            No Img
                        </div>
                    @endif
                </td>

                <td style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem;">
                    {{ $reward->title }}
                </td>

                <td style="text-align: center; color: var(--gold); font-weight: 700; font-family: 'Inter', sans-serif;">
                    {{ number_format($reward->points_required) }}
                </td>

                <td style="text-align: center; font-weight: 600; color: var(--text-primary);">
                    {{ $reward->stock }}
                </td>

                <td style="text-align: center;">
                    <span class="badge-premium" style="{{ $reward->status === 'active' ? 'background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);' : 'background: rgba(231,76,76,0.1); color: var(--red); border: 1px solid rgba(231,76,76,0.2);' }}">
                        {{ strtoupper($reward->status) }}
                    </span>
                </td>

                <td style="padding-right: 2rem; text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                        <a href="{{ route('admin.points.rewards.edit', $reward->id) }}" class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: rgba(255,255,255,0.05); color: var(--text-primary) !important; border: 1px solid var(--card-border);">
                            Edit
                        </a>

                        <form action="{{ route('admin.points.rewards.toggle-status', $reward->id) }}" method="POST" style="margin: 0; display: inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn-premium" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; {{ $reward->status === 'active' ? 'background: rgba(231,76,76,0.1); color: var(--red) !important; border: 1px solid rgba(231,76,76,0.2);' : 'background: rgba(16,185,129,0.1); color: var(--green) !important; border: 1px solid rgba(16,185,129,0.2);' }}"
                                onclick="return confirm('{{ $reward->status === 'active' ? 'Nonaktifkan reward ini?' : 'Aktifkan kembali reward ini?' }}')">
                                {{ $reward->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 4rem; color: var(--text-secondary);">
                    Data reward belum tersedia
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
