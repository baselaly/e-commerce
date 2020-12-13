<?php

namespace App\Repositories\Like;

use App\Models\Like;

interface LikeInterfaceRepository
{
    /**
     * @param array $data
     *
     * @return Like
     */
    public function create(array $data): Like;

    /**
     * @param array $data
     *
     * @return Like
     */
    public function getSingleBy(array $data): Like;

    /**
     * @param Like $Like
     * @param array $data
     *
     * @return bool
     */
    public function update(Like $Like, array $data): bool;

    /**
     * @param array $filters
     * @param int $perPage
     *
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0);

    /**
     * delete
     *
     * @param Like $like
     * @return bool
     */
    public function delete(Like $like): bool;

    /**
     * @return array
     */
    public function filters(array $filters): array;
}
