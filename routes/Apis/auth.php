<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/verify/{code}', [AuthController::class, 'activate'])->name('auth.activate');
    Route::post('/forgetpassword/email', [AuthController::class, 'forgetPassword'])->name('auth.forgetpassword');
    Route::post('/resetpassword', [AuthController::class, 'resetPassword'])->name('auth.resetpassword');

    Route::group(['middleware' => 'userAuth'], function () {
        Route::get('/profile', [AuthController::class, 'getProfile'])->name('auth.getProfile');
        Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('auth.updateProfile');
    });
});
