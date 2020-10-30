<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Response\ErrorResponse;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $ownerId = $request->store_id ?? auth()->id();
            $product = $this->productService->create(array_merge($request->validated(), ['owner_id' => $ownerId]));
            DB::commit();
            return response()->json(ProductResource::make($product), 200);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
