<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 🔍 Arahkan sesuai status
        if ($user->status === 'project-manajer') {
            return redirect()->intended(route('event.index', [], false));
        } elseif ($user->status === 'manajer') {
            return redirect()->intended(route('event.index', [], false));
        } elseif ($user->status === 'kru') {
            return redirect()->intended(route('kode.login', [], false)); // ganti 'user.index' sesuai route kamu
        } else {
            Auth::logout();
            return redirect('/')->withErrors(['login' => 'Akses ditolak.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
