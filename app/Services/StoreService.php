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
     * @param string $userId
     * @param string $storeId
     * 
     * @return bool
     */
    public function updateStore(array $data, string $storeId): Store
    {
        $userStore = $this->storeRepo->getSingleBy(['user_id' => $data['user_id'], 'id' => $storeId]);

        $this->storeRepo->update($userStore, $data);
        $userStore->refresh();
        return $userStore;
    }
}
