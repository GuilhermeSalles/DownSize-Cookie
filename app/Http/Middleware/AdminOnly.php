<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Permite apenas admin ou superadmin logado no guard "admin".
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = 'admin';

        if (! Auth::guard($guard)->check()) {
            return redirect('/')
                ->with('message', 'You must be signed in to access the admin area.');
        }

        $user = Auth::guard($guard)->user();

        if (! $user->is_active || ! in_array($user->role, ['admin', 'superadmin'], true)) {
            Auth::guard($guard)->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')
                ->with('message', 'Access denied.');
        }

        return $next($request);
    }
}
