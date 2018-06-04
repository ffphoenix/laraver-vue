<?php

namespace Backoffice\Requests;

class CurrencyForm extends AbstractFormRequest
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
                'name'   => 'required|unique:currencies,name',
                'code'   => 'required|unique:currencies,code',
                'symbol' => 'required|unique:currencies,symbol'
            ];
        } else {
            $category = WalletCategory::find($this->get('id'));
            return [
                'name'   => 'required|unique:currencies,name,' . $category->id,
                'code'   => 'required|unique:currencies,code,' . $category->id,
                'symbol' => 'required|unique:currencies,symbol,' . $category->id
            ];
        }

    }
}
