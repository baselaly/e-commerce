<?php

namespace App\Repositories\Checkout;

use App\Models\Checkout;

interface CheckoutInterfaceRepository
{
    /**
     * @param array $data
     * 
     * @return Checkout
     */
    public function create(array $data): Checkout;

    /**
     * @param array $data
     * 
     * @return Checkout
     */
    public function getSingleBy(array $data): Checkout;

    /**
     * @param Checkout $checkout
     * @param array $data
     * 
     * @return bool
     */
    public function update(Checkout $checkout, array $data): bool;

    /**
     * @param array $filters
     * @param int $perPage
     * 
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0);

    /**
     * @param Checkout $checkout
     * 
     * @return bool
     */
    public function delete(Checkout $checkout): bool;
}
