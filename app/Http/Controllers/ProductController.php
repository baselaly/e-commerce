<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Response\ErrorResponse;
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
            $product = $this->productService->create(array_merge($request->validated(), ['ownerable_id' => $ownerId]));
            DB::commit();
            return response()->json(ProductResource::make($product), 200);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getOwnerProduct($id)
    {
        try {
            return response()->json(ProductResource::make($this->productService->getSingleProductBy(['id' => $id, 'owner_id' => auth()->id])), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getProduct($id)
    {
        try {
            return response()->json(ProductResource::make($this->productService->getSingleProductBy(['id' => $id, 'active' => true])), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function updateProduct($id, UpdateProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = $this->productService->getSingleProductBy(['id' => $id, 'owner_id' => auth()->id()]);
            if (request('images') && count(request('images')) + $product->images->count() > 5) {
                return response()->json(new ErrorResponse('There will be more than 5 images for this product'), 403);
            }
            $product = $this->productService->update($product, $request->validated());
            DB::commit();
            return response()->json(ProductResource::make($product), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function changeProductStatus($id)
    {
        try {
            $product = $this->productService->getSingleProductBy(['id' => $id, 'owner_id' => auth()->id()]);
            return response()->json(ProductResource::make($this->productService->update($product, ['active' => !$product->active])), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function changeFeatured($id)
    {
        try {
            $product = $this->productService->getSingleProductBy(['id' => $id, 'store_id' => auth()->user()->store->id]);
            return response()->json(ProductResource::make($this->productService->update($product, ['featured' => !$product->featured])), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getProducts()
    {
        try {
            return ProductCollection::collection($this->productService->getProducts(['active' => true]));
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getUserProducts($userId)
    {
        try {
            return ProductCollection::collection($this->productService->getProducts(['active' => true, 'user_id' => $userId]));
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getStoreProducts($storeId)
    {
        try {
            return ProductCollection::collection($this->productService->getProducts(['active' => true, 'store_id' => $storeId]));
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
