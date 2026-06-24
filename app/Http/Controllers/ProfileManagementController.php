<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileManagementController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $user->load('role');

        // Load assigned outlets for partner users
        if ($user->role?->name === 'partner') {
            $user->load('outlets');
        }

        return view('profile.dashboard-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Role-specific fields
        $roleName = $user->role?->name;

        if ($roleName === 'customer') {
            $rules['city']          = 'nullable|string|max:100';
            $rules['date_of_birth'] = 'nullable|date';
            $rules['gender']        = 'nullable|in:male,female';
        }

        $validated = $request->validate($rules);

        $user->update([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'] ?? $user->phone,
            'city'          => $validated['city'] ?? $user->city,
            'date_of_birth' => $validated['date_of_birth'] ?? $user->date_of_birth,
            'gender'        => $validated['gender'] ?? $user->gender,
        ]);

        // Tangani upload foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('avatars', 'public');
            
            if ($user->isCustomer()) {
                $user->customerProfile()->updateOrCreate([], ['avatar' => $path]);
            } elseif ($user->isAdmin()) {
                $user->adminProfile()->updateOrCreate([], ['avatar' => $path]);
            } elseif ($user->isManager()) {
                $user->managerProfile()->updateOrCreate([], ['avatar' => $path]);
            } elseif ($user->isPartner()) {
                $user->partnerProfile()->updateOrCreate([], ['logo' => $path]);
            }
        }

        // Kirim notifikasi
        try {
            \App\Models\Notification::send(
                $user->id,
                'Profil Diperbarui',
                'Profil Anda berhasil diperbarui.',
                'profile'
            );
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('Profile update notification failed: ' . $ne->getMessage());
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
