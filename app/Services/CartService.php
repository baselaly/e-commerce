<?php

namespace App\Services;

use App\Models\Cart;
use App\Repositories\Cart\CartInterfaceRepository;

class CartService
{
    /**
     * @var CartInterfaceRepository
     */
    protected $cartRepo;

    /**
     * @param CartInterfaceRepository $cartRepo
     */
    public function __construct(CartInterfaceRepository $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    /**
     * @param array $data
     * 
     * @return Cart
     */
    public function addToCart(array $data): Cart
    {
        return $this->cartRepo->create($data);
    }
}
