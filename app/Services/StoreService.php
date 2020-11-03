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
     * @param array $data
     * 
     * @return Store
     */
    public function getSingleStoreBy(array $data = []): Store
    {
        return $this->storeRepo->getSingleBy($data);
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

    /**
     * @param array $filters
     * @param int $paginate
     * 
     * @return [type]
     */
    public function getStores(array $filters = [], int $perPage = 10)
    {
        return $this->storeRepo->getAll($filters, $perPage);
    }
}
