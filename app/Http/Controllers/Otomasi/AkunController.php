<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AkunController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $user->load('roles');

        return view('administrator.akun', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->getKey()),
            ],
            // Perubahan profil maupun password meminta bukti kepemilikan akun.
            'password_lama' => ['required', 'string', 'current_password'],
            'password_baru' => [
                'nullable', 'string', 'confirmed',
                Password::min(12)->mixedCase()->numbers()->symbols(),
            ],
            'password_baru_confirmation' => ['nullable', 'string'],
        ], [
            'password_lama.current_password' => 'Password lama tidak sesuai.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sama.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if (! empty($validated['password_baru'])) {
            // Tercakup oleh cast 'hashed' pada model User.
            $user->password = $validated['password_baru'];
        }

        // Tidak pernah menerima/mengubah role, permission, id, atau is_admin dari request.
        $user->save();
        $request->session()->regenerate();
        $request->session()->put('panel_last_activity', now()->timestamp);

        return redirect()->route('panel.akun.index')->with('status', 'Data akun berhasil diperbarui.');
    }
}
