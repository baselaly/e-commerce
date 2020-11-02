<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\QueryFilters\Product\IdFilter;
use App\QueryFilters\Product\OwnerFilter;
use App\QueryFilters\Product\StoreFilter;
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
            ->through([
                new IdFilter($data),
                new OwnerFilter($data),
                new StoreFilter($data)
            ])
            ->thenReturn()
            ->firstOrFail();
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }
}
