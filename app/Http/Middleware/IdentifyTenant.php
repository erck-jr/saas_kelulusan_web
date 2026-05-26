<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\School;
use Illuminate\Http\Request;

class IdentifyTenant
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
        $slug = $request->route('school_slug');

        if ($slug) {
            \Illuminate\Support\Facades\URL::defaults(['school_slug' => $slug]);
            $request->route()->forgetParameter('school_slug');
        }
        if (empty($slug)) {
            abort(404, 'Sekolah tidak ditentukan.');
        }

        $school = School::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$school) {
            abort(404, 'Sekolah tidak ditemukan atau dinonaktifkan.');
        }

        // Bind current school to the Service Container
        app()->instance('current_school', $school);

        // Automatically share with all views for convenient UI styling/branding
        view()->share('current_school', $school);

        return $next($request);
    }
}
