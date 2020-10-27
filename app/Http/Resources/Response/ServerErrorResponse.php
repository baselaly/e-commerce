<?php

namespace App\Http\Resources\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class ServerErrorResponse extends JsonResource
{
    protected $error;

    public function __construct($error)
    {
        $this->error = $error;
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
            'error' => $this->error
        ];
    }
}
