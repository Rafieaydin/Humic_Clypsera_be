<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\authController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\RolePremissionController;

Route::post('/auth/login', [authController::class, 'login']);
Route::post('/auth/register', [authController::class, 'register']);
Route::post('/auth/forgot-password', [authController::class, 'forget_password']);
Route::post('/auth/reset-password', [authController::class, 'reset_password']);


Route::middleware(['auth:api'])->group(function () {

    Route::post('/auth/refresh', [authController::class, 'refresh']);
    Route::post('/auth/logout', [authController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('page')->group(function(){
        Route::get('/berita', [BeritaController::class, 'index']);
        Route::get('/berita/{id}', [BeritaController::class, 'show']);
        Route::post('/berita', [BeritaController::class, 'store']);
        Route::patch('/berita/{id}', [BeritaController::class, 'update']);
        Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
    });

    Route::prefix('role')->group(function(){
        Route::get('/', [RolePremissionController::class, 'index']);
        Route::post('/create', [RolePremissionController::class, 'create_role']);
        Route::post('/assign-permission', [RolePremissionController::class, 'assign_permission']);
        // Route::post('/assign-role', [RolePremissionController::class, 'assign_role']);
        Route::post('/revoke-permission', [RolePremissionController::class, 'remove_permission']);
        Route::delete('/revoke-role/{role}', [RolePremissionController::class, 'delete_role']);
    });
});
