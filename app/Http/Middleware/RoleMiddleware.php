<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Jika belum login
        if (!$user) {
            return redirect('/')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        // Jika status tidak ada di daftar role -> logout
        if (!in_array($user->status, $roles)) {
            Auth::logout();
            return redirect('/')
                ->withErrors(['login' => 'Anda tidak memiliki akses.']);
        }

        return $next($request);
    }
}
