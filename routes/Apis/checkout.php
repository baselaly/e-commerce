<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'checkouts', 'middleware' => 'userAuth'], function () {
    Route::post('/', [CheckoutController::class, 'store'])->name('checkouts.store');
});
