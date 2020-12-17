<?php

namespace App\Repositories\Review;

use App\Models\Review;

interface ReviewInterfaceRepository
{
    /**
     * @param array $data
     *
     * @return Review
     */
    public function create(array $data): Review;

    /**
     * @param array $filters
     * @param int $perPage
     *
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0);

    /**
     * @param array $data
     *
     * @return Review
     */
    public function getSingleBy(array $data): Review;

    /**
     * @return array
     */
    public function filters(array $filters): array;
}
