<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products', 'middleware' => 'userAuth'], function () {
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('owner/{id}', [ProductController::class, 'getOwnerProduct']);
    Route::get('/{id}', [ProductController::class, 'getProduct']);
});
