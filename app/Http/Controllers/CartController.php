<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\Response\ErrorResponse;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(CartStoreRequest $request, ProductService $productService)
    {
        try {
            DB::beginTransaction();
            $product = $productService->getSingleProductBy(['id' => $request->product_id, 'active' => true]);
            if ($product->quantity < $request->quantity) {
                return response()->json(new ErrorResponse('Ordered Quantity is more than Product Quantity'), 403);
            }
            $cart = $this->cartService->addToCart(array_merge($request->validated(), ['user_id' => auth()->id()]));
            DB::commit();
            return response()->json(CartResource::make($cart));
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function update($id, CartUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $cart = $this->cartService->getSingleCartBy(['id' => $id, 'user_id' => auth()->id()]);
            if ($cart->product->quantity + $cart->quantity < $request->quantity) {
                return response()->json(new ErrorResponse('Ordered Quantity is more than Product Quantity'), 403);
            }
            $cart = $this->cartService->updateCart($cart, $request->validated());
            DB::commit();
            return response()->json(CartResource::make($cart));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function delete($id)
    {
        try {
            $cart = $this->cartService->getSingleCartBy(['id' => $id, 'user_id' => auth()->id()]);
            $this->cartService->deleteCart($cart);
            return response()->json(CartResource::make($cart));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
