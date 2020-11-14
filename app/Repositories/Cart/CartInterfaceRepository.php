<?php

namespace App\Repositories\Cart;

use App\Models\Cart;

interface CartInterfaceRepository
{
    /**
     * @param array $data
     * 
     * @return Cart
     */
    public function create(array $data): Cart;

    /**
     * @param array $data
     * 
     * @return Cart
     */
    public function getSingleBy(array $data): Cart;

    /**
     * @param Cart $cart
     * @param array $data
     * 
     * @return bool
     */
    public function update(Cart $cart, array $data): bool;

    /**
     * @param array $filters
     * @param int $perPage
     * 
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 10);

    /**
     * @param Cart $cart
     * 
     * @return bool
     */
    public function delete(Cart $cart): bool;
}
