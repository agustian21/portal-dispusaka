<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class Panel_Login extends Controller
{
    // Batas per akun berlaku lintas IP. Batas IP mengurangi serangan ke banyak akun.
    private const MAX_ACCOUNT_ATTEMPTS = 5;
    private const MAX_IP_ATTEMPTS = 40;
    private const LOCKOUT_SECONDS = 900;

    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('panel.beranda');
        }

        return view('administrator.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('panel.beranda');
        }

        $input = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'cf-turnstile-response' => ['nullable', 'string', 'max:2048'],
        ]);

        $accountKey = $this->accountKey($input['email']);
        $ipKey = $this->ipKey($request);

        if (
            RateLimiter::tooManyAttempts($accountKey, self::MAX_ACCOUNT_ATTEMPTS)
            || RateLimiter::tooManyAttempts($ipKey, self::MAX_IP_ATTEMPTS)
        ) {
            $remaining = max(
                RateLimiter::availableIn($accountKey),
                RateLimiter::availableIn($ipKey)
            );

            return back()
                ->withErrors(['email' => "Terlalu banyak percobaan. Coba lagi dalam {$remaining} detik."])
                ->onlyInput('email');
        }

        // Setiap percobaan dihitung sebelum memvalidasi challenge/password.
        RateLimiter::hit($accountKey, self::LOCKOUT_SECONDS);
        RateLimiter::hit($ipKey, self::LOCKOUT_SECONDS);

        if (! $this->verifyTurnstile($request, $input['cf-turnstile-response'] ?? null)) {
            return back()
                ->withErrors(['captcha' => 'Verifikasi keamanan gagal. Muat ulang halaman dan coba kembali.'])
                ->onlyInput('email');
        }

        // Laravel Auth::attempt menggunakan mekanisme query binding dari auth provider.
        if (! Auth::attempt([
            'email' => $input['email'],
            'password' => $input['password'],
        ], false)) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak valid.'])
                ->onlyInput('email');
        }

        RateLimiter::clear($accountKey);
        $request->session()->regenerate();
        $request->session()->put('panel_last_activity', now()->timestamp);

        return redirect()->route('panel.beranda')->with('status', 'Berhasil login.');
    }

    public function heartbeat(): Response
    {
        // Tidak boleh memperbarui waktu idle. Penanganannya ada di middleware.
        return response()->noContent();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah keluar dari panel.');
    }

    private function verifyTurnstile(Request $request, ?string $token): bool
    {
        $siteKey = (string) config('panel_security.turnstile.site_key', '');
        $secret = (string) config('panel_security.turnstile.secret_key', '');
        $expectedHostname = (string) config('panel_security.turnstile.expected_hostname', '');

        // Gagal tertutup jika belum diatur. Jangan diam-diam melewati CAPTCHA.
        if ($siteKey === '' || $secret === '' || $expectedHostname === '' || ! $token) {
            return false;
        }

        try {
            $response = Http::asForm()->timeout(6)->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ]
            );

            return $response->successful()
                && $response->json('success') === true
                && hash_equals($expectedHostname, (string) $response->json('hostname', ''));
        } catch (Throwable $exception) {
            // Gagal tertutup jika koneksi Cloudflare bermasalah; jangan log token rahasia.
            report($exception);
            return false;
        }
    }

    private function accountKey(string $email): string
    {
        return 'panel-login:account:' . hash('sha256', Str::lower(trim($email)));
    }

    private function ipKey(Request $request): string
    {
        return 'panel-login:ip:' . hash('sha256', (string) $request->ip());
    }
}
