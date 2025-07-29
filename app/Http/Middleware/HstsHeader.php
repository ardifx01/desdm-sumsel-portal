<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HstsHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Tambahkan header HSTS hanya jika koneksi HTTPS dan di lingkungan produksi
        if ($request->secure() && config('app.env') === 'production') {
            // max-age: waktu dalam detik browser harus mengingat untuk mengakses situs hanya melalui HTTPS
            // includeSubDomains: terapkan aturan ini juga ke semua sub-domain
            // preload: mengirimkan situs ke daftar preload HSTS browser
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}