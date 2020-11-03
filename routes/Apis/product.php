<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products', 'middleware' => 'userAuth'], function () {
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('owner/{id}', [ProductController::class, 'getOwnerProduct']);
    Route::get('/{id}', [ProductController::class, 'getProduct']);
    Route::post('/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('/image/{id}', [ProductImageController::class, 'delete']);
    Route::get('changeState/{id}', [ProductController::class, 'changeProductStatus']);
    Route::get('featured/{id}', [ProductController::class, 'changeFeatured'])->middleware('storeAuth');

    Route::get('/', [ProductController::class, 'getProducts']);
    Route::get('/store/{storeId}', [ProductController::class, 'getStoreProducts']);
    Route::get('/user/{userId}', [ProductController::class, 'getUserProducts']);
});
