<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // ...
    ];

    public function boot(): void
    {
        Gate::define('create-products', function ($user) {
            // $user é AdminUser
            return in_array($user->role, ['superadmin']); // só superadmin
        });

        Gate::define('edit-product-image', function ($user) {
            return in_array($user->role, ['superadmin']); // só superadmin
        });
    }
}
