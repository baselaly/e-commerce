<?php

namespace App\Repositories\Review;

use App\Models\Review;

class ReviewRepository implements ReviewInterfaceRepository
{
    /**
     * review
     *
     * @var Review
     */
    private $review;

    /**
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * filters
     *
     * @return array
     */
    public function filters(array $filters): array
    {
        return [
        ];
    }

    /**
     * @param array $data
     *
     * @return Review
     */
    public function create(array $data): Review
    {
        return $this->review->create($data);
    }

    /**
     * @param array $filters
     * @param int $paginate
     *
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0)
    {
        $reviews = app(Pipeline::class)
            ->send($this->review->query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->latest();

        return $perPage ? $reviews->paginate($perPage) : $reviews->get();
    }
}
