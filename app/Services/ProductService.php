<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Product\ProductInterfaceRepository;
use Illuminate\Database\Eloquent\Collection;

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
     * @param array $data
     * 
     * @return Product
     */
    public function getSingleProductBy(array $data = []): Product
    {
        return $this->productRepo->getSingleBy($data);
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
        if (isset($data['images'])) {
            $images = array();

            foreach ($data['images'] as $image) {
                $images[]['image'] = $image;
            }

            $product->images()->createMany($images);
        }
        $product->refresh();
        return $product;
    }

    /**
     * @param array $filters
     * @param int $paginate
     * 
     * @return [type]
     */
    public function getProducts(array $filters = [], int $perPage = 0)
    {
        return $this->productRepo->getAll($filters, $perPage);
    }
}
