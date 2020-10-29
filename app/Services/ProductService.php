<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Product\ProductInterfaceRepository;

class ProductService
{

    protected $productRepo;

    public function __construct(ProductInterfaceRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * @param string $type
     * @param string $ownerId
     * 
     * @return Product
     */
    public function create(array $data): Product
    {
        $ownerable_type = $data['type'] === 'user' ? 'App\Models\User' : 'App\Models\Store';

        $product = array_merge($data, ['ownerable_type' => $ownerable_type]);

        $images = array();
        foreach ($data['images'] as $image) {
            $images[]['image'] = $image;
        }

        $product = $this->productRepo->create($product);
        $product->images()->createMany($images);
        return $product;
    }
}
