<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\authController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\RolePremissionController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\JenisKelainanController;
use App\Http\Controllers\JenisTerapiController;
use App\Http\Controllers\OperasiController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\inputDataController;
use App\Http\Controllers\KategoriPermohonanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\UserController;

Route::post('/auth/login', [authController::class, 'login']);
Route::post('/auth/register', [authController::class, 'register']);
Route::post('/auth/forgot-password', [authController::class, 'forget_password']);
Route::post('/auth/reset-password', [authController::class, 'reset_password']);


Route::middleware(['auth:api'])->group(function () {

    Route::post('/auth/refresh', [authController::class, 'refresh']);
    Route::post('/auth/logout', [authController::class, 'logout']);



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

    Route::prefix('permission')->group(function(){
        Route::get('/', [RolePremissionController::class, 'index_permission']);
        Route::post('/create', [RolePremissionController::class, 'create_permission']);
        Route::delete('/delete/{permission}', [RolePremissionController::class, 'delete_permission']);
    });

    Route::prefix('diagnosis')->group(function(){
        Route::get('/', [DiagnosisController::class, 'index']);
        Route::get('/{id}', [DiagnosisController::class, 'show']);
        Route::post('/', [DiagnosisController::class, 'store']);
        Route::patch('/{id}', [DiagnosisController::class, 'update']);
        Route::delete('/{id}', [DiagnosisController::class, 'destroy']);
    });

    Route::prefix('jenis-kelainan')->group(function(){
        Route::get('/', [JenisKelainanController::class, 'index']);
        Route::get('/{id}', [JenisKelainanController::class, 'show']);
        Route::post('/', [JenisKelainanController::class, 'store']);
        Route::patch('/{id}', [JenisKelainanController::class, 'update']);
        Route::delete('/{id}', [JenisKelainanController::class, 'destroy']);
    });

    Route::prefix('jenis-terapi')->group(function(){
        Route::get('/', [JenisTerapiController::class, 'index']);
        Route::get('/{id}', [JenisTerapiController::class, 'show']);
        Route::post('/', [JenisTerapiController::class, 'store']);
        Route::patch('/{id}', [JenisTerapiController::class, 'update']);
        Route::delete('/{id}', [JenisTerapiController::class, 'destroy']);
    });

    Route::prefix('operasi')->group(function(){
        Route::get('/', [OperasiController::class, 'index']);
        Route::get('/show/{id}', [OperasiController::class, 'show']);
        Route::post('/store', [OperasiController::class, 'store']);
        Route::patch('/{id}/update', [OperasiController::class, 'update']);
        Route::delete('/{id}/delete', [OperasiController::class, 'destroy']);
    });


    Route::prefix('pasien')->group(function(){
        Route::get('/', [PasienController::class, 'index']);
        Route::get('/show/{id}', [PasienController::class, 'show']);
        Route::post('/store', [PasienController::class, 'store']);
        Route::patch('/{id}/update', [PasienController::class, 'update']);
        Route::delete('/{id}/delete', [PasienController::class, 'destroy']);
    });

    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/find/{id}', [UserController::class, 'find']);
        Route::get('/search', [UserController::class, 'search']);
        Route::post('/store', [UserController::class, 'store']);
        Route::patch('/{id}/update', [UserController::class, 'update']);
        Route::delete('/{id}/delete', [UserController::class, 'destroy']);
    });

    Route::prefix('kategori_permohonan')->group(function(){
        Route::get('/', [KategoriPermohonanController::class, 'index']);
        Route::get('/find/{id}', [KategoriPermohonanController::class, 'find']);
        Route::get('/search', [KategoriPermohonanController::class, 'search']);
        Route::post('/store', [KategoriPermohonanController::class, 'store']);
        Route::patch('/{id}/update', [KategoriPermohonanController::class, 'update']);
        Route::delete('/{id}/delete', [KategoriPermohonanController::class, 'destroy']);
    });

    Route::prefix('permohonan')->group(function(){
        Route::get('/', [PermohonanController::class, 'index']);
        Route::get('/find/{id}', [PermohonanController::class, 'find']);
        Route::get('/search', [PermohonanController::class, 'search']);
        Route::post('/store', [PermohonanController::class, 'store']);
        Route::patch('/{id}/update', [PermohonanController::class, 'update']);
        Route::delete('/{id}/delete', [PermohonanController::class, 'destroy']);
    });
});
