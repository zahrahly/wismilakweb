@php $roleName = auth()->user()->role?->name; @endphp
@extends($roleName === 'admin' ? 'layouts.admin' : ($roleName === 'partner' || $roleName === 'manager' ? 'layouts.dashboard' : 'layouts.customer'))

@if(in_array($roleName, ['partner', 'manager']))
    @section('sidebar')
        @include($roleName . '.partials.sidebar')
    @endsection
@endif

@section('title', 'Manage Profile')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes goldGlow {
        0%, 100% { border-color: rgba(212, 175, 55, 0.15); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.65); }
        50% { border-color: rgba(212, 175, 55, 0.3); box-shadow: 0 20px 50px rgba(212, 175, 55, 0.05); }
    }
    
    .animate-in {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1.8fr;
        gap: 3.5rem;
    }
    
    @media (max-width: 1024px) {
        .profile-grid { grid-template-columns: 1fr; gap: 2.5rem; }
    }
    
    /* Premium Glassmorphic Cards */
    .profile-card {
        background: linear-gradient(135deg, rgba(28, 15, 6, 0.45) 0%, rgba(13, 8, 5, 0.6) 100%);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        border: 1px solid rgba(212, 175, 55, 0.15);
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7), inset 0 1px 0 rgba(255, 255, 255, 0.03);
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .profile-card:hover {
        border-color: rgba(212, 175, 55, 0.35);
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.85), 0 0 30px rgba(212, 175, 55, 0.03);
        transform: translateY(-4px);
    }
    
    .identity-card {
        text-align: center;
        padding: 4rem 2.5rem;
        position: sticky;
        top: 130px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    /* Interactive Avatar Click-to-Upload */
    .avatar-container-outer {
        position: relative;
        margin-bottom: 2rem;
    }

    .avatar-wrapper {
        position: relative;
        width: 160px;
        height: 160px;
        cursor: pointer;
        border-radius: 50%;
        border: 1px solid rgba(212, 175, 55, 0.25);
        padding: 6px;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        background: rgba(20, 11, 5, 0.6);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .avatar-wrapper:hover {
        border-color: var(--gold);
        transform: scale(1.04) rotate(2deg);
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.15);
    }

    .avatar-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(184, 134, 11, 0.05) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.8rem;
        font-family: 'Crimson Pro', serif;
        font-weight: 300;
        color: var(--gold);
        position: relative;
        border: 1px solid rgba(212, 175, 55, 0.1);
    }

    .avatar-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(13, 8, 5, 0.85);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 50%;
        backdrop-filter: blur(5px);
    }

    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-overlay svg {
        color: var(--gold);
        margin-bottom: 8px;
        transform: translateY(10px);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .avatar-wrapper:hover .avatar-overlay svg {
        transform: translateY(0);
    }

    .avatar-overlay span {
        font-size: 0.65rem;
        color: var(--cream);
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-weight: 700;
        opacity: 0.8;
    }
    
    .input-label {
        display: block;
        color: rgba(245, 235, 224, 0.5);
        font-size: 0.72rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        transition: color 0.3s;
    }
    
    .input-wrapper:focus-within .input-label {
        color: var(--gold);
    }
    
    .premium-input {
        width: 100%;
        padding: 1.1rem 1.4rem;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        color: var(--cream);
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        outline: none;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .premium-input:focus {
        background: rgba(255, 255, 255, 0.04);
        border-color: var(--gold);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.12), inset 0 1px 2px rgba(255,255,255,0.02);
        transform: translateY(-1px);
    }
    
    .premium-input select, .premium-input option {
        background: #150A04;
        color: var(--cream);
    }

    .premium-input::placeholder {
        color: rgba(245, 235, 224, 0.25);
    }
    
    /* Date picker specific */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.8) sepia(50%) saturate(1000%) hue-rotate(10deg);
        cursor: pointer;
    }

    /* VIP Badge glow */
    .vip-badge {
        font-size: 0.65rem;
        color: #000;
        background: linear-gradient(135deg, var(--gold-bright) 0%, var(--gold) 100%);
        padding: 4px 14px;
        border-radius: 50px;
        font-weight: 800;
        letter-spacing: 0.15em;
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.25);
        display: inline-block;
    }

    .btn-sync {
        background: linear-gradient(135deg, #B8860B 0%, var(--gold) 100%);
        color: #000 !important;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        border: none;
        border-radius: 12px;
        padding: 1.1rem 2.8rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.15);
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
    }

    .btn-sync:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(212, 175, 55, 0.35);
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-bright) 100%);
    }
    
    .btn-sync:active {
        transform: translateY(-1px);
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 1.2rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.03);
    }
    
    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>
