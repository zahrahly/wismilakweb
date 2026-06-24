@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="header-section-premium">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Manajemen Pengguna</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola hak akses dan profil untuk Admin, Partner, Manager, dan Customer.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-premium">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        TAMBAH USER
    </a>
</div>

<div class="premium-card" style="margin-bottom: 2.5rem; background: rgba(255,255,255,0.02); padding: 1.25rem 2rem;">
    <form method="GET" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; width: 100%;">
        <!-- Search Query -->
        <div style="flex: 1; min-width: 240px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                style="width: 100%; padding: 0.65rem 1rem 0.65rem 2.5rem; background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
            >
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); pointer-events: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <!-- Role -->
        <div style="min-width: 160px;">
            <select name="role_id" style="width: 100%; padding: 0.65rem 1rem; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; cursor: pointer; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
            >
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ strtoupper($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div style="min-width: 160px;">
            <select name="status" style="width: 100%; padding: 0.65rem 1rem; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none; cursor: pointer; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--gold)'" onblur="this.style.borderColor='var(--card-border)'"
            >
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <button type="submit" class="btn-premium" style="padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                APPLY FILTER
            </button>
            @if(request()->anyFilled(['search', 'role_id', 'status']))
                <a href="{{ route('admin.users.index') }}" style="padding: 0.65rem 1.25rem; border-radius: 8px; border: 1px solid var(--card-border); background: rgba(255,255,255,0.03); color: var(--text-secondary); text-decoration: none; font-size: 0.8rem; font-weight: 600; text-align: center; transition: all 0.2s;"
                   onmouseover="this.style.borderColor='var(--gold)'; this.style.color='var(--text-primary)'"
                   onmouseout="this.style.borderColor='var(--card-border)'; this.style.color='var(--text-secondary)'"
                >
                    RESET
                </a>
            @endif
        </div>
    </form>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">User Details</th>
                <th>Access Level</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Management</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="font-weight: 600; color: var(--text-primary);">{{ $user->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $user->email }}</div>
                </td>
                <td>
                    <span class="badge-premium" style="background: rgba(99,102,241,0.1); color: #818CF8; border: 1px solid rgba(99,102,241,0.2);">{{ strtoupper($user->role->name) }}</span>
                </td>
                <td style="text-align: center;">
                    @if($user->status == 'active')
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">ACTIVE</span>
                    @else
                        <span class="badge-premium" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">INACTIVE</span>
                    @endif
                </td>
                <td style="padding-right: 2rem; text-align: right;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="table-action-btn btn-gold" title="Edit Profile">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="table-action-form">
                            @csrf @method('PATCH')
                            <button type="submit" class="table-action-btn {{ $user->status == 'active' ? 'btn-red' : 'btn-green' }}" title="{{ $user->status == 'active' ? 'Deactivate' : 'Activate' }}">
                                @if($user->status == 'active')
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                @else
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
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

