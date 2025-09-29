<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AdminGoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $admin = AdminUser::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'          => $googleUser->getName() ?: Str::before($googleUser->getEmail(), '@'),
                'google_id'     => $googleUser->getId(),
                'profile_image' => $googleUser->getAvatar(),
                'is_active'     => true,
                'role'          => 'user', // <— SEMPRE cria como user
            ],
        );

        // se o usuário NÃO é admin/superadmin, manda para a home sem logar no guard admin
        if (!in_array($admin->role, ['admin', 'superadmin'], true) || !$admin->is_active) {
            return redirect()
                ->route('site.home')
                ->with('message', 'Seu acesso ao painel ainda não foi liberado.');
        }

        // ok: loga no guard admin e leva ao dashboard
        Auth::guard('admin')->login($admin, remember: true);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('site.home');
    }
}
