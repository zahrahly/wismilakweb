@extends('layouts.admin')

@section('title', 'Kelola Outlet')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-family: 'Crimson Pro', serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Jaringan Outlet</h1>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">Kelola lokasi distribusi dan penugasan partner Wismilak Cigars.</p>
    </div>
    <a href="{{ route('admin.outlets.create') }}" class="btn-premium">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        TAMBAH OUTLET
    </a>
</div>

<div class="premium-card" style="margin-bottom: 2.5rem; background: rgba(255,255,255,0.02);">
    <div style="padding: 1.5rem 2rem;">
        <form method="GET" style="display: grid; grid-template-columns: 2fr 1.2fr 1.2fr auto; gap: 1.5rem; align-items: end;">
            <div>
                <label style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px; display: block;">Search</label>
                <input type="text" name="search" class="form-input" value="{{ request('search') }}" placeholder="Outlet name..." style="width: 100%; padding: 0.65rem 1rem;">
            </div>
            <div>
                <label style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px; display: block;">Region</label>
                <select name="region" class="form-input" style="width: 100%; padding: 0.65rem 1rem;">
                    <option value="">All Regions</option>
                    @foreach($regions as $reg)
                        <option value="{{ $reg }}" {{ request('region') == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px; display: block;">Status</label>
                <select name="status" class="form-input" style="width: 100%; padding: 0.65rem 1rem;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn-premium" style="padding: 0.65rem 1.5rem;">APPLY FILTER</button>
        </form>
    </div>
</div>

<div class="premium-card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left: 2rem;">Outlet Identity</th>
                <th>Location</th>
                <th>Assigned Partners</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right; padding-right: 2rem;">Management</th>
            </tr>
        </thead>
        <tbody>
            @forelse($outlets as $outlet)
            <tr>
                <td style="padding-left: 2rem;">
                    <div style="font-weight: 700; color: var(--text-primary); font-family: 'Crimson Pro', serif; font-size: 1.1rem;">{{ $outlet->name }}</div>
                </td>
                <td>
                    <div style="font-size: 0.85rem; color: var(--text-primary); font-weight: 600;">{{ $outlet->region }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $outlet->city }}</div>
                </td>
                <td>
                    <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 8px;">
                        @foreach($outlet->partners as $p)
                            <span class="badge-premium" style="background: rgba(99,102,241,0.1); color: #818CF8; border: 1px solid rgba(99,102,241,0.2); font-size: 0.65rem;">{{ strtoupper($p->name) }}</span>
                        @endforeach
                    </div>
                    <form action="{{ route('admin.outlets.assign-partner', $outlet->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="partner_id" onchange="this.form.submit()" class="form-input" style="font-size: 0.7rem; padding: 4px 8px; width: 100%; background: rgba(255,255,255,0.03);">
                            <option value="">+ Assign Partner</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}" {{ $outlet->partners->contains('id', $partner->id) ? 'selected' : '' }}>{{ $partner->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td style="text-align: center;">
                    @if($outlet->status === 'active')
                        <span class="badge-premium" style="background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.2);">ACTIVE</span>
                    @else
                        <span class="badge-premium" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--card-border);">INACTIVE</span>
                    @endif
                </td>
                <td style="padding-right: 2rem; text-align: right;">
                    <div class="table-actions-container">
                        <a href="{{ route('admin.outlets.edit', $outlet->id) }}" class="table-action-btn btn-gold" title="Edit Location">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <a href="{{ route('admin.outlets.products', $outlet->id) }}" class="table-action-btn btn-green" title="Manage Products">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </a>
                        <form action="{{ route('admin.outlets.toggle-status', $outlet->id) }}" method="POST" class="table-action-form">
                            @csrf @method('PATCH')
                            <button type="submit" class="table-action-btn {{ $outlet->status === 'active' ? 'btn-red' : 'btn-green' }}" title="{{ $outlet->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                @if($outlet->status === 'active')
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                @else
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 5rem; text-align: center; color: var(--text-secondary);">
                    <p>No outlets found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

