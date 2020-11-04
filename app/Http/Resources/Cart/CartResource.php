<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'product_name' => (string)$this->product->name,
            'product_quantity' => (int)$this->product->quantity,
            'total' => (float)$this->total,
            'quantity' => (int)$this->quantity,
            'thumbnail' => (string)$this->product->thumbnail
        ];
    }
}
