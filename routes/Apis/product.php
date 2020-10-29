<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'product', 'middleware' => 'userAuth'], function () {
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
});
