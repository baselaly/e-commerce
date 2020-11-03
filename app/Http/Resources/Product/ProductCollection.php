<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
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
            'name' => (string) $this->name,
            'quantity' => (int) $this->quantity,
            'price' => (float) $this->price,
            'thumbnail' => (string) $this->thumbnail,
            'featured' => (bool) $this->featured
        ];
    }
}
