@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div style="max-width: 650px; margin: 0 auto;">

    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.users.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div style="background: rgba(231,76,76,0.1); border: 1px solid rgba(231,76,76,0.3); color: #E74C4C; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem;">
            <ul style="list-style: disc; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="premium-card">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--card-border); background: rgba(255,255,255,0.01);">
            <h3 style="font-family: 'Crimson Pro', serif; font-size: 1.5rem; font-weight: 700; color: var(--gold); margin: 0;">Edit User</h3>
            <p style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">Perbarui profil, peranan, dan status akun pengguna.</p>
        </div>
        
        <div style="padding: 2rem;">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- NAME -->
                    <div>
                        <label for="name" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Name</label>
                        <input id="name" name="name" value="{{ old('name', $user->name) }}" required
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label for="email" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <!-- PHONE -->
                    <div>
                        <label for="phone" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Phone</label>
                        <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <!-- DATE OF BIRTH -->
                    <div>
                        <label for="date_of_birth" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Date of Birth</label>
                        <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <!-- CITY -->
                        <div>
                            <label for="city" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">City</label>
                            <input id="city" name="city" value="{{ old('city', $user->city) }}"
                                   style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                        </div>

                        <!-- GENDER -->
                        <div>
                            <label for="gender" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Gender</label>
                            <select id="gender" name="gender"
                                    style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <!-- ROLE -->
                        <div>
                            <label for="role_id" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Role</label>
                            <select id="role_id" name="role_id"
                                    style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- STATUS -->
                        <div>
                            <label for="status" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Status</label>
                            <select id="status" name="status"
                                    style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label for="password" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">New Password (optional)</label>
                        <input id="password" type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah"
                               style="width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; transition: all 0.3s;">
                    </div>
                </div>
                <div style="text-align: right; border-top: 1px solid var(--card-border); padding-top: 1.5rem; margin-top: 2.5rem;">
                    <button type="submit" class="btn-premium" style="width: 100%; justify-content: center; padding: 0.75rem 1rem;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
