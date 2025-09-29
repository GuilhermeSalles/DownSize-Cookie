<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareInertiaAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Usuário logado no guard "admin"
        $admin = auth('admin')->user();

        Inertia::share([
            // Disponível em usePage().props.admin no front
            'admin' => $admin ? [
                'id'            => $admin->id,
                'name'          => $admin->name,
                'email'         => $admin->email,
                'role'          => $admin->role ?? 'user', // default de segurança
                'profile_image' => $admin->profile_image,
            ] : null,

            // CSRF pra formulários fora do Blade
            'csrfToken' => csrf_token(),
        ]);

        return $next($request);
    }
}
