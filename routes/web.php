<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::middleware('guest:web')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
        Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
    });

    Route::middleware('admin.auth:web')->group(function () {

        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('profile', [AdminAuthController::class, 'profile'])->name('admin.profile');

        Route::middleware([
            'permission:view users',
            'permission:edit content'
        ])->prefix("users")->group(function () {

            Route::get('', [AdminUserController::class, 'index'])->name('admin.users');
            Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/{id}/edit', [AdminUserController::class, 'update'])->name('admin.users.update');
            Route::delete('/{id}', [AdminUserController::class, 'destroy'])
                ->middleware(['admin.auth:web', 'permission:delete users'])
                ->name('admin.users.delete');
        });

        Route::middleware([
            'role:super-admin'
        ])->prefix("admins")->group(function () {

            Route::get('', [AdminAuthController::class, 'index'])->name('admin.admins');
            Route::get('/{id}/edit', [AdminAuthController::class, 'edit'])->name('admin.admins.edit');
            Route::put('/{id}/edit', [AdminAuthController::class, 'update'])->name('admin.admins.update');
            Route::delete('/{id}', [AdminAuthController::class, 'destroy'])->name('admin.admins.delete');
        });


        Route::middleware('role:super-admin')->group(function () {
            Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register.form');
            Route::post('register', [AdminAuthController::class, 'register'])->name('admin.register');

        });
    });
});