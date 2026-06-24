@extends('layouts.admin')

@section('title', 'Manage Chat Topics')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Topik Live Chat</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola basis pengetahuan untuk asisten virtual Wismilak.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; align-items: center;">
        <form method="POST" action="{{ route('admin.chat-topics.seed') }}" onsubmit="return confirm('Peringatan: Ini akan mengembalikan semua topik chat ke setelan default. Lanjutkan?')">
            @csrf
            <button type="submit" class="btn-premium" style="background: rgba(59,130,246,0.1); color: var(--blue) !important; border: 1px solid rgba(59,130,246,0.2);">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                SEED DEFAULT
            </button>
        </form>
        <a href="{{ route('admin.chat-topics.create') }}" class="btn-premium">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            TAMBAH TOPIK
        </a>
    </div>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Keyword / Trigger</th>
                <th>Kategori</th>
                <th>Respon Otomatis</th>
                <th style="text-align: center;">Eskalasi</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topics as $topic)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="display: flex; flex-wrap: wrap; gap: 0.35rem; max-width: 280px; padding: 0.5rem 0;">
                        @foreach(array_map('trim', explode(',', $topic->keyword)) as $kw)
                            @if(!empty($kw))
                                <span style="font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.5rem; background: rgba(212, 175, 55, 0.15); color: var(--gold); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 4px; letter-spacing: 0.02em;">{{ strtolower($kw) }}</span>
                            @endif
                        @endforeach
                    </div>
                </td>
                <td>
                    <span class="badge-premium" style="background: rgba(59,130,246,0.1); color: var(--blue); border: 1px solid rgba(59,130,246,0.2);">{{ strtoupper($topic->category) }}</span>
                </td>
                <td>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5; max-width: 300px;">
                        {{ Str::limit($topic->response, 80) }}
                    </div>
                </td>
                <td style="text-align: center;">
                    @if($topic->is_escalation)
                        <span class="badge-premium" style="background: rgba(231,76,76,0.1); color: var(--red); border: 1px solid rgba(231,76,76,0.2);">YES</span>
                    @else
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">NO</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    @if($topic->is_active)
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">ACTIVE</span>
                    @else
                        <span class="badge-premium" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">INACTIVE</span>
                    @endif
                </td>
                <td style="text-align: right; padding-right: 2rem;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.chat-topics.edit', $topic) }}" class="table-action-btn btn-gold" title="Edit">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.chat-topics.destroy', $topic) }}" method="POST" class="table-action-form" onsubmit="return confirm('Hapus topik ini?')">
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
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 1rem; opacity: 0.1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <p>Belum ada topik yang dikonfigurasi.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
