<?php

namespace App\Http\Controllers;

use App\Http\Resources\Response\ErrorResponse;
use App\Http\Resources\Response\SuccessResponse;
use App\Services\ProductImageService;

class ProductImageController extends Controller
{
    protected $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

    public function delete($id)
    {
        try {
            $productImage = $this->productImageService->getImageByOwner($id, auth()->id());
            if ($productImage->product->images->count() === 1) {
                return response()->json(new ErrorResponse('Not Authorized, Last Product Image'), 403);
            }
            $this->productImageService->delete($productImage);
            return response()->json(new SuccessResponse('Image Deleted'), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
