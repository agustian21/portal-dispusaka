<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PanelInactivityTimeout
{
    private const IDLE_TIMEOUT = 7200; // 2 jam

    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $now = now()->timestamp;
        $lastActivity = $request->session()->get('panel_last_activity');

        if ($lastActivity !== null) {
            $lastActivity = (int) $lastActivity;
            if ($lastActivity <= 0 || $lastActivity > $now || ($now - $lastActivity) >= self::IDLE_TIMEOUT) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with(
                    'status',
                    'Sesi Anda berakhir karena tidak ada aktivitas selama 2 jam. Silakan login kembali.'
                );
            }
        }

        // Heartbeat/keep-alive otomatis tidak dianggap aktivitas manusia.
        if (! $request->routeIs('panel.activity')) {
            $request->session()->put('panel_last_activity', $now);
        }

        return $next($request);
    }
}
