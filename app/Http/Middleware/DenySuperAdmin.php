<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DenySuperAdmin
{
    /**
     * Block access for superadmin users.
     * Prevents heavy operations (e.g., mass certificate generation)
     * from being triggered by superadmin accounts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'superadmin') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Superadmin tidak diizinkan melakukan operasi ini. Silakan gunakan akun admin sekolah.'
                ], 403);
            }
            abort(403, 'Superadmin tidak diizinkan melakukan operasi ini.');
        }

        return $next($request);
    }
}
