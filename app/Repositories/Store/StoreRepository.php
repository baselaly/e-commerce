<?php

namespace App\Repositories\Store;

use App\Models\Store;
use App\QueryFilters\Store\UserIdFilter;
use Illuminate\Pipeline\Pipeline;

class StoreRepository implements StoreInterfaceRepository
{
    /**
     * @var Store
     */
    private $store;

    /**
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @param array $data
     * 
     * @return Store
     */
    public function create(array $data): Store
    {
        return $this->store->create($data);
    }

    /**
     * @return Store
     */
    public function getSingleBy(array $data): Store
    {
        return app(Pipeline::class)
            ->send($this->store->query())
            ->through([
                new UserIdFilter($data)
            ])
            ->thenReturn()
            ->first();
    }

    /**
     * @param Store $store
     * @param array $data
     * 
     * @return bool
     */
    public function update(Store $store, array $data): bool
    {
        return $store->update($data);
    }
}
