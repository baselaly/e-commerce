<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\Store;

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
}
