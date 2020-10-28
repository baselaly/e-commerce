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
    public function createStore(string $userId): Store
    {
        $data = [
            'name' => request('name'),
            'phone' => request('phone'),
            'address' => request('address'),
            'user_id' => $userId
        ];

        request('logo') ? $data['logo'] = request('logo') : '';

        return $this->storeRepo->create($data);
    }

    /**
     * @param string $userId
     * @param string $storeId
     * 
     * @return bool
     */
    public function updateStore(string $userId, string $storeId): Store
    {
        $store = $this->storeRepo->getSingleBy(['user_id' => $userId, 'id' => $storeId]);

        $data = [
            'name' => request('name'),
            'phone' => request('phone'),
            'address' => request('address'),
            'user_id' => $userId
        ];

        request('logo') ? $data['logo'] = request('logo') : '';

        $this->storeRepo->update($store, $data);
        $store->refresh();

        return $store;
    }
}
