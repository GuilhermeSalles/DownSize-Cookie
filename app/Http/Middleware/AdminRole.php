<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bloqueia contas com role = 'user' de acessar rotas de admin.
 * Permite apenas 'admin' e 'superadmin'.
 */
class AdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('admin')->user();

        if (!$user) {
            // 'auth:admin' deve ter rodado antes, mas fica a proteção
            return redirect()->route('site.home');
        }

        if (!in_array($user->role, ['admin', 'superadmin'], true)) {
            // Para JSON/Inertia
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            // Para navegação normal
            return redirect()->route('site.home')
                ->with('message', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
