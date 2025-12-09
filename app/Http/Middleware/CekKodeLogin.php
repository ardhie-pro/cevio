<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekKodeLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau belum login kode, arahkan ke halaman kode.login
        if (!session()->has('kode_login')) {
            return redirect()->route('kode.login')
                ->with('error', 'Silakan masukkan kode ujian terlebih dahulu!');
        }

        return $next($request);
    }
}
