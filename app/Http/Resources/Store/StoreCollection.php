<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'user_id' => (string)$this->user_id,
            'name' => (string)$this->name,
            'phone' => (string)$this->phone,
            'address' => (string)$this->address,
            'logo' => (string)$this->logo
        ];
    }
}
