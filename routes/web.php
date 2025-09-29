<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminGoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\AdminRole;

/*
|--------------------------------------------------------------------------
| Site público
|--------------------------------------------------------------------------
*/

Route::view('/', 'site.index')->name('site.home');
Route::view('/terms', 'site.terms')->name('site.terms');
Route::view('/privacy', 'site.privacy')->name('site.privacy');

// Google OAuth
Route::get('/auth/google/redirect', [AdminGoogleController::class, 'redirect'])
    ->name('admin.google.redirect');
Route::get('/auth/google/callback', [AdminGoogleController::class, 'callback'])
    ->name('admin.google.callback');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
|
| - A rota /admin exige login do guard 'admin' (feito por você) + AdminOnly
| - AdminRole garante que 'user' não entra; admin e superadmin entram.
| - Dentro enviamos props para o Dashboard via Inertia.
|
*/

Route::middleware(['web', 'auth:admin', AdminOnly::class, AdminRole::class])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Products
        Route::get('/products', [ProductController::class, 'index'])
            ->name('admin.products.index');
        Route::patch('/products/{product}', [ProductController::class, 'update'])
            ->name('admin.products.update');

        // Só superadmin cria
        Route::post('/products', [ProductController::class, 'store'])
            ->middleware('can:create-products')
            ->name('admin.products.store');

        // Métricas para os gráficos (retorna JSON usado no front)
        Route::get('/metrics', [DashboardController::class, 'metrics'])
            ->name('admin.metrics');

        // Logout
        Route::post('/logout', function () {
            auth('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('site.home');
        })->name('admin.logout');
    });

require __DIR__ . '/auth.php';
