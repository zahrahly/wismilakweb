@extends('layouts.admin')

@section('title', 'Media Inquiries')

@section('content')
<div style="margin-bottom: 2.5rem;">
    <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Media Inquiries</h1>
    <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola pertanyaan dan respon media relation Wismilak.</p>
</div>

<!-- FILTER & SEARCH BAR -->
<div class="premium-card" style="margin-bottom: 2.5rem; background: rgba(255,255,255,0.02); padding: 1.25rem 2rem;">
    <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between; width: 100%;">
        
        <!-- Tab Filters -->
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <a href="{{ route('admin.media.inquiries') }}"
               class="btn-premium"
               style="padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center;
               {{ !request('filter') ? '' : 'background: rgba(255,255,255,0.03); color: var(--text-secondary) !important; border: 1px solid var(--card-border);' }}">
                ALL
            </a>

            <a href="{{ route('admin.media.inquiries', ['filter' => 'unread']) }}"
               class="btn-premium"
               style="padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center;
               {{ request('filter') === 'unread' ? '' : 'background: rgba(255,255,255,0.03); color: var(--text-secondary) !important; border: 1px solid var(--card-border);' }}">
                UNREAD
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" style="display: flex; gap: 0.5rem; align-items: center; min-width: 320px; flex: 1; justify-content: flex-end;">
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif

            <div style="position: relative; flex: 1; max-width: 360px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email..." 
                    style="width: 100%; padding: 0.65rem 1rem 0.65rem 2.5rem; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
                >
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); pointer-events: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <button type="submit" class="btn-premium" style="padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                CARI
            </button>
        </form>

    </div>
</div>

<!-- DATA TABLE -->
<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Detail Pengirim</th>
                <th>Subjek</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Tanggal Masuk</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inquiries as $inquiry)
            <tr>
                <td style="padding: 1.25rem 2rem;">
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">{{ $inquiry->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px; font-weight: 500;">
                        {{ $inquiry->email }} &bull; {{ $inquiry->phone ?? '-' }}
                    </div>
                </td>
                <td style="font-size: 0.85rem; color: var(--text-primary); max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <span style="color: var(--gold); font-weight: 600;">[{{ $inquiry->inquiry_type ?? 'Inquiry' }}]</span> {{ $inquiry->subject ?? '-' }}
                </td>
                <td style="text-align: center;">
                    @if(!$inquiry->is_read)
                        <span class="badge-premium" style="background: rgba(239, 68, 68, 0.1); color: var(--red); border: 1px solid rgba(239, 68, 68, 0.2);">
                            UNREAD
                        </span>
                    @else
                        <span class="badge-premium" style="background: rgba(16, 185, 129, 0.1); color: var(--green); border: 1px solid rgba(16, 185, 129, 0.2);">
                            READ
                        </span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <div style="font-size: 0.85rem; color: var(--text-secondary);">{{ $inquiry->created_at->format('d M Y') }}</div>
                </td>
                <td style="padding: 1.25rem 2rem; text-align: right;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.media.inquiries.show', $inquiry->id) }}" class="table-action-btn btn-gold" title="View Detail">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <form action="{{ route('admin.media.inquiries.delete', $inquiry->id) }}"
                              method="POST"
                              class="table-action-form"
                              onsubmit="return confirm('Delete this inquiry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="table-action-btn btn-red" title="Delete">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1rem; opacity: 0.2;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2m-12 0H4"/></svg>
                    <p>Tidak ada pesan masuk.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<div style="margin-top: 1.5rem;">
    {{ $inquiries->links() }}
</div>
@endsection
