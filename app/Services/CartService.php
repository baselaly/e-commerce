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
        try {
            $cart = $this->getSingleCartBy(['user_id' => $data['user_id'], 'product_id' => $data['product_id']]);
            $cart->increment('quantity', $data['quantity']);
            $cart->product->decrement('quantity', $data['quantity']);
            return $cart;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $cart = $this->cartRepo->create($data);
            $cart->product->decrement('quantity', $data['quantity']);
            return $cart;
        }
    }

    /**
     * @param array $data
     * 
     * @return Cart
     */
    public function getSingleCartBy(array $data = []): Cart
    {
        return $this->cartRepo->getSingleBy($data);
    }

    /**
     * @param Cart $cart
     * @param array $data
     * 
     * @return Cart
     */
    public function updateCart(Cart $cart, array $data): Cart
    {
        $quantityDiff = $cart->quantity - $data['quantity'];

        $this->cartRepo->update($cart, $data);
        $cart->refresh();

        if ($quantityDiff !== 0) {
            $cart->product->increment('quantity', $quantityDiff);
        }

        return $cart;
    }
}
