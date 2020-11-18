<?php

namespace App\Repositories\Checkout;

use App\Models\Checkout;
use Illuminate\Pipeline\Pipeline;

class CheckoutRepository implements CheckoutInterfaceRepository
{
    /**
     * @var Checkout
     */
    private $checkout;

    /**
     * @param Checkout $checkout
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * @param array $data
     * 
     * @return Checkout
     */
    public function create(array $data): Checkout
    {
        return $this->checkout->create($data);
    }

    /**
     * @param array $data
     * 
     * @return Checkout
     */
    public function getSingleBy(array $data): Checkout
    {
        return app(Pipeline::class)
            ->send($this->checkout->query())
            ->through([])
            ->thenReturn()
            ->latest()->firstOrFail();
    }

    /**
     * @param Checkout $checkout
     * @param array $data
     * 
     * @return bool
     */
    public function update(Checkout $checkout, array $data): bool
    {
        return $checkout->update($data);
    }

    /**
     * @param array $filters
     * @param int $paginate
     * 
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0)
    {
        $checkouts = app(Pipeline::class)
            ->send($this->checkout->query())
            ->through([])
            ->thenReturn()
            ->latest();
        return $perPage ? $checkouts->paginate($perPage) : $checkouts->get();
    }

    /**
     * @param Checkout $checkout
     * 
     * @return bool
     */
    public function delete(Checkout $checkout): bool
    {
        return $checkout->delete();
    }
}
