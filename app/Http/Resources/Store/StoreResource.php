<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'user_id' => (string)$this->user_id,
            'name' => (string)$this->user_id,
            'phone' => (string)$this->user_id,
            'address' => (string)$this->address,
            'logo' => (string)$this->logo
        ];
    }
}
