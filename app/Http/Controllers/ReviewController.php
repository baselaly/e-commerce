<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ProductReviewRequest;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Resources\Response\ErrorResponse;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    /**
     * reviewService
     *
     * @var ReviewService
     */
    private $reviewService;

    /**
     * __construct
     *
     * @param  ReviewService $reviewService
     * @return void
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * reviewProduct
     *
     * @param  ProductReviewRequest $request
     * @return void
     */
    public function reviewProduct(ProductReviewRequest $request)
    {
        try {
        } catch (\Throwable$t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    /**
     * reviewStore
     *
     * @param  StoreReviewRequest $request
     * @return void
     */
    public function reviewStore(StoreReviewRequest $request)
    {
        try {

        } catch (\Throwable$t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
