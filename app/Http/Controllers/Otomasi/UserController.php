<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $users = User::with(['roles', 'permissions'])
            ->latest()
            ->paginate(10);

        return view('administrator.users.index', compact('users'));
    }


    /**
     * Form tambah user
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('administrator.users.create', compact('roles', 'permissions'));
    }


    /**
     * Simpan user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'exists:roles,name'],
            'password_baru' => ['required', 'confirmed', Password::min(8)],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name']
        ], [
            'nama.required' => 'Nama pengguna wajib diisi.',
            'nama.string' => 'Nama pengguna harus berupa teks.',
            'nama.max' => 'Nama pengguna maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',

            'role.required' => 'Hak akses utama wajib dipilih.',
            'role.exists' => 'Hak akses yang dipilih tidak tersedia.',

            'password_baru.required' => 'Password wajib diisi.',
            'password_baru.confirmed' => 'Konfirmasi password tidak sesuai.',

            'permissions.array' => 'Format akses modul tidak valid.',
            'permissions.*.exists' => 'Akses modul yang dipilih tidak tersedia.',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password_baru'])
            ]);

            $user->assignRole($validated['role']);

            if (isset($validated['permissions'])) {
                $user->syncPermissions($validated['permissions']);
            }
        });

        return redirect()
            ->route('panel.users.index')
            ->with('success', 'User berhasil dibuat');
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $user->load(['roles', 'permissions']);

        return view(
            'administrator.users.edit',
            compact('user', 'roles', 'permissions')
        );
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'exists:roles,name'],
            'password_baru' => ['nullable', 'confirmed', Password::min(8)],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name']
        ], [
            'nama.required' => 'Nama user wajib diisi.',
            'nama.string' => 'Nama user harus berupa teks.',
            'nama.max' => 'Nama user maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',

            'role.required' => 'Role user wajib dipilih.',
            'role.exists' => 'Role yang dipilih tidak tersedia.',

            'password_baru.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password_baru.min' => 'Password minimal harus 8 karakter.',

            'permissions.array' => 'Format permission tidak valid.',
            'permissions.*.exists' => 'Permission yang dipilih tidak tersedia.',
        ]);

        DB::transaction(function () use ($validated, $user) {
            $data = [
                'name' => $validated['nama'],
                'email' => $validated['email']
            ];

            if (!empty($validated['password_baru'])) {
                $data['password'] = Hash::make($validated['password_baru']);
            }

            $user->update($data);

            // Update Role
            $user->syncRoles([$validated['role']]);

            // Update Permission
            $user->syncPermissions($validated['permissions'] ?? []);
        });

        return redirect()
            ->route('panel.users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        if (
            $user->id == Auth::id()
        ) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}
