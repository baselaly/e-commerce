<?php

namespace App\Repositories\Store;

use App\Models\Store;

interface StoreInterfaceRepository
{
    /**
     * @param array $data
     * 
     * @return Store
     */
    public function create(array $data): Store;

    /**
     * @param array $data
     * 
     * @return Store
     */
    public function getSingleBy(array $data): Store;

    /**
     * @param Store $user
     * @param array $data
     * 
     * @return bool
     */
    public function update(Store $user, array $data): bool;
}
