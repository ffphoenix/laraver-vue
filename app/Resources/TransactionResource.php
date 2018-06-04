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
            'currency' => [
                'code' => $this->currency->code,
                'symbol' => $this->currency->symbol,
            ],
            'customer' => [
                'name' =>$this->customer->name
            ],
            'status'                  => $this->status,
            'created_at'              => date('Y-m-d H:i:s', strtotime($this->created_at)),
        ];
    }
}
