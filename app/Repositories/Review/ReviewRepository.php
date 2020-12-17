<?php

namespace App\Repositories\Review;

use App\Models\Review;
use App\QueryFilters\Review\ReviewableIdFilter;
use App\QueryFilters\Review\ReviewableTypeFilter;
use App\QueryFilters\Review\UserFilter;
use Illuminate\Pipeline\Pipeline;

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
            new ReviewableTypeFilter($filters),
            new ReviewableIdFilter($filters),
            new UserFilter($filters),
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
     * @param array $data
     *
     * @return Review
     */
    public function getSingleBy(array $data): Review
    {
        return app(Pipeline::class)
            ->send($this->review->query())
            ->through($this->filters($data))
            ->thenReturn()
            ->latest()->firstOrFail();
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
