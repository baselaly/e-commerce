<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/verify/{code}', [AuthController::class, 'activate']);
    Route::post('/forgetpassword/email', [AuthController::class, 'forgetPassword']);
    Route::post('/resetpassword', [AuthController::class, 'resetPassword']);

    Route::group(['middleware' => 'userAuth'], function () {
        Route::get('/profile', [AuthController::class, 'getProfile']);
    });
});
