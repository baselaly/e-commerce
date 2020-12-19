<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ProductReviewRequest;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Resources\Response\ErrorResponse;
use App\Http\Resources\Review\ReviewResource;
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
        $reviewData = ['user_id' => auth()->id(), 'reviewable_id' => request('product_id'), 'reviewable_type' => 'App\Models\Product'];
        try {
            $this->reviewService->getSingleReview(array_merge($reviewData, ['body' => request('body')]));
            return response()->json(new ErrorResponse('You Already Have Review on this product!'), 400);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException$e) {
            $review = $this->reviewService->create(array_merge($reviewData, ['body' => request('body')]));
            return response()->json(['review' => ReviewResource::make($review)], 200);
        } catch (\Throwable$e) {
            return response()->json(new ErrorResponse($e->getMessage()), 500);
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
        $reviewData = ['user_id' => auth()->id(), 'reviewable_id' => request('store_id'), 'reviewable_type' => 'App\Models\Store'];
        try {
            $this->reviewService->getSingleReview(array_merge($reviewData, ['body' => request('body')]));
            return response()->json(new ErrorResponse('You Already Have Review on this store!'), 400);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException$e) {
            $review = $this->reviewService->create(array_merge($reviewData, ['body' => request('body')]));
            return response()->json(['review' => ReviewResource::make($review)], 200);
        } catch (\Throwable$e) {
            return response()->json(new ErrorResponse($e->getMessage()), 500);
        }
    }
}
