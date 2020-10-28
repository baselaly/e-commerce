<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'store', 'middleware' => 'userAuth'], function () {
    Route::post('/', [StoreController::class, 'createUserStore'])->name('store.post');
    Route::post('/{storeId}', [StoreController::class, 'updateUserStore'])->name('store.update');
});
