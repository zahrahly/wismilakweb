@extends('layouts.dashboard')

@section('title', 'Laporan Users')

@section('sidebar')
  @include('manager.partials.sidebar')
@endsection

@section('content')
<div class="animate-in" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
   <div>
    <h1 style="font-family: 'Crimson Pro', serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; letter-spacing: -0.02em;">
        User Report
    </h1>
    <p style="color: var(--text-secondary); font-size: 1.1rem; max-width: 600px; line-height: 1.6;">
        View registered user data, role distribution, account status, and loyalty point activity.
    </p>
</div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('manager.users.export.pdf') }}" class="btn-premium" target="_blank" style="background: rgba(239,68,68,0.1); color: #EF4444; border: 1px solid rgba(239,68,68,0.2);">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            PDF
        </a>
        <a href="{{ route('manager.users.export.csv') }}" class="btn-premium" style="background: rgba(59,130,246,0.1); color: #60A5FA; border: 1px solid rgba(59,130,246,0.2);">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            CSV
        </a>
    </div>
</div>

<!-- FILTER BAR -->
<div class="premium-card animate-in" style="animation-delay: 0.05s; margin-bottom: 1.5rem; background: rgba(255,255,255,0.02); padding: 1.25rem 2rem;">
    <form method="GET" action="{{ route('manager.users.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; width: 100%;">
        <!-- Search Query -->
        <div style="flex: 1; min-width: 240px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." 
                style="width: 100%; padding: 0.65rem 1rem 0.65rem 2.5rem; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
            >
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); pointer-events: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <!-- Role -->
        <div style="min-width: 160px;">
            <select name="role" style="width: 100%; padding: 0.65rem 1rem; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; cursor: pointer; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
            >
                <option value="">Semua Role</option>
                @foreach(['admin','manager','partner','customer'] as $r)
                  <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <button type="submit" class="btn-premium" style="padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                FILTER
            </button>
            @if(request()->anyFilled(['search', 'role']))
                <a href="{{ route('manager.users.index') }}" style="padding: 0.65rem 1.25rem; border-radius: 8px; border: 1px solid var(--card-border); background: rgba(255,255,255,0.03); color: var(--text-secondary); text-decoration: none; font-size: 0.8rem; font-weight: 600; text-align: center; transition: all 0.2s;"
                   onmouseover="this.style.borderColor='var(--gold)'; this.style.color='var(--text-primary)'"
                   onmouseout="this.style.borderColor='var(--card-border)'; this.style.color='var(--text-secondary)'"
                >
                    RESET
                </a>
            @endif
        </div>
    </form>
</div>

<div class="premium-card animate-in" style="animation-delay: 0.1s; margin-bottom: 2rem;">
  <div class="card-body" style="padding: 0;">
    <table class="data-table">
      <thead><tr>
        <th style="padding-left: 1.5rem; width: 60px;">#</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th style="text-align: center;">Status</th>
        <th style="text-align: center;">Poin</th>
        <th style="padding-right: 1.5rem;">Bergabung</th>
      </tr></thead>
      <tbody>
      @forelse($users as $user)
      <tr>
        <td style="padding-left: 1.5rem; color:var(--text-secondary); font-size:.75rem;">{{ $user->id }}</td>
        <td style="font-weight:500; color: var(--text-primary);">{{ $user->name }}</td>
        <td style="color:var(--text-secondary); font-size:.82rem;">{{ $user->email }}</td>
        <td>
          @php
            $roleColor = match($user->role->name ?? '') {
              'admin' => 'background: rgba(239, 68, 68, 0.1); color: #F87171;',
              'manager' => 'background: rgba(139, 92, 246, 0.1); color: #C084FC;',
              'partner' => 'background: rgba(59, 130, 246, 0.1); color: #60A5FA;',
              default => 'background: rgba(16, 185, 129, 0.1); color: #34D399;',
            };
          @endphp
          <span class="badge-premium" style="{{ $roleColor }} font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
            @roleLabel($user->role->name ?? '-')
          </span>
        </td>
        <td style="text-align: center;">
          @if($user->status === 'active')
            <span class="badge-premium" style="background: rgba(16, 185, 129, 0.1); color: var(--green); font-size: 0.7rem; font-weight: 700;">Active</span>
          @else
            <span class="badge-premium" style="background: rgba(239, 68, 68, 0.1); color: var(--red); font-size: 0.7rem; font-weight: 700;">{{ ucfirst($user->status ?? 'inactive') }}</span>
          @endif
        </td>
        <td style="text-align: center; color:var(--gold); font-weight:600;">{{ number_format($user->point->total_points ?? 0) }}</td>
        <td style="padding-right: 1.5rem; color:var(--text-secondary); font-size:.78rem;">{{ $user->created_at->format('d M Y') }}</td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center; color:var(--text-secondary); padding:3rem;">Tidak ada data user.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($users->hasPages())
    <div style="padding:1.5rem; border-top: 1px solid var(--card-border);">{{ $users->links() }}</div>
  @endif
</div>
@endsection


