<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\QueryFilters\Product\ActiveFilter;
use App\QueryFilters\Product\IdFilter;
use App\QueryFilters\Product\OwnerFilter;
use App\QueryFilters\Product\StoreFilter;
use App\QueryFilters\Product\UserFilter;
use Illuminate\Pipeline\Pipeline;

class ProductRepository implements ProductInterfaceRepository
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @param Product $store
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
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
            new OwnerFilter($filters),
            new StoreFilter($filters),
            new ActiveFilter($filters),
            new UserFilter($filters),
        ];
    }

    /**
     * @param array $data
     *
     * @return Product
     */
    public function create(array $data): Product
    {
        return $this->product->create($data);
    }

    /**
     * @param array $data
     *
     * @return Product
     */
    public function getSingleBy(array $data): Product
    {
        return app(Pipeline::class)
            ->send($this->product->query())
            ->through($this->filters($data))
            ->thenReturn()
            ->latest()->firstOrFail();
    }

    /**
     * @param Product $product
     * @param array $data
     *
     * @return bool
     */
    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    /**
     * @param array $filters
     * @param int $paginate
     *
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0)
    {
        $products = app(Pipeline::class)
            ->send($this->product->query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->latest();

        return $perPage ? $products->paginate($perPage) : $products->get();
    }
}
