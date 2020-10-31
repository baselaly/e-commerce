<?php

namespace App\Services;

use App\Models\Store;
use App\Repositories\Store\StoreInterfaceRepository;

class StoreService
{
    /**
     * @var StoreInterfaceRepository
     */
    private $storeRepo;

    /**
     * @param StoreInterfaceRepository $storeRepo
     */
    public function __construct(StoreInterfaceRepository $storeRepo)
    {
        $this->storeRepo = $storeRepo;
    }

    /**
     * @param string $userId
     * 
     * @return Store
     */
    public function createStore(array $data): Store
    {
        return $this->storeRepo->create($data);
    }

    /**
     * @param string $storeId
     * @param string $userId
     * 
     * @return Store
     */
    public function getUserStore(string $storeId, string $userId): Store
    {
        return $this->storeRepo->getSingleBy(['user_id' => $userId, 'id' => $storeId]);
    }

    /**
     * @param Store $store
     * @param array $data
     * 
     * @return Store
     */
    public function updateStore(Store $store, array $data): Store
    {
        $this->storeRepo->update($store, $data);
        $store->refresh();
        return $store;
    }
}