@endpush

@section('content')
<div style="max-width:1200px; margin:0 auto; padding: 3rem 1.5rem;">

    @php
        $dashboardRoute = 'customer.dashboard';
        if ($roleName === 'admin') $dashboardRoute = 'admin.dashboard';
        elseif ($roleName === 'partner') $dashboardRoute = 'partner.dashboard';
        elseif ($roleName === 'manager') $dashboardRoute = 'manager.dashboard';
    @endphp

    <div class="animate-in" style="margin-bottom: 2.5rem;">
        <a href="{{ route($dashboardRoute) }}" style="display:inline-flex; align-items:center; gap:.6rem; color:var(--gold); text-decoration:none; font-size:.82rem; tracking: 0.15em; font-weight: 700; transition: all .3s; background: rgba(212, 175, 55, 0.05); padding: 0.6rem 1.2rem; border-radius: 50px; border: 1px solid rgba(212, 175, 55, 0.15);" onmouseover="this.style.background='rgba(212, 175, 55, 0.12)'; this.style.borderColor='var(--gold)';" onmouseout="this.style.background='rgba(212, 175, 55, 0.05)'; this.style.borderColor='rgba(212, 175, 55, 0.15)';">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            KEMBALI KE DASHBOARD
        </a>
    </div>

    <div class="animate-in" style="margin-bottom: 4rem; display: flex; align-items: center; gap: 2rem;">
        <div style="width: 5px; height: 60px; background: linear-gradient(to bottom, var(--gold), #B8860B); border-radius: 4px;"></div>
        <div>
            <h2 style="font-family: 'Crimson Pro', serif; font-size: clamp(2.2rem, 4vw, 3.2rem); font-weight: 700; color: var(--cream); line-height: 1.1; letter-spacing: -0.01em;">Executive Profile Management</h2>
            <p style="color: rgba(245, 235, 224, 0.45); font-size: 1.05rem; margin-top: 0.6rem; font-weight: 300; letter-spacing: 0.02em;">Orchestrate your personal identity and digital presence across the Wismilak ecosystem.</p>
        </div>
    </div>

    <!-- Alert success/error -->
    @if(session('success'))
        <div class="animate-in" style="background:rgba(16,185,129,0.06); border:1px solid rgba(16,185,129,0.3); color:#10B981; padding: 1.2rem 1.8rem; border-radius: 16px; margin-bottom: 3rem; font-size: 0.95rem; display: flex; align-items: center; gap: 0.8rem; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="profile-grid">
        
        <!-- Left: Identity Showcase -->
        <div class="animate-in" style="animation-delay: 0.15s;">
            <div class="profile-card identity-card">
                
                <!-- Avatar with Click-to-Upload Trigger -->
                <div class="avatar-container-outer">
                    <div class="avatar-wrapper" onclick="triggerPhotoUpload()">
                        <div class="avatar-inner" id="avatar-container">
                            @if($user->avatar_url)
                                <img id="avatar-img" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                            @else
                                <span id="avatar-initials">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            @endif
                            <div class="avatar-overlay">
                                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Ganti Foto</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 style="font-size: 2.1rem; font-weight: 700; color: var(--cream); margin-bottom: 0.5rem; font-family: 'Crimson Pro', serif; letter-spacing: -0.01em; line-height: 1.2;">{{ $user->name }}</h3>
                
                <div style="display: flex; flex-direction: column; align-items: center; gap: 0.8rem; margin-bottom: 3.5rem;">
                    <div><span class="vip-badge">VIP MEMBER</span></div>
                    <span style="color: var(--gold); font-weight: 700; text-transform: uppercase; font-size: 0.78rem; letter-spacing: 0.2em; opacity: 0.9;">
                        {{ $user->role->name ?? 'Member' }}
                    </span>
                </div>

                <div style="width: 100%; text-align: left; background: rgba(0,0,0,0.2); padding: 2.2rem; border-radius: 20px; border: 1px solid rgba(212,175,55,0.08); box-shadow: inset 0 2px 4px rgba(0,0,0,0.45);">
                    <div class="info-row">
                        <div style="font-size: 0.7rem; color: rgba(245, 235, 224, 0.4); text-transform: uppercase; letter-spacing: 0.15em;">Primary Email</div>
                        <div style="font-size: 0.95rem; color: var(--cream); font-weight: 500; text-align: right;">{{ $user->email }}</div>
                    </div>
                    <div class="info-row">
                        <div style="font-size: 0.7rem; color: rgba(245, 235, 224, 0.4); text-transform: uppercase; letter-spacing: 0.15em;">Contact Number</div>
                        <div style="font-size: 0.95rem; color: var(--cream); font-weight: 500; text-align: right;">{{ $user->phone ?? 'Not Provided' }}</div>
                    </div>
                    <div class="info-row">
                        <div style="font-size: 0.7rem; color: rgba(245, 235, 224, 0.4); text-transform: uppercase; letter-spacing: 0.15em;">Started Since</div>
                        <div style="font-size: 0.95rem; color: var(--cream); font-weight: 500; text-align: right;">{{ $user->created_at->format('d F, Y') }}</div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right: Edit Interface -->
        <div style="display: flex; flex-direction: column; gap: 3.5rem;">
            
            <!-- PRIMARY INFO -->
            <div class="profile-card animate-in" style="animation-delay: 0.25s;">
                <div style="padding: 2.2rem 2.8rem; border-bottom: 1px solid rgba(212,175,55,0.08); display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.15);">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 38px; height: 38px; background: rgba(212,175,55,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(212,175,55,0.15);">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--gold)" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <span style="font-weight: 700; letter-spacing: 0.18em; color: var(--cream); text-transform: uppercase; font-size: 0.85rem;">Identity Credentials</span>
                    </div>
                </div>
                
                <div style="padding: 3rem 2.8rem;">
                    <form method="POST" action="{{ route('profile.manage.update') }}" enctype="multipart/form-data" id="profile-form">
                        @csrf
                        @method('PUT')

                        <!-- Hidden File Input for Avatar Trigger -->
                        <input type="file" name="photo" id="photo-file-input" style="display: none;" accept="image/*" onchange="previewImage(event)">

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                            <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                <label class="input-label">Full Legal Name</label>
                                <input type="text" name="name" class="premium-input" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.4rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                <label class="input-label">Primary Email</label>
                                <input type="email" name="email" class="premium-input" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.4rem;">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                            <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                <label class="input-label">Contact Phone</label>
                                <input type="text" name="phone" class="premium-input" placeholder="+62 ..." value="{{ old('phone', $user->phone) }}">
                                @error('phone') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.4rem;">{{ $message }}</div> @enderror
                            </div>
                            @if($user->role?->name === 'customer')
                                <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                    <label class="input-label">City of Residence</label>
                                    <input type="text" name="city" class="premium-input" placeholder="Masukkan Kota" value="{{ old('city', $user->city) }}">
                                </div>
                            @endif
                        </div>

                        @if($user->role?->name === 'customer')
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
                                <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                    <label class="input-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="premium-input" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                </div>
                                <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                    <label class="input-label">Gender</label>
                                    <div style="position: relative;">
                                        <select name="gender" class="premium-input" style="appearance: none; -webkit-appearance: none; cursor: pointer; padding-right: 2.5rem;">
                                            <option value="" disabled {{ !$user->gender ? 'selected' : '' }}>Select Gender</option>
                                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        <div style="position: absolute; right: 1.2rem; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--gold);">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div style="text-align: right;">
                            <button type="submit" class="btn-sync">
                                <span>SYNCHRONIZE IDENTITY</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SECURITY -->
            <div class="profile-card animate-in" style="animation-delay: 0.3s;">
                <div style="padding: 2.2rem 2.8rem; border-bottom: 1px solid rgba(212, 175, 55, 0.08); display: flex; align-items: center; gap: 1rem; background: rgba(0,0,0,0.15);">
                    <div style="width: 38px; height: 38px; background: rgba(239,68,68,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(239,68,68,0.15);">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--red)" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <span style="font-weight: 700; letter-spacing: 0.18em; color: var(--cream); text-transform: uppercase; font-size: 0.85rem;">Security & Access</span>
                </div>
                <div style="padding: 3rem 2.8rem;">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="input-wrapper" style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom: 2rem;">
                            <label class="input-label">Current Authentication Password</label>
                            <input type="password" name="current_password" class="premium-input" required placeholder="••••••••">
                            @error('current_password') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.4rem;">{{ $message }}</div> @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
                            <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                <label class="input-label">New Password</label>
                                <input type="password" name="password" class="premium-input" required placeholder="Minimal 8 karakter">
                                @error('password') <div style="color: var(--red); font-size: 0.75rem; margin-top: 0.4rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="input-wrapper" style="display:flex; flex-direction:column;">
                                <label class="input-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="premium-input" required placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" class="btn-sync" style="background: linear-gradient(135deg, #2E1A0C 0%, #150A04 100%); color: var(--gold) !important; border: 1px solid rgba(212,175,55,0.25); box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                <span>REVOLVE SECURITY</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($user->role?->name === 'partner')
            <!-- ASSIGNED OUTLETS -->
            <div class="profile-card animate-in" style="animation-delay: 0.4s;">
                <div style="padding: 2.2rem 2.8rem; border-bottom: 1px solid rgba(212, 175, 55, 0.08); display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.15);">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 38px; height: 38px; background: rgba(59,130,246,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(59,130,246,0.15);">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#60A5FA" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <span style="font-weight: 700; letter-spacing: 0.18em; color: var(--cream); text-transform: uppercase; font-size: 0.85rem;">Assigned Outlets</span>
                    </div>
                    <span style="font-size: 0.72rem; font-weight: 700; color: #60A5FA; background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2); padding: 4px 12px; border-radius: 50px;">{{ $user->outlets->count() }} OUTLET</span>
                </div>
                <div style="padding: 2.5rem 2.8rem;">
                    @if($user->outlets->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                            @foreach($user->outlets as $outlet)
                                <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 1.5rem; transition: all 0.3s ease;" onmouseover="this.style.borderColor='rgba(212,175,55,0.25)'; this.style.background='rgba(255,255,255,0.04)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.background='rgba(255,255,255,0.02)';">
                                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                                        <div style="flex: 1; min-width: 200px;">
                                            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.6rem;">
                                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="var(--gold)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                                <h4 style="font-weight: 700; font-size: 1.05rem; color: var(--cream); margin: 0;">{{ $outlet->name }}</h4>
                                            </div>
                                            @if($outlet->address)
                                                <p style="font-size: 0.85rem; color: rgba(245,235,224,0.5); margin: 0 0 0.35rem 0; padding-left: 1.6rem;">{{ $outlet->address }}</p>
                                            @endif
                                            <div style="display: flex; align-items: center; gap: 1.2rem; padding-left: 1.6rem; flex-wrap: wrap;">
                                                @if($outlet->city)
                                                    <span style="font-size: 0.75rem; color: rgba(245,235,224,0.4); display: flex; align-items: center; gap: 0.3rem;">
                                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                        {{ $outlet->city }}
                                                    </span>
                                                @endif
                                                @if($outlet->phone)
                                                    <span style="font-size: 0.75rem; color: rgba(245,235,224,0.4); display: flex; align-items: center; gap: 0.3rem;">
                                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                                        {{ $outlet->phone }}
                                                    </span>
                                                @endif
                                                @if($outlet->opening_hours)
                                                    <span style="font-size: 0.75rem; color: rgba(245,235,224,0.4); display: flex; align-items: center; gap: 0.3rem;">
                                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                        {{ $outlet->opening_hours }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            @if($outlet->status === 'active')
                                                <span style="font-size: 0.65rem; font-weight: 800; padding: 4px 12px; border-radius: 50px; background: rgba(16,185,129,0.1); color: #10B981; border: 1px solid rgba(16,185,129,0.2); text-transform: uppercase; letter-spacing: 0.1em;">Active</span>
                                            @else
                                                <span style="font-size: 0.65rem; font-weight: 800; padding: 4px 12px; border-radius: 50px; background: rgba(245,158,11,0.1); color: #F59E0B; border: 1px solid rgba(245,158,11,0.2); text-transform: uppercase; letter-spacing: 0.1em;">{{ ucfirst($outlet->status ?? 'Inactive') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 3rem 1rem;">
                            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem;">
                                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="rgba(245,235,224,0.25)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <p style="color: rgba(245,235,224,0.4); font-size: 0.95rem; margin-bottom: 0.4rem;">Belum ada outlet yang di-assign ke akun Anda.</p>
                            <p style="color: rgba(245,235,224,0.25); font-size: 0.8rem;">Hubungi admin untuk penugasan outlet.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function triggerPhotoUpload() {
        document.getElementById('photo-file-input').click();
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const avatarContainer = document.getElementById('avatar-container');
            let avatarImg = document.getElementById('avatar-img');
            const initialsSpan = document.getElementById('avatar-initials');

            if (!avatarImg) {
                avatarImg = document.createElement('img');
                avatarImg.id = 'avatar-img';
                if (initialsSpan) {
                    initialsSpan.remove();
                }
                avatarContainer.appendChild(avatarImg);
            }
            avatarImg.src = reader.result;
        }
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endpush
