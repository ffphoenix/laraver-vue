<?php

namespace App\Resources;

use App\Models\Transaction;
use Illuminate\Http\Resources\Json\Resource;

class TransactionResource extends Resource
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
            'id'                      => $this->id,
            'amount'                  => $this->getAmount(),
            'status'                  => $this->status,
            'type'                    => $this->type,
            'created_at'              => date('Y-m-d H:i:s', strtotime($this->created_at)),
        ];
    }
}
