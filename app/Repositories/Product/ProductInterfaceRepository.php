<?php

namespace App\Repositories\Product;

use App\Models\Product;

interface ProductInterfaceRepository
{
    /**
     * @param array $data
     * 
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * @param array $data
     * 
     * @return Product
     */
    public function getSingleBy(array $data): Product;

    /**
     * @param Product $product
     * @param array $data
     * 
     * @return bool
     */
    public function update(Product $product, array $data): bool;
}
