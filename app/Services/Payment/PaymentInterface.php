<?php

namespace App\Services\Payment;

interface PaymentInterface
{
    /**
     * @param mixed $carts
     * 
     * @return array
     */
    public function pay($carts): array;
}
