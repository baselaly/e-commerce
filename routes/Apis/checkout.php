<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'checkouts', 'middleware' => 'userAuth', 'hasCart'], function () {
    Route::post('/', [CheckoutController::class, 'store'])->name('checkouts.store');
    Route::get('/paypal/success', [CheckoutController::class, 'store'])->name('success.paypal'); // should replaced with vue components
    Route::get('/paypal/fail', [CheckoutController::class, 'store'])->name('cancel.paypal'); // should replaced with vue components
    Route::post('/paypal/execute', [CheckoutController::class, 'executePayment'])->name('execute.paypal');
});
