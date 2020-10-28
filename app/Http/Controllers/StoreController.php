<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreRequest;
use App\Http\Resources\Response\ErrorResponse;
use App\Http\Resources\Store\StoreResource;
use App\Services\StoreService;

class StoreController extends Controller
{
    protected $storeService;

    /**
     * @param StoreService $storeService
     */
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * @param StoreRequest $request
     * 
     * @return [type]
     */
    public function createUserStore(StoreRequest $request)
    {
        try {
            if (auth()->user()->store) {
                return response()->json(new ErrorResponse('This User already Have one store'), 403);
            }
            return response()->json(StoreResource::make($this->storeService->createStore(auth()->id())));
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function updateUserStore($storeId, StoreRequest $request)
    {
        try {
            return response()->json(StoreResource::make($this->storeService->updateStore(auth()->id(), $storeId)));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
