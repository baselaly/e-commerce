<?php

namespace App\Http\Controllers;

use App\Http\Requests\Like\ProductLikeRequest;
use App\Http\Resources\Response\ErrorResponse;
use App\Services\LikeService;

class LikeController extends Controller
{
    /**
     * likeService
     *
     * @var LikeService
     */
    private $likeService;

    /**
     * __construct
     *
     * @param LikeService $likeService
     * @return void
     */
    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function likeProduct(ProductLikeRequest $request)
    {
        $likeData = ['user_id' => auth()->id(), 'likeable_id' => request('product_id'), 'likeable_type' => 'App\Models\Product'];
        try {
            $like = $this->likeService->getSingleBy($likeData);
            $like = $this->likeService->delete($like);
            return response()->json(['like' => $like], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException$e) {
            $like = $this->likeService->create($likeData);
            return response()->json(['like' => $like], 200);
        } catch (\Throwable$e) {
            return response()->json(new ErrorResponse($e->getMessage()), 500);
        }
    }
}