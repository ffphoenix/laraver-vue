<?php

namespace Backoffice\Requests;

use App\Models\Customer;

class CustomerForm extends AbstractFormRequest
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
                'name'       => 'required',
                'cnp'        => 'required|unique:customers,cnp',
            ];
        } else {
            if (empty($this->route('customer'))) {
                throw new BadRequestException('invalid_post_data', 'invalid_post_data');
            }
            $customer = Customer::find($this->route('customer'));
            return [
                'name'       => 'required',
                'cnp'      => 'required|email|unique:customers,cnp,' . $customer->id,
            ];
        }
    }
}
