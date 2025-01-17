<?php

namespace App\Repositories\Store;

use App\Models\Store;
use App\QueryFilters\Store\IdFilter;
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
     * filters
     *
     * @return array
     */
    public function filters(array $filters): array
    {
        return [
            new UserIdFilter($filters),
            new IdFilter($filters),
        ];
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
            ->through($this->filters($data))
            ->thenReturn()
            ->firstOrFail();
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

    /**
     * @param array $filters
     * @param int $paginate
     *
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0)
    {
        $stores = app(Pipeline::class)
            ->send($this->store->query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->latest();

        return $perPage ? $stores->paginate($perPage) : $stores->get();
    }
}
