<?php

namespace App\Services;

use App\Models\ProductImage;
use App\Repositories\ProductImage\ProductImageInterfaceRepository;

class ProductImageService
{
    /**
     * @var ProductImageInterfaceRepository
     */
    private $productImageRepo;

    /**
     * @param UserInterfaceRepository $userRepo
     */
    public function __construct(ProductImageInterfaceRepository $productImageRepo)
    {
        $this->productImageRepo = $productImageRepo;
    }

    /**
     * @param string $id
     * @param string $ownerId
     * 
     * @return ProductImage
     */
    public function getImageByOwner(string $id, string $ownerId): ProductImage
    {
        return $this->productImageRepo->getSingleBy(['id' => $id, 'owner_id' => $ownerId]);
    }

    /**
     * @param ProductImage $productImage
     * 
     * @return ProductImage
     */
    public function delete(ProductImage $productImage): ProductImage
    {
        $this->productImageRepo->delete($productImage);
        return $productImage;
    }
}
