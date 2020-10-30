<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => (string)$this->name,
            'description' => (string)$this->description,
            'quantity' => (int)$this->quantity,
            'price' => (float)$this->price,
            'images' => (array) $this->images->pluck('image')->toArray(),
            'thumbnail' => (string)$this->thumbnail,
            'active' => (bool)$this->active
        ];
    }
}
