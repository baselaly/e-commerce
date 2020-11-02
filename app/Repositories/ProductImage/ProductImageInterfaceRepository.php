<?php

namespace App\Repositories\ProductImage;

use App\Models\ProductImage;

interface ProductImageInterfaceRepository
{
    /**
     * @param array $data
     * 
     * @return ProductImage
     */
    public function getSingleBy(array $data): ProductImage;

    /**
     * @param ProductImage $productImage
     * 
     * @return bool
     */
    public function delete(ProductImage $productImage): bool;
}
