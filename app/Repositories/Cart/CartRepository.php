<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\QueryFilters\Cart\CreatedAtFilter;
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
     * filters
     *
     * @return array
     */
    public function filters(array $filters): array
    {
        return [
            new IdFilter($filters),
            new UserFilter($filters),
            new ProductFilter($filters),
            new CreatedAtFilter($filters),
        ];
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
            ->through($this->filters($data))
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
    public function getAll(array $filters = [], int $perPage = 0)
    {
        $carts = app(Pipeline::class)
            ->send($this->cart->query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->latest();

        return $perPage ? $carts->paginate($perPage) : $carts->get();
    }

    /**
     * @param Cart $cart
     *
     * @return bool
     */
    public function delete(Cart $cart): bool
    {
        return $cart->delete();
    }
}
