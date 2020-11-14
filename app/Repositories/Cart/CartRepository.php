<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\QueryFilters\Cart\IdFilter;
use App\QueryFilters\Cart\ProductFilter;
use App\QueryFilters\Cart\UserFilter;
use Illuminate\Pipeline\Pipeline;

class CartRepository implements CartInterfaceRepository
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @param Cart $store
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @param array $data
     * 
     * @return Cart
     */
    public function create(array $data): Cart
    {
        return $this->cart->create($data);
    }

    /**
     * @param array $data
     * 
     * @return Cart
     */
    public function getSingleBy(array $data): Cart
    {
        return app(Pipeline::class)
            ->send($this->cart->query())
            ->through([
                new IdFilter($data),
                new UserFilter($data),
                new ProductFilter($data)
            ])
            ->thenReturn()
            ->latest()->firstOrFail();
    }

    /**
     * @param Cart $Cart
     * @param array $data
     * 
     * @return bool
     */
    public function update(Cart $cart, array $data): bool
    {
        return $cart->update($data);
    }

    /**
     * @param array $filters
     * @param int $paginate
     * 
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 10)
    {
        return app(Pipeline::class)
            ->send($this->cart->query())
            ->through([
                new IdFilter($filters),
                new UserFilter($filters),
                new ProductFilter($filters)
            ])
            ->thenReturn()
            ->latest()->paginate($perPage);
    }

    public function delete(Cart $cart): bool
    {
        return $cart->delete();
    }
}
