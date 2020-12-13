<?php

namespace App\Repositories\ProductImage;

use App\Models\ProductImage;
use App\QueryFilters\ProductImage\IdFilter;
use App\QueryFilters\ProductImage\OwnerFilter;
use Illuminate\Pipeline\Pipeline;

class ProductImageRepository implements ProductImageInterfaceRepository
{
    /**
     * @var ProductImage
     */
    private $productImage;

    /**
     * @param ProductImage $ProductImage
     */
    public function __construct(ProductImage $productImage)
    {
        $this->productImage = $productImage;
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
        ];
    }

    public function getSingleBy(array $data): ProductImage
    {
        return app(Pipeline::class)
            ->send($this->productImage->query())
            ->through($this->filters($data))
            ->thenReturn()
            ->firstOrFail();
    }

    /**
     * @param ProductImage $productImage
     *
     * @return bool
     */
    public function delete(ProductImage $productImage): bool
    {
        return $productImage->delete();
    }
}
