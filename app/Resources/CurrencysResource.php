<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CurrencysResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return CurrencyResource::collection($this->collection);
    }
}