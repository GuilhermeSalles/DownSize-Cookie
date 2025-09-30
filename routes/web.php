<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\AdminGoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

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
| Guard 'auth:admin' + AdminOnly + AdminRole
*/
Route::middleware(['web', 'auth:admin', AdminOnly::class, AdminRole::class])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');


        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

        // Só policy (sem can:create-products aqui, a checagem fica no controller)
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');

        // Metrics
        Route::get('/metrics', [DashboardController::class, 'metrics'])->name('admin.metrics');

        // Logout
        Route::post('/logout', function () {
            Auth::guard('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('site.home');
        })->name('admin.logout');
    });

require __DIR__ . '/auth.php';
