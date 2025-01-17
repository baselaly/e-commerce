<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'image' => (string)$this->image,
            'active' => (bool)$this->active,
            'verified' => (bool)$this->verified,
            'phone' => (string)$this->phone,
            'email' => (string)$this->email
        ];
    }
}
