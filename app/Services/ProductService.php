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

    /**
     * @param string $productId
     * @param string $userId
     * 
     * @return Product
     */
    public function getOwnerProduct(string $productId, string $userId): Product
    {
        return $this->productRepo->getSingleBy(['id' => $productId, 'owner_id' => $userId]);
    }

    /**
     * @param string $productId
     * 
     * @return Product
     */
    public function getProduct(string $productId): Product
    {
        return $this->productRepo->getSingleBy(['id' => $productId, 'active' => true]);
    }

    /**
     * @param array $data
     * @param Product $product
     * 
     * @return Product
     */
    public function update(Product $product, array $data): Product
    {
        $this->productRepo->update($product, $data);
        $product->refresh();
        return $product;
    }
}
