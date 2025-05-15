<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\UserController;


Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'signUp']);
    Route::post('/login', [AuthController::class, 'signIn']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'signOut']);

        Route::get("/jobs", [JobController::class, "index"]);
        Route::get("/jobs/{id}", [JobController::class, "show"]);

        Route::prefix("/users")->group(function () {
            Route::get('', [UserController::class, "index"]);
            Route::get('/{id}', [UserController::class, "show"]);
            Route::put('', [UserController::class, "update"]);
            Route::put('/password', [UserController::class, "updatePassword"]);
            Route::post('/avatar', [UserController::class, "uploadAvatar"]);
            Route::delete('', [UserController::class, "destroy"]);
        });

        Route::prefix( "skills")->group(function () {
            Route::get("", [SkillController::class, "index"]);
            Route::get("/{id}", [SkillController::class, "show"]);
        });

        Route::prefix( "jobs")->group(function () {
            Route::get("", [JobController::class, "index"]);
            Route::get("/{id}", [JobController::class, "show"]);
        });
      
        Route::prefix( "countries")->group(function () {
            Route::get("", [CountryController::class, "index"]);//?page=2&limit=10
            Route::post("", [CountryController::class, "store"]);
            Route::delete("/{id}", [CountryController::class, "destroy"]);
        });
    });
});