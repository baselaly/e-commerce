<?php

namespace App\Http\Resources\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class NotAuthorizedResponse extends JsonResource
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
            'error' => 'Not Authorized'
        ];
    }
}
