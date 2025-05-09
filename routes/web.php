<?php

use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('app');
// });
// Route::get('/{any}', function () {
//     return view('app');
// })->where('any', 'resources/.*');

Route::get('/{any}', function () {
    return view('app'); 
})->where('any', '^(?!admin).*$');



Route::get('/admin', function () {
    if (auth('web')->check()) {
        return redirect()->route('admin.profile');
    }

    return redirect()->route('admin.login.form');
});

Route::prefix('admin')->group(function () {

    Route::middleware('guest:web')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
        Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
    });

    Route::middleware('admin.auth:web')->group(function () {

        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
        Route::get('settings', [AdminAuthController::class, 'settings'])->name('admin.settings');
        Route::put('settings/update', [AdminAuthController::class, 'settingsUpdate'])->name('admin.settings.update');
        Route::put('settings/updatePassword', [AdminAuthController::class, 'settingsUpdatePassword'])->name('admin.settings.updatePassword');

        Route::middleware([
            'permission:view users',
            'permission:edit content'
        ])->prefix("users")->group(function () {

            Route::get('', [AdminUserController::class, 'index'])->name('admin.users');
            Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/{id}/update', [AdminUserController::class, 'update'])->name('admin.users.update');
            Route::delete('/{id}', [AdminUserController::class, 'destroy'])
                ->middleware(['admin.auth:web', 'permission:delete users'])
                ->name('admin.users.destroy');
        });

        Route::middleware([
            'role:super-admin'
        ])->prefix("admins")->group(function () {

            Route::get('', [AdminAuthController::class, 'index'])->name('admin.admins');
            Route::get('/{id}/edit', [AdminAuthController::class, 'edit'])->name('admin.admins.edit');
            Route::put('/{id}/update', [AdminAuthController::class, "update"])->name('admin.admins.update');
            Route::delete('/{id}', [AdminAuthController::class, 'destroy'])->name('admin.admins.destroy');
            Route::delete('/{id}/role', [AdminAuthController::class, 'removeRole'])->name('admin.role.remove');

        });


        Route::middleware('role:super-admin')->group(function () {
            Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register.form');
            Route::post('register', [AdminAuthController::class, 'register'])->name('admin.register');
        });

        Route::middleware(['permission:view skill'])->prefix("skills")->group(function () {

            Route::get('', [AdminSkillController::class, 'index'])->name('admin.skills');

            Route::middleware([
                'permission:create skill',
                'permission:edit skill',
                'permission:delete skill'
            ])->group(function () {
                Route::post('', [AdminSkillController::class, 'store'])->name('admin.skills.store');
                Route::get('/create', [AdminSkillController::class, 'create'])->name('admin.skills.create');
                Route::get('/{id}/edit', [AdminSkillController::class, 'edit'])->name('admin.skills.edit');
                Route::put('/{id}/update', [AdminSkillController::class, 'update'])->name('admin.skills.update');
                Route::delete('/{id}', [AdminSkillController::class, 'destroy'])->name('admin.skills.destroy');
            });
        });

        Route::middleware(['permission:view job'])->prefix("jobs")->group(function () {

            Route::get('', [AdminJobController::class, 'index'])->name('admin.jobs');

            Route::middleware([
                'permission:create job',
                'permission:edit job',
                'permission:delete job'
            ])->group(function(){

                Route::post('', [AdminJobController::class, 'store'])->name('admin.jobs.store');
                Route::get('/create', [AdminJobController::class, 'create'])->name('admin.jobs.create');
                Route::get('/{id}/edit', [AdminJobController::class, 'edit'])->name('admin.jobs.edit');
                Route::put('/{id}/update', [AdminJobController::class, 'update'])->name('admin.jobs.update');
                Route::delete('/{id}', [AdminJobController::class, 'destroy'])->name('admin.jobs.destroy');
                Route::delete('/{job}/skills', [AdminJobController::class, 'removeSkills'])->name('admin.jobs.skills.remove');
            });

        });
    });
});