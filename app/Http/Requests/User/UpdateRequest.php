<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'name' => 'required',
//            'role_id' => 'required|array',
            'role_id' => 'required',
//            'role_id.*' => 'required|exists:roles,id',
            'email' => 'required|email:rfc,dns',
//            'password' => 'required|confirmed'
        ];
    }
}
