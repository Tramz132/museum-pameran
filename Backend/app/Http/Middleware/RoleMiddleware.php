<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika request API / mengharapkan JSON, kembalikan respons 403
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Forbidden. Akses ditolak karena perbedaan peran.'], 403);
        }

        // Redirect ke dashboard masing-masing jika role tidak sesuai
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'panitia' => redirect()->route('panitia.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
