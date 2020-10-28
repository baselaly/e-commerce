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
}
