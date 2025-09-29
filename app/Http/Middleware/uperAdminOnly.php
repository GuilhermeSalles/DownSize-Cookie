<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $guard = 'admin';

        if (! Auth::guard($guard)->check()) {
            return redirect('/')
                ->with('message', 'You must be signed in to access this area.');
        }

        $user = Auth::guard($guard)->user();

        if (! $user->is_active || $user->role !== 'superadmin') {
            return redirect('/admin')
                ->with('message', 'Only superadmins can access this section.');
        }

        return $next($request);
    }
}
