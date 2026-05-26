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
        if ($request->route('school_slug')) {
            \Illuminate\Support\Facades\URL::defaults(['school_slug' => $request->route('school_slug')]);
            $request->route()->forgetParameter('school_slug');
        }
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->school_id) {
                $school = $user->school;
                
                if ($school && $school->is_active) {
                    // Bind current school to the Service Container
                    app()->instance('current_school', $school);
                    
                    // Share with views
                    view()->share('current_school', $school);
                } else {
                    auth()->logout();
                    return redirect()->route('login')->with('error', 'Akun sekolah Anda telah dinonaktifkan.');
                }
            }
        }

        return $next($request);
    }
}
