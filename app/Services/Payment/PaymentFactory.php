<?php

namespace App\Services\Payment;

class PaymentFactory
{
    public static function initialize(string $type): PaymentInterface
    {
        switch ($type) {
            case 'paypal':
                return new PaypalService;
            case 'cash on delivery':
                return new CashOnDeliveryService;
            default:
                throw new \Exception("Payment method not supported");
                break;
        }
    }
}
