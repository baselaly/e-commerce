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
            return response()->json(StoreResource::make($this->storeService->createStore(array_merge($request->validated(), ['user_id' => auth()->id()]))));
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function updateUserStore($id, StoreRequest $request)
    {
        try {
            $store = $this->storeService->getSingleStoreBy(['id' => $id, 'user_id' => auth()->id()]);
            return response()->json(StoreResource::make($this->storeService->updateStore($store, $request->validated())));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getStore($id)
    {
        try {
            return response()->json(StoreResource::make($this->storeService->getSingleStoreBy(['id' => $id])));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getMyStore()
    {
        try {
            return response()->json(StoreResource::make($this->storeService->getSingleStoreBy(['user_id' => auth()->id()])));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
