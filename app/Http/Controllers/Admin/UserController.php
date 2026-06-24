<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class UserController extends Controller
{
    public function index(Request $request)
{
    $users = User::with('role')
        ->when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        })
        ->when($request->role_id, function ($q) use ($request) {
            $q->where('role_id', $request->role_id);
        })
        ->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        })
        ->latest()
        ->get();

    $roles = Role::all(); // 🔥 INI YANG KURANG

    return view('admin.users.index', compact('users', 'roles'));
}

   
public function create()
{
    $roles = Role::all();
    return view('admin.users.create', compact('roles'));
}

    public function store(Request $request)
    {
        $request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users',
    'role_id' => 'required|exists:roles,id',
    'password' => 'required|min:6',
]);


       User::create([
    'name' => $request->name,
    'email' => $request->email,
    'role_id' => $request->role_id,
    'status' => 'active',
    'password' => Hash::make($request->password),
]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
{
    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
}

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'city' => 'nullable',
            'gender' => 'nullable',
            'role_id' => 'required',
            'status' => 'required',
        ]);

        $oldStatus = $user->status;
        $oldRoleId = $user->role_id;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'city' => $request->city,
            'gender' => $request->gender,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        if ($oldStatus !== $user->status || $oldRoleId !== $user->role_id) {
            try {
                \App\Models\Notification::send(
                    $user->id,
                    'Update Status/Akses Akun',
                    "Status atau peran akun Anda telah diperbarui oleh Admin. Status aktif: " . ucfirst($user->status),
                    'verification'
                );
            } catch (\Exception $ne) {
                \Illuminate\Support\Facades\Log::error('User update notification failed: ' . $ne->getMessage());
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update([
            'status' => $newStatus
        ]);

        try {
            \App\Models\Notification::send(
                $user->id,
                'Status Akun Berubah',
                "Status akun Anda telah diubah menjadi: " . ucfirst($newStatus),
                'verification'
            );
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('User toggleStatus notification failed: ' . $ne->getMessage());
        }

        return back()->with('success', 'Status user diperbarui');
    }
}
