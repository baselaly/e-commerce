<?php

namespace Basel\RepositoryPipeline;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * getPipelineFilters
     *
     * @param string $model
     * @param array $filters
     * @return array
     */
    public static function getPipelineFilters(string $model, array $filters = []): array;

    /**
     * get
     *
     * @param Model $model
     * @param array $filters
     * @return Collection|LengthAwarePaginator
     */
    public static function get(string $model, array $filters, int $perPage = 0): Collection|LengthAwarePaginator;

    /**
     * update
     *
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool;

    /**
     * find
     *
     * @param string $model
     * @param array $filters
     * @return mixed
     */
    public static function find(string $model, array $filters = []): mixed;

    /**
     * delete
     *
     * @param mixed $model
     * @return bool
     */
    public function delete(Model $model): bool;
}
