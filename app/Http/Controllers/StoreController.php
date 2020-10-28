<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreRequest;
use App\Http\Resources\Response\ErrorResponse;
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
            if ($store = auth()->user()->store) {
                return response()->json(new ErrorResponse('This User already Have one store'), 403);
            }
            $store = $this->storeService->createStore(auth()->id());
            return $store;
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
