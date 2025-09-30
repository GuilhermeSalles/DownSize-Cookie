<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\AdminUser;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class => ProductPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('edit-product-image', function (AdminUser $user) {
            return strcasecmp($user->role, 'superadmin') === 0;
        });

        Gate::define('create-products', function (AdminUser $user) {
            return strcasecmp($user->role, 'superadmin') === 0;
        });
    }
}
