<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CurrencyResource extends Resource
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
            'id'     => $this->id,
            'name'   => $this->name,
            'symbol' => $this->symbol,
            'code'   => $this->code,
            'deleted_at'   => $this->deleted_at,
        ];
    }
}