<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'stores', 'middleware' => 'userAuth'], function () {
    Route::post('/', [StoreController::class, 'createUserStore'])->name('store.post');
    Route::post('/{id}', [StoreController::class, 'updateUserStore'])->name('store.update');
    Route::get('/{id}', [StoreController::class, 'getStore']);
    Route::get('/my/store', [StoreController::class, 'getMyStore']);
});
