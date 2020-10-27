<?php

namespace App\Http\Resources\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResponse extends JsonResource
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => $this->message
        ];
    }
}
