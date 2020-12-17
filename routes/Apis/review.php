<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reviews', 'middleware' => 'userAuth'], function () {
    Route::post('/products', [ReviewController::class, 'reviewProduct']);
    Route::post('/store', [ReviewController::class, 'reviewStore']);
});
