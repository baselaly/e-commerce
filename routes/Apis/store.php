<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'store'], function () {
    Route::post('/', [StoreController::class, 'createUserStore']);
});
