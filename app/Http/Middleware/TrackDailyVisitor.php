<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\VisitorDaily;
use Symfony\Component\HttpFoundation\Response;

class TrackDailyVisitor
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        // Jalankan halaman terlebih dahulu
        $response = $next($request);

        // Hanya catat halaman GET yang berhasil
        if (
            !$request->isMethod('GET') ||
            $request->ajax() ||
            $request->expectsJson() ||
            !$response->isSuccessful() ||
            !$request->route()
        ) {
            return $response;
        }

        // Ambil IP pengunjung
        $ip = $request->ip();

        if (!$ip) {
            return $response;
        }

        $now = now();

        // Cari atau buat record IP per hari
        $visitor = VisitorDaily::firstOrCreate(
            [
                'ip_address' => $ip,
                'visit_date' => $now->toDateString(),
            ],
            [
                'visited_routes' => [],
            ]
        );

        // Jika record baru, cari lokasi IP
        if ($visitor->wasRecentlyCreated) {

            $location = $this->getLocation($ip);

            $visitor->fill($location);
        }

        // Informasi route yang dibuka
        $route = $request->route();

        $path = '/' . ltrim($request->path(), '/');

        $page = [
            'route_name' => $route->getName(),
            'route_uri'  => $route->uri(),
            'path'       => $path,
        ];

        // Ambil daftar route sebelumnya
        $routes = $visitor->visited_routes ?? [];

        // Cegah route yang sama tercatat berulang
        $exists = collect($routes)->contains(
            fn($item) => ($item['path'] ?? null) === $path
        );

        if (!$exists) {
            $routes[] = $page;
        }

        // Update hanya aktivitas terakhir
        $visitor->forceFill([
            'visited_routes' => $routes,
            'updated_at' => now(),
        ]);

        $visitor->save();

        return $response;
    }


    /**
     * Mendeteksi lokasi berdasarkan IP
     */
    private function getLocation(string $ip): array
    {
        // IP lokal/private tidak dapat dicari lokasinya
        if (!filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE |
                FILTER_FLAG_NO_RES_RANGE
        )) {
            return [];
        }

        try {

            $response = Http::acceptJson()
                ->connectTimeout(1)
                ->timeout(2)
                ->get("https://ipwho.is/{$ip}");

            if (
                !$response->successful() ||
                $response->json('success') !== true
            ) {
                return [];
            }

            return [
                'country'   => $response->json('country'),
                'region'    => $response->json('region'),
                'city'      => $response->json('city'),
                'latitude'  => $response->json('latitude'),
                'longitude' => $response->json('longitude'),
            ];
        } catch (\Throwable $e) {

            report($e);

            return [];
        }
    }
}
