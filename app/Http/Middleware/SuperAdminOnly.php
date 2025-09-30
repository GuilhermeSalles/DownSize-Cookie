<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('admin')->user();

        if (!$user || $user->role !== 'superadmin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden (superadmin only)'], 403);
            }

            return redirect()->route('site.home')
                ->with('message', 'Only superadmins can access this route.');
        }

        return $next($request);
    }
}
