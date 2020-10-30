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
}
