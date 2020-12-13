<?php

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'likes', 'middleware' => 'userAuth'], function () {
    Route::post('/product', [LikeController::class, 'likeProduct']);
    Route::post('/store', [LikeController::class, 'likeStore']);
});
