<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\CustomerProfile;
use App\Models\UserPoint;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'         => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:' . now()->subYears(21)->format('Y-m-d')],
            'gender'        => ['nullable', 'in:male,female'],
            'city'          => ['nullable', 'string', 'max:100'],
            'terms'         => ['required', 'accepted'],
        ], [
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_of_birth.before' => 'Anda harus berusia minimal 21 tahun untuk mendaftar.',
            'terms.required'       => 'You must accept the terms of service.',
            'terms.accepted'       => 'You must accept the terms of service.',
        ]);

        $customerRole = Role::where('name', 'customer')->first();

        try {
            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'role_id'       => $customerRole?->id,
                'password'      => Hash::make($request->password),
                'status'        => 'active',
                'phone'         => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender'        => $request->gender,
                'city'          => $request->city,
            ]);

            // Auto-create customer profile
            CustomerProfile::create([
                'user_id'       => $user->id,
                'phone'         => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender'        => $request->gender,
                'city'          => $request->city,
            ]);

            // Auto-create user point record
            UserPoint::create([
                'user_id'      => $user->id,
                'total_points' => 0,
            ]);

            Auth::login($user);

            if ($request->has('redirect')) {
                return redirect($request->redirect);
            }

            return redirect()->route('dashboard')->with('success', 'Welcome to Wismilak! Your account has been created.');

        } catch (\Exception $e) {
            Log::error('Registration failed', ['error' => $e->getMessage(), 'email' => $request->email]);
            return back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }
}
