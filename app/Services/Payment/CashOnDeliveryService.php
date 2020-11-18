<?php

namespace App\Services\Payment;

use App\Models\Checkout;
use App\Services\CheckoutService;
use App\Repositories\Checkout\CheckoutInterfaceRepository;

class CashOnDeliveryService implements PaymentInterface
{
    /**
     * @param mixed $carts
     * 
     * @return array
     */
    public function pay($carts): array
    {
        $checkoutModel = new Checkout;
        $checkoutRepo = new CheckoutInterfaceRepository($checkoutModel);
        $checkoutService = new CheckoutService($checkoutRepo);
        $checkoutData = ['user_id' => $carts[0]['user_id'], 'type' => 'cash on delivery', 'paid' => false];
        $checkout = $checkoutService->createCheckout($checkoutData, $carts);
        return [
            'message' => 'Your checkout via cash on delivery is Done',
            'payment_method' => 'cash on delivery',
            'checkout' => $checkout
        ];
    }
}
