<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use App\Models\VisitorLog; // Kita akan buat model ini
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VisitorCounterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jangan catat jika ini adalah rute admin atau bukan metode GET
        if ($request->is('admin/*') || !$request->isMethod('get')) {
            return $next($request);
        }

        // Jangan catat jika ini adalah bot/crawler
        $bots = ['bot', 'crawl', 'spider', 'slurp', 'yahoo', 'bing', 'google'];
        if (Str::contains(strtolower($request->userAgent()), $bots)) {
            return $next($request);
        }

        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $sessionKey = 'visitor_logged_' . md5($ipAddress . $userAgent);

        // Cek apakah pengunjung ini sudah dicatat dalam 24 jam terakhir
        if (!session()->has($sessionKey)) {
            // Jika belum, catat sebagai pengunjung baru
            
            // 1. Tambah ke Total Pengunjung Global
            Setting::updateOrCreate(
                ['key' => 'visitors'],
                ['value' => (int)Setting::where('key', 'visitors')->firstOrNew()->value + 1]
            );

            // 2. Simpan log detail (opsional, tapi bagus untuk analisis)
            VisitorLog::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'url_visited' => $request->fullUrl(),
                'visited_at' => now(),
            ]);

            // 3. Set session agar tidak dicatat lagi selama 24 jam
            session([$sessionKey => true], 1440); // 1440 menit = 24 jam
        }

        // Lanjutkan ke response
        return $next($request);
    }
}