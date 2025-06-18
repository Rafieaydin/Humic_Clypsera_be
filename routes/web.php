<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\FcmController;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Route;

Route::get('/auth/reset_password/{token}', function ($token) {
    $email = FacadesDB::table('password_reset_tokens')->where('token', $token)->first();
    return view('emails.forget_password', ['token' => $token, 'email' => $email->email]);
})->name('password.reset');

Route::post('/auth/reset_password', [authController::class, 'reset_password_view'])->name('reset.password.post');

Route::get("testNotification", [FcmController::class, 'sendNotificationFirebase'])
    ->name('test-notification');

    Route::get('/', function () {
        return response()->json(['message' => 'Test route is working'], 200);
    })->name('test.route');
