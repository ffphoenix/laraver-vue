<?php

namespace Backoffice\Requests;

use App\Models\User;

class UserForm extends AbstractFormRequest
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
                'name'       => 'required|unique:users,name',
                'email'      => 'required|email|unique:users,email',
                'password'   => 'required'
            ];
        } else {
            $user = User::find($this->get('id'));
            return [
                'name'       => 'required|unique:users,name,' . $user->id,
                'email'      => 'required|email|unique:users,email,' . $user->id
            ];
        }
    }
}
