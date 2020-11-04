<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'carts', 'middleware' => 'userAuth'], function () {
    Route::post('/store', [CartController::class, 'store'])->name('carts.store');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('carts.update');
});
