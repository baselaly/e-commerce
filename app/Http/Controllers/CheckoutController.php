<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\ExecutePaymentRequest;
use App\Http\Requests\Checkout\StoreRequest;
use App\Http\Resources\Response\ErrorResponse;
use App\Services\CartService;
use App\Services\Payment\PaymentFactory;
use App\Services\Payment\PaypalService;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(StoreRequest $request, CartService $cartService)
    {
        try {
            DB::beginTransaction();
            $carts = $cartService->getCartsBy(['user_id' => auth()->id()]);
            $paymentService = PaymentFactory::initialize(request('type'));
            $checkoutArray = $paymentService->pay($carts);
            DB::commit();
            return response()->json($checkoutArray);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function executePayment(ExecutePaymentRequest $request, CartService $cartService, PaypalService $paypalService)
    {
        try {
            DB::beginTransaction();
            $carts = $cartService->getCartsBy(['user_id' => auth()->id()]);
            $paypalService->executePayment($request->validated());
            DB::commit();
            return response()->json(['message' => 'checkout done successfully']);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
