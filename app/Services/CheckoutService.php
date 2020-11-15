<?php

namespace App\Services;

use App\Repositories\Checkout\CheckoutInterfaceRepository;

class CheckoutService
{
    /**
     * @var CheckoutInterfaceRepository
     */
    protected $checkoutRepo;

    /**
     * @param CheckoutInterfaceRepository $checkoutRepo
     */
    public function __construct(CheckoutInterfaceRepository $checkoutRepo)
    {
        $this->checkoutRepo = $checkoutRepo;
    }

    public function checkout($carts, string $userId)
    {
    }
}
