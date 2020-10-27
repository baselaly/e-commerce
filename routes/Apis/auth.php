<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/activate/{code}', [AuthController::class, 'activate']);
    Route::post('/forgetpassword/email', [AuthController::class, 'forgetPassword']);
});
