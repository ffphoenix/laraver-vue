<?php

namespace Backoffice\Requests;

class LoginForm extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'   => 'required',
            'password'   => 'required'
        ];
    }
}
