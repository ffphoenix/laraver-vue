<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CustomerResource extends Resource
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
            'cnp' => $this->cnp,
            'created_at'   => (string)$this->created_at,
            'deleted_at'   => $this->deleted_at,
        ];
    }
}