<?php

namespace App\Http\Controllers;

use App\Http\Resources\Response\ErrorResponse;
use App\Services\CartService;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    /**
     * @var CheckoutService
     */
    protected $checkoutService;

    /**
     * @param CheckoutService $checkoutService
     */
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function store(CartService $cartService)
    {
        try {
            $carts = $cartService->getCartsBy(['user_id' => auth()->id()]);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
