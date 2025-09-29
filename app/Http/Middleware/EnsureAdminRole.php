<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('admin')->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if (!$user->is_active) {
            abort(403);
        }

        if (!in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
