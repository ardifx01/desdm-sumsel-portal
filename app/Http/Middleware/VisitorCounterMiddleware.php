<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorCounterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya tambahkan visitor jika request adalah untuk halaman web (bukan AJAX)
        if (!$request->ajax() && $request->isMethod('GET')) {
            $visitorCount = Setting::where('key', 'visitors')->first();

            if (!$visitorCount) {
                // Buat entri baru jika belum ada
                Setting::create([
                    'key' => 'visitors',
                    'value' => 1
                ]);
            } else {
                // Naikkan nilai visitor
                $visitorCount->value = (int)$visitorCount->value + 1;
                $visitorCount->save();
            }
        }

        return $next($request);
    }
}