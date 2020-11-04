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
     * @param Product $product
     * @param array $data
     * 
     * @return Cart
     */
    public function addToCart(array $data): Cart
    {
        $cart = $this->cartRepo->create($data);
        $cart->product->decrement('quantity', $data['quantity']);
        return $cart;
    }
}
