<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\authController;
use App\Http\Controllers\BeritaController;

Route::post('/auth/login', [authController::class, 'login']);
Route::post('/register', [authController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {
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
});
