<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminGoogleController;
use App\Http\Controllers\Admin\DashboardController;

Route::view('/', 'site.index')->name('site.home');
Route::view('/terms', 'site.terms')->name('site.terms');
Route::view('/privacy', 'site.privacy')->name('site.privacy');

// google oauth
Route::get('/auth/google/redirect', [AdminGoogleController::class, 'redirect'])->name('admin.google.redirect');
Route::get('/auth/google/callback', [AdminGoogleController::class, 'callback'])->name('admin.google.callback');

// admin area
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // placeholders para as próximas telas
    Route::inertia('/products', 'admin/products')->name('products');
    Route::inertia('/orders', 'admin/orders')->name('orders');
    Route::inertia('/addons', 'admin/addons')->name('addons');

    Route::post('/logout', function () {
        auth('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('site.home');
    })->name('logout');
});

// alias antigo (se sua view usa esse nome)
Route::get('/admin/login/google', [AdminGoogleController::class, 'redirect'])->name('admin.login.google');

require __DIR__ . '/auth.php';
