<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\ExecutePaymentRequest;
use App\Http\Requests\Checkout\StoreRequest;
use App\Http\Resources\Response\ErrorResponse;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\Payment\PaymentFactory;
use App\Services\Payment\PaypalService;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(StoreRequest $request, CartService $cartService)
    {
        try {
            $carts = $cartService->getCartsBy(['user_id' => auth()->id()]);
            $paymentService = PaymentFactory::initialize(request('type'));
            DB::beginTransaction();
            $checkoutArray = $paymentService->pay($carts);
            DB::commit();
            return response()->json($checkoutArray);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function executePayment(ExecutePaymentRequest $request, CheckoutService $checkoutService, CartService $cartService, PaypalService $paypalService)
    {
        try {
            $carts = $cartService->getCartsBy(['user_id' => auth()->id()]);
            DB::beginTransaction();
            $paypalService->executePayment($request->validated());
            $checkoutData = ['user_id' => auth()->id(), 'type' => 'paypal', 'paid' => true];
            $checkout = $checkoutService->createCheckout($checkoutData, $carts);
            DB::commit();
            return response()->json(['checkout' => $checkout]);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
