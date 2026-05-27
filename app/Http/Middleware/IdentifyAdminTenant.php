<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IdentifyAdminTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $schoolSlug = $request->route('school_slug');

        if ($schoolSlug) {
            \Illuminate\Support\Facades\URL::defaults(['school_slug' => $schoolSlug]);
            $request->route()->forgetParameter('school_slug');
        }

        if (auth()->check()) {
            $user = auth()->user();
            
            // 1. Superadmin bypasses tenant checks
            if ($user->role === 'superadmin') {
                if ($schoolSlug) {
                    $school = \App\Models\School::where('slug', $schoolSlug)->first();
                    if (!$school) {
                        abort(404, 'Sekolah tidak ditemukan.');
                    }
                    if (!$school->is_active) {
                        return redirect()->route('login')->with('error', 'Sekolah ini sedang dinonaktifkan.');
                    }
                    // Bind the school to the Service Container
                    app()->instance('current_school', $school);
                    
                    // Share with views
                    view()->share('current_school', $school);
                }
                return $next($request);
            }

            // 2. Regular admin or petugas
            if ($user->school_id) {
                $school = $user->school;
                
                if ($school && $school->is_active) {
                    // Check if the current subdomain matches the user's school slug
                    if ($schoolSlug && strtolower($schoolSlug) !== strtolower($school->slug)) {
                        $appDomain = parse_url(config('app.url'), PHP_URL_HOST);
                        $scheme = parse_url(config('app.url'), PHP_URL_SCHEME) ?: 'http';
                        $redirectUrl = $scheme . '://' . $school->slug . '.' . $appDomain . '/admin';

                        return response()->view('errors.403_swal', [
                            'message' => 'anda tidak punya akses ke dashboard admin ini',
                            'redirectUrl' => $redirectUrl,
                        ], 403);
                    }

                    // Bind current school to the Service Container
                    app()->instance('current_school', $school);
                    
                    // Share with views
                    view()->share('current_school', $school);
                } else {
                    auth()->logout();
                    return redirect()->route('login')->with('error', 'Akun sekolah Anda telah dinonaktifkan.');
                }
            } else {
                // If user has no school_id and is not superadmin, log out
                auth()->logout();
                return redirect()->route('login')->with('error', 'Akun Anda tidak terasosiasi dengan sekolah.');
            }
        }

        return $next($request);
    }
}
