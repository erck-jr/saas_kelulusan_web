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

        if (Auth::user()->status === 'inactive') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->back()->with('sweetalert_error', 'Akun belum aktif hubungi SuperAdmin aplikasi untuk aktivasi akun.');
        }

        $request->session()->regenerate();

        $user = $request->user();

        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.global.dashboard');
        }

        if (in_array($user->role, ['admin', 'operator'])) {
            $school = $user->school;
            if ($school) {
                $appDomain = parse_url(config('app.url'), PHP_URL_HOST);
                $protocol = parse_url(config('app.url'), PHP_URL_SCHEME) ?? 'http';
                return redirect()->away($protocol . '://' . $school->slug . '.' . $appDomain . '/admin');
            }
        }

        return redirect()->intended(route('dashboard', absolute: false));
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
