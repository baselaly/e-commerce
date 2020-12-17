<?php

namespace App\Services;

use App\Models\Review;
use App\Repositories\Review\ReviewInterfaceRepository;

class ReviewService
{
    /**
     * reviewRepo
     *
     * @var ReviewInterfaceRepository
     */
    private $reviewRepo;

    /**
     * __construct
     *
     * @param ReviewInterfaceRepository $reviewRepo
     * @return void
     */
    public function __construct(ReviewInterfaceRepository $reviewRepo)
    {
        $this->reviewRepo = $reviewRepo;
    }

    /**
     * createReview
     *
     * @param array $data
     * @return Review
     */
    public function create(array $data): Review
    {
        return $this->reviewRepo->create($data);
    }

    /**
     * getSingleReview
     *
     * @param array $filters
     * @return Review
     */
    public function getSingleReview(array $filters = []): Review
    {
        return $this->reviewRepo->getSingleBy($filters);
    }
}
