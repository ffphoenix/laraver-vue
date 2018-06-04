<?php

namespace Backoffice\Requests;

use App\Models\Transaction;

class TransactionForm extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'customer_id'       => 'required',
                'amount'        => 'required|numeric',
            ];
        } else {
            return [
                'amount'        => 'required|numeric',
            ];
        }
    }
}
