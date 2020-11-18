<?php

namespace App\Services;

use App\Models\Checkout;
use App\Repositories\Checkout\CheckoutInterfaceRepository;

class CheckoutService
{
    protected $checkoutRepo;

    public function __construct(CheckoutInterfaceRepository $checkoutRepo)
    {
        $this->checkoutRepo = $checkoutRepo;
    }

    /**
     * @param array $data
     * @param mixed $carts
     * 
     * @return Checkout
     */
    public function createCheckout(array $data, $carts): Checkout
    {
        $checkout = $this->checkoutRepo->create($data);
        $orders = array();
        foreach ($carts as $cart) {
            array_push($orders, [
                'price' => $cart->product->price,
                'quantity' => $cart->quantity,
                'product_id' => $cart->product_id
            ]);
            $cart->delete();
        }
        $checkout->orders()->createMany($orders);
        return $checkout;
    }

    /**
     * @param array $data
     * 
     * @return Checkout
     */
    public function getSingleCheckoutBy(array $data = []): Checkout
    {
        return $this->checkoutRepo->getSingleBy($data);
    }

    /**
     * @param array $data
     * @param Checkout $checkout
     * 
     * @return Checkout
     */
    public function update(Checkout $checkout, array $data): Checkout
    {
        $this->checkoutRepo->update($checkout, $data);
        $checkout->refresh();
        return $checkout;
    }

    /**
     * @param array $filters
     * @param int $paginate
     * 
     * @return [type]
     */
    public function getCheckoutsBy(array $filters = [], int $perPage = 0)
    {
        return $this->checkoutRepo->getAll($filters, $perPage);
    }
}
