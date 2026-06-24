@extends('layouts.admin')

@section('title', 'Live Chat')

@section('content')

<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    <!-- HEADER -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: var(--text-primary);">
            Monitoring Live Chat
        </h2>

        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; font-size: 0.85rem; color: var(--text-secondary);">
                Total Chat:
                <span style="font-weight: 600; color: var(--text-primary);">
                    {{ $sessions->count() }}
                </span>
            </span>

            <span style="padding: 0.5rem 1rem; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); border-radius: 8px; font-size: 0.85rem; color: #10B981;">
                Open:
                <span style="font-weight: 600;">
                    {{ $sessions->where('status','open')->count() }}
                </span>
            </span>
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" style="display: flex; align-items: center; gap: 0.75rem;">
        <select name="status" style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; font-size: 0.85rem; color: var(--text-primary);">
            <option value="">Semua Status</option>
            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
               style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; font-size: 0.85rem; color: var(--text-primary);">

        <button type="submit" class="btn-premium" style="padding: 0.5rem 1.25rem; font-size: 0.8rem;">
            Filter
        </button>
    </form>

    <!-- TABLE -->
    <div class="premium-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Terakhir Update</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sessions as $session)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: var(--text-primary);">
                                {{ $session->name ?? 'Guest' }}
                            </div>
                            @if($session->email)
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">
                                    {{ $session->email }}
                                </div>
                            @endif
                        </td>

                        <td style="text-align: center;">
                            <span class="badge-premium" style="
                                {{ $session->status == 'open'
                                    ? 'background:rgba(16,185,129,0.15);color:#10B981;border:1px solid rgba(16,185,129,0.2);'
                                    : 'background:rgba(255,255,255,0.06);color:var(--text-secondary);border:1px solid var(--card-border);' }}">
                                {{ ucfirst($session->status) }}
                            </span>
                        </td>

                        <td style="text-align: center; color: var(--text-secondary); font-size: 0.85rem;">
                            {{ $session->updated_at->diffForHumans() }}
                        </td>

                        <td style="text-align: right;">
                            <a href="{{ route('admin.messages.show', $session->id) }}" class="btn-premium" style="padding: 0.4rem 1rem; font-size: 0.75rem;">
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 3rem; color: var(--text-secondary);">
                            Belum ada percakapan masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@push('scripts')
<script>
    setInterval(() => {
        window.location.reload();
    }, 10000);
</script>
@endpush
